<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */
/* @var $form yii\bootstrap4\ActiveForm */


?>

<div class="blogs-form">


<?php $form = ActiveForm::begin([
        'id' => 'blogs-form',
      ]); ?> 


    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cuerpo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comunidad_id')->dropDownList($comunidades, ['disabled' => 'disabled']); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

