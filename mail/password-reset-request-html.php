<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\user\User */

$this->title = 'Password reset on the portal ' . Yii::$app->name;
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/password-reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username); ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink); ?></p>
</div>
