<?php

namespace app\console\fixtures;

use yii\test\ActiveFixture;
use app\models\user\User;

/**
 * Class UserFixture
 * @package app\console\fixtures
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
