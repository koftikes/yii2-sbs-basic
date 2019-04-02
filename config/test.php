<?php

use app\models\user\UserMaster;

/**
 * Application configuration shared by all test types
 */
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    require __DIR__ . '/common-local.php',
    [
        'id' => 'basic-tests',
        'aliases' => ['@tests' => '@app/tests'],
        'components' => [
            'assetManager' => [
                'basePath' => '@app/web/assets',
            ],
            'user' => [
                'identityClass' => UserMaster::class,
            ],
            'urlManager' => [
                'showScriptName' => true,
            ],
            'request' => [
                'enableCsrfValidation' => false,
                // but if you absolutely need it set cookie domain to localhost uncomment this
                // 'csrfCookie' => ['domain' => 'localhost'],
            ],
        ],
    ]
);
