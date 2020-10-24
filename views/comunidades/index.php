<?php

use hoaaah\sbadmin2\widgets\Card;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use kartik\detail\DetailView;
use kartik\icons\Icon;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = 'Comunidades';

$username = !Yii::$app->user->isGuest;
$user = $username ? (Yii::$app->user->identity->username) : (null);

$js = <<< EOF
$(document).ready(function() {
    if (localStorage.getItem('$user') === null && Boolean($username)) {
        localStorage.setItem('$user', '$user')
        $("#myModal").modal('show');
    }
});

EOF;

$this->registerJs($js);


Yii::$app->formatter->locale = 'es-ES';

?>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
       
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>



<div class="masonry-wrapper">
    <div class="masonry">
        <?php foreach($dataProvider->models as $model) { ?> 
        <div class="masonry-item">
            <div class="masonry-content responsive">
                <div class="masonry-image">
                    <?php $fakeimg = "https://picsum.photos/200/300?random=".$model->id;  ?>
                    <?= Html::a(Html::img($fakeimg), ['blogs/index', 'actual' => $model->id], ['class' => 'card-image']) ?>
                </div>
                <h5 class="masonry-title"><b><?= $model->denom  ?></b></h5>
                <p class="masonry-description"><b><?= $model->descripcion ?></b></p>
                <p id="r" class="masonry-description"><b><?= Yii::$app->formatter->asDate($model->created_at)?></b></p>
                <?php $existe = ($model->existeIntegrante($model->id)) ? ('Salir') : ('Unirse'); ?>
                <?php $unirse = Url::to(['comunidades/unirse', 'id' => $model->id]); ?>
                <div class="masonry-bar">
                    <?= Html::a($existe, $unirse, ['class' => 'masonry-button',
                        'onclick' =>"
                            event.preventDefault();
                            var self = $(this);
                            $.ajax({
                                type: 'GET',
                                url: '$unirse',
                                dataType: 'json',
                            }).done(function( data, textStatus, jqXHR ) {
                                data = JSON.parse(data);
                                $(self).text(data.button);             
                                $('#color').prop('class', data.color);
                                $('#mensaje').text(data.mensaje);
                                $('#myModal').modal('show');
                            }).fail(function( data, textStatus, jqXHR ) {
                                console.log('Error de la solicitud.');
                            });"
                    ]); 
                    ?> 
                    <?= Html::a(Icon::show('heart') , $unirse, ['class' => 'masonry-button']); ?>
                    <?= Html::a('', ['comunidades/view', 'id' => $model->id], ['class' => 'masonry-button glyphicon glyphicon-eye-open']); ?>
                    <?= Html::a('', ['delete', 'id' => $model->id], [ 'class' => 'masonry-button glyphicon glyphicon-trash',
                                'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                ],
                    ]) ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div id="color" class="modal-content">
            <div class="modal-body">
                <p id="mensaje" >Bienvenido a ADVENTURE.</p>
            </div>
        </div>
    </div>
</div>




