<?php

namespace app\modules\lyxeoville\models;

use Yii;

/**
 * This is the model class for table "{{%ville}}".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property integer $status
 * @property integer $level
 */
class Ville extends Cat
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%ville}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent', 'status', 'level'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_parent' => Yii::t('app', 'Id Parent'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'level' => Yii::t('app', 'Level'),
        ];
    }

    public static function find()
    {
        return new VilleQuery(get_called_class());
    }


//    public function getascendent()
//    {
//        $this-<getparent
//    }
}
