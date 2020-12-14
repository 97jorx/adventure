<?php
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap4\Modal;
use yii\helpers\Html;


// $this->title = 'Cambiar foto perfil';

?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]) ?>


 <?= $form->field($model, 'imagen')->fileInput();  ?>

<button class='btn btn-primary'>Enviar</button>
<?= Html::a('Cancelar', ['usuarios/view', 'alias' => Yii::$app->request->get('alias')], ['type'=>'button', 'class' => 'btn btn-light',]) ?>
<?php ActiveForm::end(); ?>


