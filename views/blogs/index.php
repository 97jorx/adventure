<?php

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

    
    // $this->title = 'Blogs';
    // $this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
    // $this->params['breadcrumbs'][] = $this->title;

?>

 <?=  $this->render('_tablon', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'actual' => $actual,
      'busqueda' => $busqueda,
]); ?>



