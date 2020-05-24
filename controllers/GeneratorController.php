<?php

namespace app\controllers;

use app\models\GiftCreative;
use app\models\Gifts;
use app\models\Seo;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class GeneratorController extends BaseController
{
    const COUNT_FOR_GENERATE = 15;
    const SEO_TITTLE = 'Генератор подарков: сервис подбора креативных подарков';
    const SEO_DESCRIPTION = 'Отвечайте на вопросы и генератор подарков сформирует список оригинальных подарков,
             основываясь на ваших предпочтениях. По итогу прохождения теста, генератор подарков создаст список из 12 презентов.
              Вы можете составить виш-лист для себя.';
    const SEO_KEYWORDS = 'подбор подарков, генератор подарков, креативные подарки, идеи креативных подарков.';
    const SEO_IMG = '/img/generator/generator.jpg';


    public function actionIndex()
    {
        Seo::setSeo(
            self::SEO_TITTLE,
            self::SEO_DESCRIPTION,
            self::SEO_KEYWORDS
        );

        Seo::setOgSeo(
            self::SEO_TITTLE,
            self::SEO_DESCRIPTION,
            self::SEO_KEYWORDS,
            self::SEO_IMG,
            Url::to(['/generator'],
                'website')
        );

        Seo::setTwitterSeo(
            self::SEO_TITTLE,
            self::SEO_DESCRIPTION,
            self::SEO_KEYWORDS,
            self::SEO_IMG,
            Url::to(['/generator'])
        );
        $key = md5($_SERVER['REMOTE_ADDR'] . time());

        return $this->render('index', ['key' => $key, 'countGenerate' => self::COUNT_FOR_GENERATE]);
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetGift()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $key = Yii::$app->request->post('key', false);
            if ($key) {
                $history = Yii::$app->session->get('generator_history', [$key => []]);
                return $this->getGift($history, $key);
            }
        }
        throw new NotFoundHttpException();
    }

    /**
     * @return array|int
     * @throws NotFoundHttpException
     */
    public function actionCheckResult()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $key = Yii::$app->request->post('key', false);
            $id = Yii::$app->request->post('id');
            $result = (int)Yii::$app->request->post('result');
            if ($key && $id) {
                $history = Yii::$app->session->get('generator_history', []);
                $gift = Gifts::findOne($id);
                if ($gift) {
                    $history[$key][$gift->id] = ['id' => $gift->id, 'value' => $result];
                    Yii::$app->session->set('generator_history', $history);
                    $giftCr = new GiftCreative(['user_ip' => $key, 'gift_id' => $gift->id, 'value' => $result]);
                    $giftCr->save(0);
                    if (count($history[$key]) >= self::COUNT_FOR_GENERATE) {
                        $giftIds = ArrayHelper::getColumn($history[$key], 'id');
                        $votes = GiftCreative::find()
                            ->where(['gift_id' => $giftIds])
                            ->andWhere(['!=', 'user_ip', $key])
                            ->andWhere(['not in', 'user_ip',
                                GiftCreative::find()->select('user_ip')
                                    ->having(['BETWEEN', 'AVG(value)', 0.2, 0.85])
                                    ->orHaving(['<', 'COUNT(id)', self::COUNT_FOR_GENERATE])->groupBy('user_ip')
                            ])->orderBy(['date' => SORT_DESC])->all();
                        $userFilters = [];
                        foreach ($votes as $vote) {
                            if ($vote->value == $history[$key][$vote->gift_id]['value']) {
                                $userFilters[$vote->user_ip]++;
                            } else {
                                $userFilters[$vote->user_ip] -= 0.3;
                            }
                        }
                        arsort($userFilters);

                        $tempUserFilters = array_filter(
                            $userFilters,
                            function ($value)  {
                                return $value > self::COUNT_FOR_GENERATE/4;
                            }
                        );
                        if (count($tempUserFilters) < 4) {
                            $userFilters = array_slice($userFilters, 0, 15);
                        } else {
                            $userFilters = $tempUserFilters;
                        }

                        $gifts = Gifts::find()->rightJoin(GiftCreative::tableName(), 'gift_id = gifts.id')
                            ->groupBy('gift_id')->where(['in', 'user_ip', array_keys($userFilters)])
                            ->andWhere(['not in', 'gift_id', $giftIds])->andWhere(['in_search' => true])
                            ->orderBy(['(sqrt(count(value)) * power(avg(value),2))' => SORT_DESC])->limit(12)->all();
                        $result = [
                            'result' => true,
                            'content' => $this->renderAjax('list', ['gifts' => $gifts])];
                    } else {
                        $result = ['result' => false, 'content' => $this->getGift($history, $key)];
                    }
                    return $result;
                }
            }
        }
        throw new NotFoundHttpException();
    }

    /**
     * @param array $history
     * @param string $key
     * @return array
     */
    private function getGift($history, $key)
    {
        $history = isset($history[$key]) ? ArrayHelper::getColumn($history[$key], 'id') : [];

        $gift = Gifts::find()->filterWhere(['not in', 'id', $history])->andWhere(['in_search' => true])
            ->orderBy('RAND()')->one();

        $creative = $gift->getCreative();
        $countCreative = $gift->getGiftCreatives()->count();
        $date = date_create($gift->date);
        return [
            'id' => $gift->id,
            'content' => $this->renderAjax('../gifts/_generatorGift',
                [
                    'gift' => $gift,
                    'creative' => $creative,
                    'countCreative' => $countCreative,
                    'date' => $date,
                ])
        ];
    }
}
