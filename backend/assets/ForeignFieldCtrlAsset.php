<?php
/**
 * Created by PhpStorm.
 * User: cehngliming
 * Date: 2018/7/20
 * Time: 11:09
 * content:场地管理
 */
namespace backend\assets;

use yii\web\AssetBundle;

class ForeignFieldCtrlAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/wcheck-card/css/style.css",
        "plugins/foreignField/css/foreignField.css",
    ];
    public $js = [
//        场地管理
        "plugins/foreignField/js/foreignFieldController.js",
    ];
    public $depends = [
        'backend\assets\DatesAsset',
        'backend\assets\TimePlugInAsset',
        'backend\assets\BootstrapSelectAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\ResetCtrlAsset',
    ];
}