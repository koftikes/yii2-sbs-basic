<?php

namespace tests\functional;

use Yii;

class HomeCest extends _BeforeRun
{
    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('My Application');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}
