<?php

namespace tests\functional;

use app\console\fixtures\UserFixture;
use app\models\user\User;

class PasswordResetCest
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
        $I->amOnRoute('user/password-reset-request');
    }

    protected function formResetRequestParams($email)
    {
        return ['PasswordResetRequestForm[email]' => $email];
    }

    protected function formResetParams($password, $repeat)
    {
        return [
            'PasswordResetForm[password]'        => $password,
            'PasswordResetForm[password_repeat]' => $repeat,
        ];
    }

    public function ensureThatPasswordResetRequestPageWorks(\FunctionalTester $I)
    {
        $I->see('Password Reset Request', 'h1');
        $I->see('Please fill out your email. A link to reset password will be sent there.');
    }

    public function passwordResetRequestWithEmptyField(\FunctionalTester $I)
    {
        $I->submitForm('#form-password-reset-request', []);
        $I->seeValidationError('Email cannot be blank.');
    }

    public function passwordResetRequestWithWrongEmail(\FunctionalTester $I)
    {
        $I->submitForm('#form-password-reset-request', $this->formResetRequestParams('ttttt'));
        $I->seeValidationError('Email is not a valid email address.');
    }

    public function passwordResetRequestForNotExistEmail(\FunctionalTester $I)
    {
        $I->submitForm('#form-password-reset-request', $this->formResetRequestParams('test@test.com'));
        $I->seeValidationError('There is no user with this email address.');
    }

    public function passwordResetRequestForNotActiveUser(\FunctionalTester $I)
    {
        $I->submitForm('#form-password-reset-request', $this->formResetRequestParams('manager@example.com'));
        $I->seeValidationError('The user is not active. We cannot send email to this type of user.');
    }

    public function passwordResetRequestSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#form-password-reset-request', $this->formResetRequestParams('user@example.com'));
        $I->seeEmailIsSent();
        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'user@example.com']);
        expect_that(null !== $user->password_reset_token);
    }

    public function passwordResetWrongToken(\FunctionalTester $I)
    {
        $I->amOnRoute('user/password-reset', ['token' => '']);
        $I->see('Password reset token cannot be blank.');

        $I->amOnRoute('user/password-reset', ['token' => 'UXmFY5w5hdNufbSpL75gVIEVIlfSVWzP']);
        $I->see('Wrong password reset token.');

        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'user@example.com']);
        $I->amOnRoute('user/password-reset', ['token' => $user->password_reset_token]);
        $I->see('Wrong password reset token.');
    }

    public function ensureThatPasswordResetPageWorks(\FunctionalTester $I)
    {
        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'admin@example.com']);
        $I->amOnRoute('user/password-reset', ['token' => $user->password_reset_token]);
        $I->see('Password Reset', 'h1');
        $I->see('Please choose your new password:');
    }

    public function passwordResetWithEmptyFields(\FunctionalTester $I)
    {
        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'admin@example.com']);
        $I->amOnRoute('user/password-reset', ['token' => $user->password_reset_token]);
        $I->submitForm('#form-password-reset', []);
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Password Repeat cannot be blank.');
    }

    public function passwordResetWithWrongFields(\FunctionalTester $I)
    {
        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'admin@example.com']);
        $I->amOnRoute('user/password-reset', ['token' => $user->password_reset_token]);
        $I->submitForm('#form-password-reset', $this->formResetParams(0, 0));
        $I->seeValidationError('Password should contain at least 6 characters.');
        $I->seeValidationError('Password Repeat should contain at least 6 characters.');

        $I->submitForm('#form-password-reset', $this->formResetParams('0_password', '0_password_1'));
        $I->seeValidationError('Passwords don\'t match.');
    }

    public function passwordResetSuccessfully(\FunctionalTester $I)
    {
        /** @var User $user */
        $user = $I->grabRecord(User::class, ['email' => 'admin@example.com']);
        $I->amOnRoute('user/password-reset', ['token' => $user->password_reset_token]);
        $I->submitForm('#form-password-reset', $this->formResetParams('password_0', 'password_0'));
        $user = $I->grabRecord(User::class, ['email' => 'admin@example.com']);
        expect_that(null === $user->password_reset_token);
    }
}
