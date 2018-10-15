<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ActionCategoryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/actionCategory/css/actionCategory.css",
        "plugins/actionCategory/css/jquery.treegrid.css",
    ];
    public $js = [
        "plugins/actionCategory/js/actionCategory.js",
        "plugins/actionCategory/js/jquery.treegrid.min.js",
         "plugins/actionCategory/js/jquery.treegrid.js",


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
