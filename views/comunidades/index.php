<?php

use hoaaah\sbadmin2\widgets\Card;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use kartik\detail\DetailView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comunidades';
$this->params['breadcrumbs'][] = $this->title;

$this->title = "ADVENTURE";

$username = !Yii::$app->user->isGuest;
$user = $username ? (Yii::$app->user->identity->username) : (null) ;
$js = <<< EOF
$(document).ready(function() {
    if (localStorage.getItem('$user') === null && Boolean($username)) {
        localStorage.setItem('$user', '$user')
        $("#myModal").modal('show');
    }
});
EOF;
$this->registerJs($js);



?>
<div class="comunidades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comunidades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]);
    ?>

<?php foreach ($comunidades as $elem) : ?>
<div class="container">
    <div class="row-fluid ">
        <div class="col-sm-4 ">
            <div class="card-columns-fluid">
                <div class="card  bg-light" style = "width: 22rem; " >
                    <img class="card-img-top"  src="<?php echo Yii::$app->request->baseUrl.'/uploads/test.jpg'?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><b><?=  $elem->nombre  ?></b></h5>
                        <p class="card-text"><b>  <?=  $elem->descripcion ?></b></p>
                        <p class="card-text"><b>  <?= date("jS F, Y", strtotime($elem->created_at))  ?></p>
                        <a href="#" class="btn btn-secondary">Unirse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
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