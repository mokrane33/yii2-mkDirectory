<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntrAnnex */
/* @var $modelcontacts app\models\EntrCont */
/* @var $modeladress app\models\EntrAdresse */
/* @var $modelentreprise app\models\Entreprise */
?>
<?= $this->render('_entreprise',['modelentreprise'=>$modelentreprise])?>
<?php
//$this->title = Yii::t('app', 'Create Entr Annex');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entr Annexes'), 'url' => ['index?id_ent='.$modelentreprise->id]];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index?id_ent='.$modelentreprise->id]];
$this->params['breadcrumbs'][] =Yii::t('app', 'Add Annexe');
?>
<div class="entr-annex-create">
    <h1><?= Html::encode(Yii::t('app', 'Create Entr Annex')) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelentreprise'=>$modelentreprise
    ]) ?>

</div>
