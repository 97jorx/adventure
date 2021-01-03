
<?php

/* @var $this yii\web\View */

use app\helpers\Util;
use dmstr\cookieconsent\widgets\CookieConsent;
use yii\bootstrap4\Html;
$this->registerCssFile('@web/css/cookie-consent.css');

// var_dump(Util::s3DeleteImage('admin.png')); die();
var_dump(Util::s3UploadImage(Yii::getAlias('@img'). '/foto.jpg','foto.jpg')); die();
?>

<?php if($count >= 4) : ?> 
<body>
  <div class="container">
  <?php $index = 0; foreach($dataProvider->models as $model) : ?>
      <?php if($index == 0) : ?>
    <div class="row align-items-center my-5">
     <div class="card h-100 flex-row flex-wrap border-0">
        <div class="col-lg-7">
          <?php $fakeimg = "https://picsum.photos/600/450?random=".$model->id;  ?>
          <?= Html::a(Html::img($fakeimg, ['class' => 'card-image']), ['blogs/index', 'actual' => $model->id],  ['class' => 'login']) ?>
        </div>
        <div class="col-lg-5">
                <h1 class="font-weight-light"><?= $model->denom  ?></h1>
          <p class="card-text"><?= $model->descripcion ?></p>
          <?= Html::a('Ver comunidad', ['blogs/index', 'actual' => $model->id],  ['class' => 'btn btn-info login']) ?>
        </div>
     </div>
    </div>
    <div class="card text-white bg-secondary my-5 py-4 text-center">
      <div class="card-body">
        <p class="text-white m-0">Estas son las comunidades más favoritas de la web, ve y mira a ver si es de tu agrado!</p>
      </div>
    </div>
    <div class="row">
    <?php elseif($index > 0 && $index < 4) :  ?>
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <div class="card-body">
              <h2 class="card-title"><?= $model->denom  ?></h2>
              <p class="card-text"><?= $model->descripcion ?></p>
          </div>
          <div class="card-footer">
          <?= Html::a('Ver comunidad', ['blogs/index', 'actual' => $model->id],  ['class' => 'btn btn-info btn-sm login']) ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    <?php $index++; endforeach; ?>
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
    

