<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comunidades */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comunidades-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

    <?php $url = Url::to(['comunidades/like', 'id' => $model->id]); ?>
    <?php $like = ($tienefavs) ? ('thumbs-up') : ('thumbs-down'); ?>
    <?= Html::a(Icon::show($like, ['id' => 'like', 'framework' => Icon::FAS]), $url, ['class' => 'masonry-button',
            'onclick' =>"
            event.preventDefault();
            var self = $(this);
            $.ajax({
                type: 'POST',
                url: '$url',
                dataType: 'json',
            }).done(function(data, textStatus, jqXHR) {
                data = JSON.parse(data);
                $('#fav').html(data.fav);
                $('#like').attr('class', (data.icono) ?
                ('fas fa-thumbs-down') : ('fas fa-thumbs-up'))
            }).fail(function(data, textStatus, jqXHR) {
                console.log('Error de la solicitud.');
            });"
        ]); 
    ?> 
    <p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'denom',
            'propietario',
            'descripcion:ntext',
            'created_at',
            
        ],
    ]) ?>

</div>
