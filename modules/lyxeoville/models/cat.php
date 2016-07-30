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
class Cat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $child=[];


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


    public function getTree($parent=0)
    {
        if($models=$this->find()->andFilterWhere(['id_parent'=>$parent])->orderBy('name')->all())
        {

           foreach($models as $key => $model)
           {
               $models[$key]->child=$this::getTree($model->id);
           }
            return $models;
        }


    }

    public static function gettreeArray($models,$array=[],$sep='')
    {


       // var_dump($models);echo'1111';
       // exit;
      if($models)
        foreach($models as $model)
        {
            //var_dump($model,'22222');
            $array[$model->id]=$sep.' '.$model->name;
            //var_dump($model->child,'child');
            if(isset($model->child))
               $array =Ville::gettreeArray($model->child,$array,$sep.'-');


        }

        return $array;

    }

     public function afterSave($insert, $changedAttributes)
    {
       $children= $this->getChildren();
        /*ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
        var_dump($children);*/
        //exit;
        if($children)
        foreach($children as $child)
        {
            $child->level=$this->level+1;
            $child->save();
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getparent()
    {
        return $this->find()->andFilterWhere(['id'=>$this->id_parent])->one();
    }

    public function getChildren($id=null)
    {
        if($id==null)
        return $this->find()->andFilterWhere(['id_parent'=>$this->id])->orderBy('name')->all();
        else
            return $this->find()->andFilterWhere(['id_parent'=>$id])->orderBy('name')->all();
    }

}
