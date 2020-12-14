<?php
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap4\Modal;
use yii\helpers\Html;


// $this->title = 'Cambiar foto perfil';

?>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'options' => ['enctype' => 'multipart/form-data'
    ]]) ?>


    <?= $form->field($model, 'imagen' 
    )->fileInput(['onchange' => "this.form.submit()"])->label(false); ?> 


    <?php ActiveForm::end(); ?>


