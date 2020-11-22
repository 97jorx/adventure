<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use kartik\date\DatePickerAsset;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/jquery-ui.css", [
    'media' => 'print',
]);


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
      console.log('No se ha podido encontrar la localización!');
    };
    navigator.geolocation.getCurrentPosition(success, failure, {
      maximumAge: Infinity,
      timeout: 5000
    });
}

EOF;
$this->registerJs($js);


?>

<div class='register-form'>
    <?php $form = ActiveForm::begin([
        'id' => 'parsley',
        'enableAjaxValidation' => true,
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-8'],
        ],
    ]); ?>

    

    <div class='fullname-group'>
       <?= $form->field($model, 'username')->textInput(['type' => 'text',
            'class' => 'form-control input-lg parsley-validated',
            'placeholder' => 'Nombre de Usuario',
         ])->label(Icon::show('user', ['class' => 'icon-label'])) ?>    
        <?= $form->field($model, 'nombre')->textInput([
            'type' => 'text',
            'placeholder' => 'Nombre',
        ])->label(false) ?>
        <?= $form->field($model, 'apellidos')->textInput([
            'type' => 'text',
            'data-parsley-error-message' => 'Los apellidos deben estar en Mayúscula y separados por un espacio.',    
            'placeholder' => 'Apellidos',
        ])->label(false) ?>
    </div>

    <div class='password-group'>
            <?= $form->field($model, 'contrasena')->passwordInput([
                'id' => 'password1',
                'type' => 'password',
                'data-parsley-pattern' => '/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?¿()=.@#$%]).{8,15})/g',
                'data-parsley-error-message' => 'La contraseña debe contener 1 mayúscula, 1 carácter especial, 1 número como mínimo.',
                'placeholder' => 'Contraseña',
                'aria-label' => 'La contraseña debe contener 1 mayúscula, 1 carácter especial, 1 número como mínimo.!',
                'data-balloon-pos' => 'right'
            ])->label(Icon::show('key', ['class' => 'icon-label'])) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput([
                'data-parsley-equalto' => '#password1',
                'data-parsley-type' => 'password',
                'data-parsley-pattern' => '/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!?¿()=.@#$%]).{8,15})/g',
                'data-parsley-error-message' => 'La contraseña debe contener 1 mayúscula, 1 carácter especial, 1 número como mínimo.',
                'placeholder' => 'Repetir contraseña',
            ])->label(false) ?>
      </div>

        <?= $form->field($model, 'fecha_nac')->widget(DatePicker::class,[
            'name' => 'Fecha nacimiento',
            'language' => 'es-ES',
            'options' => [],
            'dateFormat' => 'dd/M/yyyy',
            'options' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1996:2099',
                'buttonImageOnly' => true,
                'class' => 'form-control',
                'placeholder' => 'Fecha de nacimiento',
                'autocomplete'=>'off',
                ],
        ])->label(Icon::show('calendar', ['class' => 'icon-label'])) ?>
        <?= $form->field($model, 'email')->textInput([
            'id' => 'email', 
            'type' => 'email', 
            'data-parsley-type' => 'email',
            'data-parsley-error-message' => 'El email introducido es incorrecto.',
            'placeholder'=>'Correo eletrónico' 
        ])->label(Icon::show('envelope', ['class' => 'icon-label'])) ?>
        <p id="error-container"></p>
        <?= $form->field($model, 'poblacion')->hiddenInput(['id' => 'poblacion'])->label(false) ?>
        <?= $form->field($model, 'pais')->hiddenInput(['id' => 'pais'])->label(false) ?>
        <?= $form->field($model, 'provincia')->hiddenInput(['id' => 'provincia', 'value' => ''])->label(false) ?>
            <div class='form-group'>
                <div class="row">
                    <div class='col-6 text-center'>
                        <?= Html::submitButton('Registrar',  [
                            'class' => 'btn btn-primary', 
                            'type'=>'button', 
                            'id' => 'login-button', 
                            'name' => 'login-button'
                        ]) ?>
                    </div>
                    <div class='col-6'>
                        <div class="options text-right">
                            <p class="pt-1">¿ Tienes cuenta ya ? <a href='#' class="blue-text login">Accede aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
    <?php ActiveForm::end(); ?>

</div>