<?php

namespace app\controllers;

use app\helpers\Util;
use Yii;
use app\models\Galerias;
use app\models\GaleriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GaleriasController implements the CRUD actions for Galerias model.
 */
class GaleriasController extends Controller
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
     * Creates a new Galerias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Galerias();
        $searchModel = new GaleriasSearch();
        
        $actual = Yii::$app->request->get('actual');
        $model->comunidad_id = $actual;
        if($model->validate()) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $actual);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['create', 'actual' => $actual]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        

        return $this->render('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Galerias model.
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
     * Finds the Galerias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Galerias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Galerias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
}
