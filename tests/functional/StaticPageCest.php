<?php

namespace tests\functional;

use yii\helpers\Url;

class StaticPageCest extends _BeforeRun
{
    public function ensureThatCategoryPage404(\FunctionalTester $I)
    {
        $I->amOnRoute('site/static-page', ['slug' => 'bla-bla-bla']);
        $I->seePageNotFound();
        $I->see('The requested page does not exist.');
    }

    public function ensureThatAboutPageWorks(\FunctionalTester $I)
    {
        $about = $I->grabFixture('static_page', 'about');
        $I->amOnRoute('site/static-page', ['slug' => $about['slug']]);
        $I->seeInTitle($about['title']);
        $I->see($about['title'], 'h1');
    }

    public function ensureThatUserAgreementPageWorks(\FunctionalTester $I)
    {
        $agreement = $I->grabFixture('static_page', 'user_agreement');
        $I->sendAjaxGetRequest(Url::to(['/site/static-page', 'slug' => $agreement['slug']]));
    }
}
