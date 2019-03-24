<?php

namespace app\models\user;

use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class PasswordResetForm
 * @package app\models\user
 */
class PasswordResetForm extends Model
{
    /**
     * @var string
     */
    public $password;

    /**
     * @var UserMaster|null
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = UserMaster::findByPasswordResetToken($token);
        if (!$this->_user instanceof UserMaster) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     *
     * @throws \yii\base\Exception
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
