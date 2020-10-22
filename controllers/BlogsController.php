<?php

namespace app\controllers;

use Yii;
use app\models\Blogs;
use app\models\BlogsSearch;
use app\models\Comunidades;
use app\models\Integrantes;
use Symfony\Component\VarDumper\VarDumper;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

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
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','update', 'create', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                           return Yii::$app->user->identity->username === 'admin';
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Blogs models.
     * @return mixed
     */
    public function actionIndex($actual)
    {
       
        $searchModel = new BlogsSearch();

        if(isset($_GET['actual']) == null ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $actual = Yii::$app->request->get('actual');
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

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'actual' => $actual]);
        }


        return $this->render('create', [
            'model' => $model,
            'actual' => $actual,
            'comunidades' => ArrayHelper::map(Comunidades::find()->all(), 'id', 'denom'),
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


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'comunidades' => ArrayHelper::map(Comunidades::find()->all(), 'id', 'denom')
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


    /**
     * Finds the Blogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findBlogs($comunidad_id)
    {
        if (($model = Blogs::find(['comunidad_id' => $comunidad_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}