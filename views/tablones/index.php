<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TablonesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tablones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tablones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tablones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'blogs_id',
            'blogs_destacados_id',
            'galerias_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
