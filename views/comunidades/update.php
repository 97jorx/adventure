<?php


use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */

$this->title = 'Modificar Comunidad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="comunidades-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>



    <?= Yii::$app->runAction('usuarios/index', [
        'id' => $model->id
    ]); ?>

    

</div>
