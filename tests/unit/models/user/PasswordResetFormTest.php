<?php

namespace tests\unit\models\user;

use app\console\fixtures\UserFixture;
use app\models\user\PasswordResetForm;
use Codeception\Test\Unit;
use yii\base\InvalidArgumentException;

class PasswordResetFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testResetWrongToken()
    {
        $this->tester->expectException(InvalidArgumentException::class, function () {
            new PasswordResetForm('');
        });

        $this->tester->expectException(InvalidArgumentException::class, function () {
            new PasswordResetForm('notexistingtoken_1391882543');
        });
    }

    public function testResetEmptyForm()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $admin = $this->tester->grabFixture('user', 'admin');

        $form = new PasswordResetForm($admin['password_reset_token']);
        expect_not($form->reset());
        expect($form->errors)->hasKey('password');
        expect($form->errors)->hasKey('password_repeat');
    }

    public function testResetCorrectToken()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $admin = $this->tester->grabFixture('user', 'admin');

        $form                  = new PasswordResetForm($admin['password_reset_token']);
        $form->password        = 'admin123456';
        $form->password_repeat = 'admin123456';
        expect_that($form->reset());
    }
}
