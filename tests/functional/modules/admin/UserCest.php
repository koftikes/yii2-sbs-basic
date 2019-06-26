<?php

namespace functional\modules\admin;

use yii\helpers\Url;
use app\models\user\User;
use app\console\fixtures\UserFixture;

class UserCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     *
     * @return array
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
        $I->amLoggedInAs(User::findByLogin('admin@example.com'));
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/index');
        $I->see('Users', 'h3');
        $I->see('admin@example.com', 'td');
        $I->see('manager@example.com', 'td');
        $I->see('user@example.com', 'td');
    }

    public function createWithEmptyFields(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/create');
        $I->click('Create');
        $I->expectTo('see validations errors');
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Password Repeat cannot be blank.');
        // We need this because validation in form merged from different models.
        $I->fillField('UserForm[password]', 'some-password');
        $I->fillField('UserForm[password_repeat]', 'some-password');
        $I->click('Create');
        $I->seeValidationError('Email cannot be blank.');
    }

    public function createTakenEmail(\FunctionalTester $I)
    {
        $user = $I->grabFixture('user', 'user');
        $I->amOnRoute('admin/user/create');
        // We need this because validation in form merged from different models.
        $I->fillField('UserForm[password]', 'some-password');
        $I->fillField('UserForm[password_repeat]', 'some-password');
        $I->fillField('User[email]', $user['email']);
        $I->click('Create');
        $I->seeValidationError("Email \"{$user['email']}\" has already been taken.");
    }

    public function createSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/create');
        $I->fillField('User[email]', 'new-user@example.com');
        $I->fillField('UserForm[password]', 'some-password');
        $I->fillField('UserForm[password_repeat]', 'some-password');
        $I->selectOption('User[status]', 1);
        $I->fillField('UserProfile[name]', 'New User');
        $I->fillField('UserProfile[phone]', '+12233445566');
        $I->selectOption('UserProfile[gender]', 1);
        $I->fillField('UserProfile[DOB]', '1988-03-15');
        $I->fillField('UserProfile[info]', 'Bla-Bla-Bla');
        $I->click('Create');
        $I->amOnRoute('admin/user/index');
        $I->see('new-user@example.com', 'td');
        $I->see('New User', 'td');
    }

    public function updateTakenEmail(\FunctionalTester $I)
    {
        $user    = $I->grabFixture('user', 'user');
        $manager = $I->grabFixture('user', 'manager');
        $I->amOnRoute('admin/user/update', ['id' => $user['id']]);
        $I->fillField('User[email]', $manager['email']);
        $I->click('Update');
        $I->seeValidationError("Email \"{$manager['email']}\" has already been taken.");
    }

    public function updateSuccessfully(\FunctionalTester $I)
    {
        $user = $I->grabFixture('user', 'user');
        $I->amOnRoute('admin/user/update', ['id' => $user['id']]);
        $I->fillField('User[email]', 'user-updaded@example.com');
        $I->fillField('UserProfile[name]', 'User Updated');
        $I->click('Update');
        $I->amOnRoute('admin/user/index');
        $I->dontSee($user['email'], 'td');
        $I->see('user-updaded@example.com', 'td');
        $I->see('User Updated', 'td');
    }

    public function deleteSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/user/index');
        foreach ($I->grabFixture('user') as $user) {
            $I->sendAjaxPostRequest(Url::toRoute(['user/delete', 'id' => $user['id']]));
            $I->amOnRoute('admin/user/index');
            $I->dontSee($user['email'], 'td');
        }
    }
}
