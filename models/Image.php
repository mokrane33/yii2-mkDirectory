<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%probleme_cat}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 *
 * @property Probleme[] $problemes
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
//    public $imagefile;
//    public $image_path='images/problemecatimg/';
//    public static function tableName()
//    {
//        return '{{%probleme_cat}}';
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagefile'],'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */


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
        if($this->existImage())
            return Yii::getAlias('@web').'/'.$this->getImage();
        else
            return false;
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


    /**
     * @inheritdoc
     * @return ProblemeCatQuery the active query used by this AR class.
     */

}
