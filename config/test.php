<?php

/**
 * Application configuration shared by all test types
 */
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    [
        'id' => 'basic-tests',
        'components' => [
            'assetManager' => [
                'basePath' => __DIR__ . '/../web/assets',
            ],
            'user' => [
                'identityClass' => 'app\models\User',
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
