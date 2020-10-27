<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Registrar usuario';
$this->params['breadcrumbs'][] = $this->title;


$js = <<< EOF
$('#login-form').on('input', function(){
    $('#login-form').parsley().validate();
});
EOF;

$this->registerJs($js);

?>
<div class='site-login'>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca los siguientes datos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['class' => 'form-control input-lg parsley-validated']) ?>
        <?= $form->field($model, 'nombre')->textInput(['autofocus' => true, 'type' => 'text']) ?>
        <?= $form->field($model, 'apellidos')->textInput(['type' => 'text']) ?>
        <?= $form->field($model, 'contrasena')->passwordInput(['type' => 'password', 'id' => 'password1']) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['type' => 'password', 'data-parsley-equalto' => '#password1']) ?>
         <!-- $form->field($model, 'fecha_nac')->textInput(['id' => 'fecha', 'placeholder' => 'YYYY/MM/D', 'data-date-format' => '']) ?>  -->
        <?= $form->field($model, 'fecha_nac')->widget(DatePicker::class,[
            'name' => 'Fecha nacimiento',
            'language' => 'es-ES',
            'options' => [],
            'dateFormat' => 'yyyy/MM/dd',
            'options' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1996:2099',
                'showOn' => 'button',
                'buttonImage' => 'images/calendar.gif',
                'buttonImageOnly' => true,
                'class' => 'form-control',
                'nextText' => '>',
                'prevText' => '<',
                'autocomplete'=>'off',
                'buttonText' => 'Select date'
                ],
        ]) ?>
        <?= $form->field($model, 'email')->textInput(['id' => 'email', 'type' => 'email', 'data-parsley-type' => 'email']) ?>
        <?= $form->field($model, 'poblacion')->textInput() ?>
        <?= $form->field($model, 'provincia')->textInput() ?>
        <?= $form->field($model, 'pais')->textInput() ?>
        <div class='form-group'>
            <div class='offset-sm-2'>
                <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
</div> 
