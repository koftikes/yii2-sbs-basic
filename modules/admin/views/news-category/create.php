<?php

/**
 * @var yii\web\View
 * @var app\models\News $model
 */
$this->title                 = 'Create News Category';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News Categories', 'url' => ['news-category/index']],
    'Create',
];
?>
<div class="admin-news-category-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
