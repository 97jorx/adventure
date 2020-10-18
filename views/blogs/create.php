<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */

$this->title = 'Create Blogs';
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index', 'actual' => $actual]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blogs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
