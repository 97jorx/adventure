<?php

namespace app\controllers;

use app\models\Blogs;
use app\models\Bloqcomunidades;
use Yii;
use app\models\Comunidades;
use app\models\ComunidadesSearch;
use app\models\Favcomunidades;
use app\models\Integrantes;
use kartik\form\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
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
            
            // 'access' => [
            //     'class' => AccessControl::class,
            //     'only' => ['unirse','view','like','bloquear'],
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'roles' => ['@'],
            //             'matchCallback' => function ($rules, $action) {
            //                 return Yii::$app->AdvHelper->estaBloqueado();
            //             },
            //         ],        
                    
            //     ],
            // ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view', 'likes', 'unirse', 'bloquear', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                           return Yii::$app->user->identity->username === 'admin';
                        },
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->AdvHelper->estaBloqueado();
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
            'tienefavs' => !$favoritos->exists(),
            'likes_month' => Favcomunidades::likesEachMonth(),
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
        if(Comunidades::esPropietario() || Yii::$app->user->identity->username === 'admin'){
        
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.')); 
        }
    }
    /**
     * Deletes an existing Comunidades model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha borrado la comunidad y todos sus usuarios de ella.');
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
        $user = !Yii::$app->user->isGuest;
        $uid = Yii::$app->user->id;
        $idexist = Integrantes::find()
        ->where(['comunidad_id' => $id])
        ->andWhere(['usuario_id' => $uid]);
        
        
        $json = [ 
            'iconclass' => ['sign-in-alt','Unirse'],
            'mensaje' => 'Te has salido correctamente.',
            'color' => 'bg-danger'
        ];

        if($user) {
            if(!$idexist->exists()){
                $integrantes = new Integrantes();
                $integrantes->usuario_id = $uid;
                $integrantes->comunidad_id = $id;
                $integrantes->save();
                $json = [ 
                    'iconclass' => ['sign-out-alt','Salir'],
                    'mensaje' => 'Te has unido correctamente.',
                    'color' => 'bg-success',
                ];
            } else {
                $idexist->one()->delete();
            }    
        } else {
            $json = [ 
                'mensaje' => 'Tienes que estar logueado.',
            ];
            return $this->redirect(['site/login']);
        }
        
        return json_encode($json);
    }


 /**
     * Añade una fila en la tabla de favcomunidades o la quita dependiendo si es
     * un like o dislike.
     * @param integer $id es el ID del blog.
     */
    public function actionLike($id)
    {
        
        $json = [];
        if (!Yii::$app->user->isGuest) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $usuarioid = Yii::$app->user->id;
            $fav = new Favcomunidades();
            $favoritos = Yii::$app->AdvHelper->tieneFavoritos($id, $this);
            if(!$favoritos->exists()){
                $fav->comunidad_id = $id;
                $fav->usuario_id = $usuarioid;
                $fav->save();
                $json = [
                    'mensaje' => 'Se ha dado like a la comunidad',
                    'iconclass' => ['fas fa-heart-broken', 'No me gusta']
                ];
            } else {
                $favoritos->one()->delete();
                $json = [
                    'mensaje' => 'Se ha quitado el like a la comunidad',
                    'iconclass' => ['fas fa-heart', 'Me gusta']
                ];
            }
            return json_encode(array_merge($json, ['fav' => $this->findModel($id)->favs]));
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Bloquea a usuario de la comunidad seleccionada.
     * Si se borra correctamente la fila se redireccionará hacia el index.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBloquear($uid, $id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = !Yii::$app->user->isGuest;
        $idexist = Bloqcomunidades::find()
        ->where(['comunidad_id' => $id])
        ->andWhere(['bloqueado' => $uid]);
        
        $json = [];
            if($user) {
                if(!$idexist->exists()){
                    $bloq = new Bloqcomunidades();
                    $bloq->bloqueado = $uid;
                    $bloq->comunidad_id = $id;
                    $bloq->save();
                    $json = [ 
                            'button' => 'Desbloquear',
                            'color'  => 'bg-danger',
                            'mensaje' => 'Se ha bloqueado el usuario correctamente'
                    ];
                } else {
                    $idexist->one()->delete();
                    $json = [ 
                        'button' => 'Bloquear',
                        'color'  => 'bg-success',
                        'mensaje' => 'Se ha desbloqueado el usuario correctamente'
                    ];
                }    
            } 
            
            return json_encode($json);
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


    // public function beforeAction($action)
    // {
    //     if (Yii::$app->user->isGuest) {
    //         $url = Url::to(['site/login']);
    //         $this->redirect($url);
    //     } 
    //         return parent::beforeAction($action);
    // }



}
