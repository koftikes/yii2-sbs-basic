<?php
/**
 * @var yii\web\View
 * @var app\modules\admin\models\UserForm $model
 */
use app\models\user\User;
use app\models\user\UserProfile;
use borales\extensions\phoneInput\PhoneInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'id'   => 'admin-user-form',
    'type' => ActiveForm::TYPE_HORIZONTAL,
]); ?>
<div class="admin-user-form">
    <?= $form->field($model->user, 'email'); ?>
    <?php if ($model->user->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
    <?php endif; ?>
    <?= $form->field($model->user, 'status')->dropDownList(User::statuses()); ?>
    <?= $form->field($model->profile, 'name')->textInput(['maxlength' => 255]); ?>
    <?= $form->field($model->profile, 'phone')->widget(PhoneInput::class); ?>
    <?= $form->field($model->profile, 'gender')->dropDownlist([
        UserProfile::GENDER_THING  => Yii::t('app', 'Unknown'),
        UserProfile::GENDER_MALE   => Yii::t('app', 'Male'),
        UserProfile::GENDER_FEMALE => Yii::t('app', 'Female'),
    ]); ?>
    <?= $form->field($model->profile, 'DOB')->widget(
        DatePicker::class,
        [
        'options'       => ['placeholder' => Yii::t('app', 'Enter birth date ...')],
        'removeButton'  => false,
        'pluginOptions' => [
            'autoclose' => true,
            'format'    => 'yyyy-mm-dd',
        ],
    ]
    ); ?>
    <?= $form->field($model->profile, 'info')->textarea(['rows' => 10]); ?>
</div>
<div class="box-footer">
    <?= Html::submitButton(
        $model->user->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    ); ?>
</div>
<?php ActiveForm::end(); ?>
