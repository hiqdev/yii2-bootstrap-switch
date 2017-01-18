<?php
/**
 * Yii2 Bootstrap Switch
 *
 * @link      https://github.com/hiqdev/yii2-bootstrap-switch
 * @package   yii2-bootstrap-switch
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\bootstrap_switch\traits;

use hiqdev\bootstrap_switch\assets\BootstrapSwitchAsset;
use hiqdev\bootstrap_switch\BootstrapSwitch;
use hiqdev\higrid\FeaturedColumnTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class BootstrapSwitchTrait.
 */
trait BootstrapSwitchTrait
{
    public $type = BootstrapSwitch::TYPE_CHECKBOX;

    public $inlineLabel = true;

    use FeaturedColumnTrait {
        registerClientScript as traitRegisterClientScript;
    }

    /**
     * @var array the radio button options to render. The syntax is:
     * ```
     *  'items' => [
     *      [
     *          'label' => 'Label of item',
     *          'value' => 20,
     *          'options' => [],
     *          'labelOptions' => []
     *      ]
     * ]
     * ```
     * - label: string the label of item. If empty, will not be displayed.
     * - value: string the value of the item.
     * - options: HTML attributes of the item.
     * - labelOptions: HTML attributes of the label.
     *
     * You can also specify items like this:
     * ```
     *  'items' => [
     *      10 => 'Label of Item',
     *      [
     *          // ...
     *      ]
     *  ]
     * ```
     * On this case, the key of the array will be used as a value and the value of the array as a label.
     */
    public $items = [];

    public $itemOptions = [];

    public $labelOptions = [];

    public $separator = ' &nbsp;';

    public $containerOptions = ['class' => 'form-group'];

    public $pluginOptions = [];

    public $checked = false;

    public $inline = true;

    protected $selector;

    public function registerClientScript()
    {
        $view = Yii::$app->view;
        BootstrapSwitchAsset::register($view);
        $this->pluginOptions['animate'] = ArrayHelper::getValue($this->pluginOptions, 'animate', true);
        $this->pluginOptions['size'] = ArrayHelper::getValue($this->pluginOptions, 'size', 'mini');
        $options = Json::encode($this->pluginOptions);
        if ($this->selector) {
            $view->registerJs(";$('{$this->selector}').bootstrapSwitch({$options});");
        }
        $this->traitRegisterClientScript();
    }
}
