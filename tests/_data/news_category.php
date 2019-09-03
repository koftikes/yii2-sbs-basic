<?php

use app\models\NewsCategory;

$date = date('Y-m-d H:i:s');

return [
    'business'   => [
        'id'          => 1,
        'name'        => 'Business',
        'slug'        => 'business',
        'description' => '',
        'parent_id'   => null,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'companies'  => [
        'id'          => 2,
        'name'        => 'Companies',
        'slug'        => 'companies',
        'description' => '',
        'parent_id'   => 1,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'economy'    => [
        'id'          => 3,
        'name'        => 'Economy',
        'slug'        => 'economy',
        'description' => '',
        'parent_id'   => 1,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'technology' => [
        'id'          => 4,
        'name'        => 'Tech',
        'slug'        => 'technology',
        'description' => '',
        'parent_id'   => null,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'science'    => [
        'id'          => 5,
        'name'        => 'Science',
        'slug'        => 'science-and-environment',
        'description' => '',
        'parent_id'   => null,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'world'      => [
        'id'          => 6,
        'name'        => 'World',
        'slug'        => 'world',
        'description' => '',
        'parent_id'   => null,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'europe'     => [
        'id'          => 7,
        'name'        => 'Europe',
        'slug'        => 'europe',
        'description' => '',
        'parent_id'   => 6,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'usa'        => [
        'id'          => 8,
        'name'        => 'US & Canada',
        'slug'        => 'us-and-canada',
        'description' => '',
        'parent_id'   => 6,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
    'asia'       => [
        'id'          => 9,
        'name'        => 'Asia',
        'slug'        => 'asia',
        'description' => '',
        'parent_id'   => 6,
        'status'      => NewsCategory::STATUS_ENABLE,
        'create_date' => $date,
        'update_date' => $date,
    ],
];
