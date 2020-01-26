<?php

namespace app\modules\admin\controllers;

use app\models\News;
use app\models\NewsCategory;
use kartik\detail\DetailView;
use kartik\grid\ActionColumn;
use kartik\grid\BooleanColumn;
use kartik\grid\GridView;
use sbs\actions\CreateAction;
use sbs\actions\DeleteAction;
use sbs\actions\DetailViewAction;
use sbs\actions\GridViewAction;
use sbs\actions\Redirect;
use sbs\actions\UpdateAction;
use sbs\widgets\TreeDropDown;

/**
 * Class NewsController.
 */
class NewsController extends BaseController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index'  => [
                'class'        => GridViewAction::class,
                'modelClass'   => News::class,
                'gridClass'    => GridView::class,
                'gridConfig'   => [
                    'columns'  => [
                        [
                            'attribute'           => 'category_id',
                            'format'              => 'raw',
                            'value'               => function ($model) {
                                return $model->category ? $model->category->name : '';
                            },
                            'filterType'          => TreeDropDown::class,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'query'   => NewsCategory::find()->where(['parent_id' => null]),
                            ],
                        ],
                        'title',
                        'slug',
                        [
                            'class'     => BooleanColumn::class,
                            'attribute' => 'status',
                        ],
                        [
                            'attribute'  => 'publish_date',
                            'format'     => 'date',
                            'filterType' => GridView::FILTER_DATE,
                        ],
                        ['class' => ActionColumn::class],
                    ],
                    'export'   => false,
                    'bordered' => false,
                    'hover'    => true,
                ],
                'dataProvider' => [
                    'pagination' => ['pageSize' => 20],
                ],
                'withFilters'  => true,
            ],
            'view'   => [
                'class'        => DetailViewAction::class,
                'modelClass'   => News::class,
                'detailClass'  => DetailView::class,
                'detailConfig' => [
                    'attributes' => [
                        ['attribute' => 'id', 'displayOnly' => true],
                        [
                            'attribute' => 'category_id',
                            'format'    => 'raw',
                            'value'     => '$data->category ? $data->category->name : ""',
                        ],
                        'title',
                        'slug',
                        //'image',
                        [
                            'attribute' => 'preview',
                            'format'    => 'raw',
                            'value'     => '$data->preview',
                        ],
                        [
                            'attribute' => 'text',
                            'format'    => 'raw',
                            'value'     => '$data->text',
                        ],
                        [
                            'attribute' => 'status',
                            'format'    => 'raw',
                            'value'     => '$data->status ? "<span class=\"fas fa-check text-success\"></span>" : "<span class=\"fas fa-times text-danger\"></span>"',
                        ],
                        'publish_date',
                        'views',
                        [
                            'label'  => 'Create',
                            'format' => 'raw',
                            'value'  => '$data->create_date . " by " . $data->createUser->username',
                        ],

                        [
                            'label'  => 'Update',
                            'format' => 'raw',
                            'value'  => '$data->update_date . " by " . $data->updateUser->username',
                        ],
                    ],
                ],
            ],
            'create' => [
                'class'      => CreateAction::class,
                'modelClass' => News::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
            'update' => [
                'class'      => UpdateAction::class,
                'modelClass' => News::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
            'delete' => [
                'class'      => DeleteAction::class,
                'modelClass' => News::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
        ];
    }
}
