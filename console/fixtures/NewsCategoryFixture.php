<?php

namespace app\console\fixtures;

use app\models\NewsCategory;
use yii\test\ActiveFixture;

/**
 * Class NewsCategoryFixture.
 */
class NewsCategoryFixture extends ActiveFixture
{
    public $modelClass = NewsCategory::class;
}
