<?php

use Github\Api\Project\Cards;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ListView;

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

    <!-- <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) ?> -->
    
<?php GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'yuor_attibute',
            'label' => 'your label',
            'format' => 'raw',
            'value' => function ($model) {                      
                return "<a href='./yourPath/view?id=". $model->your_column ."'  class = 'btn  btn-success glyphicon glyphicon-user ' > </a>";
            },
            'contentOptions' => ['style' => 'width:80px; text-align: center;'],
            'headerOptions' => ['style' => 'text-align: center;'],
        ],
    ],
    [
        'attribute' => 'yuor_attibute',
        'label' => 'your  2 label',
        'format' => 'raw',
        'value' => function ($model) {                      
            return "<img src='./yourPath/image.jpg>";
        },
        'contentOptions' => ['style' => 'width:400; height 400 px;'],
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
    [
        'attribute' => 'yuor_attibute', 
        'label' => 'your  3 label',
        'format' => 'raw',
        'value' => function ($model) {                      
            return '';
        },
        'contentOptions' => ['style' => 'width:400; height 400 px;'],
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
]);
?>
        
        
</div>
       
