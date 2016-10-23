<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entreprise */

$this->title = $model->raisonsociale;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entreprises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$ressource= new \app\resources\Resources();
?>
<?php $this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCBad-zzqWdV0yBdo9SslEa7ynLcdPAT-c', ['attribute' => 'async defer']); ?>
<div class="col-lg-9 col-md-8 col-sm-12">
    <div class="entreprise-view">

        <div class="panel panel-default  row">
            <div class="panel-heading">
                <h1><?= Html::encode($model->raisonsociale) ?> </h1>
            </div>
            <div class="panel-body">

                <div class="col-md-6">
                    <label>Forme juridique : </label> <?= Html::encode($ressource->form_jurid[$model->form_jurid]);?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <label>Année de Création : </label><?= Html::encode($model->createdyear)?>
                </div>
                <div class="col-md-6">
                    <label>Categorie : </label>
                    <?php $categories = $model->getCats()->all() ?>
                    <?php /** @var \app\modules\lyxeocat\models\Category $category */
                    foreach ($categories as $category):
                        echo Html::a(Html::encode($category->name),Url::to(['/entreprise/category','slug'=>$category->slug])) . ', ';
                    endforeach;
                    ?>
                </div>



                <div class="col-md-12">
                    <label>Adresse : </label>
                    <?php /** @var \app\models\EntrAdresse $address */
                    $address = $model->getEntrAdresse()->one(); ?>
                    <?php $adressall = Html::encode($address->adresss);
                    $ville = $address->getVille()->one();
                    $adressall .= ' ' .Html::a(Html::encode($ville->name),Url::to(['/entreprise/ville','slug'=>$ville->slug])) ;
                    if ($a = $ville->getparent())
                        $adressall .= ', ' . Html::a(Html::encode($a->name),Url::to(['/entreprise/ville','slug'=>$a->slug]));
                    echo $adressall;

                    ?>
                </div>


                <div class="col-md-10">
                    <label>Description : </label></br>
                    <?= Html::encode($model->description_big)?>
                </div>
                <div class="clearfix"> </div>
                <div class="col-md-10">
                    <label>Contact</label>
                    <?php if($contacts= $model->getEntrCont()->all()):?>
                        <?php var_dump($contacts)?>
                    <?php endif?>
                </div>
                <div class="col-md-10">
                    <br/>
                    <?php
                        echo $address->latitude ;
                        $app = "function initMap() {
                            var mapDiv = document.getElementById('mapgoogle');

                            map = new google.maps.Map(mapDiv, {
                            center: {lat: " . $address->latitude . ", lng: " . $address->longitude . "},
                            zoom: 7,'mapTypeId': google.maps.MapTypeId.ROADMAP
                            });";
                        $app .= $address->AddToMap('', $model->raisonsociale);
                        $app .= "}
                                google.maps.event.addDomListener(window, 'load', initMap);";
                        $this->registerJs($app);

                    ?>
                    <div class="" style="height: 400px; overflow: hidden; width: 100% ">
                        <div id="mapgoogle"></div>
                    </div>
                </div>



            </div>
        </div>


    </div>

</div>
<?= $this->render('/layouts/right')?>