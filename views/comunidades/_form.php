<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comunidades-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'denom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
