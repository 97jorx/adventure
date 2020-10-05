<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perfiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfiles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Perfiles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'foto_perfil',
            'bibliografia',
            'valoracion',
            'usuario_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
