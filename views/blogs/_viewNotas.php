<?php

use kartik\rating\StarRating;
use yii\helpers\Url;

$url = Url::to(['/notas/darnota']);

?>


  <?=  StarRating::widget([
      'id' => 'star-rating',
      'value' => 0,
      'name' => 'rating',
      'pluginOptions' => [
        'step' => 1,
      ] ,
      'pluginEvents' => [
        'rating:change' => "function(e, val, cap){
            $.ajax({
                  url:  '$url',
                  method: 'POST',
                  data: { nota: val },
                  dataType: 'json',
              }).done(function(data, textStatus, jqXHR){
                  console.log(data.nota);
                  $(e.currentTarget).rating('update', data.nota);
              }).fail(function(data, textStatus, jqXHR){
                  console.log('Error de la solicitud.');
              });
        }"
    ]
  ]); ?>


