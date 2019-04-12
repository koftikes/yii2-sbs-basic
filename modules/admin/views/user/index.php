<?php

/**
 * @var $this yii\web\View
 * @var $widget kartik\grid\GridView
 */

use yii\helpers\Html;

$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">
    <div class="row">
        <div class="col-sm-10">
            <h3><?= Html::encode($this->title); ?></h3>
        </div>
        <div class="col-sm-2">
            <?= Html::a('Create', ['user/create'], ['class' => 'float-right btn btn-success']); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= $widget->run(); ?>
</div>
