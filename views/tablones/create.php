<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tablones */

$this->title = 'Create Tablones';
$this->params['breadcrumbs'][] = ['label' => 'Tablones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tablones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
