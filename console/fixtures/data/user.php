<?php

use app\models\user\User;

$date = date('Y-m-d H:i:s');

return [
    'admin' => [
        'id' => 1,
        'email' => 'admin@example.com',
        'email_confirm_token' => Yii::$app->security->generateRandomString(),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
        'status' => User::STATUS_ACTIVE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'manager' => [
        'id' => 2,
        'email' => 'manager@example.com',
        'email_confirm_token' => Yii::$app->security->generateRandomString(),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'password_hash' => Yii::$app->security->generatePasswordHash('manager'),
        'status' => User::STATUS_ACTIVE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'user' => [
        'id' => 3,
        'email' => 'user@example.com',
        'email_confirm_token' => Yii::$app->security->generateRandomString(),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'password_hash' => Yii::$app->security->generatePasswordHash('user'),
        'status' => User::STATUS_ACTIVE,
        'create_date' => $date,
        'update_date' => $date,
    ],
];
