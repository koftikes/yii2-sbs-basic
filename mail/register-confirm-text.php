<?php

/* @var $this yii\web\View */
/* @var $user app\models\user\UserMaster */
/* @var $password - user password */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/register-confirm', 'token' => $user->email_confirm_token]);
?>

Hello, <?= $user->username; ?>

Thank you for registering on our portal!

Your login details:

Login: <?= $user->email; ?>
Password: <?= $password; ?>

Attention! You must confirm your registration details!

To confirm your email, just go on the following link:

<?= $confirmLink; ?>