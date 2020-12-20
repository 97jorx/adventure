<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\bootstrap4\ActiveForm */


?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin([ 
        'id' => 'usuarios-form',
    ]); ?>
    

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'biografia')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'foto_perfil')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nac')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contrasena')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

