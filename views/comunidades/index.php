<?php

use yii\bootstrap4\Html;
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

    <?php ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]);
    ?>


<!-- <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
        <div class="mainflip">
            <div class="frontside">
                <div class="card">
                    <div class="card-body text-center">
                        <p><img class="img-fluid" src="@web/uploads/test.jpg" alt="card image"></p>
                        <h4 class="card-title">Prueba de card</h4>
                        <p class="card-text">Esto es una prueba de card en Boostrap</p>
                        </div>            
                 </div>
            </div>
        </div>
    </div>    
</div> -->


<?= Card::widget([

'type' => 'cardBorder',
'label' => 'Label',
'sLabel' => '1000',
'icon' => 'fas fa-calendar',
'options' => [
    'colSizeClass' => 'col-md-3',
    'borderColor' => 'primary',
]
]); 
?>
</div>