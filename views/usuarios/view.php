
<?php

use app\helpers\Util;
use app\helpers\UtilAjax;
use app\models\Usuarios;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */


$name = Yii::$app->user->identity->alias;
$this->registerCssFile("@web/css/perfil.css");
$csrfToken = Yii::$app->request->getCsrfToken();
$js = <<< EOT

$(document).ready(function(){  
// TABS LINK 

  $('.nav-link').click(function(e){
    e.preventDefault();
    $('.nav-link').removeClass('active');    
    $(this).addClass('active');
  });


  $('.tabs a').click(function(e){
    e.preventDefault();
    $('.tab-content div').removeClass('active');
    $(this).addClass('active');
    $(this).removeClass('active');
    var hr = $(this).attr("href");
    $(hr).addClass('active');
  });


  // SCROLL BUTTON TOP //

  $('.tab-content').scroll(function(e){
      e.preventDefault();
      if ($(this).scrollTop() > 100) {
          $('.top').show().fadeIn();
      } else {
          $('.top').fadeOut().hide();
      }
  });

  $('.top').click(function(e){
      e.preventDefault();
      $(".tab-content").animate({scrollTop : 0}, 360);
      return false;
  });

});
EOT;
$this->registerJs($js);
$this->registerJs(UtilAjax::COMENTARIOS);
$this->registerJs(UtilAjax::LIKE);
?>

<div class="container-perfil">
  <header>
  </header>
  <main>
    <div class="row">
      <div class="left col-lg-4">
      <input type='hidden' id='csrf' name='_csrf' value='<?= $csrfToken ?>'>
        <div class="photo-left">
           <?php $fakeimg = "https://picsum.photos/300/300?random=".$model->id;  ?>
            <?php $imagen = Yii::getAlias('@imgUrl') . '/' . $model->foto_perfil?>
           <?= Html::a(Html::img((isset($model->foto_perfil)) ?
            (Util::s3GetImage(Util::getImageByAlias($model->alias))) : ($fakeimg), ['class' => 'photo'])) ?>
          <nav class='tabs' id='activeTab'>
            <ul class="nav nav-tabs">
                <li class="nav-link"><a data-toggle="tab" id='coid' href="#comments"><?= Icon::show('comment')?></a></li>
            </ul>
          </nav>   
        </div>
          <?php if(Yii::$app->user->identity->id == $model->id) : ?>
            <div class="element cambiar-imagen">
              <?= Html::a(Icon::show('camera'), ['usuarios/imagen', 'alias' => Yii::$app->user->identity->alias]) ?>
            </div>
          <?php elseif(Yii::$app->user->identity->id !== $model->id) : ?>
          <div class="btn-group">
              <a class="btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= Icon::show('ellipsis-h') ?>
              </a>
                  <div class="dropdown-menu">
                  <?php $existe = ($model->existeBloqueado($model->alias)) ? ('Desbloquear usuario') : ('Bloquear usuario') ?>
                  <?php $bloquear = Url::to(['usuarios/bloquear', 'alias' => $model->alias]); ?>
                  <?= Html::a($existe, '#', ['class' => 'login',
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
        <h4 class="nombre"><?= strtoupper($model->alias) ?></h4>
        <?php if(Yii::$app->user->identity->alias !== $model->alias) : ?>
          <?php $existe = ($model->existeSeguidor($model->alias)) ? ('Dejar de seguir') : ('Seguir') ?>
          <?php $seguir = Url::to(['usuarios/seguir', 'alias' => $model->alias]); ?>
          <?= Html::a($existe, '#', ['class' => 'btn btn-info login',
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
          ]); ?> 
        <?php endif; ?>
        <p class="info"><?= $model->rol ?></p>
        <p class="info"><?= (empty($model->countNotes($model->alias))) ? (0) :
                            ($model->countNotes($model->alias)) ?><?= Icon::show('star') ?></p>
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
        <p class="desc"><?= $model->biografia ?></p>
       
      </div>

      <div class="right col-lg-8">
          <nav class='tabs' id='activeTab'>
            <ul class="nav nav-tabs">
              <?php foreach($dataProvider2->models as $blogs) : ?>
                <li class="nav-link"><a data-toggle="tab" href=".<?= $blogs->id ?>"><?= $blogs->denom ?></a></li>
              <?php endforeach; ?>              
            </ul>
          </nav> 
          <div class="tab-content scroll-v ">
            <?php foreach($dataProvider->models as $blogs) : ?>
              <div class='tab-pane <?= ($blogs_count > 0) ? ('active in') : ('') ?> <?=$blogs->comunidad_id?>'>
              <a name="top"></a>
                <div class="card mb-3" style="max-width: 540px;" >
                  <div class="row no-gutters">
                    <div class="col-md-4">
                      <div class='img-holder'>
                        <?php $fakeimg = "https://picsum.photos/250/250?random=".$blogs->id;  ?>
                         <?= Html::a(Html::img( ($blogs->imagen != null) ? (Util::s3GetImage($blogs->imagen)) : ($fakeimg))) ?> 
                      </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title"><?= Util::h($blogs->titulo) ?></h5>
                          <p class="card-text"><?= Util::h($blogs->descripcion) ?></p>
                            <div class="row">
                              <div class="col-md-2">
                                <p class="card-text"><small><?= Icon::show('heart') . $blogs->favs ?></small></p>
                              </div>
                              <?php if($blogs->usuario->alias == $name) { ?>
                                <div class="col-md-2">
                                  <p class="card-text"><small><?= Html::a(Icon::show('pencil'), ['blogs/update', 'id' => $blogs->id]) ?></small></p>
                                </div>
                              <?php } ?>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
          </div>
          <div class="tab-content scroll-v">
            <div id="comments" class="tab-pane <?= ($blogs_count == 0) ? ('active in') : ('') ?>">
                <div class="card my-4">
                      <h5 class="card-header">Dejar comentario:</h5>
                      
                      <div class="card-body">
                        <?= Html::beginForm(['comentarios/comentar'], 'post', [
                          'id' => 'comentar-form',
                        ]) ?>
                        <div class="form-group">
                          <?= Html::textArea('texto', '', ['class' => 'form-control login', 'id' => 'area-texto', 'rows' => "3"]) ?>
                          <?= Html::hiddenInput('alias', Yii::$app->request->get('alias'), ['class' => 'alias']) ?>
                        </div>
                        <?= Html::submitButton('Comentar', ['class' => 'btn btn-info', 'id' => 'submitComent', 'style' => 'display:none']) ?>
                      <?= Html::endForm() ?>
                      <i id='length-area-texto' style='position:absolute; left:70%'></i>
                  </div>
                </div>
                <div id='comentarios'>
                <?php foreach($model->comments as $comentario) : ?> 
                  <div class='row'>
                      <div class="media ml-5 mb-4">
                      <img class="d-flex mr-3 rounded-circle-user" src="<?= (Util::getImageByAlias($comentario['alias']) === null) ? ($fakeimg) 
                      : (Util::s3GetImage(Util::getImageByAlias($comentario['alias']))) ?>" alt="">
                        <div class="media-body">
                        <div class='row'>
                          <h5 class="mt-0 ml-3 pr-2" style='font-size:0.8rem'><?= ucfirst($comentario['alias']) ?></h5>
                          <i class='minutes text-secondary'style='font-size:0.8rem'><?= Yii::$app->AdvHelper->toMinutes($comentario['created_at']) ?></i>
                        </div>
                          <div class='texto' ><?= Util::h($comentario['texto']) ?></div>
                          <div class='container mt-2'>
                            <div class='row'>
                              <div class='col-3'>
                              <?php $clike = (!Yii::$app->AdvHelper->tieneFavoritos($comentario['id'], 'cview')->exists()) ?
                              (['thumbs-up', 'Me gusta']) : (['thumbs-down', 'No me gusta']); ?>
                              <?= Html::a(Icon::show($clike[0], ['class' => 'cicon'.$comentario['id'], 'framework' => Icon::FAS]), 
                                  Url::to(['comentarios/like', 'cid' => $comentario['id']]), [
                                    'class' => 'clike', 
                                    'id' => 'clike', 
                                    'value' => $comentario['id'],
                                    'title' => $clike[1]
                                ]); 
                              ?> 
                              </div>
                              <div class='col-3 fav<?= $comentario['id'] ?>'>
                                  <?= Util::countLikes($comentario['id']) ?>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

          
