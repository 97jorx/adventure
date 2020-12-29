<?php

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */

use app\helpers\UtilAjax;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index', 'actual' => $actual]];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['blogs/like', 'id' => $model->id]);
$like = ($tienefavs) ? (['thumbs-up','Me gusta']) : (['thumbs-down', 'No me gusta']);
$name = Yii::$app->user->identity->username;
$csrfToken = Yii::$app->request->getCsrfToken();
$comentar = Url::to(['comentarios/comentar']);

$js = <<< EOT
$('#area-texto, #area-texto-reply').on('input', (event) => {
  event.preventDefault();
  var self = $(this);
  var length = $('#area-texto').val().length;
  $("#length-area-texto").text("Carácteres restantes: " + (255 - length));
  if($('#area-texto').val().length > 0){
    if(length > 255) {
        $('#submitComent').fadeOut();
        $("#length-area-texto").text("Carácteres restantes: " + (0));
        $("#length-area-texto").css("cssText", "color: red;");
      } else {
        $('#submitComent').fadeIn();
        $("#length-area-texto").css("cssText", "color: grey;");
      }
    } else {
        $('#submitComent').fadeOut();
    }
});

$('.responder-click').on('click', function(event) {
  event.preventDefault();
  var blogid = $('.blogid').val();
  var id = this.id;
  var respuesta = '#respuesta-'+id;
  var reply_id = '#reply-'+id;
  var divid = $(reply_id);

  if(!$('#respuesta-'+id).length && $('#area-texto').val().length == 0)  {
  divid.append(`
    <div id='respuesta-\${id}' class='respuesta-form'>
      <h5 class='card-header'>Responder:</h5>
      <div class='card-body'>
        <form id='respuesta-comentario'  action='$comentar' method='post'>
          <input type='hidden' name='_csrf' value='$csrfToken'>                        
            <div class='form-group-reply'>
              <textarea id='area-texto-reply-\${id}' class='form-control' name='texto' rows='3'></textarea>                        
              <input type='hidden' name='parent' value='\${id}'>
              <input type='hidden' name='blogid' value='\${blogid}'>                        
            </div>
            <button type='button' id='close-\${id}' onclick='$(this).parent().parent().parent().remove();' class='mt-3 btn btn-white'>Cancelar</button>                        
            <button type='submit' id='submitReply-\${id}' class='btn btn-info'>Responder</button>                         
        </form>                      
      </div>
      <i id='length-area-texto-\${id}' style='position:absolute; left:70%'></i>
    </div>`);
  } 
});

$('body').on('submit', 'form#comentar-form, form#respuesta-comentario',  function(event) {
  var form = $(this);
  event.preventDefault();
  $.ajax({
    url: form.attr('action'),
    type: 'POST',
    data: form.serialize(),
    success: function (data) {
      data = JSON.parse(data);
      $('#submitComent').fadeOut();
      $('#area-texto').val('');
      var div = (data.id == null) ? $('#comentarios') : $('.reply-div-'+data.id);
      var reply = (data.id == null) ? "mb-4" : "mt-4";
        if(!data.code) {
            div.prepend(`
                <div class='row'>
                  <div class="media \${reply}">
                    <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                    <div class="media-body">
                    <div class='row'>
                      <h5 class="mt-0 ml-3 pr-2" style="font-size:0.9rem"> \${data.alias} </h5>
                      <i class="minutes" style="color:grey; font-size:0.9rem"> \${data.fecha} </i>
                    </div>
                      <div>\${data.texto}</div>
                        <div class='container mt-2'>
                          <div class='row'>
                            <div class='col-3'>
                              <a href="#" style="color:grey; font-size:0.9rem"><i class="fas fa-thumbs-up"></i> </a>
                            </div>
                          </div>
                        </div>
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
$this->registerJs(UtilAjax::LIKE);
?>

<div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mt-4"><?=  UtilAjax::h($model->titulo) ?></h1>
        <p class="lead">
         Creado por
            <a href="#"><?= $model->usuario->alias ?></a>
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
        <p class="lead"><?= UtilAjax::h($model->descripcion) ?></p>
        <p class="lead"><?= UtilAjax::h($model->cuerpo) ?></p>
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
          <?php $respuestas = $comentario->findResponsesById($comentario->id, $model->id)?>
          <?php if($comentario->parent == null) : ?> 
          <div class='row'>
              <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                <div class="media-body">
                <div class='row'>
                  <h5 class="mt-0 ml-3 pr-2" style='font-size:0.8rem'><?= ucfirst($comentario->usuario->alias) ?></h5>
                  <i class='minutes text-secondary'style='font-size:0.8rem'><?= Yii::$app->AdvHelper->toMinutes($comentario->created_at) ?></i>
                </div>
                  <div class='texto' ><?= $comentario->texto ?></div>
                  <div class='container mt-2'>
                    <div class='row'>
                      <div class='col-3'>
                      <?php $clike = (!Yii::$app->AdvHelper->tieneFavoritos($comentario->id, 'cview')->exists()) ?
                      (['thumbs-up', 'Me gusta']) : (['thumbs-down', 'No me gusta']); ?>
                      <?= Html::a(Icon::show($clike[0], ['class' => 'clike', 'id' => 'clike', 'value' => $comentario->id,'framework' => Icon::FAS]), 
                          Url::to(['comentarios/like', 'cid' => $comentario->id]), ['title' => $clike[1]
                        ]); 
                      ?> 
                      </div>
                      <div class='col-3 fav<?= $comentario->id ?>'>
                          <?= $comentario->countLikes($comentario->id) ?>
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
                              <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                              <div class="media-body">
                                <div class='row'>
                                  <h5 class="mt-0 ml-3 pr-2" style='font-size:0.8rem'><?= ucfirst($value['alias']) ?></h5>
                                  <i class='minutes text-secondary' style='font-size:0.8rem'><?= Yii::$app->AdvHelper->toMinutes($value['created_at']) ?></i>
                                </div>
                                <div class='texto pt-2' ><?= UtilAjax::h($value['texto']) ?></div>
                                <div class='container mt-2'>
                                  <div class='row'>
                                    <div class='col-3'>
                                  <?php $crlike = (!Yii::$app->AdvHelper->tieneFavoritos($value['id'], 'cview')->exists()) ?
                                  (['thumbs-up', 'Me gusta']) : (['thumbs-down', 'No me gusta']); ?>
                                  <?= Html::a(Icon::show($crlike[0], ['class' => 'clike', 'id' => 'crlike', 'value' => $value['id'], 'framework' => Icon::FAS]), 
                                      Url::to(['comentarios/like', 'cid' => $value['id']]), ['title' => $crlike[1]]); ?>   
                                    </div>
                                    <div class='col-3 fav<?= $value['id'] ?>'>
                                        <?= $comentario->countLikes($value['id']) ?>
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
