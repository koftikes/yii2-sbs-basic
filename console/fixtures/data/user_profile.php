<?php
use app\models\user\UserProfile;

return [
    'admin' => [
        'user_id' => 1,
        'name' => 'Admin User',
        'phone' => '+1-999-000-0001',
        'DOB' => date('Y-m-d', 448156800),
        'gender' => UserProfile::GENDER_MALE,
        'subscribe' => UserProfile::SUBSCRIBE_NOT_ACTIVE,
        'info' => ''
    ],
    'manager' => [
        'user_id' => 2,
        'name' => 'Manager User',
        'phone' => '+1-999-000-0002',
        'DOB' => date('Y-m-d', 531100800),
        'gender' => UserProfile::GENDER_FEMALE,
        'subscribe' => UserProfile::SUBSCRIBE_NOT_ACTIVE,
        'info' => ''
    ],
    'user' => [
        'user_id' => 3,
        'name' => 'Simple User',
        'phone' => '+1-999-000-0003',
        'DOB' => date('Y-m-d', 513993600),
        'gender' => UserProfile::GENDER_THING,
        'subscribe' => UserProfile::SUBSCRIBE_ACTIVE,
        'info' => ''
    ],
];
