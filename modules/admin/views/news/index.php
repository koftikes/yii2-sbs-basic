<?php
/**
 * @var $this yii\web\View
 * @var $widget kartik\grid\GridView
 */

use yii\helpers\Html;

$this->title = 'News';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    $this->title,
];
?>
<div class="admin-news">
    <div class="row">
        <div class="col-sm-9">
            <h3><?= Html::encode($this->title); ?></h3>
        </div>
        <div class="col-sm-3">
            <?= Html::a('News Category', ['news-category/index'], ['class' => 'btn btn-info']); ?>
            <?= Html::a('Create', ['news/create'], ['class' => 'float-right btn btn-success']); ?>
        </div>
    </div>
    <?= $widget->run(); ?>
</div>
