<?php

namespace tests\unit\models\user;

use Codeception\Test\Unit;
use app\models\user\RegisterForm;
use app\models\user\UserMaster;
use app\console\fixtures\UserMasterFixture;

class RegisterFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCorrectRegister()
    {
        $form = new RegisterForm([
            'name' => 'Some Name',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
        ]);

        $user = $form->register();

        expect($user)->isInstanceOf(UserMaster::class);

        expect($user->username)->equals('Some Name');
        expect($user->email)->equals('some_email@example.com');
        expect($user->validatePassword('some_password'))->true();
    }

    public function testNotCorrectRegister()
    {
        $this->tester->haveFixtures([
            'user_master' => [
                'class' => UserMasterFixture::class,
                'dataFile' => codecept_data_dir() . 'user_master.php'
            ]
        ]);
        $manager = $this->tester->grabFixture('user_master', 'manager');

        $form = new RegisterForm([
            'email' => $manager['email'],
            'password' => 'some_password',
        ]);

        expect_not($form->register());
        expect_that($form->getErrors('name'));
        expect_that($form->getErrors('email'));
        expect_that($form->getErrors('password_repeat'));

        expect($form->getFirstError('name'))
            ->equals('Name cannot be blank.');
        expect($form->getFirstError('email'))
            ->equals('This email address has already been taken.');
        expect($form->getFirstError('password_repeat'))
            ->equals('Password Repeat cannot be blank.');
    }

    public function testThrowException()
    {
        /** @var RegisterForm $form */
        $form = $this->getMockBuilder(RegisterForm::class)
            ->setMethods(['validate'])
            ->getMock();

        $form->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        expect_not($form->register());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Unable to save record by unknown reason.');
    }
}
