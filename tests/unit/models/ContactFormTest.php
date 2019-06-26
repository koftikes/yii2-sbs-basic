<?php

namespace tests\unit\models;

use app\models\ContactForm;
use Codeception\Test\Unit;

class ContactFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testSendIncorrectForm()
    {
        $form = new ContactForm([]);
        expect_not($form->contact('tester@example.com'));
        expect_that($form->getErrors('name'));
        expect_that($form->getErrors('email'));
        expect_that($form->getErrors('subject'));
        expect_that($form->getErrors('body'));
        expect_that($form->getErrors('verifyCode'));
    }

    public function testEmailIsSentOnContact()
    {
        /** @var ContactForm $form */
        $form = $this->getMockBuilder(ContactForm::class)
            ->setMethods(['validate'])
            ->getMock();

        $form->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $form->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($form->contact('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('noreply@example.com');
        expect($emailMessage->getReplyTo())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->stringContainsString('body of current message');
    }
}
