<?php

namespace app\models;

use Yii;
use app\modules\lyxeoville\models\Ville;

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
}
