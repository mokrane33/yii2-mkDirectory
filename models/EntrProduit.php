<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%entr_produit}}".
 *
 * @property integer $id
 * @property integer $id_ent
 * @property string $title
 * @property string $description
 *
 * @property Entreprise $idEnt
 * @property EntrProduitImage[] $entrProduitImages
 */
class EntrProduit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entr_produit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ent'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'id_ent' => Yii::t('app', 'Id Ent'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function beforedelete()
    {
        foreach($this->getEntrProduitImages()->all() as $model)
            $model->delete();


        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnt()
    {
        return $this->hasOne(Entreprise::className(), ['id' => 'id_ent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrProduitImages()
    {
        return $this->hasMany(EntrProduitImage::className(), ['id_prod' => 'id']);
    }
}
