<?php

namespace app\controllers;

use Yii;
use app\models\Comentarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ComentariosController implements the CRUD actions for Comentarios model.
 */
class ComentariosController extends Controller
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
     * Crea un comentario a partir de el texto introducido.
     
     * TABLA DE COMENTARIOS
     *
     * reply_id  -> El id del usuario que responde el comentario.
     * usuario_id -> El usuario que crea el comentario.
     * blog_id -> El id del blog donde se va a crear el comentario.
     * texto ->  El texto del comentario.
     * 
     */
    public function actionComentar($blogid = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $uid = Yii::$app->user->id;
        $texto = Yii::$app->request->post('texto');
        $model = new Comentarios();    
        $alias = ucfirst(Yii::$app->user->identity->alias);

        $json = [];
        
        if ($blogid != null) {
            $model->usuario_id = $uid;
            $model->blog_id = $blogid;
            $model->texto = $texto;
            if(!$model->validate()) {
                $json = [
                    'mensaje' => 'No debe estar vacio',
                    'code' => 1,
                ];
                return json_encode($json);
            }
    
            $model->save();
            $fecha = Comentarios::find()
            ->select('created_at')
            ->where(['id' => $model->id])
            ->scalar();
            $json = [
                'mensaje' => 'Se ha creado el comentario',
                'foto' => Yii::$app->user->identity->foto_perfil,
                'alias' => $alias,
                'fecha' => $fecha,
                'texto' => $texto,
            ];
        } 

        
        return json_encode($json);

    }



    /**
     * Finds the Comentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
