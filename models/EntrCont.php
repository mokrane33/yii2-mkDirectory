<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%entr_cont}}".
 *
 * @property integer $id
 * @property integer $type_ent
 * @property integer $id_ent
 * @property integer $type
 * @property string $valeur
 */
class EntrCont extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entr_cont}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_ent', 'id_ent', 'type'], 'integer'],
            [['valeur'], 'string', 'max' => 255],
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
            'type' => Yii::t('app', 'Type'),
            'valeur' => Yii::t('app', 'Valeur'),
        ];
    }
}
