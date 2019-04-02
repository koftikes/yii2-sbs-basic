<?php

use yii\db\Connection;
use yii\log\FileTarget;
use yii\caching\FileCache;
use yii\swiftmailer\Mailer;

return [
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
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
    ],
    'params' => require __DIR__ . '/params.php',
];
