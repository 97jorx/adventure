
<?php
use dmstr\cookieconsent\widgets\CookieConsent;
use kartik\icons\Icon;
use yii\bootstrap4\Html;


?>

<?php if($count >= 4) : ?> 
<body>
  <div class="container">
    <div class="row align-items-center my-5">
      <div class="col-lg-7">
        <?php $fakeimg = "https://picsum.photos/600/450?random=".$dataProvider->models[0]->id;  ?>
        <?= Html::a(Html::img($fakeimg), ['blogs/index', 'actual' => $dataProvider->models[0]->id], ['class' => 'card-image fluid-img']) ?>
      </div>
      <div class="col-lg-5">
              <h1 class="font-weight-light"><?= $dataProvider->models[0]->denom  ?></h1>
        <p class="card-text"><?= $dataProvider->models[0]->descripcion ?></p>
        <a class="btn btn-primary" href="#">Ver comunidad</a>
      </div>
    </div>
    <div class="card text-white bg-secondary my-5 py-4 text-center">
      <div class="card-body">
        <p class="text-white m-0">Estas son las comunidades más favoritas de la web, ve y mira a ver si es de tu agrado!</p>
      </div>
    </div>
    <div class="row">
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
          <?php $fakeimg = "https://picsum.photos/800/800?random=".$dataProvider->models[1]->id;  ?>
             <?= Html::a(Html::img($fakeimg), ['blogs/index', 'actual' => $dataProvider->models[1]->id], ['class' => 'card-image']) ?>
            <div class="card-body">
            <h2 class="card-title"><?= $dataProvider->models[1]->denom  ?></h2>
              <p class="card-text"><?= $dataProvider->models[1]->descripcion ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver comunidad</button>
                </div>
                <small class="text-muted"><?= Icon::show('heart') . $dataProvider->models[1]->favs ?></small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1757a94ddb3%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1757a94ddb3%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.2265625%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
            <div class="card-body">
            <h2 class="card-title"><?= $dataProvider->models[2]->denom  ?></h2>
              <p class="card-text"><?= $dataProvider->models[2]->descripcion ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver comunidad</button>
                </div>
                <small class="text-muted"><?= Icon::show('heart') . $dataProvider->models[2]->favs ?></small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1757a94ddb3%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1757a94ddb3%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.2265625%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
            <div class="card-body">
            <h2 class="card-title"><?= $dataProvider->models[3]->denom  ?></h2>
              <p class="card-text"><?= $dataProvider->models[3]->descripcion ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ver comunidad</button>
                </div>
                <small class="text-muted"><?= Icon::show('heart') . $dataProvider->models[3]->favs ?></small>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
<?php else:  ?>
<div class="site-index">
  <div class="jumbotron">
      <h1>Congratulations!</h1>

      <p class="lead">You have successfully created your Yii-powered application.</p>

      <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
  </div>
  <div class="body-content">

      <div class="row">
          <div class="col-xl-4">
              <h2>Heading</h2>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                  fugiat nulla pariatur.</p>

              <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
          </div>
          <div class="col-xl-4">
              <h2>Heading</h2>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                  fugiat nulla pariatur.</p>

              <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
          </div>
          <div class="col-xl-4">
              <h2>Heading</h2>

              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                  ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                  fugiat nulla pariatur.</p>

              <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
          </div>
      </div>
  </div>
</div>
<?php endif; ?>

<!-- <div class="col-md-4">
  <div class="card mb-4 box-shadow">
    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1757a94ddb3%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1757a94ddb3%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.2265625%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
    <div class="card-body">
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
        </div>
        <small class="text-muted">9 mins</small>
      </div>
    </div>
  </div>
</div> -->



    <?= CookieConsent::widget([
    'name' => 'cookie_consent_status',
    'path' => '/',
    'domain' => '',
    'expiryDays' => 365,
    'message' => Yii::t('cookie-consent',
      'Utilizamos cookies para asegurar el correcto funcionamiento de nuestro sitio web. 
       Para una mejor experiencia de visita utilizamos productos de análisis. Se utilizan cuando está de acuerdo con "Estadísticas"..'),
    'acceptAll' => Yii::t('cookie-consent', 'Aceptar'),
    'controlsOpen' => false,
    'detailsOpen' => false,
    'learnMore' =>  false,
]) ?>
    

