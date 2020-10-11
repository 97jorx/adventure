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
<div class="comunidades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

   

<?php foreach($dataProvider->models as $model) { ?> 
<div class="container">
    <div class="row-fluid ">
        <div class="col-sm-4 ">
            <div class="card-columns-fluid">
                <div class="card  bg-light" style = "width: 22rem; " >
                    <img class="card-img-top"  src="<?php echo Yii::$app->request->baseUrl . '/uploads/test.jpg'?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><b><?=  $model->denom  ?></b></h5>
                        <p class="card-text"><b><?=  $model->descripcion ?></b></p>
                        <p class="card-text"><b><?= Yii::$app->formatter->asDate($model->created_at)?></p>
                        <?php $unirse = Url::to(['comunidades/unirse', 'id' => $model->id]); ?>
                        <?= Html::a('Unirse', $unirse, [
                            'onclick'=>"
                                event.preventDefault();
                                
                                $.ajax({
                                    type: 'GET',
                                    url: '$unirse',
                                    dataType: 'json',
                                }).done(function( data, textStatus, jqXHR ) {
                                    data = JSON.parse(data);
                                    if ( console && console.log ) {
                                        console.log( 'La solicitud se ha completado correctamente' );
                                        console.log( data.button );
                                        $this.text('data.button');
                                    }
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
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Bienvenido a ADVENTURE.</p>
            </div>
        </div>
    </div>
</div>


<!--  -->