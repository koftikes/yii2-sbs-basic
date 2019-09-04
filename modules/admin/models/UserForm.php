<?php

namespace app\modules\admin\models;

use app\models\user\User;
use app\models\user\UserProfile;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class UserForm.
 */
class UserForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var UserProfile
     */
    public $profile;

    public $password;

    public $password_repeat;

    /**
     * Create User.
     *
     * @return UserForm
     */
    public function create()
    {
        $this->user    = new User();
        $this->profile = new UserProfile();
        $this->setScenario('create');

        return $this;
    }

    /**
     * Find User by id.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException
     *
     * @return UserForm
     */
    public function find($id)
    {
        $user = User::findOne($id);
        if (!$user instanceof User) {
            throw new NotFoundHttpException(Yii::t('app', 'The user was not found.'));
        }

        $this->user    = $user;
        $this->profile = $this->user->profile;
        if (!$this->profile instanceof UserProfile) {
            $this->profile = new UserProfile();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            $this->user->rules(),
            $this->profile->rules(),
            [
                [['password', 'password_repeat'], 'required', 'on' => 'create'],
                [['password'], 'string', 'min' => 6],
                [
                    'password_repeat',
                    'compare',
                    'compareAttribute' => 'password',
                    'on'               => 'create',
                    'message'          => Yii::t('app', 'Passwords don\'t match'),
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load($data, $formName = null)
    {
        if ($this->user->isNewRecord) {
            parent::load($data);
            $this->user->setPassword($this->password);
            $this->user->generateAuthKey();
            $this->user->generateRegisterConfirmToken();
        }

        return $this->user->load($data) && $this->profile->load($data);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        return
            parent::validate(['password', 'password_repeat']) && $this->user->validate() && $this->profile->validate();
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        try {
            if ($this->user->save()) {
                $this->profile->user_id = $this->user->id;
                if ($this->profile->save() && $this->sendEmail($this->user)) {
                    return true;
                }
            }
            throw new Exception(Yii::t('app', 'Unable to save record by unknown reason.'));
        } catch (\Exception $exception) {
            $this->user->addError('email', $exception->getMessage());
        }

        return false;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    protected function sendEmail($user)
    {
        //TODO: Create emails for update user info.
        if ('create' !== $this->scenario) {
            return true;
        }

        return Yii::$app
            ->mailer
            ->compose([
                'html' => '@app/modules/admin/mail/user-create-html',
                'text' => '@app/modules/admin/mail/user-create-text',
            ], ['user' => $user, 'password' => $this->password])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Robot'])
            ->setTo($user->email)
            ->setSubject(Yii::t('app', 'Create user on the {portal}', ['portal' => Yii::$app->name]))
            ->send();
    }
}
