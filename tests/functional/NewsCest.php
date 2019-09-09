<?php

namespace tests\functional;

use app\console\fixtures\NewsCategoryFixture;
use app\console\fixtures\NewsFixture;

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
            'news'          => [
                'class'    => NewsFixture::class,
                'dataFile' => codecept_data_dir() . 'news.php',
            ],
            'news_category' => [
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
        $I->see('Spirited Away: Japanese anime trounces Toy Story 4 at China box office', 'h2');
        $I->see('Migrant children crisis: Democrats agree $4.5bn aid for migrants at border', 'h2');
        $I->see('France heatwave: Paris region closes schools', 'h2');
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
