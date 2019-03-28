<?php

use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap4\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm']
]);

echo NavX::widget([
    'options' => ['class' => 'navbar-nav mr-auto'],
    'items' => [
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']]
    ]
]);

if (Yii::$app->user->isGuest) {
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav justify-content-end'],
        'items' => [
            ['label' => 'Register', 'url' => ['/user/register']],
            ['label' => 'Login', 'url' => ['/user/login']]
        ]
    ]);
} else {
    echo Html::beginForm(['/user/logout'], 'post', ['class' => 'form-inline my-2 my-lg-0'])
        . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-outline-success logout'])
        . Html::endForm();
}
NavBar::end();
