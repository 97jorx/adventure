<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use dosamigos\chartjs\ChartJs;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url = Url::to(['comunidades/like', 'id' => $model->id]); 
$like = ($tienefavs) ? (['thumbs-up','Me gusta']) : (['thumbs-down', 'No me gusta']);
// var_dump($likes); 
// var_dump($month); die();

?>

<div class="chart-container" style="position: relative; height:40vh; width:40vw">
  <canvas id="chart"></canvas>
</div>
    

<?= ChartJs::widget([
    'type' => 'bar',
    'id' => 'chart',
    'data' => [
        'labels' => $month,
        //  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        'datasets' => [
            [
                'data' => $likes, 
                'label' => 'Likes',
                'backgroundColor' => [
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    '#ADC3FF',
                    
                ],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 2,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
        ]
    ],
    'clientOptions' => [
            'scales' => [
                'yAxes' => new JsExpression(
                    "
                    [{
                        ticks: {
                            beginAtZero: true,
                            min: 0
                        }
                    }]
                    "
                )
           ],
    ],
]);

?>



<!-- <div class="comunidades-view">

    <h1><?= Html::encode($this->title) ?></h1>

      <div class="ml-3">
        <?= Html::a(Icon::show($like[0], ['id' => 'like', 'framework' => Icon::FAS]), $url, [
                'onclick' =>"
                event.preventDefault();
                var self = $(this);
                $.ajax({
                    type: 'POST',
                    url: '$url',
                    dataType: 'json',
                }).done(function(data, textStatus, jqXHR) {
                    data = JSON.parse(data);
                    $('#fav').html(data.fav);
                    $('#like').efect();
                    $('#like').attr('class', (data.icono) ? ('fas fa-thumbs-down') : ('fas fa-thumbs-up'))
                    $('#like').attr('title', (data.icono) ? ('No me gusta') : ('Me gusta'))
                }).fail(function(data, textStatus, jqXHR) {
                    console.log('Error de la solicitud.');
                });", 'title' => $like[1]
            ]); 
            ?> 
        <span id="fav" class="ml-3"><?= $model->favs ?></span>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'denom',
            'propietario',
            'descripcion:ntext',
            'created_at',
            
        ],
    ]) ?>

</div> -->
