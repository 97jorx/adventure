<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FavblogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Favblogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favblogs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Favblogs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'blog_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
