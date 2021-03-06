<?php

namespace app\models\user;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Class RegisterForm.
 */
class RegisterForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_repeat;

    /**
     * @var bool
     */
    public $agreement;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat', 'email', 'name'], 'trim'],
            [['password', 'password_repeat', 'email', 'name', 'agreement'], 'required'],
            ['email', 'email'],
            [['email', 'name'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message'          => Yii::t('app', 'Passwords don\'t match.'),
            ],
            ['agreement', 'boolean'],
            [
                'agreement',
                'in',
                'range'   => [1],
                'message' => Yii::t('app', 'You must agree to the terms of the User Agreement.'),
            ],
        ];
    }

    /**
     * Registration user.
     *
     * @return bool|User the saved model or false if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = User::create($this->email, $this->password);
            if ($user->save()) {
                $profile          = new UserProfile();
                $profile->user_id = $user->id;
                $profile->name    = $this->name;
                if ($profile->save() && $this->sendEmail($user)) {
                    $transaction->commit();

                    return $user;
                }
            }
            throw new Exception(Yii::t('app', 'Unable to save record by unknown reason.'));
        } catch (\Exception $exception) {
            $this->addError('email', $exception->getMessage());
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @param User $user
     *
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
