<?php

namespace app\modules\admin\controllers;

use app\models\NewsCategory;
use dkhlystov\widgets\TreeGrid;
use sbs\actions\CreateAction;
use sbs\actions\DeleteAction;
use sbs\actions\GridViewAction;
use sbs\actions\Redirect;
use sbs\actions\UpdateAction;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;

/**
 * Class NewsCategoryController.
 */
class NewsCategoryController extends BaseController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class'      => GridViewAction::class,
                'modelClass' => NewsCategory::class,
                'gridClass'  => TreeGrid::class,
                'gridConfig' => [
                    'columns' => [
                        'id',
                        'name',
                        'slug',
                        [
                            'class'     => DataColumn::class,
                            'attribute' => 'status',
                            'value'     => function ($model) {
                                return $model->status ? 'Yes' : 'No';
                            },
                        ],
                        [
                            'class'    => ActionColumn::class,
                            'template' => '{update} {delete}',

                        ],
                    ],
                    'showRoots'    => true,
                    'rootParentId' => null,
                    'lazyLoad'     => true,
                ],
                'dataProvider' => [
                    'pagination' => false,
                ],
            ],
            'create' => [
                'class'      => CreateAction::class,
                'modelClass' => NewsCategory::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
            'update' => [
                'class'      => UpdateAction::class,
                'modelClass' => NewsCategory::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
            'delete' => [
                'class'      => DeleteAction::class,
                'modelClass' => NewsCategory::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
        ];
    }
}
