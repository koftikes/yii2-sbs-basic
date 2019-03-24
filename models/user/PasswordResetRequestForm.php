<?php

namespace app\models\user;

use Yii;
use yii\base\Model;

/**
 * Class PasswordResetRequestForm
 * @package app\models\user
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => UserMaster::class,
                'filter' => ['status' => UserMaster::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     *
     * @throws \yii\base\Exception
     */
    public function sendEmail()
    {
        /* @var $user UserMaster */
        $user = UserMaster::findOne(['status' => UserMaster::STATUS_ACTIVE, 'email' => $this->email]);

        if (!$user instanceof UserMaster) {
            return false;
        }

        if (!UserMaster::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'password-reset-request-html', 'text' => 'password-reset-request-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Robot'])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Password reset on {portal}', ['portal' => Yii::$app->name]))
            ->send();
    }
}
