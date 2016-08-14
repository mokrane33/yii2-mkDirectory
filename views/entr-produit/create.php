<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntrProduit */

$this->title = Yii::t('app', 'Create Entr Produit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entr Produits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entr-produit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'produitImages'=>$produitImages,'modelentreprise'=>$modelentreprise
    ]) ?>

</div>
