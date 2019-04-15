<?php
/**
 * @var $this yii\web\View
 * @var $widget kartik\detail\DetailView
 */

$this->title = $widget->model->title;
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
