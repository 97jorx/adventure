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



<div itemscope itemtype="http://schema.org/Blog" class="masonry-wrapper">
    <div class="masonry">
        <?php foreach($dataProvider->models as $model) { ?> 
        <div class="masonry-item">
            <div class="masonry-content">
                <div class="masonry-bar">
                    <?php $existe = ($model->existeIntegrante($model->id)) ? ('Salir') : ('Unirse'); ?>
                    <?php $unirse = Url::to(['comunidades/unirse', 'id' => $model->id]); ?>
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
                    <?php $id = html::encode($model->id)?>
                    <?php $url = Url::to(['comunidades/like', 'id' => $model->id]); ?>
                    <?= Html::a(Icon::show('heart', ['id' => 'like', 'framework' => Icon::FAS]), $url, [
                        'onclick' =>"
                        event.preventDefault();
                        var self = $(this);
                        $.ajax({
                            type: 'POST',
                            url: '$url',
                            dataType: 'json',
                        }).done(function(data, textStatus, jqXHR) {
                            data = JSON.parse(data);
                            $('#fav$id').html(data.fav);
                            $('#like').efect();
                            console.log(data);
                        }).fail(function(data, textStatus, jqXHR) {
                            console.log('Error de la solicitud.');
                            console.log(data);
                        });", 'aria-label' => 'Me gusta', 'data-balloon-pos' => 'up', 'class' => 'masonry-button', 
                    ]); 
                    ?> 
                    <?= Html::a(Icon::show('bar-chart'), ['comunidades/view', 'id' => $model->id], [
                        'class' => 'masonry-button fa-bar-chart', 
                        'aria-label' => 'Estadísticas', 
                        'data-balloon-pos' => 'up'
                    ]); ?>
                    <?= Html::a(Icon::show('pencil', ['framework' => Icon::FA]), ['comunidades/update', 'id' => $model->id], [
                        'class' => 'masonry-button', 
                        'aria-label' => 'Modificar', 
                        'data-balloon-pos' => 'up'
                    ]); ?>
                    <?php if($user === 'admin') : ?>
                    <?= Html::a(Icon::show('trash'), ['delete', 'id' => $model->id], [
                        'class' => 'masonry-button',
                        'aria-label' => 'Borrar', 
                        'data-balloon-pos' => 'up',
                                'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                ],
                    ]) ?>
                    <?php endif;?>
                    </div>
                <?php $fakeimg = "https://picsum.photos/800/800?random=".$model->id;  ?>
                <?= Html::a(Html::img($fakeimg, ['class' => 'card-img-top masonry-img']), ['blogs/index', 'actual' => $model->id]) ?>
                <h5 itemprop="tittle" class="masonry-title"><b><?= $model->denom  ?></b></h5>
                <p itemprop="description" class="masonry-description"><b><?= $model->descripcion ?></b></p>
                </div>
                <div class="masonry-details">
                    <i itemprop="date" data-balloon-pos='up'aria-label='<?=Yii::$app->formatter->asDate($model->created_at)?>'><?= Icon::show('clock')?></i> 
                    <i  class='favdetail' ><i id='fav<?=$model->id?>'><?= $model->favs ?></i><?= Icon::show('heart')?></i>
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

