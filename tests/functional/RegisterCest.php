<?php

namespace tests\functional;

use app\console\fixtures\UserFixture;
use app\models\user\User;
use Yii;

class RegisterCest
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
        return [
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('user/register');
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->see('Register', 'h1');
        $I->see('Please fill out the following fields to sign up:');
    }

    public function registerWithEmptyFields(\FunctionalTester $I)
    {
        $I->submitForm('#form-register', []);
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Password Repeat cannot be blank.');
    }

    public function registerWithWrongEmail(\FunctionalTester $I)
    {
        $I->submitForm('#form-register', [
            'RegisterForm[name]'            => 'Tester',
            'RegisterForm[email]'           => 'ttttt',
            'RegisterForm[password]'        => 'tester_password',
            'RegisterForm[password_repeat]' => 'tester_password',
        ]);
        $I->dontSeeValidationError('Name cannot be blank.');
        $I->dontSeeValidationError('Password cannot be blank.');
        $I->dontSeeValidationError('Password Repeat cannot be blank.');
        $I->seeValidationError('Email is not a valid email address.');
    }

    public function registerWithAlreadyTakenEmail(\FunctionalTester $I)
    {
        $I->submitForm('#form-register', [
            'RegisterForm[name]'            => 'Admin User',
            'RegisterForm[email]'           => 'admin@example.com',
            'RegisterForm[password]'        => '0_password',
            'RegisterForm[password_repeat]' => '0_password',
        ]);
        $I->dontSeeValidationError('Name cannot be blank.');
        $I->dontSeeValidationError('Password cannot be blank.');
        $I->dontSeeValidationError('Password Repeat cannot be blank.');
        $I->seeValidationError('Email "admin@example.com" has already been taken.');
    }

    public function registerSuccessfullyWithoutConfirm(\FunctionalTester $I)
    {
        Yii::$app->params['user.registerConfirm'] = false;

        $I->submitForm('#form-register', [
            'RegisterForm[name]'            => 'Tester',
            'RegisterForm[email]'           => 'tester.email@example.com',
            'RegisterForm[password]'        => 'tester_password',
            'RegisterForm[password_repeat]' => 'tester_password',
        ]);

        $I->seeEmailIsSent();
        $I->seeRecord(User::class, ['email' => 'tester.email@example.com', 'status' => User::STATUS_ACTIVE]);
    }

    public function registerSuccessfullyWithConfirm(\FunctionalTester $I)
    {
        Yii::$app->params['user.registerConfirm'] = true;

        $I->submitForm('#form-register', [
            'RegisterForm[name]'            => 'Tester',
            'RegisterForm[email]'           => 'tester.email@example.com',
            'RegisterForm[password]'        => 'tester_password',
            'RegisterForm[password_repeat]' => 'tester_password',
        ]);

        $I->seeEmailIsSent();
        $I->seeRecord(User::class, ['email' => 'tester.email@example.com', 'status' => User::STATUS_PENDING]);

        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'tester.email@example.com']);
        $I->amOnRoute('user/register-confirm', ['token' => $user->email_confirm_token]);
        $I->seeRecord(User::class, ['email' => 'tester.email@example.com', 'status' => User::STATUS_ACTIVE]);
    }

    public function registerConfirmWrongToken(\FunctionalTester $I)
    {
        $I->amOnRoute('user/register-confirm', ['token' => '']);
        $I->see('Register confirm token cannot be blank.');

        $I->amOnRoute('user/register-confirm', ['token' => 'UXmFY5w5hdNufbSpL75gVIEVIlfSVWzP']);
        $I->see('Wrong register confirm token.');
    }
}
