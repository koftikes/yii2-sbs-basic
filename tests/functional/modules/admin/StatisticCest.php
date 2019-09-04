<?php

namespace tests\functional\modules\admin;

use app\console\fixtures\UserFixture;
use app\models\user\User;
use yii\helpers\Url;

class StatisticCest
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
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByLogin('admin@example.com'));
        $I->amOnRoute('admin/statistic');
    }

    public function ensureThatPageWorks(\FunctionalTester $I)
    {
        $I->see('System Statistic', 'h3');
        $I->see('Processor');
        $I->see('Memory');
        $I->see('Uptime');
        $I->see('Load Average');
        $I->see('Operating System');
        $I->see('Time');
        $I->see('Network');
        $I->see('Software');
        $I->see('Registered Users');
        $I->see('CPU Usage');
        $I->see('Memory Usage');
        $I->sendAjaxGetRequest(Url::to(['/admin/statistic', 'data' => 'memory_usage']));
        $I->sendAjaxGetRequest(Url::to(['/admin/statistic', 'data' => 'cpu_usage']));
    }
}
