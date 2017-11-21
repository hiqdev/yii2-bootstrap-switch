<?php
/**
 * Yii2 Bootstrap Switch
 *
 * @link      https://github.com/hiqdev/yii2-bootstrap-switch
 * @package   yii2-bootstrap-switch
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\bootstrap_switch;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use hiqdev\higrid\DataColumn;

class BootstrapSwitchColumn extends DataColumn
{
    /**
     * @var string
     */
    public $url;

    /**
     * {@inheritdoc}
     */
    public $format = 'raw';

    /**
     * @var array options that will be passed in the `pluginOptions`
     * field of [[BootstrapSwitch]] configuration
     */
    public $pluginOptions = [];

    /**
     * @var array options that will be passed in the [[BootstrapSwitch]] configuration
     */
    public $switchOptions = [];

    /**
     * @param ActiveRecord $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    public function getDataCellValue($model, $key, $index)
    {
        return Yii::createObject($this->getWidgetOptions($model, $key, $index))->run();
    }

    /**
     * @param ActiveRecord $model
     * @param mixed $key
     * @param int $index
     * @return array
     */
    protected function getWidgetOptions($model, $key, $index)
    {
        $options = [
            'class' => BootstrapSwitch::class,
            'name' => 'bss_' . $this->attribute . '_' . $key,
            'model' => $model,
            'attribute' => $this->attribute,
            'pluginOptions' => ArrayHelper::merge([
                'state' => (bool)parent::getDataCellValue($model, $key, $index),
            ], $this->getPluginOptions($model, $key, $index)),
            'options' => [
                'id' => 'bss_' . $this->attribute . '_' . $key,
                'label' => false,
            ],
        ];

        if ($this->url) {
            $options['class'] = AjaxBootstrapSwitch::class;
            $options['url'] = $this->url;
        }

        return array_merge($options, $this->switchOptions);
    }

    /**
     * @param $model
     * @param $key
     * @param $index
     * @return array
     */
    protected function getPluginOptions($model, $key, $index)
    {
        $result = [];
        foreach ($this->pluginOptions as $option => $value) {
            if (is_callable($value)) {
                $result[$option] = call_user_func($value, $model, $key, $index, $this);
            } elseif (is_callable($value)) {
                $result[$option] = $value;
            }
        }

        return $result;
    }
}
