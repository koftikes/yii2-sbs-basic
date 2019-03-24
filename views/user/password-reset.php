<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\user\PasswordResetForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="password-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please choose your new password:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-password-reset']); ?>
            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
