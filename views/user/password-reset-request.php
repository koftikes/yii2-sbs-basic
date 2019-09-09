<?php
/**
 * @var yii\web\View
 * @var kartik\form\ActiveForm                   $form
 * @var app\models\user\PasswordResetRequestForm $model
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title                   = 'Password Reset Request';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="password-reset-request">
    <h1><?= Html::encode($this->title); ?></h1>
    <p class="text-muted">Please fill out your email. A link to reset password will be sent there.</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-password-reset-request']); ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]); ?>
            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
