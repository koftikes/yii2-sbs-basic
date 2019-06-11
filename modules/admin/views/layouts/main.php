<?php
/**
 * @var $content string
 */

use kartik\nav\NavX;
use yii\bootstrap4\Breadcrumbs;
use app\modules\admin\AdminAsset;

$bundle = AdminAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div class="nav-scroller bg-white shadow-sm">
    <?= NavX::widget([
        'options' => ['class' => 'nav nav-underline container'],
        'activateParents' => true,
        'items' => [
            [
                'label' => 'Statistic',
                'url' => ['/admin/statistic'],
                'active' => strpos($this->context->route, 'statistic')
            ],
            [
                'label' => 'News',
                'url' => ['/admin/news'],
                'active' => strpos($this->context->route, 'news')
            ],
            [
                'label' => 'Users',
                'url' => ['/admin/user'],
                'active' => strpos($this->context->route, 'user')
            ],
        ],
    ]);
    ?>
</div>

<div class="container">
    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
    <?= $content; ?>
</div>
<?php $this->endContent() ?>
