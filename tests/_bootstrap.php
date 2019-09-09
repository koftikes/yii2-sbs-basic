<?php
\define('YII_ENV', 'test');
\defined('YII_DEBUG') or \define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../vendor/autoload.php';

// Fixed issue session_set_cookie_params(): Cannot change session cookie parameters when headers already sent
\ob_start();
