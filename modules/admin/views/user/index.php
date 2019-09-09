<?php

/**
 * @var yii\web\View
 * @var kartik\grid\GridView $widget
 */
use yii\helpers\Html;

$this->title                 = 'Users';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    $this->title,
];
?>
<div class="admin-user">
    <div class="row">
        <div class="col-sm-10">
            <h3><?= Html::encode($this->title); ?></h3>
        </div>
        <div class="col-sm-2">
            <?= Html::a('Create', ['user/create'], ['class' => 'float-right btn btn-success']); ?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>
    <?= $widget->run(); ?>
</div>
