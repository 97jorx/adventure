<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComunidadesSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comunidades-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'denom') ?>

    <!-- <div class="form-group">
        ?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        ?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div> -->

    <?php ActiveForm::end(); ?>

</div>
