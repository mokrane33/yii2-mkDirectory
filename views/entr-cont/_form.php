<?php

use yii\helpers\Html;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\EntrCont */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entr-cont-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_ent')->textInput() ?>

    <?= $form->field($model, 'id_ent')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'valeur')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
// necessary for update action.
if (!$modelCat->isNewRecord) {
    echo Html::activeHiddenInput($modelCat, "[{$index}]id");
}

if($modelCat->isNewRecord)
{
    $objcategory=new \app\models\Category();
    $subcat=[];
}else
{

    $objcategory=$modelCat->getIdCat()->one()->getparent();
    $subcat=ArrayHelper::map($objcategory->getChildren(),'id','name');
}

echo $form->field($objcategory, 'id')->widget(Select2::classname(), [
    'data' => $categorie,
    'options' => ['multiple' => false,'id'=>'level0', 'placeholder' => 'Select states ...']
]);
?>


<?php  echo $form->field($modelCat, "[{$index}]id_cat")->widget(DepDrop::classname(), [
    'data' => $subcat,
    'options'=>['id'=>'subcat-id'],
    'pluginOptions'=>[
        'depends'=>['level0'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['/category/getlist'])
    ]
]);?>
