<?php
/**
 * @var yii\web\View
 * @var app\models\News           $model
 * @var kartik\widgets\ActiveForm $form
 */
use kartik\widgets\ActiveForm;
use sbs\widgets\SeoForm;
use sbs\widgets\SlugInput;
use vova07\imperavi\Widget as Editor;
use yii\helpers\Html;

?>

<div class="admin-static-page-form">
    <?php $form = ActiveForm::begin(['id' => 'admin-static-page-form']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'slug')->widget(SlugInput::class, ['sourceAttribute' => 'title'])
        ->hint(Yii::t('app', 'If you\'ll leave this field empty, slug will be generated automatically.')); ?>
    <?= $form->field($model, 'text')->widget(
            Editor::class,
            [
            'settings' => [
                'plugins'         => ['fullscreen', 'fontcolor'],
                'minHeight'       => 400,
                'maxHeight'       => 400,
                'buttonSource'    => true,
                'convertDivs'     => false,
                'removeEmptyTags' => false,
            ],
        ]
        ); ?>
    <?= SeoForm::widget(['model' => $model, 'form' => $form, 'fields' => ['keywords', 'description']]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
