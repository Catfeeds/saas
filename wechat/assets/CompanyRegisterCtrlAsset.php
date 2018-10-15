<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/8/8
 * Time: 10:27
 */
namespace  wechat\assets;
use yii\web\AssetBundle;

class CompanyRegisterCtrlAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/weui/dist/lib/weui.min.css",
        "plugins/weui/dist/css/jquery-weui.css",
        "plugins/company/css/reset.css",
        "plugins/company/css/register.css",
    ];
    public $js = [
//        "plugins/company/js/vue.js",
        "plugins/company/js/server.js",
        "plugins/weui/dist/lib/jquery-2.1.4.js",
        "plugins/weui/dist/lib/fastclick.js",
        "plugins/weui/dist/js/jquery-weui.js",
        "plugins/weui/dist/js/city-picker.min.js",
        "plugins/company/js/companyRegister.js",
    ];
    public $depends = [
        'wechat\assets\AngularAsset',
    ];
}