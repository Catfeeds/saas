<?php
/**
 * Created by PhpStorm.
 * User: 张亚鑫
 * Date: 2017/12/7
 * 私课小团体课页面
 * Time: 17:50
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PrivateLessonGroupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/privateLessonGroup/css/index.css",
        //指纹css
        "plugins/privateLessonGroup/css/box.css",
        "plugins/privateLessonGroup/css/dhtmlx.css",
    ];
    public $js = [
        "plugins/privateLessonGroup/js/privateLessonGroup.js",
        "plugins/privateLessonGroup/js/addManyClassLessonCtrl.js",
        "plugins/privateLessonGroup/js/privateLessonGroupController.js",
        //指纹js
        "plugins/privateLessonGroup/js/main.js",
        "plugins/privateLessonGroup/js/fingerprint.js",
        "plugins/privateLessonGroup/js/baseMoth.js",
        "plugins/privateLessonGroup/js/dhtmlxCommon.js",
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\TimePlugInAsset',
        'backend\assets\AngularAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\IcheckAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\ResetCtrlAsset',
        'backend\assets\InputCheckAsset',
        'backend\assets\BootstrapSelectAsset'
    ];
}
