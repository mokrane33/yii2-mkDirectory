<?php

namespace app\models;

use Yii;
use app\modules\lyxeocat\models\Category;

/**
 * This is the model class for table "entr_cat".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_ent
 *
 * @property Category $idCat
 * @property Entreprise $idEnt
 */
class EntrCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entr_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_ent'], 'integer'],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_ent'], 'exist', 'skipOnError' => true, 'targetClass' => Entreprise::className(), 'targetAttribute' => ['id_ent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_cat' => Yii::t('app', 'Id Cat'),
            'id_ent' => Yii::t('app', 'Id Ent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnt()
    {
        return $this->hasOne(Entreprise::className(), ['id' => 'id_ent']);
    }
}
