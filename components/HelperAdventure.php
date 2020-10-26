<?php

namespace app\components;

use app\controllers\BlogsController;
use app\controllers\ComunidadesController;
use app\models\Blogs;
use app\models\Comunidades;
use app\models\Favblogs;
use app\models\Favcomunidades;
use Yii;
use yii\base\Component;


class HelperAdventure extends Component
{
    /**
     * Crea un enlace que ordena los blogs a partir del ActiveDataProvider 
     * @param ActiveDataProvider $provider el objeto ActiveDataProvider recibido del BlogsSearch
     * @param string $elem el nombre de la columna a ordenar 
     * @param string $name nombre del enlace
     * @return link
     */
    public static function ordenarBlog($provider, $elem, $name)
    {
        return $provider->sort->link($elem, 
        [
         'class' => 'sort',
         'label' =>  $name,
        ]);
    }



     /**
     * 
     * Consulta si en la tabla FavBlogs/Favcomunidades si hay un ua fila que corresponda a
     * un determinado usuario_id y un id en la correspondiente tabla.
     * @param $model $provider el objeto identificativo que determina que Query se debe hacer.
     * @param id es el id correspondiente a la tabla.
     */
    public static function tieneFavoritos($id, $model){
        $usuarioid = Yii::$app->user->id;
        if ($model instanceof BlogsController ){
            return Favblogs::find()
            ->where(['blog_id' => $id])
            ->andWhere(['usuario_id' => $usuarioid]);
        } elseif ($model instanceof ComunidadesController){
            return Favcomunidades::find()
            ->where(['comunidad_id' => $id])
            ->andWhere(['usuario_id' => $usuarioid]);
        }
    }
}
