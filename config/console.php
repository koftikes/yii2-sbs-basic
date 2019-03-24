<?php

use yii\console\controllers\MigrateController;
use yii\console\controllers\FixtureController;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    [
        'id' => 'basic-console',
        'controllerNamespace' => 'app\commands',
        'controllerMap' => [
            'migrate' => [
                'class' => MigrateController::class,
                'templateFile' => '@vendor/sbs/yii2-core-kit/src/views/migration.php',
            ],
            /*
            'fixture' => [
                'class' => FixtureController::class,
                'namespace' => 'app\fixtures',
            ],
             */
        ],
    ]
);
