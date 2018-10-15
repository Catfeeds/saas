<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ClassTemplateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/classTemplate/css/classTemplate.css",
    ];
    public $js = [
        "plugins/classTemplate/js/classTemplate.js",
        "plugins/classTemplate/js/addTemplate.js",
        "plugins/classTemplate/js/updateTemplate.js",
        "plugins/classTemplate/js/customTemplate.js"
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
