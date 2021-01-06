<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\helpers\UtilNotify;
use app\helpers\UtilAjax;
use kartik\icons\Icon;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\web\JsExpression;
use \yii\widgets\Menu;
use yii\widgets\Pjax;

$guest = Yii::$app->user->isGuest;
$url = Url::to(['usuarios/search']);
$url2 = Yii::$app->urlManager->createUrl(['usuarios/view', 'alias' => '']);
$fakeimg = 'https://picsum.photos/100/1000?random=1';






AppAsset::register($this);

$js = <<< EOT
$('#sidenav-left').hover(function() {
      $('.wrap').toggleClass('abierto');
});

$(document).ready(function () {
    if ('$guest') {
       $('.login').attr('href', '#');
       $('.login').click(function () {
            var lo = $('#login').attr('value');
            $.ajax({
                type: 'POST',
                url: lo,
                success: function(data) {
                    $('#modal').find('#createContent').html(data);
                    $('#modal').modal('show');
                    $('.modal-title').text('Acceder');
                }
            });
        });
    }

    $('#registrar').click(function () {
        var lo = $('#registrar').attr('value');
        $.ajax({
            type: 'POST',
            url: lo,
            success: function(data) {
                $('#modal').find('.site-login').remove();
                $('#modal').modal('show').find('#createContent').html(data);
                $('.modal-title').text('Registrarse');
            }
        });
    });

});
EOT;
$this->registerJs($js);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title> ADVENTURE </title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=PT+Sans" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<?php if(!$guest) { ?>
    <div class="sidenav" id='sidenav-left' >
        <div class="container">
            <?php $this->beginContent('@app/views/layouts/sidebar.php'); ?>
            <?php $this->endContent(); ?>
        </div>
    </div>
<?php } ?>

     
<?php
    NavBar::begin([
        'brandLabel' => 'ADVENTURE',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-dark navbar-custom navbar-expand-lg py-1 fixed-top',
        ],
        'collapseOptions' => [
            'class' => 'justify-content-end',
        ],
    ]);



?> <div id="select2"> <?php
  echo Select2::widget([
        'name' => 'kv-repo-template',
        'pluginOptions' => [
            'placeholder' => Icon::show('search')."Buscar usuario",
            // 'width' => '20%',
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { 
                    return {q: params.term};
                }'),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { 
               return markup;
            }'),
            'templateResult' => new JsExpression('function(params) {
                $var = params.id;
                imgenlace = \'<span><img class="small-circular-photo" src="https://picsum.photos/100/100?random=\'+$var+\'"/></span>\'+
                "<i class=\'enlace-select2\'>"+params.text+"</i>";
                return imgenlace;
            }'),
        ],
        'pluginEvents' => [
            "select2:select" => "function(e) { 
                e.preventDefault();
                texto = $(this).text();
                window.location.href = href='$url2'+texto;
            }",
            "select2:open" => "function(e) { 
                e.preventDefault();
                texto = $(this).text('');
                $(this).hide();
            }",
        ],
    ]);
?> </div> <?php 

    $items = [];
    if(Yii::$app->user->isGuest) {
        $items = [
            [
                'label' => Html::button('Login', 
                    [   
                        'value' => Url::toRoute(['site/login']),  
                        'class' => 'btn btn-info login', 
                        'id' => 'login'
                    ]) 
            ],
            [
                'label' => Html::button('Registrar', 
                    [   
                        'value' => Url::to(['usuarios/registrar']),  
                        'class' => 'btn btn-info', 
                        'id' => 'registrar'
                    ]) 
            ]
        ];
    } else  {
        $items = [
            Html::beginForm(['site/logout'], 'post').Html::submitButton(
            'Logout ' . Html::tag('i', Icon::show('power-off'), ['class' => '']).'',
            ['class' => 'dropdown-item'],).Html::endForm(),
            ['label' => 'Perfil', 'url' => ['usuarios/view', 'alias' => Yii::$app->user->identity->alias]],
            ['label' => 'Editar cuenta', 'url' => ['usuarios/update', 'id' => Yii::$app->user->identity->id]]
        ];
        
    }
    
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right' , 'id' => 'pjax-notificaciones'],
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => Html::tag('i', Icon::show('envelope'), ['class' => '',]),
                        'visible' => !$guest,
                    ],
                    [
                        'label' => Html::tag('i', Icon::show('bell',) .
                                '<i class="countNotify">'.
                                UtilNotify::countNotificaciones().
                                '</i>'),
                        'visible' => !$guest,
                        'options' => ['class' => 'bell'],
                        'items' => (UtilNotify::countNotificaciones() > 0) ?
                                ( ['label' => "<div class='notificaciones'>Notificaciones</div>", 
                                    'items' => Menu::widget([
                                                'options' => ['class' => 'items', 'style' => 'display: list-item; list-style: none'],
                                                'items' => UtilNotify::itemsNotificaciones(),
                                                'encodeLabels' => false,
                                                'activateParents' => true,
                                            ]),
                                    ]) : (''),
                    ],
                    [
                        'label' => '<div class="vertical-minus">'.Html::tag('i', Icon::show('minus')).'</div>',
                        'visible' => !$guest,
                        'options' => ['class' => 'label-vertical-minus'],
                    ],
                    [
                        'label' =>  (!Yii::$app->user->isGuest) ? ucfirst(Yii::$app->user->identity->alias) .' '. 
                        Html::tag('i', Icon::show('user'), ['class' => '',]) : 'Iniciar sesión',
                        'items' => $items,
                    ],
                    
                ],
            ]);
    NavBar::end();
?>


    <div class="container">
        <?= Breadcrumbs::widget([
             'homeLink' => [
                'label' => 'Inicio',
                'url' => '/site/index',
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>



<?php Modal::begin([
    'headerOptions' => [
        'class' => 'text-center'
    ],
    'titleOptions' => [
        'class' => 'modal-title text-center col-md-11',
    ],
    'title' => '',
    'id' => 'modal',
    'size' => 'modal-md',
]);?>
    <?="<div id='createContent'></div>"?>
<?php Modal::end();?>




<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
