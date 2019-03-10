<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            // Schema cache options (for production environment)
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // By default application send all mails to a file.
            // For production environment you have set 'useFileTransport' to false
            // and configure a transport for the mailer to send real emails.
            'useFileTransport' => false,
        ],
    ],
];
