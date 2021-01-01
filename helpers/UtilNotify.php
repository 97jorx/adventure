<?php

namespace app\helpers;

use app\models\Notificaciones;
use Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

class UtilNotify  {
  
    public static function notificaciones() {
        return Notificaciones::find()
        ->where(['usuario_id' => Yii::$app->user->id])
        ->orderBy(['created_at' => SORT_DESC])
        ->limit(5)
        ->asArray()
        ->all();
    }


    /**
     * Cuenta cuantas notificaciones.
     *
     * @param [string] $content
     */
    public static function countNotificaciones(){
        return Notificaciones::find()
        ->where(['usuario_id' => Yii::$app->user->id])
        ->count();
    }


    public static function itemsNotificaciones ()  {
        $notificaciones = [];
        $index = 0;
            foreach(UtilNotify::notificaciones() as $key => $value) {

                $m = Yii::$app->AdvHelper->toMinutes($value['created_at']);
                $n  = [
                        'label' =>"
                        <a href='#' class=' list-group-item-action flex-column align-items-start scroll-vertical'>
                            <h5 class='mb-1'>{$value['mensaje']}</h5>
                            <p class='mb-0'>{$m}</p>
                        </a>"
                    ];
                array_push($notificaciones, $n);
                $index++;
            }

        return $notificaciones;
    }


}