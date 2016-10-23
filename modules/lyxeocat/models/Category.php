<?php

namespace app\modules\lyxeocat\models;

use app\models\EntrCont;
use app\models\Entreprise;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property integer $status
 * @property integer $level
 * @property string $image
 * @property string $description
 * @property string $meta_key
 * @property string $meta_description
 *
 */
class Category extends Cat
{
    /**
     * @inheritdoc
     */

    public $imagefile;
    public $image_path='images/categoryimg/';
    public static function tableName()
    {
        return '{{%category}}';
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
            [['description', 'meta_key', 'meta_description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['imagefile'],'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Description'),
            'meta_key' => Yii::t('app', 'Meta Key'),
            'meta_description' => Yii::t('app', 'Meta Description'),
        ];
    }
    public function getCountAllEntre($status=3)
    {
        $entreprise=$this->getEntreprise();
        if($status==0)
            $entreprise->andWhere(['status'=>0]);
        if($status==1)
            $entreprise->andWhere(['status'=>1]);

       $a= $entreprise->count();

        if($children=$this->getChildren()->all())
        {
           foreach($children as $child)
           {
               $a+=$child->getCountAllEntre($status);
           }
        }

        return $a;
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

    public function getUniqueName($origin=null)
    {
        $rand=rand(1,9999999);
        $filename=$rand.'_'.$origin;
        $img=$this->image_path.$filename;

        while(is_file(Yii::getAlias('@webroot').'/'. $img))
        {
            $rand=rand(1,9999999);
            $filename=$rand.'_'.$origin;
            $img=$this->image_path.$filename;
        }

        return $filename;
    }

    public function getImage()
    {
        return $this->image_path.$this->image;
    }

    public function getImageurl()
    {
        return Yii::getAlias('@web').'/'.$this->getImage();
    }

    public function existImage()
    {
        if(!empty($this->image))
        {
            if(is_file($this->getImage()))
                return true;
        }
        return false;
    }

    public function beforedelete()
    {

        if($this->existImage())
        {
            @unlink($this->getImage());
        }

        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntreprise()
    {
        return $this->hasMany(Entreprise::className(), ['id' => 'id_ent'])
            ->viaTable('entr_cat', ['id_cat' => 'id']);
    }



    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
