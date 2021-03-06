<?php

namespace tests\unit\models\user;

use app\console\fixtures\UserFixture;
use app\models\user\LoginForm;
use Codeception\Test\Unit;
use Yii;

class LoginFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _after()
    {
        Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $form = new LoginForm([
            'login'    => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($form->login());
        expect_that(Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $form = new LoginForm([
            'login'    => 'demo',
            'password' => 'wrong_password',
        ]);

        expect_not($form->login());
        expect_that(Yii::$app->user->isGuest);
        expect($form->errors)->hasKey('login');
        expect($form->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $admin = $this->tester->grabFixture('user', 'admin');

        $form = new LoginForm([
            'login'    => $admin['email'],
            'password' => 'password_0',
        ]);

        expect_that($form->login());
        expect_not(Yii::$app->user->isGuest);
        expect($form->errors)->hasNotKey('login');
        expect($form->errors)->hasNotKey('password');
    }
}
