<?php
/**
 * @var yii\web\View
 * @var string       $content
 */
use yii\bootstrap4\Breadcrumbs;

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="container">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
        <?= $content; ?>
    </div>
<?php $this->endContent();
