<?php

namespace tests\unit\models\user;

use Yii;
use Codeception\Test\Unit;
use app\models\user\User;
use app\models\user\PasswordResetRequestForm;
use app\console\fixtures\UserFixture;
use yii\mail\MessageInterface;

class PasswordResetRequestFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSendMessageWithWrongEmailAddress()
    {
        $form = new PasswordResetRequestForm(['email' => 'not-existing-email@example.com']);
        expect_not($form->sendEmail());
        expect($form->errors)->hasKey('email');
        expect($form->getFirstError('email'))
            ->equals('There is no user with this email address.');
    }

    public function testNotSendEmailsToInactiveUser()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
        $manager = $this->tester->grabFixture('user', 'manager');

        $form = new PasswordResetRequestForm(['email' => $manager['email']]);
        expect_not($form->sendEmail());
        expect($form->getFirstError('email'))
            ->equals('The user is not active. We cannot send email to this type of user.');
    }


    public function testSendEmailsToUserWithExpiredToken()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
        $user = $this->tester->grabFixture('user', 'user');

        $form = new PasswordResetRequestForm(['email' => $user['email']]);
        expect_that($form->sendEmail());
    }

    public function testSendEmailSuccessfully()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
        $admin = $this->tester->grabFixture('user', 'admin');

        $form = new PasswordResetRequestForm(['email' => $admin['email']]);
        $user = User::findOne(['password_reset_token' => $admin['password_reset_token']]);

        expect_that($form->sendEmail());
        expect_that($user->password_reset_token);

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf(MessageInterface::class);
        expect($emailMessage->getTo())->hasKey($form->email);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['supportEmail']);
    }
}
