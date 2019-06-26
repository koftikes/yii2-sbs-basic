<?php

namespace app\models\user;

use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Class RegisterConfirmForm
 * @package app\models\user
 */
class RegisterConfirmForm extends Model
{
    /**
     * @var User|null
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
            throw new InvalidArgumentException('Register confirm token cannot be blank.');
        }
        $this->_user = User::findByRegisterConfirmToken($token);
        if (!$this->_user instanceof User) {
            throw new InvalidArgumentException('Wrong register confirm token.');
        }
        parent::__construct($config);
    }

    /**
     * Confirm register.
     *
     * @return bool if register was confirm.
     */
    public function confirm()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        return $user->save(false);
    }

}
