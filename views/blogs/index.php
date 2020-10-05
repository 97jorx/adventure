<?php

    use yii\helpers\Html;

    $this->title = 'Blogs';
    $this->params['breadcrumbs'][] = $this->title;
    $blogs = $dataProvider->models;
    var_dump($blogs);
    die();
?>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1 class="my-4"><?= $this->title?>
          <small><?= $blogs[0]->comunidad_id; ?></small>
        </h1>
        <?php
        foreach($dataProvider->models as $model) { ?> 
        <div class="card mb-4">
          <img class="card-img-top" src="<?php echo Yii::$app->request->baseUrl.'/uploads/test.jpg'?>" alt="Card image cap">
          <div class="card-body">
            <h2 class="card-title"><?= Html::encode($model->titulo); ?></h2>
            <p class="card-text"></p>
            <a href="#" class="btn btn-primary">Leer más &rarr;</a>
          </div>
          <div class="card-footer text-muted">
            Creado <?= $model->created_at ?> por
            <a href="#"><?= $model->usuario_id ?></a>
          </div>
        </div>
        <?php } ?>
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            <a class="page-link" href="#">&larr; Older</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#">Newer &rarr;</a>
          </li>
        </ul>
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
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">Web Design</a>
                  </li>
                  <li>
                    <a href="#">HTML</a>
                  </li>
                  <li>
                    <a href="#">Freebies</a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">JavaScript</a>
                  </li>
                  <li>
                    <a href="#">CSS</a>
                  </li>
                  <li>
                    <a href="#">Tutorials</a>
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
  