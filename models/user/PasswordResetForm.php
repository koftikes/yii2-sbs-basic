<?php

namespace app\models\user;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class PasswordResetForm.
 */
class PasswordResetForm extends Model
{
    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_repeat;

    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array  $config name-value pairs that will be used to initialize the object properties
     *
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !\is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $user = User::findByPasswordResetToken($token);
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        $this->_user = $user;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'trim'],
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message'          => Yii::t('app', 'Passwords don\'t match.'),
            ],
        ];
    }

    /**
     * Resets password.
     *
     * @throws \yii\base\Exception
     *
     * @return bool if password was reset
     */
    public function reset()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        // Remove email confirm token because letter send to the same email it's means email confirmed too.
        $user->removeEmailConfirmToken();

        return $user->save(false);
    }
}
