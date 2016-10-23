<?php

namespace app\models;

use Yii;
use app\modules\lyxeoville\models\Ville;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%entr_adresse}}".
 *
 * @property integer $id
 * @property integer $type_ent
 * @property integer $id_ent
 * @property integer $ville
 * @property string $adresss
 * @property double $longitude
 * @property double $latitude
 */
class EntrAdresse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entr_adresse}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_ent', 'id_ent', 'ville'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['adresss'], 'string', 'max' => 255],
            [['ville'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_ent' => Yii::t('app', 'Type Ent'),
            'id_ent' => Yii::t('app', 'Id Ent'),
            'ville' => Yii::t('app', 'Ville'),
            'adresss' => Yii::t('app', 'Adresss'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude' => Yii::t('app', 'Latitude'),
        ];
    }

    public function getVille()
    {
        return $this->hasOne(Ville::className(), ['id' => 'ville']);
    }

    public function AddToMap($contacts = null, $entreprise = null)
    {
        $contentString= '<div id="content">' .
            '<div id="siteNotice">' .
            ' <h1>' . $entreprise . '</h1>' .
            '</div>' ;
        if ($contacts):
            /** @var Ville $ville */
            $ville = $this->getVille()->one();
            $adville = $ville->name;
            if ($a = $ville->getparent())
                $adville .= ', ' . $a->name;
            $contentString =
                '<h3 id="firstHeading" class="firstHeading">' . $this->adresss . ' ' . $adville . '</h3><div id="bodyContent">';
            /** @var EntrCont $contact */
            $typecontact = New TypeContact();
            foreach ($contacts as $contact) {
                $contentString .= $typecontact->getFontAwesome($contact->type) . ' ' . $contact->valeur . '<br/>';
            }
            $contentString .= '</div>';


        endif;
        $contentString .= '</div>';

        $aa = "var infowindow = new google.maps.InfoWindow({
            content: '" . $contentString . "'
                });";
        $app = $aa;
        $lat = $this->latitude;
        $lon = $this->longitude;
        $app .= 'var markers=[];';

//        for(var i=0;i<10;i=i+1){
        $app .= " var lat=" . $lat . ";";
        $app .= " var lon=" . $lon . ";
        var marker = new google.maps.Marker({

                        position : {lat: lat, lng: lon },

                        //draggable: true,
                        animation: google.maps.Animation.DROP,
                    });
                     marker.addListener('click', function() {
                     infowindow.open(map, marker);
  });
  markers.push(marker);";
//        lat=lat+0.1;}

        $app .= "var markerCluster = new MarkerClusterer(map, markers,{imagePath: '" . Url::base() . "/images/maps/m'});";
        return $app;
    }


}
