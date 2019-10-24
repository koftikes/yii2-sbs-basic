<?php
/**
 * @var yii\web\View
 * @var kartik\form\ActiveForm       $form
 * @var app\models\user\RegisterForm $model
 */
use app\models\StaticPage;
use kartik\form\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;

$this->title                   = 'Register';
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
            <?= $form->field($model, 'agreement')->checkbox()->label(Yii::t(
    'app',
    'I accept these {link}',
    ['link' => Html::a(Yii::t('app', 'terms of use'), StaticPage::url(2), ['class' => 'showModal'])]
)); ?>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']); ?>
                </div>
                <div class="col-lg-8"><?= AuthChoice::widget(['baseAuthUrl' => ['user/auth']]); ?></div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
