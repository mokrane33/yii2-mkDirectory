<?php

namespace app\controllers;

use app\models\BaseModel;
use app\models\EntrAdresse;
use app\models\EntrCont;
use app\models\Entreprise;
use kartik\form\ActiveForm;
use Yii;
use app\models\EntrAnnex;
use app\models\EntrAnnexSearch;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * EntrAnnexController implements the CRUD actions for EntrAnnex model.
 */
class EntrAnnexController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntrAnnex models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
           return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);
        if(!Yii::$app->user->can('entreprise-update' , ['entreprise' => $modelentreprise])){
            return $this->permissionRedirect();
        }
        $params['EntrAnnexSearch']['id_ent']=$params['id_ent'];
        $searchModel = new EntrAnnexSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andWhere('')
        return $this->render('index', [
            'modelentreprise'=>$modelentreprise,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionAdmin()
//    {
//        $params= Yii::$app->request->queryParams;
//        if(!array_key_exists('id_ent',$params))
//           return $this->redirect(['/entreprise/admin']);
//        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
//            return $this->redirect(['/entreprise/admin']);
//        $params['EntrAnnexSearch']['id_ent']=$params['id_ent'];
//        $searchModel = new EntrAnnexSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
////        $dataProvider->query->andWhere('')
//        return $this->render('index', [
//            'modelentreprise'=>$modelentreprise,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single EntrAnnex model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise/admin']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise/admin']);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntrAnnex model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise/admin']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise/admin']);
        if(!Yii::$app->user->can('entreprise-update' , ['entreprise' => $modelentreprise])){
            return $this->permissionRedirect();
        }
        $model = new EntrAnnex();
        $modelcontacts=[new EntrCont()];
        $modelAdress=new EntrAdresse();


        if ($model->load(Yii::$app->request->post()))
        {
            /* contacts load in model*/
            $modelcontacts=BaseModel::createMultiple(EntrCont::className());
            Model::loadMultiple($modelcontacts,Yii::$app->request->post());
            /*contacts load in model*/

            /* adress load in model*/
            $modelAdress->load(Yii::$app->request->post());
            $modelAdress->type_ent=1;
            /* adress load in model*/

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelcontacts),
                    ActiveForm::validate($model),
                    ActiveForm::validate($modelAdress)
                );
            }

            $valid = $model->validate();
            $valid = $modelAdress->validate()&& $valid;
            $valid = Model::validateMultiple($modelcontacts)&& $valid;

            if($valid) {
                $transaction=\Yii::$app->db->beginTransaction();
                try{
                    if($flag=$model->save(false))
                    {
                        foreach($modelcontacts as $modelcontact)
                        {
                            $modelcontact->id_ent=$model->id;
                            $modelcontact->type_ent=1;
                            if(!($modelcontact->save(false)))
                            {
                                $flag=false;
                                break;
                            }
                        }
                        $modelAdress->id_ent=$model->id;
                        if(!($modelAdress->save(false)))
                        {
                            $flag=false;
                        }

                    }
                    if($flag)
                        $transaction->commit();

                    else
                        $transaction->rollBack();
                    //return $this->redirect(['index']);
                }
                catch(Exception $e)
                {
                    $transaction->rollBack();
                }
                return $this->redirect(['view', 'id' => $model->id,'id_ent' => $model->id_ent]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelentreprise'=>$modelentreprise
                ]);
            }


        //return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            $model->id_ent=$params['id_ent'];
            return $this->render('create', [
                'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelentreprise'=>$modelentreprise
            ]);
        }
    }

    /**
     * Updates an existing EntrAnnex model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise/admin']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise/admin']);

        if(!Yii::$app->user->can('entreprise-update' , ['entreprise' => $modelentreprise])){
            return $this->permissionRedirect();
        }
        $model = $this->findModel($id);
        $modelcontacts=$model->getEntrCont()->all();
        $modelAdress=$model->getEntrAdresse()->one();


        if ($model->load(Yii::$app->request->post())) {
            $oldIDsCont = ArrayHelper::map($modelcontacts, 'id', 'id');
            $modelcontacts = BaseModel::createMultiple(EntrCont::classname(), $modelcontacts);
            Model::loadMultiple($modelcontacts, Yii::$app->request->post());
            $deletedIDsCont = array_diff($oldIDsCont, array_filter(ArrayHelper::map($modelcontacts, 'id', 'id')));

            $modelAdress->load(Yii::$app->request->post());
            $modelAdress->type_ent=1;
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelcontacts),
                    ActiveForm::validate($model),
                    ActiveForm::validate($modelAdress)
                );
            }
            $valid = $model->validate();
            $valid = $modelAdress->validate()&&$valid;
            $valid = Model::validateMultiple($modelcontacts)&& $valid;
            if($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if($flag=$model->save(false))
                    {
                        if (! empty($deletedIDsCont)) {
                            EntrCont::deleteAll(['id' => $deletedIDsCont]);
                        }
                        foreach($modelcontacts as $modelcontact)
                        {
                            $modelcontact->id_ent=$model->id;
                            $modelcontact->type_ent=1;
                            if(!($modelcontact->save(false)))
                            {
                                $flag=false;
                                break;
                            }
                        }
                        $modelAdress->id_ent=$model->id;
                        if(!($modelAdress->save(false)))
                        {
                            $flag=false;
                        }


                    }
                    if($flag)
                        $transaction->commit();
                    else
                        $transaction->rollBack();

                }
                catch(Exception $e)
                {
                    $transaction->rollBack();
                }
            }

            return $this->redirect(['view', 'id' => $model->id,'id_ent' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,'modelcontacts'=>(empty ($modelcontacts)) ? [new EntrCont()]: $modelcontacts,'modelAdress'=>$modelAdress,'modelentreprise'=>$modelentreprise
            ]);
        }
    }
    /**
     * Deletes an existing EntrAnnex model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise/admin']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise/admin']);
        if(!Yii::$app->user->can('entreprise-update' , ['entreprise' => $modelentreprise])){
            return $this->permissionRedirect();
        }

        if (($model = EntrAnnex::find()->where('id='.$id.' and id_ent='.$params['id_ent'])->one()) !== null) {
             $model->delete();
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->redirect(['index','id_ent'=>$params['id_ent']]);
    }

    /**
     * Finds the EntrAnnex model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EntrAnnex the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntrAnnex::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
