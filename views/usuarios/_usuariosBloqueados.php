<?php


use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Mis bloqueados';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< EOT
EOT;
$this->registerJs($js);

?>

<div class="mis-bloqueados">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'bloqueados',
        'columns' => [
            'alias',
            'created_at:date',
           [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{bloquear}',
                'buttons' => [
                    'bloquear' => function ($url, $model) {
                        $bloquear = Url::to(['usuarios/bloquear', 'alias' => $model->alias]);
                        $existe = ($model->existeBloqueado($model->alias)) ? ('Desbloquear') : ('Bloquear'); 
                        return Html::a($existe, '#', ['class' => 'btn btn-danger login', 'aria-label' => $existe, 'data-balloon-pos' => 'up',
                            'onclick' =>"
                            event.preventDefault();
                            var self = $(this);
                            $.ajax({
                                type: 'GET',
                                url: '$bloquear',
                                dataType: 'json',
                            }).done(function( data, textStatus, jqXHR ) {
                                data = JSON.parse(data);
                                console.log(data);
                                $(self).text(data.button);
                                $(self).attr('aria-label', data.button);
                                $('#bloqueados').load(location.href + ' #bloqueados');
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