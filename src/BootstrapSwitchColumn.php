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

use hipanel\grid\DataColumn;
use hiqdev\bootstrap_switch\assets\AjaxSwitchSubmitterAsset;
use hiqdev\bootstrap_switch\traits\BootstrapSwitchTrait;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class BootstrapSwitchColumn extends DataColumn
{
    use BootstrapSwitchTrait;

    public $url;

    public $ajaxSuccess;

    public $ajaxFail;

    public $ajaxAlways;

    public $format = 'raw';

    /**
     * @param ActiveRecord $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    public function getDataCellValue($model, $key, $index)
    {
        AjaxSwitchSubmitterAsset::register($this->grid->view);

        $options = [];
        $primaryKey = reset($model->primaryKey());

        if ($this->url) {
            $options['class'][] = 'bootstrap-switch-ajax';
            $options['data'] = [
                'form-name' => $model->formName(),
                'primary-key' => $primaryKey,
                'key' => $key,
                'url' => $this->url,
                'attribute' => $this->attribute,
            ];
        }

        return BootstrapSwitch::widget([
            'name' => 'bss_' . $this->attribute . '_' . $key,
            'options' => ArrayHelper::merge($this->options, $options),
            'pluginOptions' => ArrayHelper::merge([
                'state' => (bool) parent::getDataCellValue($model, $key, $index),
            ], $this->pluginOptions),
        ]);
    }
}
