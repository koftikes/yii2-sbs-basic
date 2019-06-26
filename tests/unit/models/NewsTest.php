<?php

namespace tests\unit\models\user;

use Codeception\Test\Unit;
use yii\db\ActiveQuery;
use app\models\News;
use app\models\user\User;
use app\models\NewsCategory;
use app\console\fixtures\UserFixture;
use app\console\fixtures\NewsFixture;
use app\console\fixtures\NewsCategoryFixture;

class NewsTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
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
        ]);
    }

    public function testRules()
    {
        $model = new News();
        expect_not($model->save());
        expect_that($model->getErrors('title'));
        expect_that($model->getErrors('slug'));
        expect_that($model->getErrors('text'));
        expect_that($model->getErrors('publish_date'));

        $model->title        = 'Test Title';
        $model->slug         = 'test-title';
        $model->text         = 'Bla-Bla-Bla';
        $model->publish_date = '2019-06-27';
        expect_that($model->save());
    }

    public function testApplyFilter()
    {
        $param = [
            'title'        => 'Test Title',
            'slug'         => 'test-title',
            'status'       => News::STATUS_ENABLE,
            'publish_date' => '2019-06-26',
        ];
        $model = new News($param);
        $query = new ActiveQuery(News::class);
        $query = $model->applyFilter($query);
        expect($query->createCommand()->getRawSql())->equals(
            "SELECT * FROM `news` WHERE (`status`={$param['status']}) AND (`title` LIKE '%{$param['title']}%') AND (`slug` LIKE '%{$param['slug']}%') AND (`publish_date` BETWEEN '{$param['publish_date']} 00:00:00' AND '{$param['publish_date']} 23:59:59')"
        );
    }

    public function testGetCategory()
    {
        /** @var News $news */
        $news          = $this->tester->grabFixture('news', 'asia');
        $news_category = $this->tester->grabFixture('news_category', 'asia');
        expect($news->category)->isInstanceOf(NewsCategory::class);
        expect($news->category->name)->equals($news_category['name']);
    }

    public function testGetCreateUser()
    {
        /** @var News $news */
        $news  = $this->tester->grabFixture('news', 'asia');
        $admin = $this->tester->grabFixture('user', 'admin');
        expect($news->createUser)->isInstanceOf(User::class);
        expect($news->createUser->email)->equals($admin['email']);
    }

    public function testGetUpdateUser()
    {
        /** @var News $news */
        $news  = $this->tester->grabFixture('news', 'asia');
        $admin = $this->tester->grabFixture('user', 'admin');
        expect($news->updateUser)->isInstanceOf(User::class);
        expect($news->updateUser->email)->equals($admin['email']);
    }
}
