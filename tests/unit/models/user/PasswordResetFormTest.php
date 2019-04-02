<?php

namespace tests\unit\models\user;

use Codeception\Test\Unit;
use app\console\fixtures\UserMasterFixture;
use app\models\user\PasswordResetForm;
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
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ],
        ]);
        $admin = $this->tester->grabFixture('user_master', 'admin');

        $form = new PasswordResetForm($admin['password_reset_token']);
        expect_not($form->reset());
        expect($form->errors)->hasKey('password');
    }

    public function testResetCorrectToken()
    {
        $this->tester->haveFixtures([
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ],
        ]);
        $admin = $this->tester->grabFixture('user_master', 'admin');

        $form = new PasswordResetForm($admin['password_reset_token']);
        $form->password = 'admin123456';
        expect_that($form->reset());
    }
}
