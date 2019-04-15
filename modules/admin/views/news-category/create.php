<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\News
 */

$this->title = 'Create News Category';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News Categories', 'url' => ['news-category/index']],
    'Create'
];
?>
<div class="admin-news-category-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
