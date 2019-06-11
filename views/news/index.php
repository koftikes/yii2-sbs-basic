<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var $this         yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->registerCssFile('/css/news.css');
$this->title                   = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="pb-2 mb-2 font-italic border-bottom"><?= Html::encode($this->title) ?></h1>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions'  => ['class' => 'news-post'],
    'itemView'     => '_item',
    'summary'      => false,
]) ?>
