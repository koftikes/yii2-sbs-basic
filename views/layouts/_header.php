<?php
/**
 * @var yii\web\View $this
 */

use app\models\StaticPage;
use kartik\nav\NavX;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => ['class' => 'navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm'],
]);

echo NavX::widget([
    'options' => ['class' => 'navbar-nav mr-auto'],
    'items'   => [
        ['label' => 'News', 'url' => ['/news/index']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'About', 'url' => StaticPage::url(1)],
    ],
]);

if (Yii::$app->user->isGuest) {
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav justify-content-end'],
        'items'   => [
            ['label' => 'Register', 'url' => ['/user/register']],
            ['label' => 'Login', 'url' => ['/user/login']],
        ],
    ]);
} else {
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav justify-content-end'],
        'items'   => [
            [
                'label'  => 'Admin Panel',
                'url'    => ['/admin/statistic'],
                'active' => false !== \mb_strpos($this->context->route, 'admin'),
            ],
            [
                'label'  => Yii::$app->user->identity->username,
                'url'    => ['/user/profile'],
                'active' => false !== \mb_strpos($this->context->route, 'profile'),
            ],
        ],
    ]);
    echo Html::beginForm(['/user/logout'], 'post', ['id' => 'form-logout'])
        . Html::submitButton('Logout', ['class' => 'btn btn-outline-success logout'])
        . Html::endForm();
}
NavBar::end();
