<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

AppAsset::register($this);

$js= <<<EOT
$('#registrar').click(function (){
    $('#modal').modal('show')
    .find('#createContent')
    .load($(this).attr('value'));
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


    
    
    $items = [];
    if(Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => Html::button('Registrar', 
                [   'value' => Url::to('usuarios/registrar'),  
                    'class' => 'btn btn-success', 
                    'id' => 'registrar'
                ]) 
            ]
        ];
    } else  {
        $items = [
            Html::beginForm(['site/logout'], 'post').Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'dropdown-item'],).Html::endForm(),
            ['label' => 'Perfil', 'url' => ['usuarios/view', 'username' => Yii::$app->user->identity->username]]
        ];
        
    }

    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
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
    'title' => 'Registrarse',
    'id' => 'modal',
    'size' => 'modal-lg',
]);?>
    <?="<div id='createContent'></div>"?>
<?php Modal::end();?>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
