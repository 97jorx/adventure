<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Integrantes */

$this->title = 'Create Integrantes';
$this->params['breadcrumbs'][] = ['label' => 'Integrantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integrantes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
