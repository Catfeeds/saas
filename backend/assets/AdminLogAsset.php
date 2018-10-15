<?php
/**
 *
 * User: 菅兵琪
 * Date: 2018/4/02
 * 员工管理插件引入
 * Time:
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminLogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
//        自定义员工管理angularJs
        "plugins/adminLog/js/adminLogController.js",

//
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\UserAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\AngularAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\ResetCtrlAsset',
        'backend\assets\BootstrapSelectAsset'
    ];
}
