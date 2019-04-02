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
    <div class="container">
        <div class="row">
            <div class="col-md-2 order-md-2">
                <?= NavX::widget([
                    'options' => ['class' => 'nav flex-column nav-pills'],
                    'activateParents' => true,
                    'items' => [
                        [
                            'label' => 'Statistic',
                            'url' => ['/admin/statistic'],
                            'active' => strpos($this->context->route, 'statistic')
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
            <div class="col-md-10 order-md-1">
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
                <?= $content; ?>
            </div>
        </div>
    </div>
<?php $this->endContent() ?>
