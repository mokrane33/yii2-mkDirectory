<?php

use app\modules\lyxeocat\models\Category;
use kartik\file\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */


$categories=Category::gettreeArray((new Category)->getTree());
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'id_parent')->dropDownList($categories,['prompt' => ' -- Root --']) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?=   $form->field($model, 'status')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]);?>

    <?=  $form->field($model, 'imagefile')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
            'multiple' => false,

        ],
        'pluginOptions' => [
            'showUpload' => false,
            'previewFileType' => 'image',
            'initialPreview'=>[
                ($model->existImage())?
                    Html::img($model->getImageurl(), ['class'=>'file-preview-image', 'title'=>'cat prob']):''

            ]
        ]
    ]); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_key')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
