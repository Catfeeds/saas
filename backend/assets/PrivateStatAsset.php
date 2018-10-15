<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PrivateStatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/privateStat/css/privateStat.css",
    ];
    public $js = [
        //'plugins/admin/js/echarts.js',
        "plugins/privateStat/js/echarts.js",
        "plugins/privateStat/js/privateStat.js",
        //"plugins/privateStat/js/sellStatCtrl.js",
        //"plugins/privateStat/js/classStatCtrl.js",
        "plugins/publicMemberInfo/publicMemberInfo.js"
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
