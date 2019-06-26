<?php

namespace app\widgets;

use Yii;
use yii\bootstrap4\Widget;
use kartik\growl\Growl;
use yii\web\Session;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', 'This is the "Error" message');
 * \Yii::$app->session->setFlash('warning', 'This is the "Warning" message');
 * \Yii::$app->session->setFlash('success', 'This is the "Success" message');
 * \Yii::$app->session->setFlash('info', 'This is the "Info" message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['First error message', 'Second error message']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alert extends Widget
{
    const ERROR   = 'error';
    const WARNING = 'warning';
    const SUCCESS = 'success';
    const INFO    = 'info';

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        self::ERROR   => Growl::TYPE_DANGER,
        self::WARNING => Growl::TYPE_WARNING,
        self::SUCCESS => Growl::TYPE_SUCCESS,
        self::INFO    => Growl::TYPE_INFO,
    ];

    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap\Alert::closeButton]].
     */
    public $closeButton = [];

    public $alertIcon = [
        self::ERROR   => 'fas fa-times-circle',
        self::WARNING => 'fas fa-exclamation-circle',
        self::SUCCESS => 'fas fa-check-circle',
        self::INFO    => 'fas fa-info-circle',
    ];

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     * @return string|void
     */
    public function run()
    {
        $flashes     = Yii::$app->session->getAllFlashes();
        $appendClass = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array) $flash as $i => $message) {
                /* initialize css class for each alert box */
                $this->options['class'] = $this->alertTypes[$type] . $appendClass;

                /* assign unique id to each alert box */
                $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                echo Growl::widget([
                    'type'          => $this->alertTypes[$type],
                    'icon'          => $this->alertIcon[$type],
                    'closeButton'   => $this->closeButton,
                    'body'          => $message,
                    'pluginOptions' => ['delay' => $this->getDelay($type)],
                ]);
            }

            Yii::$app->session->removeFlash($type);
        }
    }

    /**
     * Return delay time (ms) if parameter Session::setFlash(... $removeAfterAccess) set in false.
     * If parameter set in true (default value) skip return time and return false.
     *
     * @param string $type type of flash message
     *
     * @return bool|int
     *
     * @see Session::setFlash()
     */
    private function getDelay($type)
    {
        if (Yii::$app->session->get(Yii::$app->session->flashParam)[$type]) {
            return false;
        }

        switch ($type) {
            case self::ERROR:
                return 10000;
            case self::WARNING:
                return 7000;
            case self::SUCCESS:
                return 5000;
            case self::INFO:
            default:
                return 3000;
        }
    }
}
