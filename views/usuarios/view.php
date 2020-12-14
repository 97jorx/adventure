
<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
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

  $('#imagen').click(function () {
    var lo = $('#imagen').attr('value');
    $.ajax({
        type: 'GET',
        url: lo,
        success: function(data) {
            $('#modal').find('.site-login').remove();
            $('#modal').modal('show').find('#createContent').html(data);
        }
    });
  });
EOT;


?>

<div class="container-perfil">
  <header>
  </header>
  <main>
    <div class="row">
      <div class="left col-lg-4">
        <div class="photo-left">
           <?php $fakeimg = "https://picsum.photos/300/300?random=".$model->id;  ?>
            <?php $imagen = Yii::getAlias('@imgUrl') . '/' . $model->foto_perfil?>
           <?= Html::a(Html::img((isset($model->foto_perfil) || file_exists($model->foto_perfil)) ? ($imagen) : ($fakeimg), ['class' => 'photo'])) ?>
           <?= Html::a(Icon::show('camera'), '#', ['id' => 'imagen', 'value' => Url::to(['usuarios/imagen', 'alias' => $model->alias])]) ?>
        </div>
        <?php if(Yii::$app->user->identity->alias !== $model->alias) : ?>
          <div class="btn-group">
              <a class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= Icon::show('ellipsis-h') ?>
              </a>
                  <div class="dropdown-menu">
                  <?php $existe = ($model->existeBloqueado($model->alias)) ? ('Desbloquear usuario') : ('Bloquear usuario') ?>
                  <?php $bloquear = Url::to(['usuarios/bloquear', 'alias' => $model->alias]); ?>
                  <?= Html::a($existe, $bloquear, ['class' => 'login',
                      'aria-label' => $existe, 'data-balloon-pos' => 'up',
                      'onclick' =>"
                          event.preventDefault();
                          var self = $(this);
                          $.ajax({
                              type: 'GET',
                              url: '$bloquear',
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
                </div>
            </div>
        <?php endif; ?>
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
        <p class="info"><?= (empty($model->valoracion)) ? (0) : ($model->valoracion) ?><?= Icon::show('star') ?></p>
        <div class="stats row">
          <div class="stat col-xs-4" style="padding-right: 50px;">
            <p class="number-stat"><?= $model->following ?></p>
            <p class="desc-stat">Siguiendo</p>
          </div>
          <div class="stat col-xs-4">
            <p class="number-stat"><?= $blogs_count ?></p>
            <p class="desc-stat">Blogs creados</p>
          </div>
          <div class="stat col-xs-4" style="padding-left: 50px;">
            <p class="number-stat"><?= $model->followers ?></p>
            <p class="desc-stat">Seguidores</p>
          </div>
        </div>
        <p class="desc"><?= $model->bibliografia ?></p>
       
      </div>
      <?php if($blogs_count > 0) : ?> 
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
    <?php elseif($blogs_count == 0) : ?>
      
    <?php endif;?>
  </main>
</div>


<?php Modal::begin([
    'headerOptions' => [
        'class' => 'text-center'
    ],
    'titleOptions' => [
        'class' => 'modal-title text-center col-md-11',
    ],
    'title' => '',
    'id' => 'modal',
    'size' => 'modal-md',
]);?>
    <?="<div id='createContent'></div>"?>
<?php Modal::end();?>