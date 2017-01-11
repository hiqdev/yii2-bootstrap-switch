<?php

namespace hiqdev\bootstrap_switch\assets;

use yii\web\AssetBundle;

class AjaxSwitchSubmitterAsset extends AssetBundle
{
    public $sourcePath = '@vendor/hiqdev/yii2-bootstrap-switch/src/assets/js';

    public $js = [
        'ajaxSwitchSubmitter.js'
    ];

    public $depends = [
        BootstrapSwitchAsset::class
    ];
}
