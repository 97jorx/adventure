<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfilSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfiles-index">

    <h1><?= Html::encode($this->title.' de '.Yii::$app->user->identity->username) ?></h1>


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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
