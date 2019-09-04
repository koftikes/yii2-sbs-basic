<?php

namespace tests\unit\models\user;

use app\console\fixtures\UserFixture;
use app\models\user\RegisterConfirmForm;
use Codeception\Test\Unit;
use yii\base\InvalidArgumentException;

class RegisterConfirmFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testResetWrongToken()
    {
        $this->tester->expectException(InvalidArgumentException::class, function () {
            new RegisterConfirmForm('');
        });

        $this->tester->expectException(InvalidArgumentException::class, function () {
            new RegisterConfirmForm('notexistingtoken_1391882543');
        });
    }

    public function testResetCorrectToken()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $admin = $this->tester->grabFixture('user', 'manager');

        $form = new RegisterConfirmForm($admin['email_confirm_token']);
        expect_that($form->confirm());
    }
}
