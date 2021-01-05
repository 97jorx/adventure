<?php

use app\helpers\Util;
use yii\bootstrap4\Html;
use app\helpers\UtilAjax;
/* @var $this yii\web\View */
/* @var $model app\models\Galerias */


$this->registerJs(UtilAjax::img)
?>


<div class="galerias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  -->

</div>
    <!-- Page Content -->
   <div class="container page-top">
        <div class="row">
        <?php $index = 0; foreach($dataProvider->models as $model) : ?> 
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <a href="" class="fancybox" rel="ligthbox"> 
                 <img  src="<?= Util::s3GetImage($model->fotos)  ?>" class="zoom img-fluid "  alt="">
                </a>
            </div>
        <?php endforeach; ?> 
       </div>
    </div>



</div>
