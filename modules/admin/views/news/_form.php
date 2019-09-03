<?php
/**
 * @var $this  yii\web\View
 * @var $model app\models\News
 * @var $form  kartik\widgets\ActiveForm
 */

use sbs\widgets\SlugInput;
use sbs\widgets\TreeDropDown;
use yii\helpers\Html;
use app\models\NewsCategory;
use kartik\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use vova07\imperavi\Widget as Editor;
?>

<div class="admin-news-form">
    <?php $form = ActiveForm::begin(['id' => 'admin-news-form']); ?>

    <?= $form->field($model, 'category_id')->widget(TreeDropDown::class, [
        'options' => ['prompt' => ''],
        'query'   => NewsCategory::find()->where(['parent_id' => null]),
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'slug')->widget(SlugInput::class, ['sourceAttribute' => 'title']); ?>
    <?php //echo $form->field($model, 'image')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'preview')->widget(
        Editor::class, [
            'settings' => [
                'plugins'         => ['fullscreen', 'fontcolor', 'video'],
                'minHeight'       => 200,
                'maxHeight'       => 200,
                'buttonSource'    => true,
                'convertDivs'     => false,
                'removeEmptyTags' => false,
            ],
        ]
    ); ?>
    <?= $form->field($model, 'text')->widget(
        Editor::class, [
            'settings' => [
                'plugins'         => ['fullscreen', 'fontcolor', 'video'],
                'minHeight'       => 400,
                'maxHeight'       => 400,
                'buttonSource'    => true,
                'convertDivs'     => false,
                'removeEmptyTags' => false,
            ],
        ]
    ); ?>
    <?= $form->field($model, 'publish_date')->widget(
        DateTimePicker::class, [
        'removeButton'  => false,
        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd HH:ii:ss'],
    ]); ?>
    <?= $form->field($model, 'status')->checkbox(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
