<?php

class AboutCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/site/about');
    }

    public function ensureThatAboutWorks(FunctionalTester $I)
    {
        $I->see('About', 'h1');
    }
}
