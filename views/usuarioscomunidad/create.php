<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioComunidad */

$this->title = 'Create Usuario Comunidad';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Comunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-comunidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
