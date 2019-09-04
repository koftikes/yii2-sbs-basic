<?php
/**
 * @var yii\web\View
 * @var app\models\News $model
 */
$this->title                 = 'Update News: ' . $model->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News', 'url' => ['news/index']],
    ['label' => $model->title, 'url' => ['view', 'id' => $model->id]],
    'Update',
];
?>
<div class="admin-news-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
