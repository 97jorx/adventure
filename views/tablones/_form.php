<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tablones */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="tablones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'blogs_id')->textInput() ?>

    <?= $form->field($model, 'blogs_destacados_id')->textInput() ?>

    <?= $form->field($model, 'galerias_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
