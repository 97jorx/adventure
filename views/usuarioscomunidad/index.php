<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioComunidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuario Comunidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-comunidad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario Comunidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'creador:boolean',
            'comunidad_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
