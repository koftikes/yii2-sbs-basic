<?php

namespace tests\functional\modules\admin;

use app\console\fixtures\UserFixture;
use app\models\user\User;
use tests\functional\_BeforeRun;
use yii\helpers\ArrayHelper;

class StaticPageCest extends _BeforeRun
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
                'user' => [
                    'class'    => UserFixture::class,
                    'dataFile' => codecept_data_dir() . 'user.php',
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
        $I->amOnRoute('admin/static-page/index');
        $I->see('Static Page', 'h3');
        foreach ($I->grabFixture('static_page') as $page) {
            $I->see($page['title'], 'td');
            $I->see($page['slug'], 'td');
        }
    }

    public function updateTakenSlug(\FunctionalTester $I)
    {
        $about     = $I->grabFixture('static_page', 'about');
        $agreement = $I->grabFixture('static_page', 'user_agreement');
        $I->amOnRoute('admin/static-page/update', ['id' => $about['id']]);
        $I->fillField('StaticPage[slug]', $agreement['slug']);
        $I->click('Update');
        $I->seeValidationError("Slug \"{$agreement['slug']}\" has already been taken.");
    }

    public function updateSuccessfully(\FunctionalTester $I)
    {
        $about = $I->grabFixture('static_page', 'about');
        $I->amOnRoute('admin/static-page/update', ['id' => $about['id']]);
        $I->fillField('StaticPage[title]', $about['title'] . ' New');
        $I->fillField('StaticPage[slug]', $about['slug'] . '-new');
        $I->click('Update');
        $I->amOnRoute('admin/static-page/index');
        $I->see($about['title'] . ' New');
        $I->see($about['slug'] . '-new');
    }
}
