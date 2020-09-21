<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Galerias */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="galerias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fotos')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
