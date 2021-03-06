<?php

namespace app\models\user;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm is the model behind the login form.
 *
 * @property null|User $user This property is read-only.
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @var null|User
     */
    private $_user;

    /**
     * @return array the validation rules
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword(): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('login');
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
        }

        return false;
    }

    /**
     * Finds user by [[login]].
     *
     * @return null|User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }
}
