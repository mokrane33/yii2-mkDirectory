<?php

use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\EntrCat */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$categorie=ArrayHelper::map(\app\models\Category::find()->andFilterWhere(['id_parent'=>0,'status'=>1])->asArray()->all(),'id','name');
?>

<?php
    DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_categorie', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 5, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $modelCats[0],
    'formId' => 'dynamic-form',
    'formFields' => [
    'type',
    'valeur',
    ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> categorie
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Ajouter contact</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelCats as $index => $modelCat): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">Contact: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">

                        <?= $form->field($modelCat, "[{$index}]id_cat")->textInput() ?>


                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>
