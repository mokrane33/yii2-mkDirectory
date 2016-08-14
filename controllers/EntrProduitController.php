<?php

namespace app\controllers;

use app\models\BaseModel;
use app\models\Entreprise;
use app\models\EntrProduitImage;
use kartik\form\ActiveForm;
use Yii;
use app\models\EntrProduit;
use app\models\EntrProduitSearch;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * EntrProduitController implements the CRUD actions for EntrProduit model.
 */
class EntrProduitController extends Controller
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
     * Lists all EntrProduit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);
        $params['EntrProduitSearch']['id_ent']=$params['id_ent'];
        $searchModel = new EntrProduitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'modelentreprise'=>$modelentreprise,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntrProduit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);
        return $this->render('view', [
            'modelentreprise'=>$modelentreprise,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntrProduit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);

        $model = new EntrProduit();
        $produitImages=[new EntrProduitImage()];

        if ($model->load(Yii::$app->request->post())) {
            $produitImages=BaseModel::createMultiple(EntrProduitImage::className());
            Model::loadMultiple($produitImages,Yii::$app->request->post());
            foreach ($produitImages as $index => $produitImage) {
                $produitImage->imagefile = UploadedFile::getInstance($produitImage, "[{$index}]imagefile");
                if($produitImage->imagefile)
                    $produitImage->image=$produitImage->getUniqueName($produitImage->imagefile->name);
            }


            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelcontacts),
                    ActiveForm::validate($model),
                    ActiveForm::validateMultiple($produitImages)
                );
            }
            $valid = $model->validate();
            $valid = Model::validateMultiple($produitImages)&& $valid;
            if($valid) {
                $transaction=\Yii::$app->db->beginTransaction();
                try{
                    if($flag=$model->save(false))
                    {
                        foreach($produitImages as $produitImage)
                        {
                            $produitImage->id_prod=$model->id;
                            if(!($produitImage->save(false)))
                            {
                                $flag=false;
                                break;
                            }
                        }

                        foreach($produitImages as $produitImage){
                            if( $produitImage->imagefile)
                                $produitImage->imagefile->saveAs($produitImage->getImage());
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
                    'model' => $model,'produitImages'=>$produitImages,'modelentreprise'=>$modelentreprise
                ]);
            }


            //return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            $model->id_ent=$params['id_ent'];
            return $this->render('create', [
                'model' => $model,'produitImages'=>$produitImages,'modelentreprise'=>$modelentreprise
            ]);
        }
    }

    /**
     * Updates an existing EntrProduit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);

        $model = $this->findModel($id);

        $produitImages=$model->getEntrProduitImages()->all();
        if ($model->load(Yii::$app->request->post())) {
            $oldIDsPI = ArrayHelper::map($produitImages, 'id', 'id');
            $produitImages = BaseModel::createMultiple(EntrProduitImage::classname(), $produitImages);
            Model::loadMultiple($produitImages, Yii::$app->request->post());
            $deletedIDsPI = array_diff($oldIDsPI, array_filter(ArrayHelper::map($produitImages, 'id', 'id')));

            foreach ($produitImages as $index => $produitImage) {
                $produitImage->imagefile = UploadedFile::getInstance($produitImage, "[{$index}]imagefile");
                if($produitImage->imagefile)
                    if(!$produitImage->image)
                        $produitImage->image=$produitImage->getUniqueName($produitImage->imagefile->name);

            }

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelcontacts),
                    ActiveForm::validate($model),
                    ActiveForm::validateMultiple($produitImages)
                );
            }
            $valid = $model->validate();
            $valid = Model::validateMultiple($produitImages)&& $valid;
            if($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if($flag=$model->save(false))
                    {
                        foreach($produitImages as $produitImage)
                        {
                            $produitImage->id_prod=$model->id;
                            if (! ($flag = $produitImage->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                        }
                        if(!empty($deletedIDsPI))
                        {
                            foreach($deletedIDsPI as $delteidimage)
                            {
                                if( $modelimagedel=EntrProduitImage::findOne($delteidimage))
                                    $modelimagedel->delete();
                            }
//                            PartnerImages::deleteAll(['id'=>$deletedIDsImg]);
                        }

                        foreach($produitImages as $produitImage){
                            if( $produitImage->imagefile)
                                $produitImage->imagefile->saveAs($produitImage->getImage());
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

            return $this->redirect(['index', 'id_ent' => $modelentreprise->id]);
        } else {
            return $this->render('update', [
                'model' => $model,'produitImages'=>(empty ($produitImages)) ? [new EntrProduitImage()]: $produitImages,'modelentreprise'=>$modelentreprise
            ]);
        }
    }
    /**
     * Deletes an existing EntrProduit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $params= Yii::$app->request->queryParams;
        if(!array_key_exists('id_ent',$params))
            return $this->redirect(['/entreprise']);
        if(!$modelentreprise=Entreprise::find()->where(['id'=>$params['id_ent']])->one())
            return $this->redirect(['/entreprise']);

        if (($model = EntrProduit::find()->where('id='.$id.' and id_ent='.$params['id_ent'])->one()) !== null) {
            $model->delete();
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->redirect(['index','id_ent'=>$params['id_ent']]);

    }

    /**
     * Finds the EntrProduit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EntrProduit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntrProduit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
