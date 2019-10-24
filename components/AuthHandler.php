<?php

namespace app\components;

use app\models\user\User;
use app\models\user\UserAuth;
use app\models\user\UserProfile;
use Yii;
use yii\authclient\ClientInterface;
use yii\authclient\clients\VKontakte;
use yii\authclient\clients\Yandex;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component.
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $auth_id;

    /**
     * @var string
     */
    private $auth_email;

    /**
     * @var string
     */
    private $auth_name;

    /**
     * @var null|string
     */
    private $auth_dob;

    /**
     * @var int
     */
    private $auth_gender = UserProfile::GENDER_THING;

    /**
     * AuthHandler constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->getAttributes();
    }

    /**
     * @throws Exception
     *
     * @return bool
     */
    public function handle()
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
        $auth = UserAuth::findOne(['source' => $this->client->getId(), 'source_id' => $this->auth_id]);

        // User login
        if ($auth instanceof UserAuth && Yii::$app->user->isGuest) {
            return Yii::$app->user->login($auth->user, Yii::$app->params['user.rememberMeDuration']);
        }

        // User account already linked
        if ($auth instanceof UserAuth && !Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash(
                'info',
                Yii::t('app', 'User account already linked to {client}.', ['client' => $this->client->getTitle()])
            );

            return true;
        }

        // User already logged in. Add auth provider.
        if (!$auth instanceof UserAuth && !Yii::$app->user->isGuest) {
            $this->saveAuth(Yii::$app->user->id);
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Linked {client} account.', ['client' => $this->client->getTitle()])
            );

            return true;
        }

        /**
         * User registration.
         */
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (User::find()->where(['email' => $this->auth_email])->exists()) {
                throw new Exception(
                    Yii::t('app', 'Email exist but not linked to {client}.', ['client' => $this->client->getTitle()])
                );
            }
            Yii::$app->params['user.registerConfirm'] = false;

            $user = User::create($this->auth_email, Yii::$app->security->generateRandomString(10));
            if ($user->save()) {
                $this->saveAuth($user->getId());
                $profile = new UserProfile([
                    'user_id' => $user->getId(),
                    'name'    => $this->auth_name,
                    'DOB'     => $this->auth_dob,
                    'gender'  => $this->auth_gender,
                ]);
                if ($profile->save()) {
                    Yii::$app->user->setReturnUrl(['user/profile']);
                    $transaction->commit();

                    return Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                }
            }

            throw new Exception(
                Yii::t('app', 'Unable to save user with {client} account.', ['client' => $this->client->getTitle()])
            );
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());

            return false;
        }
    }

    /**
     * @param int $user_id
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function saveAuth($user_id)
    {
        $auth = new UserAuth([
            'user_id'   => $user_id,
            'source'    => $this->client->getId(),
            'source_id' => $this->auth_id,
        ]);
        if (!$auth->save()) {
            throw new Exception(Yii::t('app', 'There were some errors while saving the user. Please try again later.'));
        }

        return true;
    }

    protected function getAttributes()
    {
        try {
            $attributes        = $this->client->getUserAttributes();
            $this->auth_id     = (string) ArrayHelper::getValue($attributes, 'id');
            $this->auth_email  = $this->getAuthEmail($attributes);
            $this->auth_name   = $this->getAuthName($attributes);
            $this->auth_gender = $this->getAuthGender($attributes);
            $this->auth_dob    = $this->getAuthDOB($attributes);
            //TODO: Save user photo. For Yandex @see https://yandex.ru/dev/passport/doc/dg/reference/response-docpage/

            if (!$this->auth_id && !$this->auth_email) {
                throw new Exception(Yii::t('app', 'This type of authorization is not supported.'));
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    private function getAuthEmail($attributes)
    {
        if ($this->client instanceof Yandex) {
            return ArrayHelper::getValue($attributes, 'default_email');
        }

        return ArrayHelper::getValue($attributes, 'email');
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    private function getAuthName($attributes)
    {
        if ($this->client instanceof Yandex) {
            return ArrayHelper::getValue($attributes, 'real_name');
        }

        if ($this->client instanceof VKontakte) {
            return \trim(
                ArrayHelper::getValue($attributes, 'first_name') . ' ' . ArrayHelper::getValue($attributes, 'last_name')
            );
        }

        return ArrayHelper::getValue($attributes, 'name');
    }

    /**
     * @param array $attributes
     *
     * @return int
     */
    private function getAuthGender($attributes)
    {
        if ($this->client instanceof VKontakte) {
            switch (ArrayHelper::getValue($attributes, 'sex')) {
                case 1:
                    return UserProfile::GENDER_FEMALE;
                case 2:
                    return UserProfile::GENDER_MALE;
            }
        }

        if ($this->client instanceof Yandex) {
            switch (ArrayHelper::getValue($attributes, 'sex')) {
                case 'male':
                    return UserProfile::GENDER_MALE;
                case 'female':
                    return UserProfile::GENDER_FEMALE;
            }
        }

        return UserProfile::GENDER_THING;
    }

    /**
     * @param array $attributes
     *
     * @throws \Exception
     *
     * @return null|string
     */
    private function getAuthDOB($attributes)
    {
        if ($this->client instanceof VKontakte) {
            return (new \DateTime(ArrayHelper::getValue($attributes, 'bdate')))->format('Y-m-d');
        }

        if ($this->client instanceof Yandex) {
            return (new \DateTime(ArrayHelper::getValue($attributes, 'birthday')))->format('Y-m-d');
        }

        return null;
    }
}
