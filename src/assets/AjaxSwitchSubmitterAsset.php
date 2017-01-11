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

class AjaxSwitchSubmitterAsset extends AssetBundle
{
    public $sourcePath = '@vendor/hiqdev/yii2-bootstrap-switch/src/assets/js';

    public $js = [
        'ajaxSwitchSubmitter.js',
    ];

    public $depends = [
        BootstrapSwitchAsset::class,
    ];
}
