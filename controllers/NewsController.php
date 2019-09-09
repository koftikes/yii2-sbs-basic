<?php

namespace app\controllers;

use app\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController.
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
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return mixed
     */
    public function actionView($slug)
    {
        if (null === ($model = News::findOne(['slug' => $slug]))) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('view', ['model' => $model]);
    }
}
