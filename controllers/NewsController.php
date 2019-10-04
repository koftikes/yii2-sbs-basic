<?php

namespace app\controllers;

use app\models\News;
use app\models\NewsCategory;
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
     * @throws \Exception
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => News::find()->publish()]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => null]);
    }

    /**
     * List of News by category.
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     *
     * @return string
     */
    public function actionCategory($slug)
    {
        if (null === ($category = NewsCategory::findOne(['slug' => $slug]))) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $dataProvider = new ActiveDataProvider(['query' => News::find()->category($category->id)->publish()]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => $category]);
    }

    /**
     * Displays a single News model.
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     *
     * @return string
     */
    public function actionView($slug)
    {
        if (null === ($model = News::find()->where(['slug' => $slug])->publish()->one())) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('view', ['model' => $model]);
    }
}
