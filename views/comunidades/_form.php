<?php

use kartik\file\FileInput;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comunidades-form">

<?php $form = ActiveForm::begin([
        'id' => 'comunidades-form',
      ]); ?> 

    <?= $form->field($model, 'denom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

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
