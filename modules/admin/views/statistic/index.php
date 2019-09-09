<?php
/**
 * @var yii\web\View
 * @var probe\provider\ProviderInterface $provider
 */
use app\models\user\User;
use yii\helpers\Html;

$this->registerJs('window.paceOptions = { ajax: false }', yii\web\View::POS_HEAD);
$this->title                   = 'System Statistic';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-statistic">
    <h3><?= Html::encode($this->title); ?></h3>
    <div class="card-columns">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-microchip"></i> <?= Yii::t('app', 'Processor'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'Processor'); ?></dt>
                    <dd><?= $provider->getCpuModel(); ?></dd>
                    <dt><?= Yii::t('app', 'Processor Architecture'); ?></dt>
                    <dd><?= $provider->getArchitecture(); ?></dd>
                    <dt><?= Yii::t('app', 'Number of cores'); ?></dt>
                    <dd><?= $provider->getCpuCores(); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-memory"></i> <?= Yii::t('app', 'Memory'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'Total memory'); ?></dt>
                    <dd><?= Yii::$app->formatter->asSize($provider->getTotalMem()); ?></dd>
                    <dt><?= Yii::t('app', 'Free memory'); ?></dt>
                    <dd><?= Yii::$app->formatter->asSize($provider->getFreeMem()); ?></dd>
                    <dt><?= Yii::t('app', 'Total Swap'); ?></dt>
                    <dd><?= Yii::$app->formatter->asSize($provider->getTotalSwap()); ?></dd>
                    <dt><?= Yii::t('app', 'Free Swap'); ?></dt>
                    <dd><?= Yii::$app->formatter->asSize($provider->getFreeSwap()); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> <?= Yii::t('app', 'Uptime'); ?>
            </div>
            <div class="card-body">
                <h4><?= \gmdate('H:i:s', $provider->getUptime()); ?></h4>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-spinner"></i> <?= Yii::t('app', 'Load Average'); ?>
            </div>
            <div class="card-body">
                <h4><?= $provider->getLoadAverage(); ?></h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="far fa-hdd"></i> <?= Yii::t('app', 'Operating System'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'OS'); ?></dt>
                    <dd><?= $provider->getOsType(); ?></dd>
                    <dt><?= Yii::t('app', 'OS Release'); ?></dt>
                    <dd><?= $provider->getOsRelease(); ?></dd>
                    <dt><?= Yii::t('app', 'Kernel version'); ?></dt>
                    <dd><?= $provider->getOsKernelVersion(); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="far fa-clock"></i> <?= Yii::t('app', 'Time'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'System Date'); ?></dt>
                    <dd><?= Yii::$app->formatter->asDate(\time()); ?></dd>
                    <dt><?= Yii::t('app', 'System Time'); ?></dt>
                    <dd><?= Yii::$app->formatter->asTime(\time()); ?></dd>
                    <dt><?= Yii::t('app', 'Timezone'); ?></dt>
                    <dd><?= \date_default_timezone_get(); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-network-wired"></i> <?= Yii::t('app', 'Network'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'Hostname'); ?></dt>
                    <dd><?= $provider->getHostname(); ?></dd>
                    <dt><?= Yii::t('app', 'Internal IP'); ?></dt>
                    <dd><?= $provider->getServerIP(); ?></dd>
                    <dt><?= Yii::t('app', 'External IP'); ?></dt>
                    <dd><?= $provider->getExternalIP(); ?></dd>
                    <dt><?= Yii::t('app', 'Port'); ?></dt>
                    <dd><?= $provider->getServerVariable('SERVER_PORT'); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="far fa-hdd"></i> <?= Yii::t('app', 'Software'); ?>
            </div>
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('app', 'Web Server'); ?></dt>
                    <dd><?= $provider->getServerSoftware(); ?></dd>
                    <dt><?= Yii::t('app', 'PHP Version'); ?></dt>
                    <dd><?= $provider->getPhpVersion(); ?></dd>
                    <dt><?= Yii::t('app', 'DB Type'); ?></dt>
                    <dd><?= $provider->getDbType(Yii::$app->db->pdo); ?></dd>
                    <dt><?= Yii::t('app', 'DB Version'); ?></dt>
                    <dd><?= $provider->getDbVersion(Yii::$app->db->pdo); ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users"></i> <?= Yii::t('app', 'Registered Users'); ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h4><?= User::find()->count(); ?></h4>
                    </div>
                    <div class="col-sm-8">
                        <?= Html::a(
    Yii::t('app', 'More info') . ' <i class="fa fa-arrow-circle-right"></i>',
    ['user/index'],
    ['class' => 'float-right btn btn-success']
); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="cpu-usage" class="card">
                <div class="card-header">
                    <i class="fas fa-microchip"></i> <?= Yii::t('app', 'CPU Usage'); ?>
                    <div class="btn-group btn-group-toggle float-right realtime" data-toggle="buttons">
                        <label class="btn btn-sm btn-secondary active" data-toggle="on">
                            <input type="radio" name="options" autocomplete="off">
                            <?= Yii::t('app', 'On'); ?>
                        </label>
                        <label class="btn btn-sm btn-secondary" data-toggle="off">
                            <input type="radio" name="options" autocomplete="off">
                            <?= Yii::t('app', 'Off'); ?>
                        </label>
                    </div>
                </div>
                <div class="card-body chart" style="height: 300px;"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card" id="memory-usage">
                <div class="card-header">
                    <i class="fas fa-memory"></i> <?= Yii::t('app', 'Memory Usage'); ?>
                    <div class="btn-group btn-group-toggle float-right realtime" data-toggle="buttons">
                        <label class="btn btn-sm btn-secondary active" data-toggle="on">
                            <input type="radio" name="options" autocomplete="off">
                            <?= Yii::t('app', 'On'); ?>
                        </label>
                        <label class="btn btn-sm btn-secondary" data-toggle="off">
                            <input type="radio" name="options" autocomplete="off">
                            <?= Yii::t('app', 'Off'); ?>
                        </label>
                    </div>
                </div>
                <div class="card-body chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
