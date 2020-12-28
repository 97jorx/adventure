<?php

namespace app\controllers;

use Yii;
use app\models\Favcomentarios;
use app\models\FavcomentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavcomentariosController implements the CRUD actions for Favcomentarios model.
 */
class FavcomentariosController extends Controller
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
     * Añade una fila en la tabla de Favcomentarios.
     * @param integer $cid es el ID del comentario.
     * $fav es una instancia de Favcomentarios;
     * $usuarioid es el ID del usuario actual
     * 
     */
    public function actionLike($cid)
    {
        $json = [];
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
            return json_encode(array_merge($json, ['fav' => $this->countLikes($cid)]));
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




    public function countLikes($cid) {
        return Favcomentarios::find()
                ->where(['c.id' => $cid])
                ->count();
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
