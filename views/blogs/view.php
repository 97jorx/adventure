<?php

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index', 'actual' => $actual]];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['blogs/like', 'id' => $model->id]);
$like = ($tienefavs) ? (['thumbs-up','Me gusta']) : (['thumbs-down', 'No me gusta']);

?>
<div class="blogs-view">


<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mt-4"><?= $model->titulo ?></h1>
        <p class="lead">
         Creado por
            <a href="#"><?= $model->usuario->nombre ?></a>
        </p>
        <hr>
        <p>Posteado <?= $model->created_at?></p>
        <div class="row">
          <div class="col-1">
          <?= Html::a(Icon::show($like[0], ['id' => 'like', 'framework' => Icon::FAS]), $url, [
            'onclick' =>"
              event.preventDefault();
              var self = $(this);
              $.ajax({
                  type: 'POST',
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
            <form>
              <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Aceptar</button>
            </form>
          </div>
        </div>
        <div class="media mb-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          <div class="media-body">
            <h5 class="mt-0">Nombre del comentador</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
          </div>
        </div>
        <div class="media mb-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          <div class="media-body">
            <h5 class="mt-0">Nombre del comentador</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            <div class="media mt-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Nombre del comentador</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </div>
            </div>
            <div class="media mt-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Nombre del comentador</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card my-4">
          <h5 class="card-header">Buscar</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar por...">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="button">Aceptar!</button>
              </span>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
</div>
