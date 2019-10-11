<?php
/**
 * @var yii\web\View
 * @var kartik\grid\GridView $widget
 */
use yii\helpers\Html;

$this->title                 = 'Static Page';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    $this->title,
];
?>
<div class="admin-static-page">
    <div class="row">
        <div class="col-sm-9">
            <h3><?= Html::encode($this->title); ?></h3>
        </div>
    </div>
    <?= $widget->run(); ?>
</div>
