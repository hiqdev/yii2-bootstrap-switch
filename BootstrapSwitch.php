<?php

namespace hiqdev\bootstrap_switch;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class BootstrapSwitch extends InputWidget
{
    use BootstrapSwitchTrait;

    public function init()
    {
        parent::init();
        if ($this->type == BootstrapSwitchAsset::TYPE_RADIO) {
            if (empty($this->items) || !is_array($this->items)) {
                throw new InvalidConfigException('"$items" cannot be empty and must be of type array');
            }
            $name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;
            $this->selector = "input:radio[name=\"$name\"]";
        } else {
            $this->selector = "#{$this->options['id']}";
        }
    }

    public function run()
    {
        switch ($this->type) {
            case BootstrapSwitchAsset::TYPE_CHECKBOX:
                $this->renderCheckboxInput();
                break;
            case BootstrapSwitchAsset::TYPE_RADIO:
                $this->renderRadioInput();
                break;
        }

        $this->registerClientScript();
    }

    private function renderRadioInput()
    {
        $items = [];
        foreach ($this->items as $key => $item) {
            if (!is_array($item)) {
                $options = $this->options;
                $options['value'] = $key;
                $options['label'] = $item;
                $options['labelOptions'] = $this->labelOptions;
            } else {
                $options = ArrayHelper::getValue($item, 'options', []) + $this->options;
                $options['value'] = ArrayHelper::getValue($item, 'value');
                $options['label'] = ArrayHelper::getValue($item, 'label', false);
                $options['labelOptions'] = ArrayHelper::getValue($item, 'labelOptions', []) + $this->labelOptions;
            }
            if ($this->inline) {
                $options['container'] = '';
            }
            $items[] = $this->hasModel() ? Html::activeRadio($this->model, $this->attribute, $options)
                : Html::radio($this->name, $this->checked, $options);
        }
        $this->containerOptions['class'] = ArrayHelper::getValue($this->containerOptions, 'class', 'form-group');
        print Html::tag('div', implode($this->separator, $items), $this->containerOptions);
    }

    private function renderCheckboxInput()
    {
        if ($this->hasModel()) {
            $input = Html::activeCheckbox($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::checkbox($this->name, $this->checked, $this->options);
        }
        print $this->inlineLabel ? $input : Html::tag('div', $input);
    }
}