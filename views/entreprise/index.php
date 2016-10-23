<?php


use app\models\Entreprise;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrepriseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$entreprises=Entreprise::find()->andWhere(['status'=>1])->limit(20)->orderBy(['created'=>'desc'])->all();
$this->title = Yii::t('app', 'Entreprises');
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="col-lg-9 col-md-8 col-sm-8">
        <?= $this->render('/module/_last_register',['models'=>$entreprises,'title'=>'Dernieres entreprise inscritent'])?>

    </div>
<?= $this->render('/layouts/right')?>
