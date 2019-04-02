<?php

namespace app\console\fixtures;

use yii\test\ActiveFixture;
use app\models\user\UserMaster;

/**
 * Class UserFixture
 * @package app\console\fixtures
 */
class UserMasterFixture extends ActiveFixture
{
    public $modelClass = UserMaster::class;
}
