<?php

use app\helpers\Util;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$blogs = $dataProvider->models;
    
?>
    <p>
        <?= Html::a('Crear Blog', ['create', 'actual' => $actual],  ['class' => 'btn btn-success']) ?>
    </p>
  
  <div itemscope itemtype="http://schema.org/Blog" class="container">
    <div class="row">
      <div class="col-md-8">
        <h1 class="my-4"><?= Util::h($this->title.' de '.Util::h(Util::comunidad())) ?></h1>
        <?php $index = 0; foreach($dataProvider->models as $model) : ?> 
          <?php if ($index == 0): ?>  
          <?php endif; ?> 
        <div class="card mb-4"> 
        <div class="container-img"> 
            <?php $fakeimg = "https://picsum.photos/850/850?random=".$model->id;  ?>
           <?= Html::a(Html::img((isset($model->imagen)) ? (Util::s3GetImage($model->imagen)) :
            ($fakeimg), ['class' => 'card-img-top-blog', 'itemprop' => 'image'])) ?>
        </div> 
          <div class="card-body">
            <h2 temprop="title" class="card-title"><?= Html::encode($model->titulo); ?></h2>
            <p class="card-text"></p>
            <?= Html::a('Continuar leyendo...', ['blogs/view', 'id' => $model->id, 'actual' => $actual], ['class' => 'btn btn-primary']) ?>
          </div>
          <div class="card-footer text-muted ml-4">
            Creado <?= Yii::$app->formatter->asDate($model->created_at) ?> por
            <?= Html::a(''.html::encode($model->usuario->alias).'', ['usuarios/view', 'username' => $model->usuario->username]) ?>
            <?php $like = Url::to(['blogs/like']); ?>
            <i temprop="favoritos" class="ml-4"><?= $model->favs ?></i>
            <?= Icon::show('thumbs-up', ['framework' => Icon::FAS]) ?> 
            <i temprop="favoritos" class="ml-4"><?= $model->visits ?></i>
            <?= Icon::show('eye', ['framework' => Icon::FAS]) ?> 
          </div>
        </div>
        <?php $index++; endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]);?>
      </div>
      <div class="col-md-4">
      <?php echo $this->render('_search', [
          'model' => $searchModel , 
          'busqueda' => $busqueda,
          'actual' => $actual,
        ]); ?>
      <div class="card my-4">
          <h5 class="card-header">Ordenar por... </h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                <li>
                   <?= Yii::$app->AdvHelper->ordenarBlog($dataProvider, 'titulo', 'Título'); ?>
                  </li>
                  <li>
                    <?= Yii::$app->AdvHelper->ordenarBlog($dataProvider, 'created_at', 'Fecha'); ?>
                  </li>
                  <li>
                    <?= Yii::$app->AdvHelper->ordenarBlog($dataProvider, 'favs', 'Favoritos'); ?>  
                  </li>
                  <li>
                    <?= Yii::$app->AdvHelper->ordenarBlog($dataProvider, 'valoracion', 'Valoración'); ?>  
                  </li>
                  <li>
                    <?= Yii::$app->AdvHelper->ordenarBlog($dataProvider, 'visits', 'Visitas'); ?>  
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
          <div class="card my-4">
            <h5 class="card-header">Side Widget</h5>
              <div class="card-body">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam excepturi deserunt incidunt suscipit, 
               tempore commodi magni quam quis perspiciatis sapiente blanditiis vitae saepe dolor ipsum aperiam, eos alias animi dignissimos.
            </div>
          </div>
        </div>
      </div>
    </div>

