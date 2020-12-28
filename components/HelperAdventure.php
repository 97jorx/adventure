<?php

namespace app\components;

use app\controllers\BlogsController;
use app\controllers\ComentariosController;
use app\controllers\ComunidadesController;
use app\models\Bloqcomunidades;
use app\models\Bloqueados;
use app\models\Favblogs;
use app\models\Favcomentarios;
use app\models\Favcomunidades;
use app\models\Notas;
use DateTime;
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
     * Consulta si en la tabla FavBlogs/Favcomunidades/Favcomentarios si hay un ua fila que corresponda a
     * un determinado usuario_id y un id en la correspondiente tabla.
     * @param $model $provider el objeto identificativo que determina que Query se debe hacer.
     * @param id es el id correspondiente a la tabla.
     * @param mixed $id
     */
    public static function tieneFavoritos($id, $model)
    {
        $usuarioid = Yii::$app->user->id;
        if ($model instanceof BlogsController) {
            $query = Favblogs::find()
            ->where(['blog_id' => $id]);
        } elseif ($model instanceof ComunidadesController || $model == 'view') {
            $query = Favcomunidades::find()
            ->where(['comunidad_id' => $id]);
        } elseif ($model instanceof ComentariosController || $model == 'cview') {
            $query = Favcomentarios::find()
            ->where(['comentario_id' => $id]);
        }

        return $query->andWhere(['usuario_id' => $usuarioid]);
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
     * Devuelve un boolean si el usuario actual esta bloqueado por el
     * usuario que se quiere buscar o ver.
     * 
     * Devuelve un array de los usuarios que han bloqueado al usuario 
     * actual. Ejemplo: En el buscar usuarios no aparezca dichos usuarios.
     * 
     * @return Boolean retorna un booleano si @param id no es nulo.
     * @return Arry retorna un array si @param id es nulo.
     */
    public static function usuarioBloqueado($id = null) {
        
        $uid = Yii::$app->user->id;
        
        if (isset($id) && $id != 0) {

            return Bloqueados::find()
            ->where(['usuario_id' => $id])
            ->andWhere(['bloqueado' => $uid])
            ->exists();

        } else {

            return Bloqueados::find()
            ->select('usuario_id')
            ->andWhere(['bloqueado' => $uid])
            ->column();

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

    /**
     * Devuelve la fecha en minutos que han transcurrido desde 
     * la fecha en la que se realizó la acción.
     * @return String
     */
    public function toMinutes($datetime, $full = false) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'año',
            'm' => 'mese',
            'w' => 'semana',
            'd' => 'dia',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? 'hace ' . implode(', ', $string)  : 'justo ahora';
    }

   
}



