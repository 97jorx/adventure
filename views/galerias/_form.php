<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Galerias */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="galerias-form">
  
  <?php  $form = ActiveForm::begin([
            'id' => 'gallery', 
    ]); ?> 

        <?= $form->field($model, 'uploadedFile')->widget(FileInput::class, [
        'options' => ['accept' => 'uploadedFile/*', 
        'data-allowed-file-extensions' => ["png", "jpg"]],
        'pluginOptions' => [
            'maxFileSize' => 2048,
        ]
        ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
