<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Favblogs */

$this->title = 'Create Favblogs';
$this->params['breadcrumbs'][] = ['label' => 'Favblogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favblogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
