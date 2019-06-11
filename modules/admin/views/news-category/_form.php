<?php
/**
 * @var $this  yii\web\View
 * @var $model app\models\NewsCategory
 * @var $form  kartik\widgets\ActiveForm
 */

use yii\helpers\Html;
use sbs\widgets\TreeDropDown;
use sbs\widgets\SlugInput;
use kartik\widgets\ActiveForm;
use vova07\imperavi\Widget as Editor;
use app\models\NewsCategory;

?>
<div class="admin-user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'parent_id')->widget(TreeDropDown::class, [
        'options' => ['prompt' => ''],
        'query'   => NewsCategory::find()->where(['parent_id' => null]),
        'exclude' => $model->id,
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'slug')->widget(SlugInput::class, ['sourceAttribute' => 'name']); ?>
    <?= $form->field($model, 'description')->widget(Editor::class, [
        'settings' => [
            'plugins'         => ['fullscreen', 'fontcolor', 'video'],
            'minHeight'       => 200,
            'maxHeight'       => 200,
            'buttonSource'    => true,
            'convertDivs'     => false,
            'removeEmptyTags' => true,
        ],
    ]); ?>
    <?= $form->field($model, 'status')->checkbox(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
