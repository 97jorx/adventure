<?php

namespace app\controllers;

use Yii;
use app\models\Notas;
use app\models\NotasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NotasController implements the CRUD actions for Notas model.
 */
class NotasController extends Controller
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
     * Lists all Notas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notas model.
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
     * Creates a new Notas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notas model.
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
     * Deletes an existing Notas model.
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
     * Dar nota al usuario en un blog en concreto.
     * 
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDarnota()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        

        $uid = Yii::$app->user->id;
        $id = Yii::$app->request->get('id');
        $model = new Notas();    

        $notaexist = Notas::find()
        ->where(['blog_id' => $id])
        ->andWhere(['usuario_id' => $uid]);

        $json = [];
       
            $nota = Yii::$app->request->post('nota');
            if (!$notaexist->exists()) {
                $model->usuario_id = $uid;
                $model->blog_id = $id;
                $model->nota = $nota;
                $model->save();
                $json = [
                    'mensaje' => 'Se ha guardado la nota.',
                    'valor' => $model->nota,
                    'uid' => $uid,
                    'blogid' => $id
                ];
            } else {
                $notaexist->nota = $nota;
                $model->save();
                $json = [
                     'mensaje' => 'Se ha actualizado la nota.',
                     'valor' => $model->nota,
                     'uid' => $uid,
                     'blogid' => $id
                ];
            }
       
        return json_encode($json);
    }




    /**
     * Finds the Notas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
