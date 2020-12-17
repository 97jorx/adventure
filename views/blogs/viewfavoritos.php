<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FavblogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs favoritos';
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['blogs/viewfavoritos']);


$js = <<< EOF

setInterval(function(){  
    $.pjax.load({container:"#grid-view-favoritos"});
}, 15000); 

EOF;
$this->registerJs($js);

?>
<div class="favblogs-index">
    <h1><?= Html::encode($this->title) ?></h1>

    
<?php  ?>


<?php Pjax::begin([]); ?>

    <?= GridView::widget([
            'id' => "grid-view-favoritos",
            'dataProvider' => $dataProvider,
            'columns' => [
                'usuario.nombre',
                'titulo',
                [
                    'attribute' => 'imagen',
                    'value' => function ($model, $widget) {
                        $fakeimg = 'https://picsum.photos/100/100?random=' . $model->id;
                        return Html::img($fakeimg, ['class' => 'img', 'width' => '100px']);
                    },
                    'format' => 'raw',
                ],
                
            ],
        ]); ?>
        
<?php Pjax::end(); ?>

</div>
