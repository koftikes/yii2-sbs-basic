<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\News
 */

$this->registerCssFile('/css/news.css');
$this->title                 = $model->title;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'News'), 'url' => ['index']],
    $this->title,
];
?>
<div class="news-post">
    <h2 class="news-post-title"><?= Html::encode($model->title); ?></h2>
    <p class="news-post-meta">
        <?= Yii::$app->formatter->asDate($model->create_date, 'long'); ?> by
        <b><?= Html::encode($model->createUser->username); ?></b>
    </p>
    <?= $model->text; ?>
</div>
