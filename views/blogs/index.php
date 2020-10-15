<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
    use yii\helpers\Url;
use yii\widgets\LinkPager;

    $blogs = $dataProvider->models;
    $this->title = 'Blogs';
    $this->params['breadcrumbs'][] = $this->title;


    
?>
    <p>
        <?= Html::a('Crear Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1 class="my-4"><?= $this->title?></h1>
        <?php $index = 0; foreach($dataProvider->models as $model) { ?> 
          <?php if($index == 0): ?>  
            <?php $model->comunidad->denom;?>
          <h2><small><?= $model->comunidad->denom ?></small></h2> 
         <?php endif; ?> 
        <div class="card mb-4">
          <img class="card-img-top img-thumbnail" src="<?= Yii::$app->request->baseUrl.'/uploads/test.jpg'?>" alt="Card image cap">
          <div class="card-body">
            <h2 class="card-title"><?= Html::encode($model->titulo); ?></h2>
            <p class="card-text"></p>
            <?= Html::a('Continuar leyendo...', ['blogs/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
          </div>
          <div class="card-footer text-muted">
            Creado <?= $model->created_at ?> por
            <a href="#"><?= $model->usuario->nombre ?></a>
          </div>
        </div>
        <?php $index++;} ?>
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]);?>
      </div>
      <div class="col-md-4">
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <?= Html::beginForm(['blogs/index'], 'get') ?>
            <div class="input-group">
                <?= Html::textInput('busqueda', $busqueda , ['class' => 'form-control']) ?>
              <span class="input-group-append">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
              </span>
            <?= Html::endForm() ?>
            </div>
          </div>
        </div>
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
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-4">
          <h5 class="card-header">Side Widget</h5>
          <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div>
      </div>
    </div>
  </div>
  