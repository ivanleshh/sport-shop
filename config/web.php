<?php

use app\models\Category;
use app\models\Product;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'search'],
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'defaultRoute' => '/site',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gfs78gdf5gdf',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'modules' => [
        'personal' => [
            'class' => 'app\modules\account\Module',
            'defaultRoute' => 'user',
        ],
        'admin-panel' => [
            'class' => 'app\modules\adminPanel\Module',
            'defaultRoute' => 'orders',
        ],
        'search' => [
            'class' => '\kazda01\search\SearchModule',
            'searchConfig' => [
                'app\models\ProductSearch' => [
                    'columns' => ['title'],
                    'matchTitle' => 'Результаты поиска:',
                    'matchText' => function ($model) {
                        return "<img src='" . Product::IMG_PATH . $model->productImages[0]->photo . "' alt='product'>";
                    },
                    'route' => '/product/view',
                    'routeParams' => function ($model) {
                        return ['id' => $model->id];
                    },
                    'limit' => 4,
                ],
            ]
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
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
