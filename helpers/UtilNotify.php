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
        ->orderBy(['created_at' => SORT_ASC])
        ->limit(5)
        ->asArray()
        ->all();
    }


}