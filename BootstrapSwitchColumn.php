<?php

namespace hiqdev\bootstrap_switch;

use Yii;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class BootstrapSwitchColumn extends DataColumn
{
    use BootstrapSwitchTrait;

    public $url;

    public $ajaxSuccess;

    public $ajaxFail;

    public $ajaxAlways;

    public $format = 'raw';

    public function getDataCellValue($model, $key, $index)
    {
        $itemName = 'bss_' . $this->attribute . '_' . $key;
        if ($this->url) {
            Yii::$app->view->registerJs(<<<JS
            $('input[name="$itemName"]').on('switchChange.bootstrapSwitch', function(event, state) {
                jQuery.ajaxSetup({
                    type: 'POST'
                });
                jQuery.post('$this->url', {
                    pk: '$key',
                    name: '$this->attribute',
                    value: state ? 1 : 0
                });
            });
JS
            );
        }
        return BootstrapSwitch::widget([
            'name' => $itemName,
            'options' => $this->options,
            'pluginOptions' => ArrayHelper::merge(['state' => (boolean)parent::getDataCellValue($model, $key, $index)], $this->pluginOptions),
        ]);
    }
}