<?php
/**
 * @var yii\web\View            $this
 * @var app\models\NewsCategory $model
 */
$this->title                 = 'Update News Category: ' . $model->name;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News Categories', 'url' => ['news-category/index']],
    $model->name,
    'Update',
];
?>
<div class="admin-news-category-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
