<?php
/**
 * @var yii\web\View    $this
 * @var app\models\News $model
 */
$this->title                 = 'Create News';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'News', 'url' => ['news/index']],
    'Create',
];
?>
<div class="admin-news-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
