<?php

namespace app\models;

use app\modules\lyxeocat\models\Category;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%entreprise}}".
 *
 * @property integer $id
 * @property string $created
 * @property string $modified
 * @property integer $status
 * @property string $image
 * @property string $raisonsociale
 * @property string $description_small
 * @property string $description_big
 * @property integer $user_id
 * @property string $slug
 * @property string $createdyear
 * @property integer $form_jurid
 * @property string $defaultlogo
 *
 * @property EntrAnnex[] $entrAnnexes
 * @property EntrCat[] $entrCats
 * @property EntrProduit[] $entrProduits
 */
class Entreprise extends Image
{
    /**
     * @inheritdoc
     */
    public $imagefile;
    public $defaultlogo='images/logo.png';
   public $image_path='images/entrepriselogo/';
    public $entreprise_cat_array=[];
    public static function tableName()
    {
        return '{{%entreprise}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'raisonsociale',
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
            [['created', 'modified'], 'safe'],
            [['status','user_id','form_jurid'], 'integer'],
            [['description_small', 'description_big'], 'string'],
            [[ 'image','raisonsociale','createdyear'], 'string', 'max' => 255],
            [['entreprise_cat_array'], 'each', 'rule' => ['integer']],
            [[ 'raisonsociale'], 'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created' => Yii::t('app', 'Created'),
            'modified' => Yii::t('app', 'Modified'),
            'status' => Yii::t('app', 'Status'),
            'image' => Yii::t('app', 'Logo'),
            'imagefile' => Yii::t('app', 'Logo'),
            'raisonsociale' => Yii::t('app', 'Raisonsociale'),
            'description_small' => Yii::t('app', 'Description Small'),
            'description_big' => Yii::t('app', 'Description Big'),
            'createdyear' => Yii::t('app', 'Annee creation'),
            'form_jurid' => Yii::t('app', 'Forme Juridique'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrAnnexes()
    {
        return $this->hasMany(EntrAnnex::className(), ['id_ent' => 'id']);
    }


    public function aftersave($insert, $changedAttributes)
    {
      $cats= $this->getCats()->all();
        $oldIDsCont = ArrayHelper::map($cats, 'id', 'id');
       $dellcats= array_diff($oldIDsCont,$this->entreprise_cat_array);
        EntrCat::deleteAll(['id_cat'=>$dellcats,'id_ent'=>$this->id]);
        $addcats=array_diff($this->entreprise_cat_array,$oldIDsCont);
        foreach($addcats as $id_cat)
        {
            $addcat=new EntrCat();
            $addcat->id_cat=$id_cat;
            $addcat->id_ent=$this->id;
            $addcat->save();
        }

        return parent::afterSave($insert, $changedAttributes);
    }


    public function afterFind()
    {
        $cats= $this->getCats()->all();
        $this->entreprise_cat_array=ArrayHelper::map($cats, 'id', 'id');
        parent::afterFind();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrCont()
    {
        return $this->hasMany(EntrCont::className(), ['id_ent' => 'id'])->andFilterWhere(['type_ent'=>0])->orderBy('type');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrAdresse()
    {
        return $this->hasMany(EntrAdresse::className(), ['id_ent' => 'id'])->andFilterWhere(['type_ent'=>0]);
    }

    public function getEntrAdresseSec()
    {
        return $this->hasMany(EntrAdresse::className(), ['id_ent' => 'id'])->andFilterWhere(['type_ent'=>1])->viaTable('entr_annex', ['id_ent' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(Category::className(), ['id' => 'id_cat'])
            ->viaTable('entr_cat', ['id_ent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrProduits()
    {
        return $this->hasMany(EntrProduit::className(), ['id_ent' => 'id']);
    }

    public function getLogo()
    {
        if($this->getImageurl())
            return $this->getImageurl();
        else
            return Yii::getAlias('@web').'/'.$this->defaultlogo;
    }

    public function beforedelete()
    {

        foreach($this->getEntrAdresse()->all() as $entradress)
           $entradress->delete();
        foreach($this->getEntrCont()->all() as $entcont)
            $entcont->delete();
        foreach($this->getEntrAnnexes()->all() as $annex)
            $annex->delete();
        foreach($this->getEntrProduits()->all() as $annex)
            $annex->delete();

        return parent::beforeDelete();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
