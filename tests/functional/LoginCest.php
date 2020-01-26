<?php

namespace tests\functional;

use app\console\fixtures\UserFixture;
use app\console\fixtures\UserProfileFixture;
use app\models\user\User;
use app\models\user\UserProfile;
use yii\helpers\ArrayHelper;

class LoginCest extends _BeforeRun
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before().
     *
     * @return array
     *
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return ArrayHelper::merge(
            parent::_fixtures(),
            [
                'user'         => [
                    'class'    => UserFixture::class,
                    'dataFile' => codecept_data_dir() . 'user.php',
                ],
                'user_profile' => [
                    'class'    => UserProfileFixture::class,
                    'dataFile' => codecept_data_dir() . 'user_profile.php',
                ],
            ]
        );
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('user/login');
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return array
     */
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[login]'    => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByLogin('admin@example.com'));
        $I->amOnPage('/');
        $I->see('Logout');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('', ''));
        $I->expectTo('see validations errors');
        $I->see('Login cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('admin@example.com', 'wrong'));
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#form-login', $this->formParams('admin@example.com', 'password_0'));
        $I->see('Logout', 'form button[type=submit]');
        $I->dontSeeElement('form#form-login');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Register');
        $I->amOnRoute('user/login');
    }

    public function logoutSuccessfully(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByLogin('admin@example.com'));
        $I->amOnPage('/');
        $I->see('Logout');
        $I->seeElement('form#form-logout');
        $I->submitForm('#form-logout', []);
        $I->dontSeeElement('form#form-logout');
        $I->seeLink('Login');
        $I->seeLink('Register');
    }

    public function profileSuccessfully(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByLogin('no_profile@example.com'));
        $I->amOnRoute('user/profile');
        $I->see('Update User: no_profile@example.com', 'h1');
        $I->submitForm('#form-user-profile', [
            'UserProfile[name]'   => 'New Name',
            'UserProfile[phone]'  => '+12015559999',
            'UserProfile[gender]' => UserProfile::GENDER_MALE,
            'UserProfile[DOB]'    => '1984-03-15',
            'UserProfile[info]'   => 'Test info: Bla-Bla-Bla',
        ]);
        $I->amOnRoute('user/profile');
        $I->see('Update User: New Name', 'h1');
    }
}
