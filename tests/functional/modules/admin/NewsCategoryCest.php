<?php

namespace tests\functional\modules\admin;

use app\console\fixtures\NewsCategoryFixture;
use app\console\fixtures\UserFixture;
use app\models\user\User;
use tests\functional\_BeforeRun;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class NewsCategoryCest extends _BeforeRun
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
        $I->click('News Category');
        $I->dontSee('News Category', 'h3');
        $I->see('News', 'h3');
        foreach ($I->grabFixture('news_category') as $category) {
            if (null !== $category['parent_id']) {
                continue;
            }
            $I->see($category['name']);
            $I->see($category['slug']);
        }
        $I->click('Back to News');
        $I->dontSee('News Category', 'h3');
        $I->see('News', 'h3');
    }

    public function createWithEmptyFields(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news-category/create');
        $I->submitForm('#admin-news-category-form', []);
        $I->expectTo('see validations errors');
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Slug cannot be blank.');
    }

    public function createTakenSlug(\FunctionalTester $I)
    {
        $category = $I->grabFixture('news_category', 'business');
        $I->amOnRoute('admin/news-category/create');
        $I->fillField('NewsCategory[slug]', $category['slug']);
        $I->click('Create');
        $I->seeValidationError("Slug \"{$category['slug']}\" has already been taken.");
    }

    public function createSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news-category/create');
        $I->fillField('NewsCategory[name]', 'Test News');
        $I->fillField('NewsCategory[slug]', 'test-news');
        $I->click('NewsCategory[status]');
        $I->click('Create');
        $I->amOnRoute('admin/news-category/index');
        $I->see('Test News');
        $I->see('test-news');
    }

    public function updateTakenSlug(\FunctionalTester $I)
    {
        $business  = $I->grabFixture('news_category', 'business');
        $companies = $I->grabFixture('news_category', 'companies');
        $I->amOnRoute('admin/news-category/update', ['id' => $business['id']]);
        $I->fillField('NewsCategory[slug]', $companies['slug']);
        $I->click('Update');
        $I->seeValidationError("Slug \"{$companies['slug']}\" has already been taken.");
    }

    public function updateSuccessfully(\FunctionalTester $I)
    {
        $business = $I->grabFixture('news_category', 'business');
        $I->amOnRoute('admin/news-category/update', ['id' => $business['id']]);
        $I->fillField('NewsCategory[name]', $business['name'] . ' News');
        $I->fillField('NewsCategory[slug]', $business['slug'] . '-news');
        $I->click('Update');
        $I->amOnRoute('admin/news-category/index');
        $I->see($business['name'] . ' News');
        $I->see($business['slug'] . '-news');
    }

    public function deleteSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('admin/news-category/index');
        foreach ($I->grabFixture('news_category') as $category) {
            $I->sendAjaxPostRequest(Url::toRoute(['news-category/delete', 'id' => $category['id']]));
            $I->amOnRoute('admin/news-category/index');
            $I->dontSee($category['name'], 'td');
            $I->dontSee($category['slug'], 'td');
        }
    }
}
