<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\NewsCategory
 */

$this->title = 'Update News Category: ' . $model->name;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News Categories', 'url' => ['news-category/index']],
    $model->name,
    'Update'
];
?>
<div class="admin-news-category-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
