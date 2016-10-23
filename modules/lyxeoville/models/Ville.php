<?php

namespace app\modules\lyxeoville\models;

use Yii;
use yii\behaviors\SluggableBehavior;

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

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true,
                'ensureUnique'=>true,
            ],
        ];
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

    public function getAllEntreIds($status=3)
    {
        $entreprise=$this->getEntreprise();
        if($status==0)
            $entreprise->andWhere(['status'=>0]);
        if($status==1)
            $entreprise->andWhere(['status'=>1]);

        $a= ArrayHelper::map( $entreprise->all(),'id','id'); // $entreprise->all();

        if($children=$this->getChildren()->all())
        {
            foreach($children as $child)
            {
                $a+=$child->getAllEntreIds($status=3);
            }
        }

        return $a;
    }
    public function getEntreprise()
    {
        return $this->hasMany(Entreprise::className(), ['id' => 'id_ent'])
            ->viaTable('entr_cat', ['id_cat' => 'id']);
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
