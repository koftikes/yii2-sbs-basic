<?php
/**
 * @var $this yii\web\View
 * @var $widget kartik\grid\GridView
 */

use yii\helpers\Html;

$this->title = 'News Categories';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    $this->title,
];
?>
<div class="admin-news-category">
    <div class="row">
        <div class="col-sm-9">
            <h3><?= Html::encode($this->title); ?></h3>
        </div>
        <div class="col-sm-3">
            <?= Html::a('Back to News', ['news/index'], ['class' => 'btn btn-info']); ?>
            <?= Html::a('Create', ['news-category/create'], ['class' => 'float-right btn btn-success']); ?>
        </div>
    </div>
    <p></p>
    <?= $widget->run(); ?>
</div>
