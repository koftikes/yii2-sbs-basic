<?php
/**
 * @var yii\web\View
 * @var app\models\user\User $user
 * @var string               $password - user password
 */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl([
    'user/register-confirm',
    'token' => $user->email_confirm_token,
]);
?>

Hello, <?= $user->username; ?>

Our administration created a user for you on our portal!

Your login details:

Login: <?= $user->email; ?>
Password: <?= $password; ?>

Attention! You must confirm your registration details!

To confirm your email, just go on the following link:

<?= $confirmLink; ?>
