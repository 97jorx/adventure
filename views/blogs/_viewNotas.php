<?php

use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\web\Response;

$url = Url::to(['/notas/darnota', 'id' => Yii::$app->request->get('id')]);


?>
<?=  StarRating::widget([
      'id' => 'star-rating',
      'value' => 0,
      'name' => 'rating',
      'pluginOptions' => [
        'step' => 1,
      ] ,
      'pluginEvents' => [
        'rating:change' => "function(e, value, cap){
            $.ajax({
                  url:  '$url',
                  type: 'post',
                  data: {nota: value},
                  dataType: 'json',
              }).done(function(data, textStatus, jqXHR){
                  console.log(data);
                  $(e.currentTarget).rating('update', data.nota);
              }).fail(function(data, textStatus, jqXHR){
                  console.log('Error de la solicitud.');
                  console.log(data.valor);
              });
        }"
    ]
  ]); ?>


