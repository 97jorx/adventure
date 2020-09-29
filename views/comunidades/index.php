<?php

use hoaaah\sbadmin2\widgets\Card;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunidades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]);
    ?>



        <!--  GridView::widget([
            'dataProvider' => $libros,
            'columns' => [
                'titulo',
                [
                    'class' => ActionColumn::class,
                    'controller' => 'libros',
                    'template' => '{view}',
                ],
            ],
        ])  -->

      <?= DetailView::widget([
        'model'=>$model,    
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Book # ' . $model->id,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>[
            'nombre',
            'descripcion',
        ['attribute'=>'created_at', 'type'=>DetailView::INPUT_DATE],
    ]
]); ?>

    
</div>