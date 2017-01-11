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
use Yii;
use yii\helpers\ArrayHelper;

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
        $modelPkName = reset($model::primaryKey());
        if ($this->url) {
            Yii::$app->view->registerJs(<<<JS
            var input = $('input[name="$itemName"]');
            input.on('switchChange.bootstrapSwitch', function(event, state) {
                var elem = $(this);
                var data = {};
                data['{$model->formName()}'] = {};
                data['{$model->formName()}']['$modelPkName'] = '$key';
                data['{$model->formName()}']['{$this->attribute}'] = state ? 1 : 0;
                jQuery.ajax({
                    'type': 'POST',
                    'url': '$this->url',
                    'data': data
                }).done(function(resp) {
                    var options = {
                        text: resp.text,
                        buttons: {
                            sticker: false
                        },
                        styling: 'bootstrap3'
                    };
                    if (resp.success === false) {
                        options.type = 'error';
                        options.icon = 'fa fa-fw fa-exclamation-triangle';
                        elem.bootstrapSwitch('toggleReadonly');
                    } else {
                        options.type = 'success';
                        options.icon = 'fa fa-fw fa-check-circle';
                    }
                    if (typeof PNotify != "undefined") {
                        new PNotify(options);
                    } else {
                        alert(resp.text);
                    }
                });
            });
JS
            );
        }

        return BootstrapSwitch::widget([
            'name' => $itemName,
            'options' => $this->options,
            'pluginOptions' => ArrayHelper::merge(['state' => (bool) parent::getDataCellValue($model, $key, $index)], $this->pluginOptions),
        ]);
    }
}
