<?php

use app\helpers\Util;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['usuarios/status']);
$estados = [1 => 'Conectado', 2 => 'Ausente', 3 => 'Ocupado', 4 => 'Desconectado'];

$js = <<< EOT
$.ajax({
    method: 'GET',
    url: '$url',
    success: function (data, code, jqXHR) {
        data = JSON.parse(data);
        var color = data.color;
        var icon = $('#color');
        icon.attr('style', 'color:'+color);
        var sel = $('#estados');
        var estado = data.estado;
        sel.empty();
        
        for (var i in data.estados) {
            if(i == estado) {
                sel.append(`<option class='dropdown-item' selected value="\${i}">\${data.estados[i]}</option>`);
            } else {
                sel.append(`<option class='dropdown-item' value="\${i}">\${data.estados[i]}</option>`);
            }
        }

        
    }   
});


$('#estados').on('change', function (ev) {
    var elemento = $(this);
    var estado = elemento.val();
    $.ajax({
        method: 'GET',
        url: '$url',
        data: {
            estado: estado
        }
        }).done(function(data, textStatus, jqXHR) {
            data = JSON.parse(data);
            var color = data.color;
            var icon = $('#color');
            icon.attr('style', 'color:'+color);
        }).fail(function(data, textStatus, jqXHR) {
            console.log(data.message);
        });  
});


EOT;
$this->registerJs($js);
?>
    <div class="row">
        <div class='img-container'>
            <?php $fakeimg = "https://picsum.photos/300/300?random=1";  ?>
            <?= Html::a(Html::img((isset(Yii::$app->user->identity->foto_perfil)) ?
            (Util::s3GetImage(Yii::$app->user->identity->foto_perfil)) : ($fakeimg), ['class' => 'img'])) ?>
        </div>
        <div class="masonry-title text-center" id="nav-title">
            <?= ucfirst(Yii::$app->user->identity->alias) ?>
            <?= Icon::show('circle', ['id' => 'color']) ?>
        </div>
    </div>
    <div class="row">
        <div class="masonry-title text-center" id="nav-title">
            <div class="box">
                <?= Html::dropDownList('estados', '', $estados, 
                    [
                        'id' => 'estados',
                        'options' => [ 'selected' => Yii::$app->user->identity->estado_id]
                    ], 
                ) ?>
             </div>
        </div>
    </div>
    <div class="row">
        <div class="masonry-menu">
            <ul>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('users');?></i>
                        </div>
                        <div class="col-6">
                        <?= Html::a('Seguidos', ['usuarios/userseguidos']) ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('columns');?></i>
                        </div>
                        <div class="col-6">
                            <?= Html::a('Comunidades', ['comunidades/index']) ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('clipboard-check');?></i>
                        </div>
                        <div class="col-6">
                            <?= Html::a('Blogs que me gustan', ['blogs/viewfavoritos']) ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-1">
                            <i><?= Icon::show('user-times');?></i>
                        </div>
                        <div class="col-6">
                            <?= Html::a('Bloqueados', ['usuarios/userbloqueados']) ?>
                        </div>
                    </div>
                </li>
                <?php if($actual = Yii::$app->request->get('actual') != null) { ?>
                    <li>
                        <div class="row">

                            <div class="col-1">
                                <i><?= Icon::show('images');?></i>
                            </div>
                            <div class="col-6">
                            <?= Html::a('Galerias', ['galerias/create', 'actual' => $actual]) ?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
 

    
           
    