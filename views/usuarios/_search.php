<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'apellidos') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'rol') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'contrasena') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'poblacion') ?>

    <?php // echo $form->field($model, 'provincia') ?>

    <?php // echo $form->field($model, 'pais') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
