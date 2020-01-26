<?php
/**
 * @var yii\web\View view component instance
 * @var string       $content main view render result
 */
?>

<?php $this->beginPage(); ?>
<?php $this->beginBody(); ?>
<?= $content; ?>
<?php $this->endBody(); ?>
With respect, administration portal <?= Yii::$app->name; ?>
<?php $this->endPage(); ?>
