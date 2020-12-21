<?php


use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Mis amigos';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< EOT
EOT;
$this->registerJs($js);

?>

<div class="mis-seguidores">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'seguidores',
        'columns' => [
            'alias',
            'created_at:date',
           [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{seguir}',
                'buttons' => [
                    'seguir' => function ($url, $model) {
                        $seguir = Url::to(['usuarios/seguir', 'alias' => $model->alias]);
                        $existe = ($model->existeSeguidor($model->alias)) ? ('Dejar de seguir') : ('Seguir'); 
                        return Html::a($existe, '#', ['class' => 'btn btn-danger login', 'aria-label' => $existe, 'data-balloon-pos' => 'up',
                            'onclick' =>"
                            event.preventDefault();
                            var self = $(this);
                            $.ajax({
                                type: 'GET',
                                url: '$seguir',
                                dataType: 'json',
                            }).done(function( data, textStatus, jqXHR ) {
                                data = JSON.parse(data);
                                console.log(data);
                                $(self).text(data.button);
                                $(self).attr('aria-label', data.button);
                                $('#seguidores').load(location.href + ' #seguidores');
                            }).fail(function( data, textStatus, jqXHR ) {
                                console.log('Error de la solicitud.');
                            });",
                        ]); 
                    },
                ],
            ],
        ],
        
    ]); ?>


</div>