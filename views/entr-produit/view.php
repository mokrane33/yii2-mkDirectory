<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntrProduit */
/* @var $modelentreprise app\models\Entreprise */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entr Produits'), 'url' => ['index','id_ent'=>$modelentreprise->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entr-produit-view">
    <?= $this->render('/entr-annex/_entreprise',['modelentreprise'=>$modelentreprise]);?>
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id,'id_ent'=>$modelentreprise->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id,'id_ent'=>$modelentreprise->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'id_ent',
            'title',
            'description:ntext',
        ],
    ]) ?>

</div>
