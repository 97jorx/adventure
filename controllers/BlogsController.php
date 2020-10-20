<?php

namespace app\controllers;

use Yii;
use app\models\Blogs;
use app\models\BlogsSearch;
use app\models\Integrantes;
use Symfony\Component\VarDumper\VarDumper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BlogsController implements the CRUD actions for Blogs model.
 */
class BlogsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blogs models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new BlogsSearch();
        
        if($actual = Yii::$app->request->get('actual')){

        }

        if(isset($_GET['actual']) == null ){
             throw new NotFoundHttpException('The requested page does not exist.');
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $actual);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actual' => $actual,
        ]);
        
    }

    /**
     * Displays a single Blogs model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $actual = Yii::$app->request->get('actual');
        return $this->render('view', [
            'model' => $this->findModel($id),
            'actual' => $actual
        ]);
    }

    /**
     * Creates a new Blogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Blogs();
        $uid = Yii::$app->user->id;
        $actual = Yii::$app->request->get('actual');
        $comunidad = Integrantes::find('comunidad_id')
        ->where(['usuario_id' => $uid])
        ->andWhere(['comunidad_id' => $actual]);

        if($comunidad->exists()){
            if (!Yii::$app->user->isGuest) {
                $model->usuario_id = $uid;
                $model->comunidad_id = $actual;
            } else {
                return $this->redirect(['site/login']);
            }    
        } else {
            Yii::$app->session->setFlash('error', 'No te has unido a esta comunidad');
            return $this->redirect(['site/login']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('create', [
            'model' => $model,
            'actual' => $actual
        ]);
    }

    /**
     * Updates an existing Blogs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blogs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blogs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}