<?php

namespace app\console\fixtures;

use app\models\NewsCategory;
use yii\test\ActiveFixture;

/**
 * Class NewsCategoryFixture
 *
 * @package app\console\fixtures
 */
class NewsCategoryFixture extends ActiveFixture
{
    public $modelClass = NewsCategory::class;
}
