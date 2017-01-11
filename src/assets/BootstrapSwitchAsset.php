<?php
/**
 * Yii2 Bootstrap Switch
 *
 * @link      https://github.com/hiqdev/yii2-bootstrap-switch
 * @package   yii2-bootstrap-switch
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\bootstrap_switch\assets;

use yii\web\AssetBundle;

class BootstrapSwitchAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-switch/dist';
    public $css = [
        'css/bootstrap3/bootstrap-switch.css',
    ];
    public $js = [
        'js/bootstrap-switch.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
