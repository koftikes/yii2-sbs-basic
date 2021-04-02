<?php
/**
 * @var yii\web\View             $this
 * @var kartik\detail\DetailView $widget
 * @var app\models\News          $model
 */
$model                       = $widget->model;
$this->title                 = $model->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News', 'url' => ['news/index']],
    $this->title,
    'View',
];
?>
<div class="admin-news-view">
    <?= $widget->run(); ?>
</div>
