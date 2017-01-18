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

use hiqdev\bootstrap_switch\assets\AjaxSwitchSubmitterAsset;

/**
 * Class AjaxBootstrapSwitch
 * @package hiqdev\bootstrap_switch
 */
class AjaxBootstrapSwitch extends BootstrapSwitch
{
    /**
     * @var string
     */
    public $url;

    protected function renderCheckboxInput()
    {
        $this->options = array_merge([
            'data' => [
                'bootstrap-switch-ajax' => true,
                'form-name' => $this->model->formName(),
                'primary-key' => reset($this->model->primaryKey()),
                'key' => $this->model->getPrimaryKey(),
                'url' => $this->url,
                'attribute' => $this->attribute,
            ],
        ], $this->options);

        return parent::renderCheckboxInput();
    }

    public function registerClientScript()
    {
        parent::registerClientScript();

        AjaxSwitchSubmitterAsset::register($this->view);
    }
}
