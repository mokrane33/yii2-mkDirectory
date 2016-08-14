<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%entr_produit_image}}".
 *
 * @property integer $id
 * @property integer $id_prod
 * @property string $image
 * @property integer $default
 *
 * @property EntrProduit $idProd
 */
class EntrProduitImage extends Image
{
    /**
     * @inheritdoc
     */
    public $imagefile;
    public $image_path='images/produitimg/';
    public static function tableName()
    {
        return '{{%entr_produit_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prod', 'default'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['id_prod'], 'exist', 'skipOnError' => true, 'targetClass' => EntrProduit::className(), 'targetAttribute' => ['id_prod' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_prod' => Yii::t('app', 'Id Prod'),
            'image' => Yii::t('app', 'Image'),
            'default' => Yii::t('app', 'Default'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProd()
    {
        return $this->hasOne(EntrProduit::className(), ['id' => 'id_prod']);
    }
}
