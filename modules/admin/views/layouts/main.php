<?php
/**
 * @var yii\web\View
 * @var string       $content
 */
use app\modules\admin\AdminAsset;
use kartik\nav\NavX;
use yii\bootstrap4\Breadcrumbs;

$bundle = AdminAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div class="nav-scroller bg-white shadow-sm">
    <?= NavX::widget([
        'options'         => ['class' => 'nav nav-underline container'],
        'activateParents' => true,
        'items'           => [
            [
                'label'  => 'Statistic',
                'url'    => ['/admin/statistic'],
                'active' => \mb_strpos($this->context->route, 'statistic'),
            ],
            [
                'label'  => 'News',
                'url'    => ['/admin/news'],
                'active' => \mb_strpos($this->context->route, 'news'),
            ],
            [
                'label'  => 'Users',
                'url'    => ['/admin/user'],
                'active' => \mb_strpos($this->context->route, 'user'),
            ],
            [
                'label'  => 'Static Page',
                'url'    => ['/admin/static-page'],
                'active' => \mb_strpos($this->context->route, 'static-page'),
            ],
        ],
    ]);
    ?>
</div>

<div class="container">
    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
    <?= $content; ?>
</div>
<?php $this->endContent(); ?>
