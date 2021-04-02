<?php
/**
 * @var yii\web\View          $this
 * @var app\models\StaticPage $model
 */

use sbs\widgets\SeoTags;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $model->title;
SeoTags::widget(['seo' => $model->seo, 'title' => $model->title]);

?>
<div class="site-static-page">
    <h1><?= Html::encode($model->title); ?></h1>
    <?= $model->text; ?>
</div>
