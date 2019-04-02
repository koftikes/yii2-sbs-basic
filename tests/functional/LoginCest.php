<?php

use app\models\user\UserMaster;
use app\console\fixtures\UserMasterFixture;
use app\console\fixtures\UserProfileFixture;

class LoginCest
{

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @return array
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return [
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php',
            ],
            'user_profile' => [
                'class' => UserProfileFixture::class,
                'dataFile' => codecept_data_dir() . 'user_profile.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('user/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[login]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function ensureThatLoginPageWorks(FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (Admin User)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(FunctionalTester $I)
    {
        $I->amLoggedInAs(UserMaster::findByLogin('admin@example.com'));
        $I->amOnPage('/');
        $I->see('Logout (Admin User)');
    }

    public function loginWithEmptyCredentials(FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('', ''));
        $I->expectTo('see validations errors');
        $I->see('Login cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('admin@example.com', 'wrong'));
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('admin@example.com', 'password_0'));
        $I->see('Logout (Admin User)', 'form button[type=submit]');
        $I->dontSeeElement('form#form-login');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Register');
    }
}
