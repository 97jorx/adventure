
<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = $model->username;

$this->registerCssFile("@web/css/perfil.css");
        // var_dump($comunidades);
        // die();
?>


<body>
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
        <p class="info"><?= $model->rol ?></p>
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
        <a href="#top"><button class="btn btn-primary" aria-label='Volver arriba' data-balloon-pos="up"><?= Icon::show('arrow-up') ?></button></a>
      </div>
      <div class="right col-lg-8">
          <nav class='tabs' >
            <ul class="nav nav-tabs">
              <?php foreach($dataProvider2->models as $model) : ?>
              <li class="nav-link active"><a data-toggle="tab" href="#<?=$model->id?>"><?= $model->denom ?></a></li>
              <?php endforeach; ?>
            </ul>
            </nav> 
           
          <div class="tab-content scroll-vertical">
            <?php foreach($dataProvider->models as $model) : ?>
            <div id="<?=$model->comunidad_id?>" class="tab-pane active in">
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
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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
</body>

