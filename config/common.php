<?php

use yii\db\Connection;
use yii\log\FileTarget;
use yii\caching\FileCache;
use yii\swiftmailer\Mailer;
use app\modules\admin\AdminModule;
use kartik\grid\Module as GridModule;
use kartik\icons\FontAwesomeAsset;
use sbs\controllers\TransliterationController;

return [
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'transliteration' => [
            'class' => TransliterationController::class,
        ]
    ],
    'components' => [
        'db' => [
            'class' => Connection::class,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => Mailer::class,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => '@app/web/assets',
            'bundles' => [
                FontAwesomeAsset::class => [
                    'js' => [],
                    'css' => [
                        'https://use.fontawesome.com/releases/v5.8.1/css/all.css'
                    ]
                ]
            ]
        ],
    ],
    'modules' => [
        'gridview' => ['class' => GridModule::class],
        'admin' => ['class' => AdminModule::class],
    ],
    'params' => require __DIR__ . '/params.php',
];
