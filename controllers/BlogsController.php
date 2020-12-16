<?php

namespace app\controllers;

use Yii;
use app\models\Blogs;
use app\models\BlogsSearch;
use app\models\Comunidades;
use app\models\Favblogs;
use app\models\Integrantes;
use app\models\Visitas;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
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
                        'actions' => [
                                      'index','update', 'create',
                                      'view', 'like', 'viewfavoritos'
                        ],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'index', 'create',
                            'update', 'delete', 
                            'view', 'like', 'viewfavoritos'],
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
    public function actionIndex()
    {
       
        $searchModel = new BlogsSearch();
        $busqueda = Yii::$app->request->get('busqueda', '');
        $actual = Yii::$app->request->get('actual');
        $this->findActualById($actual);


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $busqueda, $actual);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actual' => $actual,
            'busqueda' => $busqueda,
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
        $fav = $this;
        $visita = new Visitas();

        $favoritos = Yii::$app->AdvHelper->tieneFavoritos($id, $fav);
        $actual = Yii::$app->request->get('actual');
        $usuarioid = Yii::$app->user->id;
        
        $existe = Visitas::find()
        ->where(['or', ['usuario_id' => $usuarioid,'blog_id' => $id]])
        ->exists();
        
        if(!$existe){
            $visita->usuario_id = $usuarioid;
            $visita->blog_id = $id;
            $visita->save();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'actual' => $actual,
            'tienefavs' => !$favoritos->exists()

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
            } 
        } else {
            Yii::$app->session->setFlash('error', 'No te has unido a esta comunidad');
            return $this->redirect(['site/login']);
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
     * Add row into Favoritos table.
     * @param integer $blogid es el ID del blog.
     */
    public function actionLike()
    {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $usuarioid = Yii::$app->user->id;
        $blogid = Yii::$app->request->get('id');
        $fav = new Favblogs();
        $favoritos = Yii::$app->AdvHelper->tieneFavoritos($blogid, $this);

        $json = [];
        if (!Yii::$app->user->isGuest) {

            if(!$favoritos->exists()){
                $fav->blog_id = $blogid;
                $fav->usuario_id = $usuarioid;
                $fav->save();
                $json = [
                    'mensaje' => 'Se ha dado like al blog',
                    'icono' => 1
                ];

            } else {
                $favoritos->one()->delete();
                $json = [
                    'mensaje' => 'Se ha quitado el like al blog',
                    'icono' => 0
                ];
            }
        } else {
            return $this->redirect(['site/login']);
        }
        
        return json_encode(array_merge($json, ['fav' => $this->findModel($blogid)->favs]));
    }
    
    

    /**
     * Genero un DataProvider para mostrar los Blogs favoritos del usuario actual.
     * @return DataProvider
     */
    public function actionViewfavoritos()
    {
     
        $query = Blogs::blogsUserLikes();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('viewfavoritos', [
            'dataProvider' => $dataProvider,
        ]);

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


    /**
     * Actual es el id de la comunidad actual.
     * @param integer $id
     * @return Comunidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findActualById($actual)
    {
        if (($model = Comunidades::findOne($actual)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}