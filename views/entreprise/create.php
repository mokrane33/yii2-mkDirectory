<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Entreprise */

$this->title = Yii::t('app', 'Create Entreprise');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entreprises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entreprise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelCats'=>$modelCats
    ]) ?>

</div>
