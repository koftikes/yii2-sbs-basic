<?php
/**
 * @var yii\web\View
 * @var kartik\detail\DetailView $widget
 */
$this->title                 = $widget->model->title;
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
