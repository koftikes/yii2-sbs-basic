<?php
/**
 * @var $this yii\web\View
 * @var $form kartik\form\ActiveForm
 * @var $model app\models\user\RegisterForm
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register">
    <h1><?= Html::encode($this->title); ?></h1>
    <p class="text-muted">Please fill out the following fields to sign up:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'email'); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
