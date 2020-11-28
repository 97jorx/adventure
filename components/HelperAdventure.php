<?php

namespace app\components;

use app\controllers\BlogsController;
use app\controllers\ComunidadesController;
use app\models\Bloqcomunidades;
use app\models\Comunidades;
use app\models\Favblogs;
use app\models\Favcomunidades;
use app\models\Notas;
use yii\base\Component;
use Yii;


class HelperAdventure extends Component
{
    /**
     * Crea un enlace que ordena los blogs a partir del ActiveDataProvider.
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
         'label' => $name,
        ]
        );
    }

    /**
     * Consulta si en la tabla FavBlogs/Favcomunidades si hay un ua fila que corresponda a
     * un determinado usuario_id y un id en la correspondiente tabla.
     * @param $model $provider el objeto identificativo que determina que Query se debe hacer.
     * @param id es el id correspondiente a la tabla.
     * @param mixed $id
     */
    public static function tieneFavoritos($id, $model)
    {
        $usuarioid = Yii::$app->user->id;
        if ($model instanceof BlogsController) {
            return Favblogs::find()
            ->where(['blog_id' => $id])
            ->andWhere(['usuario_id' => $usuarioid]);
        } elseif ($model instanceof ComunidadesController || $model == 'view') {
            return Favcomunidades::find()
            ->where(['comunidad_id' => $id])
            ->andWhere(['usuario_id' => $usuarioid]);
        }
    }


     /**
     * Devuelve un boolean si el usuario actualo esta bloqueado en esa comunidad.
     * @return Boolean retorna un booleano.
     */
    public static function estaBloqueado($uid = null, $id = null){
        
        $bloqueado = Bloqcomunidades::find();
        
        if (!isset($uid)) {
            $uid = Yii::$app->user->id;
            $id = Yii::$app->request->get('id');
            return !$bloqueado
            ->where(['comunidad_id' => $id])
            ->andWhere(['bloqueado' => $uid])
            ->exists();
        } else {
            return $bloqueado
            ->where(['comunidad_id' => $id])
            ->andWhere(['bloqueado' => $uid])
            ->exists();
        }
    }


     /**
     * Devuelve la nota si existe en la tabla Notas del blog especificado y el usuario actual.
     * @return Integer retorna un booleano.
     */
    public static function recibirNota($id = null){
        
        $uid = Yii::$app->user->id;
        $existe = Notas::find()
        ->where(['blog_id' => $id])
        ->andWhere(['usuario_id' => $uid]);

        if (isset($id) && $existe->exists()) {
            return $existe->one()->nota;
        } else {
            return 0;
        }
    }
}
