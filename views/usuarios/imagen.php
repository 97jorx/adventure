<?php
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Html;


$this->title = 'Cambiar foto perfil';

?>

<?php $form = ActiveForm::begin() ?>


<div class=container>
  <div class="alert alert-warning alert-dismissable">
      <div class="col-">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      </div>
      <div class="col-10">
        Sólo están permitidas las extensiones de <strong>.jpg y .png.</strong>
      </div>
  </div>
</div>


<?= $form->field($model, 'imagen')->widget(FileInput::class, [
    'options' => ['accept' => 'imagen/*', 
    'data-allowed-file-extensions' => ["png", "jpg"]],
    'pluginOptions' => [
        'maxFileSize' => 2048,
    ]
])->label(false); ?>

    <button class='btn btn-primary'>Enviar</button>
    <?= Html::a('Cancelar', ['usuarios/view', 'alias' => Yii::$app->request->get('alias')], ['type'=>'button', 'class' => 'btn btn-light',]) ?>
<?php ActiveForm::end() ?>