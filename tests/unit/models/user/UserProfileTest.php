<?php

namespace tests\unit\models\user;

use app\models\user\UserProfile;
use Codeception\Test\Unit;
use app\models\user\UserMaster;
use app\console\fixtures\UserMasterFixture;
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
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ],
            'user_profile' => [
                'class' => UserProfileFixture::class,
                'dataFile' => codecept_data_dir() . 'user_profile.php',
            ],
        ]);
    }

    public function testGetUser()
    {
        $admin = $this->tester->grabFixture('user_master', 'admin');
        $adminProfile = $this->tester->grabFixture('user_profile', 'admin');
        $userProfile = UserProfile::findOne(['name' => $adminProfile['name']]);
        expect($userProfile->user)->isInstanceOf(UserMaster::class);
        expect($userProfile->user->email)->equals($admin['email']);
    }
}
