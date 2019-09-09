<?php

namespace app\console\fixtures;

use app\models\News;
use yii\test\ActiveFixture;

/**
 * Class NewsFixture.
 */
class NewsFixture extends ActiveFixture
{
    public $modelClass = News::class;

    public $depends = [
        UserFixture::class,
        NewsCategoryFixture::class,
    ];
}
