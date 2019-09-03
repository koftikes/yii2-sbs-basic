<?php

namespace app\modules\admin\controllers;

use Yii;
use kartik\grid\GridView;
use kartik\grid\ActionColumn;
use sbs\actions\Redirect;
use sbs\actions\GridViewAction;
use sbs\actions\DeleteAction;
use app\models\user\User;
use app\modules\admin\models\UserForm;
use yii\web\NotFoundHttpException;

/**
 * Class UserController
 *
 * @package app\modules\admin\controllers
 */
class UserController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index'  => [
                'class'        => GridViewAction::class,
                'modelClass'   => User::class,
                'gridClass'    => GridView::class,
                'gridConfig'   => [
                    'columns'  => [
                        'id',
                        'email',
                        [
                            'attribute' => 'username',
                            'label'     => Yii::t('app', 'Name'),
                        ],
                        [
                            'attribute' => 'status',
                            'value'     => function ($model) {
                                return User::statuses($model->status);
                            },
                        ],
                        [
                            'attribute' => 'last_visit',
                            'format'    => 'date',
                        ],
                        [
                            'class'    => ActionColumn::class,
                            'template' => '{update} {delete}',
                        ],
                    ],
                    'export'   => false,
                    'bordered' => false,
                    'hover'    => true,
                ],
                'dataProvider' => [
                    'pagination' => ['pageSize' => 15],
                ],
            ],
            'delete' => [
                'class'      => DeleteAction::class,
                'modelClass' => User::class,
                'handlers'   => [
                    'success' => [
                        'class'         => Redirect::class,
                        'route'         => 'user/index',
                        'refererParams' => ['page', 'per-page'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws yii\base\Exception
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $model = (new UserForm())->create();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'The user is successfully created.'));
            return $this->redirect(['user/index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     *
     * @throws NotFoundHttpException
     * @throws yii\base\Exception
     * @return string|yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = (new UserForm())->find($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'The user is successfully updated.'));
            return $this->refresh();
        }

        return $this->render('update', ['model' => $model]);
    }
}
