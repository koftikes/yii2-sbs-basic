<?php
/**
 * @var yii\web\View              $this
 * @var app\models\NewsCategory   $model
 * @var kartik\widgets\ActiveForm $form
 */
use app\models\NewsCategory;
use kartik\widgets\ActiveForm;
use sbs\widgets\SeoForm;
use sbs\widgets\SlugInput;
use sbs\widgets\TreeDropDown;
use vova07\imperavi\Widget as Editor;
use yii\helpers\Html;

?>
<div class="admin-news-category-form">
    <?php $form = ActiveForm::begin(['id' => 'admin-news-category-form']); ?>
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
    <?= SeoForm::widget(['model' => $model, 'form' => $form, 'fields' => ['keywords', 'description']]); ?>
    <div class="form-group">
        <?= Html::submitButton(
        $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    ); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
