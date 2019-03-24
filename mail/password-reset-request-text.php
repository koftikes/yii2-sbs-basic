<?php

/* @var $this yii\web\View */
/* @var $user app\models\user\UserMaster */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/password-reset', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
