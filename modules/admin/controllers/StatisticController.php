<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Response;
use Probe\ProviderFactory;

/**
 * Class StatisticController
 * @package app\modules\admin\controllers
 */
class StatisticController extends BaseController
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $provider = ProviderFactory::create();
        if ($provider) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($key = Yii::$app->request->get('data')) {
                    switch ($key) {
                        case 'cpu_usage':
                            return $provider->getCpuUsage();
                        case 'memory_usage':
                            return ($provider->getTotalMem() - $provider->getFreeMem()) / $provider->getTotalMem();
                    }
                }
            } else {
                return $this->render('index', ['provider' => $provider]);
            }
        }
        return $this->render('fail');
    }
}
