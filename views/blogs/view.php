<?php

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */

use kartik\icons\Icon;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index', 'actual' => $actual]];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['blogs/like', 'id' => $model->id]);
$like = ($tienefavs) ? (['thumbs-up','Me gusta']) : (['thumbs-down', 'No me gusta']);
$name = Yii::$app->user->identity->username;
Yii::$app->formatter->locale = 'es-ES';

$js = <<< EOT

$('#area-texto').on('input', (event) => {
  var self = $(this);
  console.log();
  if($('#area-texto').val().length > 0){
      $('#submitComent').fadeIn();
  } else {
      $('#submitComent').fadeOut();
  }
});

$('body').on('submit', 'form#comentar', function(event) {
  var form = $(this);
  var div = $('#comentarios');
  $.ajax({
       url: form.attr('action'),
       type: 'POST',
       data: form.serialize(),
       success: function (data) {
         data = JSON.parse(data);
         $('#submitComent').fadeOut();
         $('#area-texto').val('');
        if(!data.code) {
            div.prepend(`
                <div class='row'>
                  <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                    <div class="media-body">
                      <h5 class="mt-0">\${data.alias}</h5>
                      <span>\${data.fecha}</span>
                      <div>\${data.texto}</div>
                    </div>
                  </div>
                </div>
            `);
        }
      }
  });
  return false;
});
EOT;
$this->registerJs($js);

?>

<div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mt-4"><?= $model->titulo ?></h1>
        <p class="lead">
         Creado por
            <a href="#"><?= $model->usuario->nombre ?></a>
        </p>
        <?php if($model->usuario->nombre == $name) { ?>
            <div class="col-md-2">
              <p class="card-text"><small><?= Html::a(Icon::show('pencil'), ['blogs/update', 'id' => $model->id]) ?></small></p>
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
        <img class="img-fluid rounded"  src="<?php echo Yii::$app->request->baseUrl.'/uploads/test.jpg'?>"  alt="">
        <hr>
        <p class="lead"><?= $model->descripcion?></p>
        <p class="lead"><?= $model->cuerpo ?></p>
        <hr>
        <div class="card my-4">
          <h5 class="card-header">Dejar comentario:</h5>
          <div class="card-body">
            <?= Html::beginForm(['comentarios/comentar', 'blogid' => $model->id], 'post', [
              'id' => 'comentar',
              'enableAjaxValidation' => true
            ]) ?>
            <div class="form-group">
              <?= Html::textArea('texto', '', ['class' => 'form-control', 'id' => 'area-texto', 'rows' => "3"]) ?>
            </div>
            <?= Html::submitButton('Comentar', ['class' => 'btn btn-info', 'id' => 'submitComent', 'style' => 'display:none']) ?>
           <?= Html::endForm() ?>
          </div>
        </div>
       <div id='comentarios'>
         <?php foreach($model->comentarios as $comentario) : ?> 
          <?php if($comentario->reply_id == null) : ?>
            <div class='row'>
              <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                <div class="media-body">
                  <h5 class="mt-0"><?= ucfirst($comentario->usuario->alias) ?></h5>
                  <span class='minutes' style='color:grey'><?= Yii::$app->AdvHelper->toMinutes($comentario->created_at) ?></span>
                  <div class='texto' ><?= $comentario->texto ?></div>
                <div class='container mt-2'>
                  <div class='row'>
                    <div class='col-6'>
                      <?= Html::a(Icon::show('thumbs-up'), '#', ['style' => 'color:grey; font-size:0.9rem']); ?>
                    </div>
                    <div class='col-6'>
                    <?= Html::tag('div', 'RESPONDER', ['style' => 'color:grey; font-size:0.9rem']); ?>
                    </div>
                  </div>
                </div>
                  <?php if($comentario->reply_id != null) : ?>
                    <div class='row'>
                      <div class="media mb-4">
                        <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                        <div class="media-body">
                          <h5 class="mt-0"><?= ucfirst($comentario->usuario->alias) ?></h5>
                          <span class='minutes'><?= Yii::$app->AdvHelper->toMinutes($comentario->created_at) ?></span>
                            <div class='texto' ><?= $comentario->texto ?></div>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
            </div>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
       </div>
      </div>
  </div>
</div>
