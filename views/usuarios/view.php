
<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['comunidades/index']];
// $this->params['breadcrumbs'][] = $model->username;

$name = Yii::$app->user->identity->username;
$this->registerCssFile("@web/css/perfil.css");
       
$js = <<< EOT
$(document).ready(function(){    
  $('.nav-link').click(function(){
    $('.nav-link').removeClass('active');    
    $(this).addClass('active');
  });

  $('.tabs a').click(function(){
      $('.tab-content div').removeClass('active');
      $(this).addClass('active');
      $(this).removeClass('active');
      var hr = $(this).attr("href");
      $(hr).addClass('active');
    });
});

EOT;

$this->registerJs($js);


?>



<div class="container-perfil">
  <header>
  </header>
  <main>
    <div class="row">
      <div class="left col-lg-4">
        <div class="photo-left">
           <?php $fakeimg = "https://picsum.photos/300/300?random=".$model->id;  ?>
           <?= Html::a(Html::img($fakeimg, ['class' => 'photo'])) ?>
        </div>
        <h4 class="nombre"><?= strtoupper($model->nombre) ?></h4>
        <?php if(Yii::$app->user->identity->alias !== $model->alias) : ?>
          <?php $existe = ($model->existeSeguidor($model->alias)) ? ('Dejar de seguir') : ('Seguir') ?>
          <?php $seguir = Url::to(['usuarios/seguir', 'alias' => $model->alias]); ?>
          <?= Html::a($existe, $seguir, ['class' => 'btn btn-info login',
              'aria-label' => $existe, 'data-balloon-pos' => 'up',
              'onclick' =>"
                  event.preventDefault();
                  var self = $(this);
                  $.ajax({
                      type: 'GET',
                      url: '$seguir',
                      dataType: 'json',
                  }).done(function( data, textStatus, jqXHR ) {
                      data = JSON.parse(data);
                      console.log(data);
                      $(self).text(data.button);
                      $(self).attr('aria-label', data.button);
                  }).fail(function( data, textStatus, jqXHR ) {
                      console.log('Error de la solicitud.');
                  });",
          ]);
          ?> 
        <?php endif; ?>
        <p class="info"><?= $model->rol ?></p>
        <p class="info"><?= $model->alias ?></p>
        <p class="info"><?= $model->email ?></p>
        <div class="stats row">
          <div class="stat col-xs-4" style="padding-right: 50px;">
            <p class="number-stat">5</p>
            <p class="desc-stat">Puntuación</p>
          </div>
          <div class="stat col-xs-4">
            <p class="number-stat"><?= $count ?></p>
            <p class="desc-stat">Blogs creados</p>
          </div>
          <div class="stat col-xs-4" style="padding-left: 50px;">
            <p class="number-stat">38</p>
            <p class="desc-stat">Seguidores</p>
          </div>
        </div>
        <p class="desc"><?= $model->bibliografia ?></p>
       
      </div>
      <div class="right col-lg-8">
          <nav class='tabs' id='activeTab'>
            <ul class="nav nav-tabs only-profile">
              <?php foreach($dataProvider2->models as $model) : ?>
              <li  class="nav-link active"><a data-toggle="tab" href=".<?=$model->id?>"><?= $model->denom ?></a></li>
              <?php endforeach; ?>              
            </ul>
          </nav> 
          <div class="tab-content border-class scroll-vertical">
          <a href="#top"><button class="top" aria-label='Volver arriba' data-balloon-pos="right"><?= Icon::show('arrow-up') ?></button></a>
            <?php foreach($dataProvider->models as $model) : ?>
              <div id="<?=$model->comunidad_id?>" class='tab-pane active in <?=$model->comunidad_id?>'>
              <a name="top"></a>
                <div class="card mb-3" style="max-width: 540px;" >
                  <div class="row no-gutters">
                    <div class="col-md-4">
                      <div class='img-holder'>
                        <?php $fakeimg = "https://picsum.photos/250/250?random=".$model->id;  ?>
                        <?= Html::a(Html::img($fakeimg)) ?>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title"><?= $model->titulo ?></h5>
                        <p class="card-text"><?= $model->descripcion ?></p>
                          <div class="row">
                            <div class="col-md-2">
                              <p class="card-text"><small><?= Icon::show('heart') . $model->favs ?></small></p>
                            </div>
                            <?php if($model->usuario->nombre == $name) { ?>
                              <div class="col-md-2">
                                <p class="card-text"><small><?= Html::a(Icon::show('pencil'), ['blogs/update', 'id' => $model->id]) ?></small></p>
                              </div>
                            <?php } ?>
                         </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
          </div>
        </div>
    </div>
  </main>
</div>


