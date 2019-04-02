<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'System Statistic');

echo Yii::t('app', 'Sorry, application failed to collect information about your system. See {link}.',
    ['link' => Html::a('trntv/probe', 'https://github.com/trntv/probe#user-content-supported-os')]);
