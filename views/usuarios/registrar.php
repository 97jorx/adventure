<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use kartik\date\DatePickerAsset;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Registrar usuario';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/jquery-ui.css", [
    'media' => 'print',
]);

;
$js = <<< EOF
$('#parsley').on('input', function(){
    $('#parsley').parsley().validate();
});

if (window.navigator.geolocation) {
    var failure, success;
    success = function(position) {
        $.ajax({
            url: "https://geolocation-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function(location) {
              $('#pais').val(location.country_name);
              $('#provincia').val(location.state);
              $('#poblacion').val(location.city);
            }
          });
    };
    failure = function(message) {
      alert('No se ha podido encontrar la localización!');
    };
    navigator.geolocation.getCurrentPosition(success, failure, {
      maximumAge: Infinity,
      timeout: 5000
    });
}

EOF;
$this->registerJs($js);


?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<AIzaSyCcDtT4jEMwzFLwULB2_3ae9teZmq2joJc>&sensor=false&v=3&libraries=geometry"></script>
<div class='site-login'>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca los siguientes datos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'parsley',
        'enableAjaxValidation' => true,
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['type' => 'text', 'class' => 'form-control input-lg parsley-validated']) ?>
        <?= $form->field($model, 'nombre')->textInput(['type' => 'text']) ?>
        <?= $form->field($model, 'apellidos')->textInput(['type' => 'text']) ?>
        <?= $form->field($model, 'contrasena')->passwordInput(['type' => 'password', 'id' => 'password1']) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['type' => 'password', 'data-parsley-equalto' => '#password1']) ?>
        <?= $form->field($model, 'fecha_nac')->widget(DatePicker::class,[
            'name' => 'Fecha nacimiento',
            'language' => 'es-ES',
            'options' => [],
            'dateFormat' => 'yyyy/MM/dd',
            'options' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1996:2099',
                'buttonImageOnly' => true,
                'class' => 'form-control',
                'placeholder' => 'YYYY/MM/D',
                'autocomplete'=>'off',
                ],
        ]) ?>
        <?= $form->field($model, 'email')->textInput(['id' => 'email', 'type' => 'email', 'data-parsley-type' => 'email']) ?>
        <?= $form->field($model, 'poblacion')->hiddenInput(['id' => 'poblacion'])->label(false) ?>
        <?= $form->field($model, 'pais')->hiddenInput(['id' => 'pais'])->label(false) ?>
        <?= $form->field($model, 'provincia')->hiddenInput(['id' => 'provincia', 'value' => ''])->label(false) ?>
        <div class='form-group'>
            <div class='offset-sm-2'>
                <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    
</div> 
