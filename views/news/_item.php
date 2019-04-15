<?php
/**
 * @var $this  yii\web\View
 * @var $model app\models\News
 */

use yii\helpers\Html;
use yii\helpers\StringHelper;

?>

<h2 class="news-post-title"><?= Html::a(Html::encode($model->title), ['news/view', 'slug' => $model->slug]); ?></h2>
<p class="news-post-meta">
    <?= Yii::$app->formatter->asDate($model->create_date, 'long'); ?> by
    <b><?= Html::encode($model->createUser->username); ?></b>
</p>

<?= StringHelper::truncateWords($model->preview ?: $model->text, 150); ?>
