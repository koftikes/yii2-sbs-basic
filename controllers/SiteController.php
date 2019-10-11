<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\StaticPage;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'base';

        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * @param string $slug
     *
     * @throws NotFoundHttpException
     *
     * @return false|string
     */
    public function actionStaticPage($slug)
    {
        if (null === ($model = StaticPage::findOne(['slug' => $slug]))) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if (Yii::$app->request->isAjax) {
            return \json_encode(['header' => $model->title, 'content' => $model->text]);
        }

        return $this->render('static-page', ['model' => $model]);
    }
}
