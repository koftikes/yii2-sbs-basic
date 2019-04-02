<?php

namespace tests\unit\models\user;

use Codeception\Test\Unit;
use app\models\user\UserMaster;
use app\console\fixtures\UserMasterFixture;
use yii\base\NotSupportedException;

class UserMasterTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var array
     */
    private $admin;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ],
        ]);
        $this->admin = $this->tester->grabFixture('user_master', 'admin');
    }

    public function testFindIdentityByAccessToken()
    {
        $this->tester->expectException(NotSupportedException::class, function () {
            UserMaster::findIdentityByAccessToken('notexistingtoken_1391882543');
        });
    }

    public function testIsPasswordResetTokenNotValid()
    {
        expect_not(UserMaster::isPasswordResetTokenValid(false));
    }

    public function testIsPasswordResetTokenValid()
    {
        expect_that(UserMaster::isPasswordResetTokenValid('token_' . time()));
    }

    public function testFindUserById()
    {
        expect_that($user = UserMaster::findIdentity($this->admin['id']));
        expect($user->username)->equals($this->admin['email']);

        expect_not(UserMaster::findIdentity(9999));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = UserMaster::findByLogin($this->admin['email']));
        expect_not(UserMaster::findByLogin('not-admin@example.com'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = UserMaster::findByLogin($this->admin['email']);
        expect_that($user->validateAuthKey($this->admin['auth_key']));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('password_0'));
        expect_not($user->validatePassword('123456'));
    }
}
