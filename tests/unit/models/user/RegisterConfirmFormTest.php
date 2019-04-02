<?php

namespace tests\unit\models\user;

use app\console\fixtures\UserMasterFixture;
use Codeception\Test\Unit;
use yii\base\InvalidArgumentException;
use app\models\user\RegisterConfirmForm;

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
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ],
        ]);
        $admin = $this->tester->grabFixture('user_master', 'manager');

        $form = new RegisterConfirmForm($admin['email_confirm_token']);
        expect_that($form->confirm());
    }
}
