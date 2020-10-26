<?php

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

    
    $this->title = 'Blogs';
    $this->params['breadcrumbs'][] = ['label' => 'Comunidad', 'url' => ['comunidades/index']];
    $this->params['breadcrumbs'][] = $this->title;

    
?>
 

 <?=  $this->render('_tablon', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'actual' => $actual,
      'busqueda' => $busqueda,
]); ?>



       
<div class="card my-4">
    <h5 class="card-header">Side Widget</h5>
    <div class="card-body">
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam excepturi deserunt incidunt suscipit, tempore commodi magni quam quis perspiciatis sapiente blanditiis vitae saepe dolor ipsum aperiam, eos alias animi dignissimos.
    </div>
</div>