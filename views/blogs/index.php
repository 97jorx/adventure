<?php

use app\helpers\Util;
use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

    
    $this->title = 'Blogs';
    $this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['comunidades/index']];
    $this->params['breadcrumbs'][] = ['label' => Util::h(Util::comunidad()), 'url' => ['comunidades/index']];
    $this->params['breadcrumbs'][] = Util::h($this->title);

?>

 <?=  $this->render('_tablon', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'actual' => $actual,
      'busqueda' => $busqueda,
]); ?>


