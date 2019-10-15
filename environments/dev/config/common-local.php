<?php

$config = [
    'components' => [
        'db'      => [
            'dsn'      => 'mysql:host=localhost;dbname=yii2_basic',
            'username' => 'root',
            'password' => 'root',
        ],
        'mailer'  => [
            // By default application send all mails to a file. For production environment you have
            // set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
            'baseUrl'             => '',
        ],
    ],
];

if (YII_ENV_TEST) {
    $config['aliases']['@tests']       = '@app/tests';
    $config['components']['db']['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';
}

// configuration adjustments for 'dev' environment
if (YII_ENV_DEV) {
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
