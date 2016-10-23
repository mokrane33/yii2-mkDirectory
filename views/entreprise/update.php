<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entreprise */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Entreprise',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entreprises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="entreprise-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress
    ]) ?>

</div>
