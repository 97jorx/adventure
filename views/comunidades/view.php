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

<div class="chart-container" style="height:40vh; width:40vw">
  <canvas id="chart"></canvas>
</div>
    

<?= ChartJs::widget([
    'type' => 'bar',
    'id' => 'chart',
    'data' => [
        'labels' => $month,
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



