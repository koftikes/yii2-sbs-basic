<?php

namespace tests\functional;

class AboutCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/about');
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->see('About', 'h1');
    }
}
