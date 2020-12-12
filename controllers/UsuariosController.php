<?php

namespace app\controllers;

use Yii;
use app\models\Blogs;
use app\models\Bloqueados;
use app\models\Comunidades;
use app\models\Seguidores;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\db\Query;
use yii\bootstrap4\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
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

    public function actionRegistrar()
    {
            
            $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);
          
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado el usuario.');
                return $this->redirect(['site/index']);
            }
            if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            return $this->renderAjax('registrar', [
                'model' => $model,
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
     * Muestra el perfil del usuario.
     * @param string $alias
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($alias)
    {
        $id = Usuarios::find('id')->where(['alias' => $alias])->scalar();
        if (!Yii::$app->AdvHelper->usuarioBloqueado($id)) {

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

            if (!Yii::$app->user->isGuest) {
                return $this->render('view', [
                    'model' => $this->findModel($id),
                    'blogs_count' => $blogs->count(),
                    'dataProvider' => $dataProvider,
                    'dataProvider2' => $dataProvider2,
                    'comunidades' => $comunidades,
                ]);
            }

            return $this->redirect(['site/login']);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
     * Busca el usuario por su alias mediante una consulta a la tabla usuarios.
     * @param q la busqueda introducida por el input.
     * @return Json
     */
    public function actionSearch($q = null, $id = null) {

        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $bloqueados = Yii::$app->AdvHelper->usuarioBloqueado();
        $out = ['results' => ['text' => '', 'id' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, alias AS text')
                ->from('usuarios')
                ->where(['ilike', 'alias', $q])
                ->andWhere(['not in', 'id', $bloqueados])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Usuarios::find($id)->alias];
        } else {
            return false;
        }
        
        return $out;
    }

    /**
     * Seguir a un usuario con ajax desde el perfil.
     * @param alias se pasa como parametro el alias.
     * @return Json
     */
    public function actionSeguir($alias) {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $seguidor = Yii::$app->user->id;
        $user = !Yii::$app->user->isGuest;

        $usuarioid = Usuarios::find('id')
        ->where(['alias' => $alias])->scalar();

        $idexist = Seguidores::find()
           ->where(['usuario_id' => $usuarioid])
           ->andWhere(['seguidor' => $seguidor]);
        
        $json = [];
            if($user) {
                if(!$idexist->exists()){
                    $model = new Seguidores();
                    $model->usuario_id = $usuarioid;
                    $model->seguidor = $seguidor;
                    $model->save();
                    $json = [ 
                            'button' => 'Dejar de seguir',
                            'color'  => 'bg-danger',
                            'mensaje' => 'Se ha seguido al usuario'
                    ];
                } else {
                    Seguidores::findOne(['usuario_id' => $usuarioid, 'seguidor' => $seguidor])
                    ->delete();
                    $json = [ 
                        'button' => 'Seguir',
                        'color'  => 'bg-success',
                        'mensaje' => 'Se ha dejado de seguir al usuario'
                    ];
                }    
            } 
            
            return json_encode($json);
    }

     /**
     * $bloqueado es el usuario que esta en la base de datos.
     * $bloqueador es el usuario actual que va a bloquear al usuario seleccionado.
     * Seguir a un usuario con ajax desde el perfil.
     * @param alias se pasa como parametro el alias.
     * @return Json
     */
    public function actionBloquear($alias) {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = !Yii::$app->user->isGuest;
        
        $bloqueador = Yii::$app->user->id;
        $bloqueado = Usuarios::find('id')
        ->where(['alias' => $alias])->scalar();

        $idexist = Bloqueados::find()
           ->where(['bloqueado' => $bloqueado])
           ->andWhere(['usuario_id' => $bloqueador]);
        
        $json = [];
            if($user) {
                if(!$idexist->exists()){
                    $model = new Bloqueados();
                    $model->bloqueado = $bloqueado;
                    $model->usuario_id = $bloqueador;
                    $model->save();
                    $json = [ 
                            'button' => 'Desbloquear usuario',
                            'color'  => 'bg-danger',
                            'mensaje' => 'Se ha bloqueado al usuario'
                    ];
                } else {
                    Bloqueados::findOne(['bloqueado' => $bloqueado, 'usuario_id' => $bloqueador])
                    ->delete();
                    $json = [ 
                        'button' => 'Bloquear usuario',
                        'color'  => 'bg-success',
                        'mensaje' => 'Se ha dejado de bloquear al usuario'
                    ];
                }    
            } 
            
            return json_encode($json);
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
