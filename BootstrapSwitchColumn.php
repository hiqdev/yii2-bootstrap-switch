<?php
namespace hiqdev\bootstrap_switch;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class BootstrapSwitchColumn extends DataColumn
{
    use BootstrapSwitchTrait;

    public $format = 'raw';

    public function getDataCellValue ($model, $key, $index) {
        return BootstrapSwitch::widget([
            'name' => 'bsc_' . $key . $model->id,
            'pluginOptions' => ArrayHelper::merge($this->pluginOptions, [
                'state' => (boolean)parent::getDataCellValue($model, $key, $index),
                'onSwitchChange' => new JsExpression('function () { console.log("it`s work"); }'),
                'size' => 'mini'
            ]),
        ]);
    }
}