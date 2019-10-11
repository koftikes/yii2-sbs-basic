<?php

namespace app\modules\admin\controllers;

use app\models\StaticPage;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use sbs\actions\GridViewAction;
use sbs\actions\Redirect;
use sbs\actions\UpdateAction;

class StaticPageController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index'  => [
                'class'        => GridViewAction::class,
                'modelClass'   => StaticPage::class,
                'gridClass'    => GridView::class,
                'gridConfig'   => [
                    'columns'  => [
                        'id',
                        'title',
                        'slug',
                        'update_date',
                        [
                            'class'    => ActionColumn::class,
                            'template' => '{update}',
                        ],
                    ],
                    'export'   => false,
                    'bordered' => false,
                    'hover'    => true,
                ],
                'dataProvider' => [
                    'pagination' => ['pageSize' => 20],
                ],
            ],
            'update' => [
                'class'      => UpdateAction::class,
                'modelClass' => StaticPage::class,
                'handlers'   => [
                    'success' => ['class' => Redirect::class],
                ],
            ],
        ];
    }
}
