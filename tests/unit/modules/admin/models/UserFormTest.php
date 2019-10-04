<?php

namespace tests\unit\modules\admin\models;

use app\console\fixtures\UserFixture;
use app\models\user\User;
use app\models\user\UserProfile;
use app\modules\admin\models\UserForm;
use Codeception\Test\Unit;
use yii\web\NotFoundHttpException;

class UserFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUserNotFound()
    {
        $this->tester->expectThrowable(NotFoundHttpException::class, function () {
            (new UserForm())->find(100);
        });
    }

    public function testUserNotCorrect()
    {
        $form = (new UserForm())->create();
        expect_not($form->save());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))->equals('Password cannot be blank.');
        expect_that($form->getErrors('password_repeat'));
        expect($form->getFirstError('password_repeat'))->equals('Password Repeat cannot be blank.');
        $form->attributes = [
            'password'        => '123',
            'password_repeat' => '123456',
        ];
        expect_not($form->save());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))->equals('Password should contain at least 6 characters.');
        expect_that($form->getErrors('password_repeat'));
        expect($form->getFirstError('password_repeat'))->equals('Passwords don\'t match');
    }

    public function testUserCreate()
    {
        $form = (new UserForm())->create();
        expect($form->user)->isInstanceOf(User::class);
        expect_that($form->user->isNewRecord);
        expect($form->profile)->isInstanceOf(UserProfile::class);
        expect_that($form->profile->isNewRecord);
        expect($form->getScenario())->equals('create');
        $form->load([
            'User'        => [
                'email'  => 'new_user@example.com',
                'status' => 1,
            ],
            'UserForm'    => [
                'password'        => 'some_password',
                'password_repeat' => 'some_password',
            ],
            'UserProfile' => [
                'name'   => 'New User',
                'phone'  => '+12013334545',
                'gender' => '1',
                'DOB'    => '1986-10-31',
                'info'   => 'Bla-Bla-Bla',
            ],
        ]);
        expect_that($form->save());
        $this->tester->seeEmailIsSent();
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('new_user@example.com');
        expect($emailMessage->getFrom())->hasKey('support@example.com');
    }

    public function testUserUpdate()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
        $user = $this->tester->grabFixture('user', 'user');
        /** @var UserForm $form */
        $form = (new UserForm())->find($user['id']);
        expect($form->user)->isInstanceOf(User::class);
        expect($form->user->email)->equals($user['email']);
        expect($form->profile)->isInstanceOf(UserProfile::class);
        $form->load([
            'User'        => [
                'email'  => $user['email'],
                'status' => 1,
            ],
            'UserProfile' => [
                'name'  => 'Update User',
                'phone' => '+12013334545',
            ],
        ]);

        expect_that($form->save());
        $this->tester->dontSeeEmailIsSent();
    }

    public function testThrowException()
    {
        /** @var UserForm $user */
        $form = $this->getMockBuilder(UserForm::class)
            ->setMethods(['validate'])
            ->getMock();

        $form->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        /** @var User $user */
        $user             = $this->getMockBuilder(User::class)
            ->setMethods(['validate'])
            ->getMock();
        $user->attributes = ['email' => 'test@example.com'];
        $form->user       = $user;

        expect_not($form->save());
        expect_that($form->user->getErrors('email'));
        expect($form->user->getFirstError('email'))->equals('Unable to save record by unknown reason.');
    }
}
