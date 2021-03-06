<?php

use yii\console\controllers\FixtureController;
use yii\console\controllers\MigrateController;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    require __DIR__ . '/common-local.php',
    [
        'id'                  => 'basic-console',
        'aliases'             => ['@console' => '@app/console'],
        'controllerNamespace' => 'app\console\commands',
        'controllerMap'       => [
            'migrate' => [
                'class'         => MigrateController::class,
                'migrationPath' => [
                    '@console/migrations',
                    '@vendor/sbs/yii2-seo/src/migrations',
                ],
                'templateFile'  => '@vendor/sbs/yii2-core-kit/src/views/migration.php',
            ],
            'fixture' => [
                'class'     => FixtureController::class,
                'namespace' => 'app\console\fixtures',
            ],
        ],
    ]
);
