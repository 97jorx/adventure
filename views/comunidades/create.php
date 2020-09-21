<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */

$this->title = 'Create Comunidades';
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunidades-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
