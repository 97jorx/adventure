<?php

namespace app\helpers;

use app\models\Comunidades;
use Yii;
use app\models\Favcomentarios;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

class Util  {


    /**
     * Cuenta los likes del comentario.
     *
     * @param [type] $cid ID del comentario pasado por parámetro.
     * @return integer
     */
    public static function countLikes($cid) {
        return Favcomentarios::find()
                ->where(['comentario_id' => $cid])
                ->count();
    }


    /**
     * Dame el nombre de la comunidad a partir de id.
     * Para evitar por ejemplo el crsf
     *
     * @param [string] $content
     */
    public static function comunidad(){
        $id = Yii::$app->request->get('actual');
        return Comunidades::find()
        ->select('denom')
        ->where(['id' => $id])
        ->scalar();
    }



    
    /**
     * Funcion para transformar las etiquetas html.
     * Para evitar por ejemplo el crsf
     *
     * @param [string] $content
     */
    public static function h($content){
        return Html::encode($content);
    }


    /**
     * Funcion para transformar las etiquetas html.
     * Para evitar por ejemplo el crsf
     *
     * @param [type] $content
     * @return void
     */
    public static function p($html){
        HtmlPurifier::process($html);
    }


}