<?php
/**
 * @var $this yii\web\View
 * @var $model app\modules\admin\models\UserForm
 */

use yii\helpers\Html;

$this->title = 'Create User';
$this->params['breadcrumbs'] = [['label' => 'Admin Users', 'url' => ['user/index']], $this->title];
?>
<div class="admin-user-create">
    <h3><?= Html::encode($this->title); ?></h3>
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
