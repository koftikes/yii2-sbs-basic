<?php

namespace app\modules\admin;

use yii\web\YiiAsset;
use yii\web\AssetBundle;
use yii\bootstrap4\BootstrapPluginAsset;
use machour\flot\ChartAsset;

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
        'js/system-information.js'
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
        ChartAsset::class
    ];
}
