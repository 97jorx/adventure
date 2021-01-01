<?php

namespace app\controllers;

use app\helpers\Util;
use Yii;
use app\models\Comentarios;
use app\models\Favcomentarios;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;

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
     * parent_id  -> El id del usuario que responde el comentario.
     * usuario_id -> El usuario que crea el comentario.
     * blog_id -> El id del blog donde se va a crear el comentario.
     * texto ->  El texto del comentario.
     * 
     */
    public function actionComentar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $uid = Yii::$app->user->id;
        $texto = Yii::$app->request->post('texto');
        $blogid = Yii::$app->request->post('blogid');
        $parent = Yii::$app->request->post('parent');
        $model = new Comentarios();    
        $alias = ucfirst(Yii::$app->user->identity->alias);
        $csrfToken = Yii::$app->request->getCsrfToken();

        $json = [];
        
        $model->usuario_id = Html::encode($uid);
        $model->texto = Html::encode($texto);

        if ($blogid != null) {
            $model->blog_id = Html::encode($blogid);
        }
        
        if($parent != null){
            $model->parent_id = $parent;
        } else {
            $json = [
                'mensaje' => 'Ha ocurrido un error inesperado.',
            ];
        }
        
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
        
        $alias = Usuarios::find()
        ->select('alias')
        ->where(['id' => $model->usuario_id])
        ->scalar();

        $json = [
            'mensaje' => 'Se ha creado el comentario',
            'id' => $model->parent_id,
            'blog_id' => $model->blog_id,
            'foto' => Yii::$app->user->identity->foto_perfil,
            'alias' => ucfirst($alias),
            'fecha' => Yii::$app->AdvHelper->toMinutes($fecha),
            'texto' => Html::encode($texto),
            'csrf' => $csrfToken,
        ];
         

        
        return json_encode($json);

    }



    /**
     * Añade una fila en la tabla de Favcomentarios.
     * @param integer $cid es el ID del comentario.
     * $fav es una instancia de Favcomentarios;
     * $usuarioid es el ID del usuario actual
     * 
     */
    public function actionLike($cid)
    {
        $json = [];
        $c = new Comentarios();
        if (!Yii::$app->user->isGuest) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $usuarioid = Yii::$app->user->id;
            $fav = new Favcomentarios();
            $favoritos = Yii::$app->AdvHelper->tieneFavoritos($cid, $this);
            if(!$favoritos->exists()){
                $fav->comentario_id = $cid;
                $fav->usuario_id = $usuarioid;
                $fav->save();
                $json = [
                    'mensaje' => 'Se ha dado like al comentario',
                    'icono' => 1
                ];

            } else {
                $favoritos->one()->delete();
                $json = [
                    'mensaje' => 'Se ha quitado el like al comentario',
                    'icono' => 0
                ];
            }
            return json_encode(array_merge($json, ['fav' => Util::countLikes($cid)]));
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





     /**
     * Deletes an existing Comentarios model.
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
