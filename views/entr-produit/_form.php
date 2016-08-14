<?php

use kartik\file\FileInput;
use kartik\switchinput\SwitchInput;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntrProduit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entr-produit-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]); ?>

    <?= $form->field($model, 'id_ent')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?php
    DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_contact', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 5, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $produitImages[0],
    'formId' => 'dynamic-form',
    'formFields' => [
    'type',
    'valeur',
    ],

    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Contact
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Ajouter contact</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($produitImages as $index => $produitImage): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">image:</span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$produitImage->isNewRecord) {
                            echo Html::activeHiddenInput($produitImage, "[{$index}]id");
                        }
                        ?>


                        <div class="row">
                            <div class="col-sm-6">

                                <?php
                                $initialPreview = [];
                                if ($produitImage->existImage())
                                    $initialPreview[] = Html::img($produitImage->getImageurl(), ['class' => 'file-preview-image']); ?>
                                <?= $form->field($produitImage, "[{$index}]imagefile")->label(false)->widget(FileInput::className(), [
                                    'options' => [
                                        'multiple' => false,
                                        'accept' => 'image/*',
                                        'class' => 'optionvalue-img'
                                    ],
                                    'pluginOptions' => [
                                        'previewFileType' => 'image',
                                        'showCaption' => false,
                                        'showRemove'=>false,
                                        'showPreview' => true,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-default btn-sm',
                                        'browseLabel' => Yii::t('app',' Pick image'),
                                        'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                                        'removeClass' => 'btn btn-danger btn-sm delete-item',
                                        'removeLabel' => Yii::t('app','Delete'),
                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                        'previewSettings' => [
                                            'image' => ['width' => '138px', 'height' => 'auto']
                                        ],
                                        'initialPreview' => $initialPreview,
                                        'layoutTemplates' => ['footer' => '']
                                    ]
                                ])
                                //*/  ?>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
//JuiAsset::register($this);
$this->registerJs(
    <<< JS
$(".optionvalue-img").on("filecleared", function(event) {
    var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    var id = event.target.id;
    var matches = id.match(regexID);
    if (matches && matches.length === 4) {
        var identifiers = matches[2].split("-");
        $("#optionvalue-" + identifiers[1] + "-deleteimg").val("1");
    }
});
JS
);
?>