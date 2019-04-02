<?php

namespace app\console\fixtures;

use yii\test\ActiveFixture;
use app\models\user\UserProfile;

class UserProfileFixture extends ActiveFixture
{
    public $modelClass = UserProfile::class;

    public $depends = [
        UserMasterFixture::class,
    ];
}
