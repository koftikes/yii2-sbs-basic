<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\user\UserMaster;
use app\models\user\UserProfile;

/**
 * Class UserForm
 * @package app\modules\admin\models
 */
class UserForm extends Model
{
    /**
     * @var UserMaster
     */
    public $user;
    /**
     * @var UserProfile
     */
    public $profile;

    public $password;
    public $password_repeat;

    /**
     * UserForm constructor.
     * @param null $id
     * @param array $config
     * @throws NotFoundHttpException
     */
    public function __construct($id = null, $config = [])
    {
        if (null === $id) {
            $this->user = new UserMaster();
        } else {
            $this->user = UserMaster::findOne($id);
            $this->profile = $this->user->profile;

            if (!$this->user instanceof UserMaster) {
                throw new NotFoundHttpException(Yii::t('app', 'The user was not found.'));
            }
        }

        if (!$this->profile instanceof UserProfile) {
            $this->profile = new UserProfile();
        }

        parent::__construct($config);
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
                    'on' => 'create',
                    'message' => Yii::t('app', 'Passwords don\'t match')
                ]
            ]);
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
        return parent::validate(['password', 'password_repeat'])
            && $this->user->validate() && $this->profile->validate();
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->user->save()) {
                $this->profile->user_id = $this->user->getId();
                if ($this->profile->save() && $this->sendEmail($this->user)) {
                    $transaction->commit();

                    return true;
                }
            }
            throw new Exception(Yii::t('app', 'Unable to save record by unknown reason.'));
        } catch (\Exception $exception) {
            $this->user->addError('email', $exception->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param $user UserMaster
     * @return bool
     */
    protected function sendEmail($user)
    {
        //TODO: Create emails for update user info.
        if ($this->scenario !== 'create') {
            return true;
        }

        return Yii::$app
            ->mailer
            ->compose([
                'html' => '@app/modules/admin/mail/user-create-html',
                'text' => '@app/modules/admin/mail/user-create-text'
            ], ['user' => $user, 'password' => $this->password])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Robot'])
            ->setTo($user->email)
            ->setSubject(Yii::t('app', 'Create user on the {portal}', ['portal' => Yii::$app->name]))
            ->send();
    }
}
