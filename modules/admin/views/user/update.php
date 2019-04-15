<?php
/**
 * @var $this yii\web\View
 * @var $model app\modules\admin\models\UserForm
 */

$this->title = 'Update User: ' . $model->user->username;
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'Users', 'url' => ['user/index']],
    $model->user->username,
    'Update'
];
?>
<div class="admin-user-update">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
