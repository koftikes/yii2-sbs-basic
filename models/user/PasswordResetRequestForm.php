<?php

namespace app\models\user;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Class PasswordResetRequestForm.
 */
class PasswordResetRequestForm extends Model
{
    /**
     * @var string
     */
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
                'targetClass' => User::class,
                'message'     => Yii::t('app', 'There is no user with this email address.'),
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
            /** @var User $user */
            $user = User::findOne(['email' => $this->email]);
            if (User::STATUS_ACTIVE !== $user->status) {
                throw new Exception(
                    Yii::t('app', 'The user is not active. We cannot send email to this type of user.')
                );
            }

            if (null !== $user->password_reset_token && !User::isPasswordResetTokenValid($user->password_reset_token)) {
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
