<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Cambiar foto perfil';

?>

<?php $form = ActiveForm::begin() ?>

<div class="alert alert-warning alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Sólo están permitidas las extensiones de .jpg y .png
</div>

<?= $form->field($model, 'imagen')->widget(FileInput::class, [
    'options' => ['accept' => 'imagen/*', 'data-allowed-file-extensions' => ["png", "jpg"]],
]); ?>

    <button class='btn btn-primary'>Enviar</button>
    <?= Html::a('Cancelar', ['incidencias/index'], ['type'=>'button', 'class' => 'btn btn-light',]) ?>
<?php ActiveForm::end() ?>