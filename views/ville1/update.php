<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ville */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ville',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Villes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ville-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
