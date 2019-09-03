<?php

namespace app\console\fixtures;

use app\models\News;
use yii\test\ActiveFixture;

/**
 * Class NewsFixture
 *
 * @package app\console\fixtures
 */
class NewsFixture extends ActiveFixture
{
    public $modelClass = News::class;

    public $depends = [
        UserFixture::class,
        NewsCategoryFixture::class,
    ];
}
