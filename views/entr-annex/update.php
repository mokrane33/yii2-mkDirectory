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

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Entr Annex',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => $modelentreprise->raisonsociale, 'url' => ['index?id_ent='.$modelentreprise->id]];
$this->params['breadcrumbs'][] =Yii::t('app', 'update Annexe').' '.$model->id;

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entr Annexes'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="entr-annex-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelentreprise'=>$modelentreprise
    ]) ?>

</div>
