<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\Icon;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\web\JsExpression;

$guest = Yii::$app->user->isGuest;
$url = Url::to(['usuarios/search']);
$url2 = Yii::$app->urlManager->createUrl(['usuarios/view', 'alias' => '']);
$fakeimg = 'https://picsum.photos/100/1000?random=1';

AppAsset::register($this);

$js = <<< EOT

$('.open').on('click', function () {
    document.getElementById("sidenav-left").style.width = "250px";
});

$('.close').on('click', function () {
    document.getElementById("sidenav-left").style.width = "0px";
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
    <title> <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

<div class="container">
    <button class="btn btn-info open"><?= Icon::show('bars') ?></button>
</div>

<div class="sidenav" id='sidenav-left' >
    <button class="btn btn-info close"><?= Icon::show('times') ?></button>
    <?php $this->beginContent('@app/views/layouts/sidebar.php'); ?>
    <?php $this->endContent(); ?>
</div>

<?php
    NavBar::begin([
        'brandLabel' => 'ADVENTURE',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-dark bg-dark navbar-expand-md fixed-top',
        ],
        'collapseOptions' => [
            'class' => 'justify-content-end',
        ],
    ]);

  echo Select2::widget([
        'name' => 'kv-repo-template',
        'class' => 'select2',
        'pluginOptions' => [
            'placeholder' => Icon::show('search')."Buscar usuario",
            'width' => '30%',
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
    

  
  


    $items = [];
    if(Yii::$app->user->isGuest) {
        $items = [
            ['label' => Html::button('Login', 
            [   
                'value' => Url::toRoute(['site/login']),  
                'class' => 'btn btn-info login', 
                'id' => 'login'
            ]) ],
            ['label' => Html::button('Registrar', 
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
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'dropdown-item'],).Html::endForm(),
            ['label' => 'Perfil', 'url' => ['usuarios/view', 'alias' => Yii::$app->user->identity->alias]]
        ];
        
    }
    
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            // ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Comunidades', 'url' => ['comunidades/index']],
            [
                'label'=>  (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->username : 'Iniciar sesión',
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




<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; Adventure <?= date('Y') ?></p>

        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>


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
