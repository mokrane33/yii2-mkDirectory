<?php

use app\modules\lyxeoville\models\Ville;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lyxeoville\models\Ville */
/* @var $form yii\widgets\ActiveForm */
/*ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
$modelList=Ville::find()->all();*/

$ville=Ville::gettreeArray((new Ville)->getTree());

?>

<div class="ville-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_parent')->dropDownList($ville,['prompt' => ' -- Root --']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?=   $form->field($model, 'status')->widget(SwitchInput::classname(), [
        'type' => SwitchInput::CHECKBOX
    ]);?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
