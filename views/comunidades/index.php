<?php

use yii\bootstrap4\Html;
use kartik\icons\FontAwesomeAsset;
use kartik\icons\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = 'Comunidades';

$username = !Yii::$app->user->isGuest;
$user = $username ? (Yii::$app->user->identity->username) : (null);

$js = <<< EOF
window.onload = (e) => { 
    if (localStorage.getItem('$user') === null && Boolean($username)) {
        localStorage.setItem('$user', '$user')
        $("#myModal").modal('show');
    }

$('#next_nav').click(function () {
    $( "#nav" ).animate({
        scrollLeft: '+=156px'
    });
});
$('#prev_nav').click(function () {
    $( "#nav" ).animate({
        scrollLeft: '-=156px'
    });
});
}
EOF;

$this->registerJs($js);


Yii::$app->formatter->locale = 'es-ES';

?>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
       
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>



<div itemtype="adventureSchema.org/comunidades" class="masonry-wrapper">
    <div class="masonry">
        <?php foreach($dataProvider->models as $model) { ?> 
        <div class="masonry-item">
            <div class="masonry-content">
                <?php $fakeimg = "https://picsum.photos/800/800?random=".$model->id;  ?>
                <?= Html::a(Html::img($fakeimg, ['class' => 'card-img-top masonry-img']), ['blogs/index', 'actual' => $model->id]) ?>
                <h5 itemprop="titulo" class="masonry-title"><b><?= $model->denom  ?></b></h5>
                <p itemprop="descripción" class="masonry-description"><b><?= $model->descripcion ?></b></p>
                <div class="masonry-details">
                    <i itemprop="fecha" data-balloon-pos='up'aria-label='<?=Yii::$app->formatter->asDate($model->created_at)?>'><?= Icon::show('clock')?></i> 
                    <i itemprop="detalles" class='favdetail' ><i><?= $model->favs ?></i><?= Icon::show('heart')?></i>
                </div>
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
                    <?= Html::a(Icon::show('heart') , ['comunidades/like', 'id' => $model->id], [
                        'class' => 'masonry-button', 
                        'aria-label' => 'Me gusta', 
                        'data-balloon-pos' => 'up'
                    ]); ?>
                    <?= Html::a(Icon::show('bar-chart'), ['comunidades/view', 'id' => $model->id], [
                        'class' => 'masonry-button fa-bar-chart', 
                        'aria-label' => 'Estadísticas', 
                        'data-balloon-pos' => 'up'
                    ]); ?>

                    <?= Html::a(Icon::show('trash'), ['delete', 'id' => $model->id], [
                        'class' => 'masonry-button',
                        'aria-label' => 'Borrar', 
                        'data-balloon-pos' => 'up',
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

