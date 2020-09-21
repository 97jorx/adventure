<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Galerias */

$this->title = 'Create Galerias';
$this->params['breadcrumbs'][] = ['label' => 'Galerias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="galerias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
