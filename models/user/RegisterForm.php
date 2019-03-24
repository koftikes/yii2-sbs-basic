<?php

namespace app\models\user;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Class RegisterForm
 * @package app\models\user
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat', 'email', 'name'], 'trim'],
            [['password', 'password_repeat', 'email', 'name'], 'required'],
            ['email', 'email'],
            [['email', 'name'], 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => UserMaster::class,
                'message' => Yii::t('app', 'This email address has already been taken.')
            ],
            ['password', 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('app', 'Passwords don\'t match')
            ]
        ];
    }

    /**
     * Registration user
     *
     * @return UserMaster|bool the saved model or false if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = UserMaster::create($this->email, $this->password);
            if ($user->save()) {
                $profile = new UserProfile();
                $profile->user_id = $user->getId();
                $profile->name = $this->name;
                if ($profile->save() && $this->sendEmail($user)) {
                    $transaction->commit();

                    return $user;
                }
            }
            throw new Exception('Unable to save record.');
        } catch (\Exception $exception) {
            $this->addError($exception->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param UserMaster $user
     * @return bool
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'register-confirm-html', 'text' => 'register-confirm-text'],
                ['user' => $user, 'password' => $this->password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Robot'])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Registration on {portal}', ['portal' => Yii::$app->name]))
            ->send();
    }
}
