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

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class LabeledAjaxSwitch.
 */
class LabeledAjaxSwitch extends AjaxBootstrapSwitch
{
    /**
     * @var array array of labels of each switch state
     * Key - switch state
     * Value - array of configuration compatible with [[yii\helpers\Html::tag()]], closure or text
     */
    public $labels = [];

    public function init()
    {
        parent::init();

        $this->setInputLabels();
    }

    protected function setInputLabels()
    {
        $labels = [];
        foreach ($this->labels as $key => $label) {
            if (is_string($label)) {
                $options = ['content' => $label];
            } elseif ($label instanceof \Closure) {
                $options = call_user_func($label, $this);
            } else {
                $options = $label;
            }

            $tag = ArrayHelper::remove($options, 'tag', 'span');
            $content = ArrayHelper::remove($options, 'content');
            $options = array_merge(['data' => ['active-state' => $key]], $options);

            $labels[] = Html::tag($tag, $content, $options);
        }

        $this->options['label'] = implode('', $labels);
    }
}
