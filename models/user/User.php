<?php

namespace app\models\user;

use sbs\behaviors\DateTimeBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int         $id
 * @property string      $email
 * @property null|string $email_confirm_token
 * @property string      $auth_key
 * @property string      $password_hash
 * @property null|string $password_reset_token
 * @property int         $status
 * @property string      $create_date
 * @property string      $update_date
 * @property string      $last_visit
 * @property string      $username
 * @property UserProfile $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_PENDING = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_BLOCKED = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            DateTimeBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_ACTIVE, self::STATUS_BLOCKED]],
            [['email', 'auth_key', 'password_hash'], 'required'],
            [['status'], 'integer'],
            [['create_date', 'update_date', 'last_visit'], 'safe'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['email_confirm_token', 'auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['email_confirm_token'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     * {@codeCoverageIgnore}.
     */
    public function attributeLabels()
    {
        return [
            'id'                   => '#',
            'email'                => Yii::t('app', 'Email'),
            'email_confirm_token'  => Yii::t('app', 'Email Confirm'),
            'auth_key'             => Yii::t('app', 'Auth Key'),
            'password_hash'        => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status'               => Yii::t('app', 'Status'),
            'create_date'          => Yii::t('app', 'Create Date'),
            'update_date'          => Yii::t('app', 'Update Date'),
            'last_visit'           => Yii::t('app', 'Last Visit'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key.
     *
     * @throws yii\base\Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates token for email confirmation.
     *
     * @throws yii\base\Exception
     */
    public function generateRegisterConfirmToken(): void
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Finds user by email confirm token.
     *
     * @param string $token email confirm token
     *
     * @return null|User
     */
    public static function findByRegisterConfirmToken($token)
    {
        return static::findOne([
            'email_confirm_token' => $token,
            'status'              => [self::STATUS_ACTIVE, self::STATUS_PENDING],
        ]);
    }

    /**
     * Removes email confirm token.
     */
    public function removeEmailConfirmToken(): void
    {
        $this->email_confirm_token = null;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     *
     * @throws yii\base\Exception
     */
    public function setPassword($password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token.
     *
     * @throws yii\base\Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . \time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        $timestamp = (int) \mb_substr($token, \mb_strrpos($token, '_') + 1);
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= \time();
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return null|User
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @throws yii\base\Exception
     *
     * @return User
     */
    public static function create($email, $password)
    {
        $user        = new self();
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateRegisterConfirmToken();
        $user->status = Yii::$app->params['user.registerConfirm'] ? self::STATUS_PENDING : self::STATUS_ACTIVE;

        return $user;
    }

    /**
     * Finds user by login.
     *
     * @param string $login
     *
     * @return null|User
     */
    public static function findByLogin($login)
    {
        return static::findOne(['email' => $login, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return (null !== $this->profile) ? $this->profile->name : $this->email;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'Pending'),
            self::STATUS_ACTIVE  => Yii::t('app', 'Active'),
            self::STATUS_BLOCKED => Yii::t('app', 'Blocked'),
        ];
    }

    /**
     * @param int $status
     *
     * @return string
     */
    public static function status($status)
    {
        $data = self::statuses();

        return $data[$status];
    }
}
