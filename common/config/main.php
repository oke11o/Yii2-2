<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'startApp' => [
            'class' => 'common\components\StartApp'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'i18n' => [
            'translations' => [
                'task*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages'
                ]
            ]
        ]
    ],
];
