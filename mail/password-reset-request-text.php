<?php
/**
 * @var yii\web\View
 * @var app\models\user\User $user
 */
?>
Hello <?= $user->username; ?>,

Follow the link below to reset your password:

<?= Yii::$app->urlManager->createAbsoluteUrl(['user/password-reset', 'token' => $user->password_reset_token]); ?>
