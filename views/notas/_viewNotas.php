<?php

use kartik\rating\StarRating;
use yii\bootstrap4\ActiveForm;


?>

<div class="star-rating-view">
  <?php $form = ActiveForm::begin([
          'id' => 'star-rating-view-form',
          'enableAjaxValidation' => true,
        ]); ?> 
            <div class="col-2">
                <?= $form->field($model, 'nota')->widget(StarRating::class, [
                    'pluginOptions' => ['step' => 1]
                ]); ?>
            
            </div>
  <?php ActiveForm::end(); ?>
</div>

