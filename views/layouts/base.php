<?php
/**
 * @var yii\web\View $this
 * @var string       $content
 */
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<main role="main" class="wrap">
    <?= $this->render('@app/views/layouts/_header.php'); ?>
    <?= Alert::widget(); ?>
    <?= $content; ?>
</main>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . \date('Y'); ?></p>
    </div>
</footer>
<?php Modal::begin(['id' => 'modal', 'clientOptions' => ['keyboard' => false]]); ?>
<?php Modal::end(); ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
