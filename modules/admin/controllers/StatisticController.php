<?php

namespace app\modules\admin\controllers;

use Probe\Provider\AbstractProvider;
use Probe\ProviderFactory;
use Yii;
use yii\web\Response;

/**
 * Class StatisticController.
 */
class StatisticController extends BaseController
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $provider = ProviderFactory::create();
        if ($provider instanceof AbstractProvider) {
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
            }

            return $this->render('index', ['provider' => $provider]);
        }

        return $this->render('fail');
    }
}
