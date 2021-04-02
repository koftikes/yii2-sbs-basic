<?php
/**
 * @var yii\web\View          $this
 * @var app\models\StaticPage $model
 */
$this->title                 = 'Update Static Page: ' . $model->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'Static Page', 'url' => ['static-page/index']],
    $model->title,
    'Update',
];
?>
<div class="admin-static-page-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
