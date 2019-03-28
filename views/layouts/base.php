<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<main role="main" class="wrap">
    <?= $this->render('@app/views/layouts/_header.php'); ?>
    <?= Alert::widget(); ?>
    <?= $content ?>
</main>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
