<?php
/**
 * @var yii\web\View
 * @var kartik\form\ActiveForm      $form
 * @var app\models\user\UserProfile $model
 */
use app\models\user\UserProfile;
use borales\extensions\phoneInput\PhoneInput;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Html;

$this->title                   = 'Update User: ' . $model->user->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">
    <h1><?= Html::encode($this->title); ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id'   => 'form-user-profile',
                'type' => ActiveForm::TYPE_HORIZONTAL,
            ]); ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]); ?>
            <?= $form->field($model, 'phone')->widget(
                PhoneInput::class,
                ['jsOptions' => ['nationalMode' => false]]
            ); ?>
            <?= $form->field($model, 'gender')->dropDownlist([
                UserProfile::GENDER_THING  => Yii::t('app', 'Unknown'),
                UserProfile::GENDER_MALE   => Yii::t('app', 'Male'),
                UserProfile::GENDER_FEMALE => Yii::t('app', 'Female'),
            ]); ?>
            <?= $form->field($model, 'DOB')->widget(DatePicker::class, [
                'options'       => ['placeholder' => Yii::t('app', 'Enter birth date ...')],
                'removeButton'  => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format'    => 'yyyy-mm-dd',
                ],
            ]); ?>
            <?= $form->field($model, 'info')->textarea(['rows' => 10]); ?>
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-success']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
