<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\base\Exception;

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
                'message' => Yii::t('app', 'There is no user with this email address.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        if (!$this->validate()) {
            return false;
        }

        try {
            /* @var $user UserMaster */
            $user = UserMaster::findOne(['email' => $this->email]);
            if ($user->status !== UserMaster::STATUS_ACTIVE) {
                throw new Exception(Yii::t('app',
                    'The user is not active. We cannot send email to this type of user.'));
            }

            if (!UserMaster::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
                $user->save(false);
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

        } catch (Exception $exception) {
            $this->addError('email', $exception->getMessage());

            return false;
        }
    }
}
