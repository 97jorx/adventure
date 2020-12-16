<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FavblogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favblogs-index">
    <h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'titulo',
            'usuario.nombre',
            'usuario.foto_perfil',

            ['class' => 'yii\grid\ActionColumn'],
        ],
]); ?>

</div>
