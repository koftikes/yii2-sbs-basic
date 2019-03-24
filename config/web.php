<?php

use app\models\user\UserMaster;
use sbs\behaviors\LastVisitBehavior;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    [
        'id' => 'basic',
        'components' => [
            'user' => [
                'identityClass' => UserMaster::class,
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
