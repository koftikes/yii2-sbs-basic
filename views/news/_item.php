<?php
/**
 * @var yii\web\View    $this
 * @var app\models\News $model
 */
use app\models\NewsCategory;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>

<h2 class="news-post-title"><?= Html::a(Html::encode($model->title), ['news/view', 'slug' => $model->slug]); ?></h2>
<p class="news-post-meta">
    <?php if ($model->category instanceof NewsCategory) : ?>
        <?= Html::a(Html::encode($model->category->name), ['news/category', 'slug' => $model->category->slug]); ?> at
    <?php endif; ?>
    <?= Yii::$app->formatter->asDate($model->create_date, 'long'); ?> by
    <b><?= Html::encode($model->createUser->username); ?></b>
</p>

<?= StringHelper::truncateWords($model->preview ?: $model->text, 150); ?>
