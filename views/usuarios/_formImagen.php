<?php
use yii\bootstrap4\ActiveForm;
use kartik\icons\Icon;

$js = <<< EOT
$(document).ready(function(){ 
    e.preventDefault();   
    $("i").click(function () {
        $("input[type='file']").trigger('click');
      });
      
      $('input[type="file"]').on('change', function() {
        var val = $(this).val();
        $(this).siblings('span').text(val);
      })
});
EOT;
$this->registerJs($js);

$css = <<< EOT

.element {
    display: inline-flex;
    align-items: center;
}

i.fa-camera {
    display: inline-block;
    border-radius: 50%;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
    background-color: white;
    margin: 10px;
    cursor: pointer;
    font-size: 30px;
}

i:hover {
    opacity: 0.6;
}

input {
    display: none;
}

EOT;
$this->registerCss($css);

?>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'options' => ['enctype' => 'multipart/form-data'
    ]]) ?>

    <div class="element">
        <?= $form->field($model, 'imagen')->fileInput(['onchange' => "this.form.submit()", 
        'style' => 'display:none'])->label(Icon::show('camera')); ?> 
    </div>


<?php ActiveForm::end(); ?>


