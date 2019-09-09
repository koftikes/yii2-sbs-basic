<?php

namespace tests\unit\models\user;

use app\console\fixtures\UserFixture;
use app\models\user\User;
use Codeception\Test\Unit;
use yii\base\NotSupportedException;

class UserTest extends Unit
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
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $this->admin = $this->tester->grabFixture('user', 'admin');
    }

    public function testFindIdentityByAccessToken()
    {
        $this->tester->expectException(NotSupportedException::class, function () {
            User::findIdentityByAccessToken('notexistingtoken_1391882543');
        });
    }

    public function testIsPasswordResetTokenNotValid()
    {
        expect_not(User::isPasswordResetTokenValid('false'));
    }

    public function testIsPasswordResetTokenValid()
    {
        expect_that(User::isPasswordResetTokenValid('token_' . \time()));
    }

    public function testFindUserById()
    {
        /** @var User $user */
        $user = User::findIdentity($this->admin['id']);
        expect($user)->isInstanceOf(User::class);
        expect($user->username)->equals($this->admin['email']);
        expect_not(User::findIdentity(9999));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByLogin($this->admin['email']));
        expect_not(User::findByLogin('not-admin@example.com'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        /** @var User $user */
        $user = User::findByLogin($this->admin['email']);
        expect_that($user->validateAuthKey($this->admin['auth_key']));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('password_0'));
        expect_not($user->validatePassword('123456'));
    }

    public function testStaticStatuses()
    {
        $statuses = User::statuses();
        expect($statuses)->count(3);
    }

    public function testStaticStatus()
    {
        $status = User::status(User::STATUS_ACTIVE);
        expect($status)->equals('Active');
    }
}
