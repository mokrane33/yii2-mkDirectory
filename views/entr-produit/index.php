<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrProduitSearch */
/* @var $modelentreprise app\models\Entreprise */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Entr Produits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entr-produit-index">
    <?= $this->render('/entr-annex/_entreprise',['modelentreprise'=>$modelentreprise]);?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Entr Produit'), ['create','id_ent'=>$modelentreprise->id], ['class' => 'btn btn-success']) ?>
    </p>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_ent',
            'title',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn',

                'urlCreator' => function ($action, $model, $key, $index) {
                    switch($action)
                    {
                        case 'view': return Url::to(['view', 'id' => $model->id,'id_ent'=>$model->id_ent]);break;
                        case 'update': return Url::to(['update', 'id' => $model->id,'id_ent'=>$model->id_ent]);break;
                        case 'delete': return Url::to(['delete', 'id' => $model->id,'id_ent'=>$model->id_ent]);break;

                    }
                }
            ],
        ],
    ]); ?>
</div>
