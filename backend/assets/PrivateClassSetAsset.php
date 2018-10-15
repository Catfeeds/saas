<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PrivateClassSetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/privateClassSet/css/privateClassSet.css",
    ];
    public $js = [
        "plugins/privateClassSet/js/jquery-ui.js",
        "plugins/privateClassSet/js/classSetCtrl.js",
        "plugins/privateClassSet/js/fileSetCtrl.js",
        "plugins/privateClassSet/js/assessCtrl.js",
        "plugins/privateClassSet/js/goalCtrl.js",
        "plugins/privateClassSet/js/qaCtrl.js",
        "plugins/privateClassSet/js/followWayCtrl.js",
        "plugins/privateClassSet/js/sourceCtrl.js",
        "plugins/privateClassSet/js/clientCtrl.js",
        "plugins/privateClassSet/js/followStatusCtrl.js",
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\AngularAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\ResetCtrlAsset',
        'backend\assets\CommonAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\InputCheckAsset',
        'backend\assets\IcheckAsset',
        'backend\assets\SweetAlertAsset',
        'backend\assets\BootstrapSelectAsset'
    ];
}
