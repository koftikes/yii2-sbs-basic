<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\News
 */

$this->title = 'Create News';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News', 'url' => ['news/index']],
    'Create'
];
?>
<div class="admin-news-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
