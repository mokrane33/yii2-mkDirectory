<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%entr_annex}}".
 *
 * @property integer $id
 * @property integer $id_ent
 *
 * @property Entreprise $idEnt
 */
class EntrAnnex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entr_annex}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ent'], 'integer'],
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
        ];
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
    public function getEntrCont()
    {
        return $this->hasMany(EntrCont::className(), ['id_ent' => 'id'])->andFilterWhere(['type_ent'=>1]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrAdresse()
    {
        return $this->hasMany(EntrAdresse::className(), ['id_ent' => 'id'])->andFilterWhere(['type_ent'=>1]);
    }

    public function beforedelete()
    {

        foreach($this->getEntrAdresse()->all() as $entradress)
            $entradress->delete();
        foreach($this->getEntrCont()->all() as $entcont)
            $entcont->delete();

        return parent::beforeDelete();
    }
}
