<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

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
        ],
    ]); ?>


</div>