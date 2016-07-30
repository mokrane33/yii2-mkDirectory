<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ville */

$this->title = Yii::t('app', 'Create Ville');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Villes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ville-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
