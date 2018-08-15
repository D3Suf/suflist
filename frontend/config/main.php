<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;

$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());


return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'pt',
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
//            'authTimeout' => 110,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => TRUE,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'signup' => 'site/signup',
                'home' => 'site/home',
                'profile' => 'site/profile',
                'setup' => 'site/suflist',
                'step1' => 'site/step1',
                'step2' => 'site/step2',
                'step3' => 'site/step3',
                'utilizador/<id:\d+>-<slug>' => 'site/view-user',
                'changepassword' => 'site/changepassword',
                'alert' => 'site/alert',
                '403' => 'site/403',
                'info' => 'site/info',
                ['pattern' => 'googlea6a979bfa97e6b1e', 'route' => 'site/googlea6a979bfa97e6b1e', 'suffix' => '.html'],
                ['pattern' => 'sitemap', 'route' => 'site/sitemap', 'suffix' => '.xml'],
            ]
        ]
    ],
    'params' => $params,
];
