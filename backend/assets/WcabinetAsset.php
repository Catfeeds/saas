<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class WcabinetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/wcheck-card/css/style.css",
        "plugins/Wcabinet/css/style.css",
    ];
    public $js = [
        "plugins/Wcabinet/js/cabinetController.js",
        "plugins/wcheck-card/js/common.js"
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\FlotAsset',
        'backend\assets\PaceAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\AngularAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\BootstrapSelectAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\SweetAlertAsset',
    ];
}