<?php

namespace app\controllers;

use Yii;
use app\models\Comunidades;
use app\models\ComunidadesSearch;
use app\models\Integrantes;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                  //      'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                        // 'matchCallback' => function ($rules, $action) {
                        //     return Yii::$app->user->identity->username === 'admin';
                        // },
                    ],
                    // [
                    //     'allow' => true,
                    //     'actions' => ['view', 'delete'],
                    //     'roles' => ['@'],
                    //     'matchCallback' => function ($rules, $action) {
                    //         return Yii::$app->user->identity->username === 'pepe';
                    //     },
                    // ],
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comunidades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comunidades();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        return $this->render('update', [
            'model' => $model,
        ]);
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

        return $this->redirect(['index']);
    }


    /**
     * Permite al usuario logueado unirse a la comunidad elegida mediante un botón.
     * @return Comunidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnirse($id)
    {
        $username = !Yii::$app->user->isGuest;
        $idexist = Integrantes::find()
        ->where(['id' => $id])
        ->exists();
        
        if(!$idexist){
            if($username) {
                $integrantes = new Integrantes();
                $uid = Yii::$app->user->id;
                $integrantes->usuario_id = $uid;
                $integrantes->comunidad_id = $id;
                $integrantes->creador = false;
                $integrantes->save();
                Yii::$app->session->setFlash('success', "Te has unido correctamente");
                return $this->redirect(['comunidades/index']);
            } else {
                Yii::$app->session->setFlash('error', "Tienes que estar logueado.");
            }    
        }
            Yii::$app->session->setFlash('error', "Ya te has unido a esta comunidad.");
            return $this->redirect(['comunidades/index']);
    }


    /**
     * Permite al usuario logueado salir a la comunidad elegida mediante un botón.
     * @return Comunidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSalir($id)
    {
        $username = !Yii::$app->user->isGuest;
        $idexist = Integrantes::find()
        ->where(['id' => $id]);
        
        if($idexist->exists()){
            if($username) {
                $idexist->delete();
                Yii::$app->session->setFlash('success', "Has salido correctamente");
                return $this->redirect(['comunidades/index']);
            } else {
                Yii::$app->session->setFlash('error', "Tienes que estar logueado.");
            }    
        }
        return $this->redirect(['comunidades/index']);
        
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
