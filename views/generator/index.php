<?php

/* @var $this \yii\web\View */
/* @var $countGenerate int */
/* @var $key string */

use yii\helpers\Url;

\app\assets\GeneratorAsset::register($this);

$this->registerJsVar('generatorKey', $key)

?>

<div class="block-size block-4" id="generator-title">
    <img src="/img/generator/generator.jpg" id="generator-title-img"
         alt="Генератор подарков - подбор подарков, проходя опрос/тест">
    <h1 class="block-size-title">Генератор подарков</h1>
</div>
<div class="block-4 block-size flex" id="generator-counter">
    <?php for ($i = 0; $i < $countGenerate; $i++): ?>
        <div class="generator-counter-element"></div>
    <?php endfor; ?>
    <div id="generator-counter-value">
        <span id="generator-counter-value-now">0</span> / <?= $countGenerate ?>
    </div>
</div>
<div class="list-block" id="generator-result"></div>
<div class='block-4 block-size flex' id="generator-block">
    <div class="block-1-zero-space after-block-0">
        <div class='block-4 block-size color-red generator-btn' data-value="0">Не хочу</div>
    </div>
    <div class="block-2-zero-space after-block-4" id="generator-gift-list">

    </div>
    <div class="block-1-zero-space after-block-0">
        <div class='block-4 block-size color-green generator-btn' data-value="1">Хочу</div>
    </div>
</div>

<div class='block-4 block-size' id="generator-block-info">
    <div id="genertor-infographics" class="block-4">
        <img src="/img/generator/macbook-gifts.png" id="infographics-macbook"
             alt="ноутбук с результатом генератором подарков">
        <div id="infographics-mobile-line">
            <div class="point" id="point-1"></div>
            <div class="point" id="point-2"></div>
            <div class="point" id="point-3"></div>
            <div class="point" id="point-4"></div>
            <div class="point" id="point-5"></div>
            <img src="/img/generator/phone-generator.png" id="infographics-phone"
                 alt="телефон с анимацией выбора подарков">
            <img src="/img/generator/gift-animate.png" id="infographics-gift-animate"
                 alt="идея подарка для анимации в инфографике">
            <div class="infographics-text" id="infographics-text-1">Сервис сгенирирует список подарков по вашим
                предпочтениям. Оцените всего 15 идей подарков.
            </div>
            <div class="infographics-text" id="infographics-text-2">Делайте свайп в сторону для оценки подарка. Чем
                больше
                честных ответов, тем более правильно сформируется список подарков
            </div>
            <div class="infographics-text" id="infographics-text-3">Ваши ответы сравниваются с резульататами опроса
                других
                людей. Результаты группируются по схожести ответов и формируется список подарков.
            </div>
            <div class="infographics-text" id="infographics-text-4">Изучите сгенерированный список и найдите нужную вам
                идею
                подарков.
            </div>
            <div class="infographics-text" id="infographics-text-5">Расскажи друзьям о сервисе в социальных сетях!</div>
            <div class="infographics-text color-green" id="infographics-text-6">Хочу</div>
            <div class="infographics-text color-red" id="infographics-text-7">Не хочу</div>
            <svg x="0px" y="0px" xml:space="preserve" class="infographics-line size-view-3">
                <path class="infographics-element" d="M600,125c0-25-25-50-50-50"/>
                <line class="infographics-element" x1="90" x2="550" y1="75" y2="75"/>
                <path class="infographics-element" d="M850,285c0-25-25-50-50-50"/>
                <path class="infographics-element" d="M360,285c0-25,25-50,50-50"/>
                <line class="infographics-element" x1="410" x2="800" y1="235" y2="235"/>
                <line class="infographics-element" x1="360" x2="360" y1="285" y2="560"/>
                <line class="infographics-element" x1="850" x2="850" y1="285" y2="560"/>
                <path class="infographics-element" d="M360,555c0,25,25,50,50,50"/>
                <path class="infographics-element" d="M850,555c0,25-25,50-50,50"/>
                <line class="infographics-element" x1="410" x2="800" y1="605" y2="605"/>
                <line class="infographics-element" x1="600" x2="600" y1="605" y2="920"/>
                <path class="infographics-element" d="M600,920c0,25-25,50-50,50"/>
                <line class="infographics-element" x1="300" x2="550" y1="970" y2="970"/>
                <line class="infographics-element" x1="282" x2="282" y1="1060" y2="1300"/>
                <path class="infographics-element" d="M282,1300c0,25,25,50,50,50"/>
                <line class="infographics-element" x1="330" x2="650" y1="1350" y2="1350"/>
            </svg>
            <svg x="0px" y="0px" xml:space="preserve" class="infographics-line size-view-4">
                <path class="infographics-element" d="M910,125c0-25-25-50-50-50"/>
                <line class="infographics-element" x1="270" x2="860" y1="75" y2="75"/>
                <path class="infographics-element" d="M1160,285c0-25-25-50-50-50"/>
                <path class="infographics-element" d="M670,285c0-25,25-50,50-50"/>
                <line class="infographics-element" x1="720" x2="1110" y1="235" y2="235"/>
                <line class="infographics-element" x1="670" x2="670" y1="285" y2="560"/>
                <line class="infographics-element" x1="1160" x2="1160" y1="285" y2="560"/>
                <path class="infographics-element" d="M670,555c0,25,25,50,50,50"/>
                <path class="infographics-element" d="M1160,555c0,25-25,50-50,50"/>
                <line class="infographics-element" x1="720" x2="1110" y1="605" y2="605"/>
                <line class="infographics-element" x1="910" x2="910" y1="605" y2="920"/>
                <path class="infographics-element" d="M910,920c0,25-25,50-50,50"/>
                <line class="infographics-element" x1="300" x2="860" y1="970" y2="970"/>
                <line class="infographics-element" x1="367" x2="367" y1="1060" y2="1300"/>
                <path class="infographics-element" d="M367,1300c0,25,25,50,50,50"/>
                <line class="infographics-element" x1="417" x2="800" y1="1350" y2="1350"/>
            </svg>
            <svg x="0px" y="0px" xml:space="preserve" class="infographics-line size-view-2">
               <line class="infographics-element" x1="300" x2="300" y1="50" y2="1550"/>
            </svg>
            <svg x="0px" y="0px" xml:space="preserve" class="infographics-line size-view-1">
               <line class="infographics-element" x1="150" x2="150" y1="50" y2="1550"/>
            </svg>
            <div id='infographics-social'>
                <?=
                $this->render('../social/_social', [
                    'url' => Url::to(['/generator'], true),
                    'tittle' => 'Генераторо подарков',
                    'description' => 'Сервис сгенирирует список подарков по вашим
                предпочтениям. Оцените всего 15 идей подарков.'
                ])
                ?>
            </div>
        </div>
    </div>
</div>

<div class='block-4 block-size block-text-p'>
    <h2>Как работает сервис подбора подарков?</h2>
    <p>Что подарить близким на День Рождения, Новый Год, 8 марта, 23 февраля, День Всех Влюбленных? Как выбрать подарок?
        Что делать, если идеи подарков не приходят в голову? На помощь может прийти простой в использовании сервис,
        выполняющий подбор подарков онлайн. </p>
    <p>Сервис Генератор подарков это – универсальный функционал, позволяющий быстро определить и подобрать нужный
        презент на основе предпочтений получателя. </p>

    <h3>Что это за сервис?</h3>
    <p>Итак, генератор подарков – это тест, пройдя который вы получаете список подходящих презентов. Получив ваши ответы
        на 15 вопросов, сервис сгенерирует список идей, вам останется только выбрать. На основе результатов вы легко
        сформируете собственный виш-лист, или выберете один из подарков для близкого человека. Здесь собрано множество
        креативных вариантов, так что подбор подарков происходит максимально просто.</p>

    <h3>Что можно получить после прохождения опроса</h3>
    <p>В отличие от других сервисов, генератор подарков не станет предлагать стандартные клише, основываясь на поле,
        возрасте или семейном положении получателя. Алгоритм выбора подарка в сервисе происходит исключительно по
        предполагаемым предпочтениям. Пройдя опрос и получив список, вопросы: «какой выбрать подарок» или «что подарить»
        больше не будут актуальны, учитывая разнообразие предлагаемых идей.</p>

    <h3>Что нужно делать в генераторе подарков</h3>
    <p>Пользователь свайпает ответы «да/нет» на экране, выбирая из представленных вариантов. На основе сбора этой
        информации происходит подбор подарков и в результате сервис предлагает 12 вариантов. Идеи подарков, которые
        предлагает сервис, в большинстве случаев могут соответствовать пожеланиям получателя. </p>
    <p>Генератор подарков работает на основе сложного алгоритма, выполняя сложные аналитические просчеты. Ответы на тест
        надо давать максимально честно, тогда сервис сформирует более точное совпадение с предпочтениями подарков. </p>
    <p>Сервис сравнивает ответы с ответами других людей и группирует их по схожести, формируя ваш индивидуальный
        список.</p>
    <h3>Для кого создан этот сервис</h3>
    <p>Как часто бывает – праздники приходят совершенно неожиданно. Подбор подарков полезен, если вы не успели
        подготовиться и придумать что подарить. </p>
    <p>Генератор подарков создан для того, чтобы помочь пользователю реализовать лучший презент для близкого человека
        или друга. Классические и оригинальные подарки. </p>
    <p>Здесь собраны идеи подарков на любой повод:</p>
    <ul>
        <li>Новый Год;</li>
        <li>День Рождения;</li>
        <li>8 марта;</li>
        <li>23 февраля;</li>
        <li>14 Февраля;</li>
        <li>День Учителя;</li>
        <li>День Матери и т.д.</li>
    </ul>
    <p>Не забывайте делиться сервисом в социальных сетях!</p>
</div>