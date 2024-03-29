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
Yii::debug($likes_month); 


$month = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

?>

<div class="chart-container" style="position: relative; height:40vh; width:50vw">
  <canvas id="chart"></canvas>
</div>
    

<?= ChartJs::widget([
    'type' => 'bar',
    'id' => 'chart',
    'data' => [
        'labels' => $month,
        'datasets' => [
            [
                'data' => $likes_month, 
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
        'responsive' => true,
        'maintainAspectRatio' => false,
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



