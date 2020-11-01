
<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['comunidades/index']];
$this->params['breadcrumbs'][] = $model->username;

$this->registerCssFile("@web/css/perfil.css");
        
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
      </div>
      <div class="right col-lg-8">
        <ul class="nav-perfil">
          <li>Blogs creados</li>
        </ul>
        <div class="tab-content">
          <div class="row gallery">
            <div class="col-md-4">
                <?php $fakeimg = "https://picsum.photos/800/800?random=".$model->id;  ?>
                <?= Html::a(Html::img($fakeimg)) ?>
                <div id="menu3" class="tab-pane fade">
                  <h3>Menu 3</h3>
                  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>

