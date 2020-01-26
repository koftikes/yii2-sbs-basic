<?php

namespace tests\functional\modules\admin;

use app\console\fixtures\NewsCategoryFixture;
use app\console\fixtures\NewsFixture;
use app\console\fixtures\UserFixture;
use app\models\user\User;
use tests\functional\_BeforeRun;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class NewsCest extends _BeforeRun
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
        return ArrayHelper::merge(
            parent::_fixtures(),
            [
                'user'          => [
                    'class'    => UserFixture::class,
                    'dataFile' => codecept_data_dir() . 'user.php',
                ],
                'news'          => [
                    'class'    => NewsFixture::class,
                    'dataFile' => codecept_data_dir() . 'news.php',
                ],
                'news_category' => [
                    'class'    => NewsCategoryFixture::class,
                    'dataFile' => codecept_data_dir() . 'news_category.php',
                ],
            ]
        );
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByLogin('admin@example.com'));
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news/index');
        $I->see('News', 'h3');
        $I->see('Asia', 'td');
        $I->see('US & Canada', 'td');
        $I->see('Europe', 'td');
    }

    public function ensureThatViewPageWorks(\FunctionalTester $I)
    {
        foreach ($I->grabFixture('news') as $news) {
            $I->amOnRoute('admin/news/view', ['id' => $news['id']]);
            $I->seeInTitle($news['title']);
            $I->see($news['id'], 'td');
            $I->see($news['title'], 'td');
        }
    }

    public function createWithEmptyFields(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news/create');
        $I->submitForm('#admin-news-form', []);
        $I->expectTo('see validations errors');
        $I->see('Title cannot be blank.');
        $I->see('Slug cannot be blank.');
        $I->see('Text cannot be blank.');
        $I->see('Publish Date cannot be blank.');
    }

    public function createTakenSlug(\FunctionalTester $I)
    {
        $news = $I->grabFixture('news', 'asia');
        $I->amOnRoute('admin/news/create');
        $I->fillField('News[slug]', $news['slug']);
        $I->click('Create');
        $I->seeValidationError("Slug \"{$news['slug']}\" has already been taken.");
    }

    public function createSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news/create');
        $I->fillField('News[title]', 'Test News #123');
        $I->fillField('News[slug]', 'test-news-123');
        $I->fillField('News[text]', 'Bla-Bla-Bla');
        $I->fillField('News[publish_date]', '2019-05-31 12:55:00');
        $I->fillField('News[status]', 1);
        $I->click('Create');
        $I->amOnRoute('admin/news/index');
        $I->see('Test News #123', 'td');
        $I->see('test-news-123', 'td');
    }

    public function updateTakenSlug(\FunctionalTester $I)
    {
        $asia = $I->grabFixture('news', 'asia');
        $usa  = $I->grabFixture('news', 'usa');
        $I->amOnRoute('admin/news/update', ['id' => $asia['id']]);
        $I->fillField('News[slug]', $usa['slug']);
        $I->click('Update');
        $I->seeValidationError("Slug \"{$usa['slug']}\" has already been taken.");
    }

    public function updateSuccessfully(\FunctionalTester $I)
    {
        $news = $I->grabFixture('news', 'asia');
        $I->amOnRoute('admin/news/update', ['id' => $news['id']]);
        $I->selectOption('News[category_id]', 6);
        $I->fillField('News[title]', $news['title'] . ' Updated');
        $I->fillField('News[preview]', '');
        $I->click('Update');
        $I->amOnRoute('admin/news/index');
        $I->see($news['title'] . ' Updated', 'td');
        $I->see('World', 'td');
    }

    public function deleteSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news/index');
        foreach ($I->grabFixture('news') as $news) {
            $I->sendAjaxPostRequest(Url::toRoute(['news/delete', 'id' => $news['id']]));
            $I->amOnRoute('admin/news/index');
            $I->dontSee($news['title'], 'td');
            $I->dontSee($news['slug'], 'td');
        }
    }
}
