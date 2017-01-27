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

use hiqdev\higrid\DataColumn;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
                'state' => (bool) parent::getDataCellValue($model, $key, $index),
            ], $this->pluginOptions),
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
}
