<?php

use app\modules\lyxeoville\models\Ville;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\EntrAdresse */
/* @var $form yii\widgets\ActiveForm */
?>
<?php //$this->registerJsFile('https://maps.googleapis.com/maps/api/js?v=3&libraries=place?s'); ?>

<?php $this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=AIzaSyCBad-zzqWdV0yBdo9SslEa7ynLcdPAT-c',['attribute'=>'async defer']); ?>
<?php
if(!$model->isNewRecord) {
    $app = " function initMap() {
        var mapDiv = document.getElementById('mapgoogle');
          map = new google.maps.Map(mapDiv, {
          center: {lat:".$model->latitude.", lng:".$model->longitude."},
          zoom: 15
        });
         marker = new google.maps.Marker({
                    map : map,
                    position : {lat:".$model->latitude.", lng:".$model->longitude."},

                    draggable: true,
                    animation: google.maps.Animation.DROP,
                });
          marker.addListener('dragend', function(evt){
                    document.getElementById('entradresse-latitude').value=evt.latLng.lat();
                    document.getElementById('entradresse-longitude').value=evt.latLng.lng();
                });
      }";
}
else{
    $app = " function initMap() {
        var mapDiv = document.getElementById('mapgoogle');

          map = new google.maps.Map(mapDiv, {
          center: {lat: 36.540, lng: 3.482},
          zoom: 7
        });

             marker = new google.maps.Marker({
                        map : map,
                        position : {lat: 36.540, lng:3.482},

                        draggable: true,
                        animation: google.maps.Animation.DROP,
                    });
          marker.addListener('dragend', function(evt){
                    document.getElementById('entradresse-latitude').value=evt.latLng.lat();
                    document.getElementById('entradresse-longitude').value=evt.latLng.lng();
                });
      }";

}
$app .= "function getgeoloc()
    {
        // creation objet Geocoder
        var geocoder = new google.maps.Geocoder();
        var address=document.getElementById(\"entradresse-adresss\").value+' '+$('#subcat-id option:selected').html()+' '+$('#level0 option:selected').html();

        // appel methode geocode
//        alert(address);

        geocoder.geocode( { 'address': address}, function( data, status) {
            // reponse OK
            if( status == google.maps.GeocoderStatus.OK){
                // recup. position
                pos = data[0].geometry.location;
                        document.getElementById(\"entradresse-latitude\").value=data[0].geometry.location.lat();
                        document.getElementById(\"entradresse-longitude\").value=data[0].geometry.location.lng();
                        // set marker position
                        marker.setPosition(pos);
                        // centrage de la carte
                        map.setCenter( pos);
                        map.setZoom(10);
                    }
            else {
                alert(\"Geocode was not successful for the following reason: \" + status);
            }
        });
    }";
$this->registerJs($app,  $this::POS_BEGIN);
?>
<?php //$this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap',['attribute'=>'async defer']); ?>
<?php
//if(!$model->isNewRecord) {
//    $app = " function initMap() {
//        var mapDiv = document.getElementById('mapgoogle');
//          map = new google.maps.Map(mapDiv, {
//          center: {lat:".$model->latitude.", lng:".$model->longitude."},
//          zoom: 10
//        });
//         marker = new google.maps.Marker({
//                    map : map,
//                    position : {lat:".$model->latitude.", lng:".$model->longitude."},
//                    draggable: true,
//                    animation: google.maps.Animation.DROP,
//                });
//          marker.addListener('dragend', function(evt){
//                    document.getElementById('entradresse-latitude').value=evt.latLng.lat();
//                    document.getElementById('entradresse-longitude').value=evt.latLng.lng();
//                });
//      }";
//}
//else{
//    $app = " function initMap() {
//        var mapDiv = document.getElementById('mapgoogle');
//          map = new google.maps.Map(mapDiv, {
//          center: {lat: 36.540, lng: 0.0546},
//          zoom: 2
//        });
//         marker = new google.maps.Marker({
//                    map : map,
//                    position : {lat: 36.540, lng: 0.0546},
//
//                    draggable: true,
//                    animation: google.maps.Animation.DROP,
//                });
//          marker.addListener('dragend', function(evt){
//                    document.getElementById('entradresse-latitude').value=evt.latLng.lat();
//                    document.getElementById('entradresse-longitude').value=evt.latLng.lng();
//                });
//      }";
//
//}
//$app .= "function getgeoloc()
//    {
//        // creation objet Geocoder
//        var geocoder = new google.maps.Geocoder();
//        var address= $(\"#level0 option:selected\").html()+', '+$(\"#subcat-id option:selected\").html()+', '+$(\"#entradresse-adresss\").val();
//        // appel methode geocode
//
//        geocoder.geocode( { 'address': address}, function( data, status) {
//            // reponse OK
//            if( status == google.maps.GeocoderStatus.OK){
//                // recup. position
//                pos = data[0].geometry.location;
//                        document.getElementById(\"entradresse-latitude\").value=data[0].geometry.location.lat();
//                        document.getElementById(\"entradresse-longitude\").value=data[0].geometry.location.lng();
//                        // set marker position
//                        marker.setPosition(pos);
//                        // centrage de la carte
//                        map.setCenter( pos);
//                        map.setZoom(10);
//                    }
//            else {
//                alert(\"Geocode was not successful for the following reason: \" + status);
//            }
//        });
//
//
//         var service = new google.maps.places.PlacesService(map);
//  var pyrmont = new google.maps.LatLng(-25.363882,131.044922);
//   var placeResults = service.nearbySearch({
//    location: pyrmont,
//    radius: 10000 // meters
//  },sss);
//  aa=placeResults;
//  alert(aa);
//    };
//
//    function sss(results, status) {
//  if (status === google.maps.places.PlacesServiceStatus.OK) {
//    for (var i = 0; i < results.length; i++) {
//      alert(results[i]);
//    }
//  }";
//
//$app=
//    "function initMap() {
//  var pyrmont = {lat:36.7301683, lng:3.9598303};
// // var mapDiv = document.getElementById('mapgoogle');
//  map = new google.maps.Map(document.getElementById('mapgoogle'), {
//    center: pyrmont,
//    zoom: 15
//  });
//
//  infowindow = new google.maps.InfoWindow();
//
//  var service = new google.maps.places.PlacesService(map);
//  service.nearbySearch({
//    location: pyrmont,
//    radius: 25000,
//    types: ['city_hall']
//  }, callback);
//}
//
//function callback(results, status) {
//  if (status === google.maps.places.PlacesServiceStatus.OK) {
//    for (var i = 0; i < results.length; i++) {
//      alert(results[i]);
//    }
//  }
//}";
//$this->registerJs($app,  $this::POS_BEGIN);
?>
<?php
$wilaya=ArrayHelper::map(Ville::find()->andFilterWhere(['id_parent'=>0,'status'=>1])->asArray()->all(),'id','name');
?>

<div class="entr-adresse-form">

   <?php
   if($model->isNewRecord)
   {
       $objwilaya=new Ville();
           $villes=[];
   }else
   {

       $objwilaya=$model->getVille()->one()->getparent();
       $villes=ArrayHelper::map($objwilaya->getChildren(),'id','name');
   }


    echo $form->field($objwilaya, 'id')->widget(Select2::classname(), [
       'data' => $wilaya,
       'options' => ['multiple' => false,'id'=>'level0', 'placeholder' => 'Select states ...']
   ]);
   ?>


  <?php  echo $form->field($model, 'ville')->widget(DepDrop::classname(), [
      'data' => $villes,
    'options'=>['id'=>'subcat-id'],
    'pluginOptions'=>[
    'depends'=>['level0'],
    'placeholder'=>'Select...',
    'url'=>Url::to(['/ville/default/getlist'])
    ]
    ]);?>

   <?php //= $form->field($model, 'ville')->textInput() ?>

    <?= $form->field($model, 'adresss')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>
    <div onclick="getgeoloc()">Trouver GPS depuis adress</div>
    <div id="mapgoogle"></div>

</div>
