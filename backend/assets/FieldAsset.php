<?php

/**
 * 验卡管理
 */
namespace backend\assets;

use yii\web\AssetBundle;

class FieldAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/wcheck-card/css/style.css",
        "plugins/checkCard/css/style.css",
        "plugins/checkCard/css/courseList.css",
    ];
    public $js = [
//        验卡页面js
        "plugins/wcheck-card/js/fieldController.js",
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\AngularAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\ResetCtrlAsset',
    ];
}