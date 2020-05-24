<?php

/* @var $this \yii\web\View */
/* @var $gifts \app\models\Gifts[] */

?>
<div class="block-size block-4 block-size-title generator-result-msg">
    Ваша подборка подарков
</div>
<?php
foreach ($gifts as $gift) {
    echo $this->render('../gifts/_smallGift', ['gift' => $gift, 'social' => false]);
}

?>


