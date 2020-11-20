<?php

use yii\bootstrap4\Html;
use kartik\icons\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = 'Comunidades';



$username = !Yii::$app->user->isGuest;
$user = $username ? (Yii::$app->user->identity->username) : (null);

$js = <<< EOF
$(".masonry-item").hover(
    function() {
      $(this).find(".masonry-bar")
      .toggleClass("move-top")
    } 
);

window.onload = (e) => { 
if (localStorage.getItem('$user') === null && Boolean($username)) {
    localStorage.setItem('$user', '$user')
    $("#myModal").modal('show');
}
   
$(".arrow-left").click(function(){
    $(".masonry").animate({scrollLeft: "-="+100});
});
$(".arrow-right").click(function(){
    $(".masonry").animate({scrollLeft: "+="+100});
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
<a class="arrow-left visible"><?= Icon::show('angle-left')?> </a>
    <div class="masonry">
        <?php foreach($dataProvider->models as $model) { ?> 
        <div class="masonry-item" id="<?=$model->id?>">
            <div class="masonry-content">
                <div class="masonry-bar" id="masonry-bar<?=$model->id?>">
                    <?php $existe = ($model->existeIntegrante($model->id)) ? ['sign-out-alt', 'Salir'] : ['sign-in-alt', 'Unirse']; ?>
                    <?php $unirse = Url::to(['comunidades/unirse', 'id' => $model->id]); ?>
                    <?= Html::a(Icon::show($existe[0], ['id' => 'acceso']), $unirse, ['class' => 'masonry-button login', 
                        'aria-label' => $existe[1], 'data-balloon-pos' => 'up',
                        'onclick' =>"
                            event.preventDefault();
                            var self = $(this);
                            $.ajax({
                                type: 'GET',
                                url: '$unirse',
                                dataType: 'json',
                            }).done(function( data, textStatus, jqXHR ) {
                                data = JSON.parse(data);
                                $(self).find('i').removeClass();
                                $(self).find('i').addClass('fas fa-'+data.iconclass[0]);
                                $(self).attr('aria-label', data.iconclass[1]);
                                $('#color').prop('class', data.color);
                                $('#mensaje').text(data.mensaje);
                                $('#myModal').modal('show');
                            }).fail(function( data, textStatus, jqXHR ) {
                                console.log('Error de la solicitud.');
                            });"
                    ]); 
                    ?> 
                    <?php $id = html::encode($model->id)?>
                    <?php $tienelike = (Yii::$app->AdvHelper->tieneFavoritos($id, 'view')->exists()) ?
                         ['heart-broken', 'No me gusta'] : 
                         ['heart', 'Me gusta']; 
                    ?>
                    <?php $url = Url::to(['comunidades/like', 'id' => $model->id]); ?>
                    <?= Html::a(Icon::show($tienelike[0], ['id' => 'like', 'framework' => Icon::FAS]), $url, [
                        'aria-label' => $tienelike[1], 'data-balloon-pos' => 'up', 'class' => 'masonry-button login',
                        'onclick' =>"
                        event.preventDefault();
                        var self = $(this);
                        
                        $.ajax({
                            type: 'POST',
                            url: '$url',
                            dataType: 'json',
                        }).done(function(data, textStatus, jqXHR) {
                            data = JSON.parse(data);
                            $('.fav$id').html(data.fav);
                            $('#like').efect();
                            $(self).find('i').removeClass();
                            $(self).find('i').addClass(data.iconclass[0]);
                            $(self).attr('aria-label', data.iconclass[1]);
                            $('#color').prop('class', data.color);
                            $('#mensaje').text(data.mensaje);
                            $('#myModal').modal('show');
                        }).fail(function(data, textStatus, jqXHR) {
                            console.log('Error de la solicitud.');
                            console.log(data);
                        });",  
                    ]); 
                    ?> 
                    <?= Html::a(Icon::show('bar-chart'), ['comunidades/view', 'id' => $model->id], [
                        'class' => 'masonry-button login', 
                        'aria-label' => 'Estadísticas', 
                        'data-balloon-pos' => 'up'
                    ]); ?>
                    <?= Html::a(Icon::show('pencil', ['framework' => Icon::FA]), ['comunidades/update', 'id' => $model->id], [
                        'class' => 'masonry-button login', 
                        'aria-label' => 'Modificar', 
                        'data-balloon-pos' => 'up'
                    ]); ?>
                    <?php if($user === 'admin') : ?>
                    <?= Html::a(Icon::show('trash'), ['delete', 'id' => $model->id], [
                        'class' => 'masonry-button login',
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
                <?= Html::a(Html::img($fakeimg, ['class' => 'card-img-top masonry-img ']),  ['blogs/index',  'actual' => $model->id], ['class' => 'login']) ?>
                <h5 itemprop="tittle" class="masonry-title"><b><?= $model->denom  ?></b></h5>
                <p itemprop="description" class="masonry-description"><b><?= $model->descripcion ?></b></p>
                </div>
                <div class="masonry-details">
                    <i itemprop="date" data-balloon-pos='up'aria-label='<?=Yii::$app->formatter->asDate($model->created_at)?>'><?= Icon::show('clock')?></i> 
                    <i  class='favdetail' ><i class='fav<?=$model->id?>'><?= $model->favs ?></i><?= Icon::show('heart')?></i>
                </div>
            </div>
            <?php } ?>
        </div>
        <a class="arrow-right visible" ><?= Icon::show('angle-right')?> </a>
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

