<?php

namespace app\controllers;

use app\helpers\UtilNotify;
use Yii;
use app\models\Notificaciones;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * NotificacionesController implements the CRUD actions for Notificaciones model.
 */
class NotificacionesController extends Controller
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
     * Marca como leídas todas las notificaciones 
     * de ese usuario.
     * @return mixed
     */
    public function actionClear()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        Notificaciones::updateAll([
            'leido' => true, 
            'usuario_id' => Yii::$app->user->id
        ], 'leido = false');
        
        $json = [
            'message' => 'Se ha marcado como leida todas las notificaciones.', 
            'ncount' => UtilNotify::countNotificaciones()
        ];
        return $json;
    }

 
}
