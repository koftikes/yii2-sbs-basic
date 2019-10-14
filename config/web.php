<?php

use app\models\user\User;
use sbs\behaviors\LastVisitBehavior;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    require __DIR__ . '/common-local.php',
    [
        'id'         => 'basic',
        'components' => [
            'user'         => [
                'identityClass'   => User::class,
                'loginUrl'        => ['user/login'],
                'enableAutoLogin' => true,
                'as afterLogin'   => LastVisitBehavior::class,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'urlManager'   => [
                'enablePrettyUrl'     => true,
                'showScriptName'      => false,
                'enableStrictParsing' => true,
                'suffix'              => '',
                'rules'               => [
                    ''                                                                => 'site/index',
                    'contact'                                                         => 'site/contact',
                    'site/<slug:\S+>'                                                 => 'site/static-page',
                    // news rules
                    '<_c:(news)>'                                                     => '<_c>/index',
                    '<_c:(news)>/category/<slug:\S+>'                                 => '<_c>/category',
                    '<_c:(news)>/<slug:\S+>'                                          => '<_c>/view',
                    // default rules
                    '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>'                  => '<controller>/<action>',
                    '<controller:[\w\-]+>/<action:[\w\-]+>'                           => '<controller>/<action>',
                    '<controller:[\w\-]+>/<id:\d+>'                                   => '<controller>/view',
                    '<controller:[\w\-]+>'                                            => '<controller>/index',
                    // default module rules
                    '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                    '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>'          => '<module>/<controller>/<action>',
                    '<module:[\w\-]+>/<controller:[\w\-]+>/<id:\d+>'                  => '<module>/<controller>/view',
                    '<module:[\w\-]+>/<controller:[\w\-]+>'                           => '<module>/<controller>/index',
                ],
            ],
        ],
    ]
);
