
<?php

/* @var $this yii\web\View */
use dmstr\cookieconsent\widgets\CookieConsent;



?>


<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>
    <div class="body-content">

        <div class="row">
            <div class="col-xl-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-xl-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-xl-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-info" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>


    <?= CookieConsent::widget([
    'name' => 'cookie_consent_status',
    'path' => '/',
    'domain' => '',
    'expiryDays' => 365,
    'message' => Yii::t('cookie-consent', 'Utilizamos cookies para asegurar el correcto funcionamiento de nuestro sitio web. Para una mejor experiencia de visita utilizamos productos de análisis. Se utilizan cuando está de acuerdo con "Estadísticas"..'),
    'save' => Yii::t('cookie-consent', 'Guardar'),
    'acceptAll' => Yii::t('cookie-consent', 'Aceptar'),
    'controlsOpen' => Yii::t('cookie-consent', 'Cambiar'),
    'detailsOpen' => Yii::t('cookie-consent', 'Cookie Detalles'),
    'learnMore' => Yii::t('cookie-consent', 'Declaracion de privacidad'),
    'visibleControls' => true,
    'visibleDetails' => false,
    'link' => '#',
    'consent' => [
        'necessary' => [
            'label' => Yii::t('cookie-consent', 'Necesario'),
            'checked' => true,
            'disabled' => true
        ],
        'statistics' => [
            'label' => Yii::t('cookie-consent', 'Estadísticas'),
            'cookies' => [
                ['name' => '_ga'],
                ['name' => '_gat', 'domain' => '', 'path' => '/'],
                ['name' => '_gid', 'domain' => '', 'path' => '/']
            ],
            'details' => [
                [
                    'title' => Yii::t('cookie-consent', 'Google Analytics'),
                    'description' => Yii::t('cookie-consent', 'Crear datos de estadísticas')

                ],
                [
                    'title' => Yii::t('cookie-consent', 'Goal'),
                    'description' => Yii::t('cookie-consent', '_ga, _gat, _gid, _gali')

                ]
            ]
        ]
    ]
]) ?>
    

