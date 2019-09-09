<?php

namespace app\console\fixtures;

use app\models\user\User;
use yii\test\ActiveFixture;

/**
 * Class UserFixture.
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
