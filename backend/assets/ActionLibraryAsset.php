<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ActionLibraryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/actionLibrary/css/actionLibrary.css",
    ];
    public $js = [

        "plugins/actionLibrary/js/actionLibrary.js",
        "plugins/actionLibrary/js/createCtrl.js",
        "plugins/actionLibrary/js/updateCtrl.js"

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
