<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntrepriseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entreprise-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'modified') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'raisonsociale') ?>

    <?php // echo $form->field($model, 'description_small') ?>

    <?php // echo $form->field($model, 'description_big') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
