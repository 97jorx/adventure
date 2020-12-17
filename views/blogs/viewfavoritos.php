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
<?php  ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'imagen',
                'value' => function ($model, $widget) {
                    $fakeimg = 'https://picsum.photos/100/100?random=' . $model->id;
                    return Html::img($fakeimg, ['class' => 'img', 'width' => '100px']);
                },
                'format' => 'raw',
            ],
            'usuario.nombre',
            'titulo',
        ],
        ]); ?>

</div>
