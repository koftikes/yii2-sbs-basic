<?php

return [
    'components' => [
        'db'      => [
            'dsn'                 => 'mysql:host=localhost;dbname=yii2_basic',
            'username'            => 'root',
            'password'            => 'root',
            // Schema cache options (for production environment)
            'enableSchemaCache'   => true,
            'schemaCacheDuration' => 60,
            'schemaCache'         => 'cache',
        ],
        'mailer'  => [
            // By default application send all mails to a file. For production environment you have
            // set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
            'baseUrl'             => '',
        ],
    ],
];
