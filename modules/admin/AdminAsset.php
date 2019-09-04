<?php

namespace app\modules\admin;

use machour\flot\ChartAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@app/modules/admin/assets';

    /**
     * {@inheritdoc}
     */
    public $js = [
        'js/system-information.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $css = [];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
        ChartAsset::class,
    ];
}
