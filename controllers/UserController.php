<?php

namespace app\controllers;

use app\models\user\LoginForm;
use app\models\user\PasswordResetForm;
use app\models\user\PasswordResetRequestForm;
use app\models\user\RegisterConfirmForm;
use app\models\user\RegisterForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return Response|string
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->register()) {
            if (!Yii::$app->params['user.registerConfirm'] && Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Thank you for registration. You was automatically login to portal.')
                );
            } else {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Thank you for registration. Check your email for further instructions.')
                );
            }

            return $this->goHome();
        }

        return $this->render('register', ['model' => $model]);
    }

    /**
     * @param string $token
     *
     * @throws BadRequestHttpException
     *
     * @return Response
     */
    public function actionRegisterConfirm($token)
    {
        try {
            $model = new RegisterConfirmForm($token);
            if ($model->confirm()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Registration was confirm. Now you can login to portal.')
                );
            }

            return $this->goHome();
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Requests password reset.
     *
     * @return Response|string
     */
    public function actionPasswordResetRequest()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendEmail()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

            return $this->goHome();
        }

        return $this->render('password-reset-request', ['model' => $model]);
    }

    /**
     * @param string $token
     *
     * @throws BadRequestHttpException
     * @throws yii\base\Exception
     *
     * @return Response|string
     */
    public function actionPasswordReset($token)
    {
        try {
            $model = new PasswordResetForm($token);

            if ($model->load(Yii::$app->request->post()) && $model->reset()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'New password saved. Now you can login to portal.')
                );

                return $this->goHome();
            }

            return $this->render('password-reset', ['model' => $model]);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
