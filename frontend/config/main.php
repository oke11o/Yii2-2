<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'startApp'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'aliases' => [
        '@img' => '@frontend/web/img'
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => $params['cookieValidationKey'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\tables\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-infosite', 'httpOnly' => true, 'domain' => $params['cookieDomain']],
            //'enableSession' => false //- нужно включать для api.
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-infosite',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => $params['cookieDomain'],
            ]
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'task/item/<id:\d+>' => 'task/item',
                'task/chatItem/<id:\d+>' => 'task/chatItem',
                'project/item/<id:\d+>' => 'project/item',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'tasks'
                ]
            ],
        ],
        'lang' => [
            'class' => 'common\models\tables\Language'
        ]
    ],
    'params' => $params,
    'language' => 'ru',
    'defaultRoute' => 'task/index'
];
