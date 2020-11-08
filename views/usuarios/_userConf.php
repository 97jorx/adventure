<?php


use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Configuración de usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userconf-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'nombre',
            'apellidos',
            'email:email',
            'rol',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{bloquear}',
                'buttons' => [
                    'bloquear' => function ($model) {
                        $bloquear = Url::to(['comunidades/bloquear', 'id' => $model->id]);
                        return  Html::a('', $bloquear, [
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
                                    $('#color').prop('class', data.color);
                                    $('#mensaje').text(data.mensaje);
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