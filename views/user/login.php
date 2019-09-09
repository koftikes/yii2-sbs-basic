<?php
/**
 * @var yii\web\View
 * @var kartik\form\ActiveForm    $form
 * @var app\models\user\LoginForm $model
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login">
    <h1><?= Html::encode($this->title); ?></h1>
    <p class="text-muted">Please fill out the following fields to login:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-login']); ?>
            <?= $form->field($model, 'login')->textInput(['autofocus' => true]); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
            <?= $form->field($model, 'rememberMe')->checkbox(); ?>
            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['user/password-reset-request']); ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
