<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\user\UserMaster */
/* @var $password - user password */

$this->title = 'Create user on the portal ' . Yii::$app->name;
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/register-confirm', 'token' => $user->email_confirm_token]);
?>
<p>Hello, <?= Html::encode($user->username); ?></p>
<p>Our administration created a user for you on our portal!</p>
<p><b>Your login details:</b></p>
<p>
    Login: <?= $user->email; ?><br/>
    Password: <?= $password; ?>
</p>

<p>Attention! You must confirm your registration details!</p>
<p>To confirm, just click on the following link: <?= Html::a('Confirm Email', $confirmLink); ?></p>
<p>If the link does not work, copy and paste it into your browser: </p>
<p><?= Html::a(Html::encode($confirmLink), $confirmLink); ?></p>

