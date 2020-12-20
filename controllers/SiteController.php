<?php

namespace app\controllers;

use app\models\Comunidades;
use Yii;
use app\models\ComunidadesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuarios;
use yii\bootstrap4\ActiveForm;
use yii\db\Query;
use yii\helpers\Url;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new ComunidadesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count = Comunidades::find()->count();
        
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'count' => $count
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        $model = new LoginForm();

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->sessionStatus('login');            
            return Yii::$app->response->redirect(Url::to(['site/index']));
        }

        $model->contrasena = '';
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }


    }

    


    /**
     * Si el usuario logueado esta en la tabla de session entonces el 
     * estado pasa a ser 'Conectado'.
     * 
     * Si el usuario se desloguea y ya no esta en la tabla de session el 
     * estado pasa a ser 'Desconectado'
     * 
     * 1 => Conectado.
     * 2 => Ausente.
     * 3 => Ocupado.
     * 4 => Desconectado.
     * @param $accion 
     */
    public function sessionStatus($accion){
        $session = (new Query())
        ->select('user_id')
        ->from('session')
        ->where(['user_id' => Yii::$app->user->id])
        ->scalar();

        
        $model = Usuarios::findOne($session);
        if($session && $accion == 'login') {
            $model->estado_id = 1;
        } else if($accion == 'logout') {
            $model->estado_id = 4;
        } else if($session == null) {
            $model->estado_id = 4;
        }
        
        $model->save(false);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->sessionStatus('logout');
        Yii::$app->user->logout();
        
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionCrearCookie() {

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => '',
            'value' => '',
            'expire' => time() + 86400 * 365,
        ]));
    }

    public function actionRecogerCookie() {
        $cookie = Yii::$app->request->cookies;
        if ($cookie->has(''))
            $cookieValue = $cookie->getValue('');
        return $cookieValue;
    }


    // /**
    //  * Este metodo es invocado después de ejecutar una acción.
    //  * @param $action la acción que se ejecuta.
    //  * Your custom code here, if you want the code to run before action filters,
    //  * Which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
    //  */
    // public function afterAction($action, $result)
    // {
    //     $result = parent::afterAction($action, $result);
    
    //     if($action->id == 'login') {
    //         $session = (new Query())
    //         ->select(['user_id'])
    //         ->from('session')
    //         ->scalar();
            
    //         $model = Usuarios::find()->where(['id' => $session]);
    //         $model->estado_id = 1;
    //         $model->save();
    //     }
        
    //     return $result;
    // }

}
