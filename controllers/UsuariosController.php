<?php

namespace app\controllers;

use Yii;
use app\models\Blogs;
use app\models\Comunidades;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->user->identity->username === 'admin';
                        },
                    ],
                    // [
                    //     'allow' => true,
                    //     'actions' => ['view', 'delete', 'update'],
                    //     'roles' => ['@'],
                    //     'matchCallback' => function ($rules, $action) {
                    //         return Yii::$app->user->identity->username === 'pepe';
                    //     },
                    // ],
                ],
            ],
        ];
    }

    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);
        $address = Yii::$app->getRequest()->getUserIP();
        $geoip = new \lysenkobv\GeoIP\GeoIP();
        $ip = $geoip->ip("79.158.132.204");
        $ciudad = $ip->city; 
        $pais = $ip->country; 

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha creado el usuario.');
            return $this->redirect(['site/login']);
        }


        return $this->render('registrar', [
            'model' => $model,
            'ciudad' => $ciudad,
            'pais' => $pais
            
        ]);
    }
    
    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        if (!isset($id)) {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->renderPartial('_userConf.php', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    }



    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($username)
    {
        $id = Usuarios::find('id')->where(['username' => $username])->scalar();
        $blogs = Blogs::find()->where(['usuario_id' => $id]);  
        $comunidades = Comunidades::find()
        ->joinWith('blogs b')
        ->where(['b.usuario_id' => $id])
        ->groupBy('comunidades.id');  
        
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $comunidades,
        ]);

        if(!Yii::$app->user->isGuest){
            return $this->render('view', [
                'model' => $this->findModel($id),
                'count' => $blogs->count(),
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
                'comunidades' => $comunidades
            ]);
        }
        return $this->redirect(['site/login']);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
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
     * Deletes an existing Usuarios model.
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
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
