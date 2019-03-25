<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;
use kartik\growl\Growl;

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
    const ERROR = 'error';
    const WARNING = 'warning';
    const SUCCESS = 'success';
    const INFO = 'info';

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        self::ERROR => Growl::TYPE_DANGER,
        self::WARNING => Growl::TYPE_WARNING,
        self::SUCCESS => Growl::TYPE_SUCCESS,
        self::INFO => Growl::TYPE_INFO,
    ];
    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap\Alert::closeButton]].
     */
    public $closeButton = [];

    public $alertIcon = [
        self::ERROR => 'glyphicon glyphicon-remove-sign',
        self::WARNING => 'glyphicon glyphicon-exclamation-sign',
        self::SUCCESS => 'glyphicon glyphicon-ok-sign',
        self::INFO => 'glyphicon glyphicon-info-sign',
    ];

    /**
     * {@inheritdoc}
     *
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        $flashes = Yii::$app->session->getAllFlashes();
        $appendClass = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array)$flash as $i => $message) {
                /* initialize css class for each alert box */
                $this->options['class'] = $this->alertTypes[$type] . $appendClass;

                /* assign unique id to each alert box */
                $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                echo Growl::widget([
                    'type' => $this->alertTypes[$type],
                    'icon' => $this->alertIcon[$type],
                    'closeButton' => $this->closeButton,
                    'body' => $message,
                    'pluginOptions' => ['delay' => $this->getDelay($type)],
                ]);
            }

            Yii::$app->session->removeFlash($type);
        }
    }

    /**
     * @param string $type type of flash message
     * @return bool|int return false if stop delay else time in ms.
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
