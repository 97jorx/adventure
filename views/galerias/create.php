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

</div>
    <!-- Page Content -->
   <div class="container page-top">
        <div class="row">
        <?php $index = 0; foreach($dataProvider->models as $model) : ?> 
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <a class="fancybox" href="<?= Util::s3GetImage($model->fotos)?>" data-fancybox-group="gallery" title=""> 
                 <img  src="<?= Util::s3GetImage($model->fotos)  ?>" class="zoom img-fluid "  alt="">
                </a>
            </div>
        <?php endforeach; ?> 
       </div>
    </div>



</div>
