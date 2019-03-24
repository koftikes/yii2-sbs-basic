<?php

namespace app\models\user;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm is the model behind the login form.
 * @package app\models\user
 *
 * @property UserMaster|null $user This property is read-only.
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    /**
     * @var UserMaster|null
     */
    private $_user;

    /**
     * @return array the validation rules.
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
    public function validatePassword()
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
     * Finds user by [[login]]
     *
     * @return UserMaster|null
     */
    public function getUser()
    {
        if (!$this->_user instanceof UserMaster) {
            $this->_user = UserMaster::findByLogin($this->login);
        }

        return $this->_user;
    }
}
