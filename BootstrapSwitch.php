<?php
namespace hiqdev\bootstrap_switch;

use yii\base\InvalidConfigException;
use yii\widgets\InputWidget;

class BootstrapSwitch extends InputWidget
{
    public $type = BootstrapSwitchAsset::TYPE_CHECKBOX;

    public $items = [];

    public $inlineLabel = true;

    public $itemOptions = [];

    public $labelOptions = [];

    public $separator = " &nbsp;";

    public $containerOptions = ['class'=>'form-group'];

    public function init()
    {
        parent::init();
        if (empty($this->type) && $this->type !== BootstrapSwitchAsset::TYPE_CHECKBOX && $this->type !== BootstrapSwitchAsset::TYPE_RADIO) {
            throw new InvalidConfigException("You must define a valid 'type' which must be either 1 (for checkbox) or 2 (for radio).");
        }
        if ($this->type == BootstrapSwitchAsset::TYPE_RADIO) {
            if (empty($this->items) || !is_array($this->items)) {
                throw new InvalidConfigException("You must setup the 'items' array for the 'radio' type.");
            }
        }
        $this->registerClientScript();
        print $this->renderInput();
    }

    public function renderInput()
    {

    }

}