<?php
/**
 * @var yii\web\View         $this
 * @var app\models\user\User $user
 * @var string               $password - user password
 */
?>

Hello, <?= $user->username; ?>

Thank you for registering on our portal!

Your login details:

Login: <?= $user->email; ?>
Password: <?= $password; ?>

Attention! You must confirm your registration details!

To confirm your email, just go on the following link:

<?= Yii::$app->urlManager->createAbsoluteUrl(['user/register-confirm', 'token' => $user->email_confirm_token]); ?>
