<?php

namespace hiqdev\bootstrap_switch;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

trait BootstrapSwitchTrait
{
    public $type = BootstrapSwitchAsset::TYPE_CHECKBOX;

    public $model;

    public $attribute;

    public $items = [];

    public $inlineLabel = true;

    public $itemOptions = [];

    public $labelOptions = [];

    public $separator = " &nbsp;";

    public $containerOptions = ['class'=>'form-group'];

    public $pluginOptions;

    public $clientEvents = [];

    public $checked = false;

    protected $selector;

    public function registerClientScript()
    {
        $view = $this->view;
        BootstrapSwitch::register($view);
        $this->pluginOptions['animate'] = ArrayHelper::getValue($this->pluginOptions, 'animate', true);
        $options = Json::encode($this->pluginOptions);
        $js[] = ";jQuery('$this->selector').bootstrapSwitch($options);";
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('$this->selector').on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
    }
}

