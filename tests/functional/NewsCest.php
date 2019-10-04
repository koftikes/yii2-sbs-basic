<?php

namespace tests\functional;

use app\console\fixtures\NewsCategoryFixture;
use app\console\fixtures\NewsFixture;
use app\models\News;

class NewsCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before().
     *
     * @return array
     *
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return [
            'news'       => [
                'class'    => NewsFixture::class,
                'dataFile' => codecept_data_dir() . 'news.php',
            ],
            'categories' => [
                'class'    => NewsCategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'news_category.php',
            ],
        ];
    }

    public function ensureThatMainPageWorks(\FunctionalTester $I)
    {
        $I->amOnRoute('news/index');
        $I->seeInTitle('News');
        $I->see('News', 'h1');
        foreach ($I->grabFixture('news') as $news) {
            $I->see($news['title'], 'h2');
        }
    }

    public function ensureThatCategoryPageWorks(\FunctionalTester $I)
    {
        foreach ($I->grabFixture('categories') as $category) {
            $I->amOnRoute('news/category', ['slug' => $category['slug']]);
            $I->seeInTitle($category['name']);
            $I->see('News: ' . $category['name'], 'h1');
            $news = $I->grabRecord(News::class, ['category_id' => $category['id']]);
            if ($news instanceof News) {
                $I->see($news->title, 'h2');
            }
        }
    }

    public function ensureThatCategoryPage404(\FunctionalTester $I)
    {
        $I->amOnRoute('news/category', ['slug' => 'bla-bla-bla']);
        $I->seePageNotFound();
        $I->see('The requested page does not exist.');
    }

    public function ensureThatViewPageWorks(\FunctionalTester $I)
    {
        foreach ($I->grabFixture('news') as $news) {
            $I->amOnRoute('news/view', ['slug' => $news['slug']]);
            $I->seeInTitle($news['title']);
            $I->see($news['title'], 'h2');
        }
    }

    public function ensureThatViewPage404(\FunctionalTester $I)
    {
        $I->amOnRoute('news/view', ['slug' => 'bla-bla-bla']);
        $I->seePageNotFound();
        $I->see('The requested page does not exist.');
    }
}
