<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioComunidad */

$this->title = 'Update Usuario Comunidad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Comunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-comunidad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
