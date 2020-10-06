<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
    use yii\helpers\Url;
use yii\widgets\LinkPager;

$blogs = $dataProvider->models;
    $this->title = 'Blogs';
    $this->params['breadcrumbs'][] = $this->title;
    $this->params['breadcrumbs'][] = $blogs[0]->comunidad->denom;
    
?>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1 class="my-4"><?= $this->title?></h1>
        <h2><small><?= $blogs[0]->comunidad->denom; ?></small></h2>
        <?php
        foreach($dataProvider->models as $model) { ?> 
        <div class="card mb-4">
          <img class="card-img-top img-thumbnail" src="" alt="Card image cap">
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
        <?php } ?>
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]);?>
      </div>
      <div class="col-md-4">
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
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
                  <?= $dataProvider->sort->link('titulo', 
                    [
                     'class'     => 'sort',
                     'label'     => 'Título',
                     'direction' =>  SORT_ASC
                    ]) ?>
                  </li>
                  <li>
                  <?= $dataProvider->sort->link('created_at', 
                    [
                     'class'     => 'sort',
                     'label'     => 'Fecha de creación',
                     'direction' =>  SORT_ASC
                    ]) ?>
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
  