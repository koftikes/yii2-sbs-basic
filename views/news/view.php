<?php
/**
 * @var yii\web\View    $this
 * @var app\models\News $model
 */
use app\models\NewsCategory;
use sbs\widgets\SeoTags;
use yii\helpers\Html;

$this->registerCssFile('/css/news.css');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
if ($model->category instanceof NewsCategory) {
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($model->category->name),
        'url'   => ['news/category', 'slug' => $model->category->slug],
    ];
}
$this->params['breadcrumbs'][] = $model->title;
SeoTags::widget(['seo' => $model->seo, 'title' => $model->title]);
?>
<div class="news-post">
    <h2 class="news-post-title"><?= Html::encode($model->title); ?></h2>
    <p class="news-post-meta">
        <?= Yii::$app->formatter->asDate($model->create_date, 'long'); ?> by
        <b><?= Html::encode($model->createUser->username); ?></b>
    </p>
    <?= $model->text; ?>
</div>
