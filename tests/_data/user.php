<?php

use app\models\user\User;

$date      = \date('Y-m-d H:i:s');
$timestamp = \time();
$expire    = Yii::$app->params['user.passwordResetTokenExpire'];

return [
    'admin' => [
        'id'                  => 1,
        'email'               => 'admin@example.com',
        'email_confirm_token' => 'QyPm-5Pqkuic5JP0hO1twe5DPMfUFdb5',
        'auth_key'            => 'iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv',
        // password_0
        'password_hash'        => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        'password_reset_token' => 't5GU9NwpuGYSfb7FEZMAxqtuz2PkEvv_' . $timestamp,
        'create_date'          => $date,
        'update_date'          => $date,
        'status'               => User::STATUS_ACTIVE,
    ],
    'manager' => [
        'id'                  => 2,
        'email'               => 'manager@example.com',
        'email_confirm_token' => 'Ky9k33p8F1zBCvoZUmI7yitQb_JuBh7K',
        'auth_key'            => 'ZHa_r-LC8Fy0BCkld5qmJ3IWkPOkVYvx',
        // password_0
        'password_hash'        => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        'password_reset_token' => '4BSNyiZNAuxjs5M7FEZMAxqtuz2PkEv_' . $timestamp,
        'create_date'          => $date,
        'update_date'          => $date,
        'status'               => User::STATUS_PENDING,
    ],
    'user' => [
        'id'                  => 3,
        'email'               => 'user@example.com',
        'email_confirm_token' => 'SCSS_2k0gxY8tDq4YGXALl5vNw1gsJ1v',
        'auth_key'            => 'Q4rHqHGBsPGIFSABYX1UQAbq0Hd5MZr-',
        // password_0
        'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
        // password_reset_token is expired
        'password_reset_token' => 'H0GzA0ZimNII2NEmgbCyNmQ7Ay6H14PQ_' . ($timestamp - $expire - $expire),
        'create_date'          => $date,
        'update_date'          => $date,
        'status'               => User::STATUS_ACTIVE,
    ],
];
