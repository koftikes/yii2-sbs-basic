<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\News
 */

$this->title = 'Update News: ' . $model->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News', 'url' => ['news/index']],
    ['label' => $model->title, 'url' => ['view', 'id' => $model->id]],
    'Update'
];
?>
<div class="admin-news-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
