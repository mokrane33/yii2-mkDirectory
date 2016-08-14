<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrAnnexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entreprise'), 'url' => ['/entreprise/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entreprise annex')];
?>
<div class="entr-annex-index">

<?= $this->render('_entreprise',['modelentreprise'=>$modelentreprise]);?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Entr Annex'), ['/entr-annex/create','id_ent'=>$modelentreprise->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_ent',

//            ['class' => 'yii\grid\ActionColumn'],
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
