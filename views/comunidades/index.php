<?php

use hoaaah\sbadmin2\widgets\Card;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use kartik\detail\DetailView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunidades';
$this->params['breadcrumbs'][] = $this->title;

$this->title = "ADVENTURE";

$this->registerJsFile(Yii::getAlias('@web') . '/js/masonry.js', [
    'depends' => [\yii\web\JqueryAsset::class]
]);


$username = !Yii::$app->user->isGuest;
$user = $username ? (Yii::$app->user->identity->username) : (null);

$js = <<< EOF
$(document).ready(function() {
    if (localStorage.getItem('$user') === null && Boolean($username)) {
        localStorage.setItem('$user', '$user')
        $("#myModal").modal('show');
    }
});

$(function(){
    $('.masonry-container').masonry({
      itemSelector: '.item', 
      columnWidth: '.panel',
      percentPosition: true
    });
  });
EOF;

$this->registerJs($js);


Yii::$app->formatter->locale = 'es-ES';

?>
<div class="comunidades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div id="color" class="modal-content">
            <div class="modal-body">
                <p id="mensaje" >Bienvenido a ADVENTURE.</p>
            </div>
        </div>
    </div>
</div>


<?php foreach($dataProvider->models as $model) { ?> 
<div class="masonry-wrapper">
     <div class="masonry">
            <div class="masonry-item">
                <div class="masonry-content">
                    <img src="https://picsum.photos/450/325?image=100" alt="Masonry">
                    <h5 class="masonry-title"><b><?= $model->denom  ?></b></h5>
                    <p class="masonry-description"><b><?= $model->descripcion ?></b></p>
                    <p class="masonry-description"><b><?= Yii::$app->formatter->asDate($model->created_at)?></p>
                    <?php $existe = ($model->existeIntegrante($model->id)) ? ('Salir') : ('Unirse'); ?>
                    <?php $unirse = Url::to(['comunidades/unirse', 'id' => $model->id]); ?>
                    <div class="masonry-item">
                    <?= Html::a($existe, $unirse, ['class' => 'masonry-button ',
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
                                if ( console && console.log ) {
                                    console.log( 'La solicitud a fallado');
                                }
                            });"
                    ]); 
                    ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script src="//unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>