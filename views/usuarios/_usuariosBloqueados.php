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
        'columns' => [
            'alias',
            'created_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{bloquear}',
                'buttons' => [
                    'bloquear' => function ($url, $model) {
                        $bloquear = Url::to(['usuarios/bloquear', 'uid' => $model->id, 'id' => Yii::$app->request->get('id')]);
                        $existe = (Yii::$app->AdvHelper->estaBloqueado($model->id, Yii::$app->request->get('id'))) ? ('Desbloquear') : ('Bloquear'); 
                        return  Html::a($existe, '#', ['class' => 'btn btn-danger',
                            'onclick' =>"
                                event.preventDefault();
                                var self = $(this);
                                $.ajax({
                                    type: 'GET',
                                    url: '$bloquear',
                                    dataType: 'json',
                                }).done(function(data, textStatus, jqXHR) {
                                    data = JSON.parse(data);
                                    $(self).text(data.button);             
                                    $(body).append(data.modal);
                                    $('#myModal').modal('show');
                                }).fail(function( data, textStatus, jqXHR ) {
                                    console.log('Error de la solicitud.');
                                });"
                        ]); 
                    },
                ],
            ],
        ],

        
    ]); ?>


</div>