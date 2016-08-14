<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntrAnnex */
/* @var $modelAdress app\models\EntrAdresse */
/* @var $modelcontacts app\models\EntrCont */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entr-annex-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
//            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]); ?>
    <?php echo $this->render('/entr-adresse/_form',['model'=>$modelAdress,'form'=>$form]); ?>
    <?php
    echo $this->render('/entreprise/entr_contact_form',['modelcontacts'=>$modelcontacts,'form'=>$form]);
    ?>

    <?= $form->field($model, 'id_ent')->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
