<?php

use app\modules\admin\AdminModule;
use kartik\grid\Module as GridModule;
use kartik\icons\FontAwesomeAsset;
use sbs\controllers\TransliterationController;
use yii\authclient\clients\Facebook;
use yii\authclient\clients\Google;
use yii\authclient\clients\VKontakte;
use yii\authclient\clients\Yandex;
use yii\authclient\Collection;
use yii\caching\FileCache;
use yii\db\Connection;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;

return [
    'basePath'      => \dirname(__DIR__),
    'language'      => 'en-US',
    'bootstrap'     => ['log'],
    'aliases'       => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'transliteration' => [
            'class' => TransliterationController::class,
        ],
    ],
    'components'    => [
        'db'                   => [
            'class'   => Connection::class,
            'charset' => 'utf8',
        ],
        'mailer'               => [
            'class' => Mailer::class,
        ],
        'cache'                => [
            'class' => FileCache::class,
        ],
        'log'                  => [
            'traceLevel' => (YII_DEBUG === true) ? 3 : 0,
            'targets'    => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager'         => [
            'basePath' => '@app/web/assets',
            'bundles'  => [
                FontAwesomeAsset::class => [
                    'js'  => [],
                    'css' => [
                        'https://use.fontawesome.com/releases/v5.8.1/css/all.css',
                    ],
                ],
            ],
        ],
        'authClientCollection' => [
            'class'   => Collection::class,
            'clients' => [
                'vkontakte' => [
                    'class'          => VKontakte::class,
                    'scope'          => 'email,public_profile',
                    'attributeNames' => [
                        'email',
                        'first_name',
                        'last_name',
                        'sex',
                        'bdate',
                        'photo_max_orig',
                    ],
                ],
                'facebook'  => [
                    'class'          => Facebook::class,
                    'scope'          => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'picture.type(large)',
                    ],
                ],
                'yandex'    => ['class' => Yandex::class],
                'google'    => ['class' => Google::class],
            ],
        ],
    ],
    'modules'       => [
        'gridview' => ['class' => GridModule::class],
        'admin'    => ['class' => AdminModule::class],
    ],
    'params'        => require __DIR__ . '/params.php',
];
