<?php

use app\models\user\UserMaster;
use app\console\fixtures\UserMasterFixture;

class RegisterCest
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
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('user/register');
    }

    public function ensureThatRegisterPageWorks(FunctionalTester $I)
    {
        $I->see('Register', 'h1');
        $I->see('Please fill out the following fields to sign up:');
    }

    public function registerWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm('#form-register', []);
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Password Repeat cannot be blank.');
    }

    public function registerWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            '#form-register', [
                'RegisterForm[name]' => 'Tester',
                'RegisterForm[email]' => 'ttttt',
                'RegisterForm[password]' => 'tester_password',
                'RegisterForm[password_repeat]' => 'tester_password',
            ]
        );
        $I->dontSeeValidationError('Name cannot be blank.');
        $I->dontSeeValidationError('Password cannot be blank.');
        $I->dontSeeValidationError('Password Repeat cannot be blank.');
        $I->seeValidationError('Email is not a valid email address.');
    }

    public function registerWithAlreadyTakenEmail(FunctionalTester $I)
    {
        $I->submitForm(
            '#form-register', [
                'RegisterForm[name]' => 'Admin User',
                'RegisterForm[email]' => 'admin@example.com',
                'RegisterForm[password]' => '0_password',
                'RegisterForm[password_repeat]' => '0_password',
            ]
        );
        $I->dontSeeValidationError('Name cannot be blank.');
        $I->dontSeeValidationError('Password cannot be blank.');
        $I->dontSeeValidationError('Password Repeat cannot be blank.');
        $I->seeValidationError('This email address has already been taken.');
    }

    public function registerSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#form-register', [
            'RegisterForm[name]' => 'Tester',
            'RegisterForm[email]' => 'tester.email@example.com',
            'RegisterForm[password]' => 'tester_password',
            'RegisterForm[password_repeat]' => 'tester_password',
        ]);

        $I->seeRecord(UserMaster::class, ['email' => 'tester.email@example.com', 'status' => UserMaster::STATUS_PENDING]);
    }
}