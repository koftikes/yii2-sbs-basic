<?php

namespace app\controllers;

use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 *
 * @package app\controllers
 */
class NewsController extends Controller
{
    /**
     * Lists all News models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => News::find()]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single News model.
     *
     * @param string $slug
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        if (($model = News::findOne(['slug' => $slug])) === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('view', ['model' => $model]);
    }
}
