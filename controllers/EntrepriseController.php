<?php

namespace app\controllers;

use app\models\BaseModel;
use app\models\EntrAdresse;
use app\models\EntrCat;
use app\models\EntrCont;
use app\modules\lyxeocat\models\Category;
use app\modules\lyxeoville\models\Ville;
use kartik\widgets\ActiveForm;
use Yii;
use app\models\Entreprise;
use app\models\EntrepriseSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * EntrepriseController implements the CRUD actions for Entreprise model.
 */
class EntrepriseController extends BaseController
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
     * Lists all Entreprise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntrepriseSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status'=>1])->orderBy(['created'=>'DESC']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    /**
     * Lists all Entreprise models.
     * @return mixed
     */
    public function actionAdmin()
    {
        if(!Yii::$app->user->can('entreprise-admin')){
            return $this->permissionRedirect();
        }
        $searchModel = new EntrepriseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!Yii::$app->user->identity->isAdmin)
            $dataProvider->query->andWhere('user_id ='.Yii::$app->user->id);
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entreprise model.
     * @param string $id
     * @return mixed
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModelslug($slug),
        ]);
    }

    public function actionCategory($slug=null)
    {
        if($slug)
        {
            /** @var Category $model */
            $model=$this->findCatModelslug($slug);
            $entrepri=new ActiveDataProvider([
                'query' => Entreprise::find()->where(['id'=> $model-> getAllEntreIds(1)])->orderBy(['raisonsociale'=>'ASC']),
            ]);

            if($children=$model->getChildren())
//                return $this->render('/module/_cat-list', [
//                    'modelcat' => $model,
//                    'catmodels'=>$children->all()
//                ]);
                return $this->render('list_entre_by_cat', [
                    'modelcat' => $model,
                    'entreprises'=>$entrepri
                ]);
            else
                return $this->render('list_entre_by_cat', [
                    'modelcat' => $model,
                    'entreprises'=>$entrepri
                ]);

        }
        else{
            $models=Category::find()->orderBy(['name'=>'ASC'])->all();
            $title='Liste Categories';
            $this->render('category-list',['model-cat'=>null,'catmodels'=>$models]);
        }
    }
    public function actionVille($slug=null)
    {
        if($slug)
        {
            /** @var Category $model */
            $model=$this->findVilleModelslug($slug);
            $entrepri=new ActiveDataProvider([
                'query' => Entreprise::find()->where(['id'=> $model-> getAllEntreIds(3)])->orderBy(['raisonsociale'=>'ASC']),
            ]);

            if($children=$model->getChildren())
//                return $this->render('/module/_cat-list', [
//                    'modelcat' => $model,
//                    'catmodels'=>$children->all()
//                ]);
                return $this->render('list_entre_by_cat', [
                    'model-cat' => $model,
                    'entreprises'=>$entrepri
                ]);
            else
                return $this->render('list_entre_by_cat', [
                    'model-cat' => $model,
                    'entreprises'=>$entrepri
                ]);

        }
        else{
            $models=Category::find()->orderBy(['name'=>'ASC'])->all();
            $title='Liste Ville';
            $this->render('category-list',['model-cat'=>null,'catmodels'=>$models]);
        }
    }

    /**
     * Creates a new Entreprise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('entreprise-create')){
            return $this->permissionRedirect();
        }

        $model = new Entreprise();
        $model->status=0;
        $modelcontacts=[new EntrCont()];
        $modelAdress=new EntrAdresse();
        $modelCats=[new EntrCat()];
        if(!Yii::$app->user->identity->isAdmin)
            $model->user_id=Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->created=date("Y-m-d");

            /* logo upload*/
            $model->imagefile=UploadedFile::getInstance($model,'imagefile');
            if($model->imagefile)
            {
                $model->image=$model->getUniqueName($model->imagefile->name);
            }
            /*logo upload*/

            /* contacts load in model*/
            $modelcontacts=BaseModel::createMultiple(EntrCont::className());
            Model::loadMultiple($modelcontacts,Yii::$app->request->post());
            /*contacts load in model*/

            /* adress load in model*/

            $modelAdress->load(Yii::$app->request->post());
            $modelAdress->type_ent=0;
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
                            $modelcontact->type_ent=0;
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
                        if($model->imagefile && $flag)
                            $model->imagefile->saveAs($model->getImage($model->image));

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
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelCats'=>$modelCats
                ]);
            }




            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,'modelcontacts'=>$modelcontacts,'modelAdress'=>$modelAdress,'modelCats'=>$modelCats
            ]);
        }
    }

    /**
     * Updates an existing Entreprise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(!Yii::$app->user->can('entreprise-update' , ['entreprise' => $model])){
            return $this->permissionRedirect();
        }
        $user_id=$model->user_id;

        $modelcontacts=$model->getEntrCont()->all();
        $modelAdress=$model->getEntrAdresse()->one();
//var_dump($modelAdress);exit;

        if ($model->load(Yii::$app->request->post())) {
            if(!Yii::$app->user->identity->isAdmin)
                $model->user_id=$user_id;
            $model->modified=date("Y-m-d");
            $oldIDsCont = ArrayHelper::map($modelcontacts, 'id', 'id');
            $modelcontacts = BaseModel::createMultiple(EntrCont::classname(), $modelcontacts);
            Model::loadMultiple($modelcontacts, Yii::$app->request->post());
            $deletedIDsCont = array_diff($oldIDsCont, array_filter(ArrayHelper::map($modelcontacts, 'id', 'id')));

            $modelAdress->load(Yii::$app->request->post());
            $modelAdress->type_ent=0;

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
                            $modelcontact->type_ent=0;
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

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,'modelcontacts'=>(empty ($modelcontacts)) ? [new EntrCont()]: $modelcontacts,'modelAdress'=>$modelAdress
            ]);
        }
    }

    /**
     * Deletes an existing Entreprise model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model= $this->findModel($id);
        if(!Yii::$app->user->can('entreprise-delete', ['entreprise' => $model])){
            return $this->permissionRedirect();
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entreprise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entreprise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entreprise::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelslug($id)
    {
        if (($model = Entreprise::findOne(['slug' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findCatModelslug($id)
    {
        if (($model = Category::findOne(['slug' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findVilleModelslug($id)
    {
        if (($model = Ville::findOne(['slug' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
