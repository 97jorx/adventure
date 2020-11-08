<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BlogsSearch */
/* @var $form yii\bootstrap4\ActiveForm */
$url = Yii::$app->urlManager->createUrl('blogs/index', ['blogs/index', 'actual' => $actual, 'busqueda' => $busqueda]);
?>


 <?php $form = ActiveForm::begin([
     'method' => 'get',
     'action' => Url::to(['blogs/index', 'actual' => $actual]),
]); ?>

<div class='card my-4'>
        <h5 class='card-header'>Búsqueda</h5>
        <div class='card-body'>
            <div class='input-group'>
                <?= Html::textInput('busqueda', $busqueda, ['class' => 'form-control']) ?>
                <span class='input-group-append'>
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                </span>
            </div>
      </div>
</div>
<?php $form = ActiveForm::end(); ?>
        
        
      
    
