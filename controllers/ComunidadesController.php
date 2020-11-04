<?php

namespace app\controllers;

use Yii;
use app\models\Comunidades;
use app\models\ComunidadesSearch;
use app\models\Favcomunidades;
use app\models\Integrantes;
use app\models\UsuariosSearch;
use kartik\form\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ComunidadesController implements the CRUD actions for Comunidades model.
 */
class ComunidadesController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'unirse', 'like'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
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
     * Lists all Comunidades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComunidadesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single Comunidades model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $favoritos = Yii::$app->AdvHelper->tieneFavoritos($id, $this);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'tienefavs' => !$favoritos->exists()
        ]);
    }

    /**
     * Creates a new Comunidades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = !Yii::$app->user->isGuest;
        if ($username) {
            $uid = Yii::$app->user->id;
            $model = new Comunidades();
            $model->propietario = $uid;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $integrantes = new Integrantes();
                $integrantes->usuario_id = $uid;
                $integrantes->comunidad_id = $model->id;
                $integrantes->save();
                return $this->redirect(['index']);
            }
        }
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Comunidades model.
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

        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Borra la comunidad por el id pasado como parametro.
     * Si se borra correctamente la fila se redireccionará hacia el index.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->getIntegrantes()->exists()) {
            Integrantes::find()
            ->where(['comunidad_id' => $id])
            ->one()
            ->delete();
            $model->delete();    
            Yii::$app->session->setFlash('success', 'Se ha borrado la comunidad y todos sus usuarios de ella.');
        } else {
            Yii::$app->session->setFlash('success', 'No se ha borrado la comunidad.');
        }
        
        return $this->redirect(['index']);
    }


    /**
     * Permite al usuario logueado unirse a la comunidad elegida mediante un botón o salirse.
     * @param id se le pasa el id de la comunidad a la que se quiere unir
     * @return json array de opciones.
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnirse($id)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $username = !Yii::$app->user->isGuest;
        $uid = Yii::$app->user->id;
        $idexist = Integrantes::find()
        ->where(['comunidad_id' => $id])
        ->andWhere(['usuario_id' => $uid]);
        
        
        $json = [];

        if($username) {
            if(!$idexist->exists()){
                $integrantes = new Integrantes();
                $integrantes->usuario_id = $uid;
                $integrantes->comunidad_id = $id;
                $integrantes->save();
                $json = [ 
                    'button' => 'Salir',
                    'mensaje' => 'Te has unido correctamente.',
                    'color' => 'bg-success',
                ];
            } else {
                $idexist->one()->delete();
                $json = [ 
                    'button' => 'Unirse',
                    'mensaje' => 'Te has salido correctamente.',
                    'color' => 'bg-danger'
                ];
            }    
        } else {
            $json = [ 
                'button' => 'Unirse',
                'mensaje' => 'Tienes que estar logueado.',
                'color' => 'bg-danger'
            ];
        }
        
            return json_encode($json);
    }

   


 /**
     * Add row into Favoritos table.
     * @param integer $blogid es el ID del blog.
     */
    public function actionLike($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $usuarioid = Yii::$app->user->id;
        $fav = new Favcomunidades();
        $favoritos = Yii::$app->AdvHelper->tieneFavoritos($id, $this);
        $json = [];
        if (!Yii::$app->user->isGuest) {
            if(!$favoritos->exists()){
                $fav->comunidad_id = $id;
                $fav->usuario_id = $usuarioid;
                $fav->save();
                $json = [
                    'mensaje' => 'Se ha dado like a la comunidad',
                    'icono' => 1
                ];
            } else {
                $favoritos->one()->delete();
                $json = [
                    'mensaje' => 'Se ha quitado el like a la comunidad',
                    'icono' => 0
                ];
            }
        } else {
            return $this->redirect(['site/login']);
        }
        return json_encode(array_merge($json, ['fav' => $this->findModel($id)->favs]));
    }


    /**
     * Finds the Comunidades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comunidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comunidades::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




}
