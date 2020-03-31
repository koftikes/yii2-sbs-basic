<?php

namespace tests\unit\models;

use app\console\fixtures\NewsCategoryFixture;
use app\console\fixtures\NewsFixture;
use app\models\News;
use app\models\NewsCategory;
use Codeception\Test\Unit;

class NewsCategoryTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'news'          => [
                'class'    => NewsFixture::class,
                'dataFile' => codecept_data_dir() . 'news.php',
            ],
            'news_category' => [
                'class'    => NewsCategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'news_category.php',
            ],
        ]);
    }

    public function testRules()
    {
        $model = new NewsCategory();
        expect_not($model->save());
        expect_that($model->getErrors('name'));
        expect_that($model->getErrors('slug'));

        $model->name = 'Test Name';
        $model->slug = 'test-name';
        expect_that($model->save());
    }

    public function testGetNews()
    {
        $category = $this->tester->grabFixture('news_category', 'asia');
        $news     = $this->tester->grabFixture('news', 'asia');

        expect($category->news)->count(1);
        foreach ($category->news as $news_category) {
            expect($news_category)->isInstanceOf(News::class);
            expect($news_category->title)->equals($news['title']);
            expect($news_category->category_id)->equals($news['category_id']);
            expect($news_category->category_id)->equals($category['id']);
        }
    }

    public function testGetParent()
    {
        $category_asia  = $this->tester->grabFixture('news_category', 'asia');
        $category_world = $this->tester->grabFixture('news_category', 'world');
        expect($category_asia->parent)->isInstanceOf(NewsCategory::class);
        expect($category_asia->parent->id)->equals($category_world['id']);
    }

    public function testGetChildren()
    {
        $category_world = $this->tester->grabFixture('news_category', 'world');
        expect($category_world->children)->count(3);
        foreach ($category_world->children as $category) {
            expect($category)->isInstanceOf(NewsCategory::class);
            expect($category->parent->id)->equals($category_world['id']);
        }
    }
}
