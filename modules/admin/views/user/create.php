<?php
/**
 * @var $this yii\web\View
 * @var $model app\modules\admin\models\UserForm
 */

$this->title = 'Create User';
$this->params['breadcrumbs'] = [
    ['label' => 'Admin Panel', 'url' => ['statistic/index']],
    ['label' => 'Users', 'url' => ['user/index']],
    'Create'
];
?>
<div class="admin-user-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
