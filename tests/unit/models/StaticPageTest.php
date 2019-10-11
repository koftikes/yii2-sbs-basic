<?php

namespace tests\unit\models;

use app\console\fixtures\StaticPageFixture;
use app\models\StaticPage;
use Codeception\Test\Unit;
use yii\web\NotFoundHttpException;

class StaticPageTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'pages' => ['class' => StaticPageFixture::class],
        ]);
    }

    public function testRules()
    {
        $model = new StaticPage();
        expect_not($model->save());
        expect_that($model->getErrors('title'));
        expect_that($model->getErrors('slug'));

        $model->title = 'Test title';
        $model->slug  = 'test-title';
        expect_that($model->save());
    }

    public function testUrl()
    {
        $about = $this->tester->grabFixture('pages', 'about');
        $url   = StaticPage::url($about['id']);
        expect($url)->array();
        expect($url)->count(2);
        expect($url)->contains($about['slug']);
    }

    public function testUrlThrowException()
    {
        $this->tester->expectThrowable(NotFoundHttpException::class, function () {
            StaticPage::url(999);
        });
    }
}
