<?php
/**
 * @var yii\web\View $this
 * @var string       $content
 */
use yii\bootstrap4\Breadcrumbs;

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="container">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]); ?>
        <?= $content; ?>
    </div>
<?php $this->endContent();
