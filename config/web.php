<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$log = require __DIR__ . '/log.php';


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'es-ES',
    'components' => [
        'geoip' => ['class' => 'lysenkobv\GeoIP\GeoIP'],
        
        'ip2location' => [
            'class' => 'frontend\components\IP2Location\Geolocation',
            'database' => __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'IP2Location'.DIRECTORY_SEPARATOR.'IP2LOCATION-LITE-DB1.BIN',
            'mode' => 'FILE_IO',
        ],
        
        'cookieConsentHelper' => [
            'class' => dmstr\cookieconsent\components\CookieConsentHelper::class
        ],

        
        'AdvHelper' => [
            'class' => 'app\components\HelperAdventure'
        ],

        'i18n' => [
            'translations' => [
                'cookie-consent' => [
                    'class'          => \yii\i18n\PhpMessageSource::class,
                    'basePath'       => '@app/messages',
                    'sourceLanguage' => 'es',
                ],
            ],
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UnqFVoGaH1mtVlhPrgZqrkfnVZum37N7',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,

        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            /*
            // comment the following array to send mail using php's mail function:
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $params['smtpUsername'],
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
            */
        ],
        'log' => $log,
        'db' => $db,
        'formatter' => [
            'timeZone' => 'Europe/Madrid',
        ],
        
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '/comunidad/<actual:\d+>/blogs/index' => 'blogs/index',
                '/comunidad/<actual:\d+>/blogs/search/<busqueda:\w+>' => 'blogs/search',
                '/comunidad/<actual:\d+>/blogs/create' => 'blogs/create',
                '/comunidad/inicio' => 'comunidades/index',
                '/comunidad/estadisticas/<id:\d+>' => 'comunidades/view',
                '/comunidad/<actual:\d+>/blogs/update/<id:\d+>' => 'blogs/update',
                '/comunidad/<actual:\d+>/blogs/view/<id:\d+>' => 'blogs/view',
                '/perfil/usuario/<username:\w+>' => 'usuarios/view',
                'usuarios/registrarse' => 'usuarios/registrar',
                'usuarios/login' => 'site/login',
            ],
        ],

       
        
    ],
    'container' => [
        'definitions' => [
            'yii\grid\ActionColumn' => ['header' => 'Acciones'],
            'yii\widgets\LinkPager' => 'yii\bootstrap4\LinkPager',
            'yii\grid\DataColumn' => 'app\widgets\DataColumn',
            'yii\grid\GridView' => ['filterErrorOptions' => ['class' => 'invalid-feedback']],
        ],
    ],
    'params' => $params,
];



if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for out templates
                    'default' => '@app/templates/crud/default', // template name => path to template
                ],
            ],
        ],
    ];
}

return $config;
