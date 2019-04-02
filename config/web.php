<?php

use app\models\user\UserMaster;
use sbs\behaviors\LastVisitBehavior;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    require __DIR__ . '/common-local.php',
    [
        'id' => 'basic',
        'components' => [
            'user' => [
                'identityClass' => UserMaster::class,
                'loginUrl' => ['user/login'],
                'enableAutoLogin' => true,
                'as afterLogin' => LastVisitBehavior::class,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            /*
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
            */
        ],
    ]
);
