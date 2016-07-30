<?php

use app\models\Ville;
use app\modules\lyxeocat\models\Category;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entreprise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entreprise-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]);
    var_dump((new Category())->getTree());
   $catlist=ArrayHelper::map((new Category())->getTree(),'id','name');
//    (new Category())->gettreeArray();
// $catlist=['aa'=>[1=>'111',2=>'2222']];
    var_dump( $catlist);
    ?>

    <?= $form->field($model, 'raisonsociale')->textInput(['maxlength' => true]) ?>

<?= $form->field($model,'entreprise_cat_array')->widget(Select2::classname(), [
    'data' => $catlist,
    'language' => 'fr',
    'options' => ['multiple' => true, 'placeholder' => 'Select states ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
<!--    --><?php //echo $this->render('/entr-cat/_form',['modelCats'=>$modelCats, 'form'=>$form]); ?>

    <?php echo $this->render('/entr-adresse/_form',['model'=>$modelAdress,'form'=>$form]); ?>
    <?=   $form->field($model, 'status')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]);
    ?>

    <?php
    if($model->getImageurl()) {
        echo $form->field($model, 'imagefile')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,

            ],
            'pluginOptions' => [
                'showUpload' => false,
                'showRemove'=>false,
                'previewFileType' => 'image',
                'initialPreview' => [
                    ($model->existImage()) ?
                        Html::img($model->getImageurl(), ['class' => 'file-preview-image', 'alt' => $model->raisonsociale, 'title' => 'cat prob']) : ''

                ]
            ]
        ]);
    }
    else {
        echo $form->field($model, 'imagefile')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,

            ],
            'pluginOptions' => [
                'showUpload' => false,

                'showRemove'=>false,
                'previewFileType' => 'image'
            ]
        ]);
    }
        ?>


    <?= $form->field($model, 'description_small')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_big')->textarea(['rows' => 6]) ?>
    <!-- begin partner contact form-->
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    <?php
    //echo $this->render('entr_contact_form',['modelcontacts'=>$modelcontacts,'form'=>$form]);
    ?>

    <!-- begin partner contact form-->


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
