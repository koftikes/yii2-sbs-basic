<?php

namespace tests\unit\models\user;

use app\models\user\UserProfile;
use Codeception\Test\Unit;
use app\models\user\User;
use app\console\fixtures\UserFixture;
use app\console\fixtures\UserProfileFixture;

class UserProfileTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'user_profile' => [
                'class' => UserProfileFixture::class,
                'dataFile' => codecept_data_dir() . 'user_profile.php',
            ],
        ]);
    }

    public function testGetUser()
    {
        $admin = $this->tester->grabFixture('user', 'admin');
        $adminProfile = $this->tester->grabFixture('user_profile', 'admin');
        $userProfile = UserProfile::findOne(['name' => $adminProfile['name']]);
        expect($userProfile->user)->isInstanceOf(User::class);
        expect($userProfile->user->email)->equals($admin['email']);
    }
}
