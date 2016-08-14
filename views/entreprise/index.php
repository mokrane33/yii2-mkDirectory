<?php


use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrepriseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Entreprises');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="entreprise-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Entreprise'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            [
                    'label' => 'Annexe',
                    'format' => 'html',
                    'value' => function ($data) {
                        return Html::a(FA::icon(FA::_PENCIL) ,Url::to(['/entr-annex/', 'id_ent' => $data->id]));
                    }

            ],
            [
                    'label' => 'Produits et services',
                    'format' => 'html',
                    'value' => function ($data) {
                        return Html::a(FA::icon(FA::_PENCIL) ,Url::to(['/entr-produit/', 'id_ent' => $data->id]));
                    }

            ],

            'raisonsociale',
            // 'description_small:ntext',
            // 'description_big:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
