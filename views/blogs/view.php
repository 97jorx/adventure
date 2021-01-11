<?php

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */

use app\helpers\Util;
use app\helpers\UtilAjax;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['blogs/index', 'actual' => $actual]];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['blogs/like', 'id' => $model->id]);
$like = ($tienefavs) ? (['thumbs-up','Me gusta']) : (['thumbs-down', 'No me gusta']);
$name = Yii::$app->user->identity->username;
$csrfToken = Yii::$app->request->getCsrfToken();
$comentar = Url::to(['comentarios/comentar']);

$this->registerJs(UtilAjax::COMENTARIOS);
$this->registerJs(UtilAjax::LIKE);
?>

<div class="container">
  <input type='hidden' id='csrf' name='_csrf' value='<?= $csrfToken ?>'>
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mt-4"><?=  Util::h($model->titulo) ?></h1>
        <p class="lead">
         Creado por
            <a href="#"><?= $model->usuario->alias ?></a>
        </p>
        <?php if($model->usuario->nombre == $name) { ?>
            <div class="col-md-2">
              <p class="card-text"><small><?= Html::a(Icon::show('pencil'), ['blogs/update', 'id' => $model->id, 'actual' => $actual]) ?></small></p>
            </div>
        <?php } ?>
        <hr>
        <p>Posteado <?= $model->created_at?></p>
        <?= $this->render('_viewNotas') ?>
        <div class="row">
          <div class="col-1">
          <?= Html::a(Icon::show($like[0], ['id' => 'like', 'framework' => Icon::FAS]), $url, [
            'onclick' =>"
              event.preventDefault();
              var self = $(this);
              $.ajax({
                  type: 'GET',
                  url: '$url',
                  dataType: 'json',
              }).done(function(data, textStatus, jqXHR) {
                  data = JSON.parse(data);
                  $('#fav').html(data.fav);
                  $('#like').efect();
                  $('#like').attr('class', (data.icono) ? ('fas fa-thumbs-down') : ('fas fa-thumbs-up')) 
                  $('#like').attr('title', (data.icono) ? ('No me gusta') : ('Me gusta'))
                  $('.mensaje').text(data.mensaje);
                  $('#w4-success-0').removeAttr('style');
              }).fail(function(data, textStatus, jqXHR) {
                  console.log('Error de la solicitud.');
              });", 'title' => $like[1]
          ]); 
          ?> 
          </div>
          <div id='fav' class="col-1">
              <?= $model->favs ?>     
          </div>
          <div class="col-1">
              <?= Icon::show('eye')?><?= $model->visits ?>     
          </div>
        </div>
        <hr>
        <?php $fakeimg = "https://picsum.photos/850/850?random=".$model->id;  ?>
           <?= Html::a(Html::img((isset($model->imagen)) ? (Util::s3GetImage($model->imagen)) :
            ($fakeimg), ['class' => 'card-img-top-blog', 'itemprop' => 'image', 'alt' => 'blog-view-img'])) ?>
        <hr>
        <p class="lead"><?= Util::h($model->descripcion) ?></p>
        <p class="lead"><?= Util::h($model->cuerpo) ?></p>
        <hr>
        <div class="card my-4">
            <h5 class="card-header">Dejar comentario:</h5>
            
            <div class="card-body">
            <?= Html::beginForm(['comentarios/comentar'], 'post', [
              'id' => 'comentar-form',
            ]) ?>
            <div class="form-group">
              <?= Html::textArea('texto', '', ['class' => 'form-control login', 'id' => 'area-texto', 'rows' => "3"]) ?>
              <?= Html::hiddenInput('blogid', $model->id, ['class' => 'blogid']) ?>
            </div>
            <?= Html::submitButton('Comentar', ['class' => 'btn btn-info', 'id' => 'submitComent', 'style' => 'display:none']) ?>
           <?= Html::endForm() ?>
           <i id='length-area-texto' style='position:absolute; left:70%'></i>
          </div>
        </div>
       <div id='comentarios'>
         <?php foreach($model->comentarios as $comentario) : ?> 
          <?php $fakeimg = 'https://picsum.photos/50/50?random='.$comentario->id ?>
          <?php $respuestas = $comentario->findResponsesById($comentario->id, $model->id)?>
          <?php if($comentario->parent == null) : ?> 
          <div class='row'>
              <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle-user" src='<?= (isset($comentario->usuario->foto_perfil)) ?
                (Util::s3GetImage($comentario->usuario->foto_perfil)) : ($fakeimg) ?>' alt="">
                <div class="media-body">
                <div class='row'>
                  <h5 class="mt-0 ml-3 pr-2" style='font-size:0.8rem'><?= ucfirst($comentario->usuario->alias) ?></h5>
                  <i class='minutes text-secondary'style='font-size:0.8rem'><?= Yii::$app->AdvHelper->toMinutes($comentario->created_at) ?></i>
                </div>
                  <div class='texto' ><?= Util::h($comentario->texto) ?></div>
                  <div class='container mt-2'>
                    <div class='row'>
                      <div class='col-3'>
                      <?php $clike = (!Yii::$app->AdvHelper->tieneFavoritos($comentario->id, 'cview')->exists()) ?
                      (['thumbs-up', 'Me gusta']) : (['thumbs-down', 'No me gusta']); ?>
                      <?= Html::a(Icon::show($clike[0], ['class' => 'cicon'.$comentario->id, 'framework' => Icon::FAS]), 
                          Url::to(['comentarios/like', 'cid' => $comentario->id]), [
                            'class' => 'clike', 
                            'id' => 'clike', 
                            'value' => $comentario->id,
                            'title' => $clike[1]
                        ]); 
                      ?> 
                      </div>
                      <div class='col-3 fav<?= $comentario->id ?>'>
                          <?= Util::countLikes($comentario->id) ?>
                      </div>
                      <div class='col-3'>
                        <?= Html::tag('div', 'RESPONDER', [
                          'style' => 'font-size:0.9rem; cursor:pointer;', 
                          'class' => 'responder-click text-secondary',
                          'id' => $comentario->id 
                        ]); ?>
                        </div>
                        <!-- --- REPLY -->
                        <div class="card my-4" id="reply-<?= $comentario->id ?>">
                        </div>
                        <!-- --- -->
                    </div>
                  </div>
                  <div class="reply-div-<?= $comentario->id ?>">
                    <?php foreach($respuestas as $key => $value) : ?>
                          <div class='row'>
                            <div class="media mt-4">
                              <img class="d-flex mr-3 rounded-circle-user" src='<?= (isset($value['foto_perfil'])) ?
                              (Util::s3GetImage($value['foto_perfil'])) : ($fakeimg) ?>' alt="blog-img-comment">
                              <div class="media-body">
                                <div class='row'>
                                  <h5 class="mt-0 ml-3 pr-2" style='font-size:0.8rem'><?= ucfirst($value['alias']) ?></h5>
                                  <i class='minutes text-secondary' style='font-size:0.8rem'><?= Yii::$app->AdvHelper->toMinutes($value['created_at']) ?></i>
                                </div>
                                <div class='texto pt-2' ><?= Util::h($value['texto']) ?></div>
                                <div class='container mt-2'>
                                  <div class='row'>
                                    <div class='col-3'>
                                  <?php $crlike = (!Yii::$app->AdvHelper->tieneFavoritos($value['id'], 'cview')->exists()) ?
                                  (['thumbs-up', 'Me gusta']) : (['thumbs-down', 'No me gusta']); ?>
                                  <?= Html::a(Icon::show($crlike[0], ['class' => 'cicon'.$value['id'], 'framework' => Icon::FAS]), Url::to(['comentarios/like', 'cid' => $value['id']]), 
                                        [
                                         'class' => 'clike', 
                                         'id' => 'crlike', 
                                         'value' => $value['id'],
                                         'title' => $crlike[1]]); 
                                        ?>   
                                    </div>
                                    <div class='col-3 fav<?= $value['id'] ?>'>
                                        <?= Util::countLikes($value['id']) ?>
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
          <?php endif; ?>
        <?php endforeach; ?>
       </div>
      </div>
  </div>
</div>
