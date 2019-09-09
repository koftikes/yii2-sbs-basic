<?php

namespace app\console\fixtures;

use app\models\user\UserProfile;
use yii\test\ActiveFixture;

class UserProfileFixture extends ActiveFixture
{
    public $modelClass = UserProfile::class;

    public $depends = [
        UserFixture::class,
    ];
}
