<?php
/**
 * Created by PhpStorm.
 * User: 李广杨
 * Date: 2017/5/11
 * Time: 14:47
 * 商品管理
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class  ShopAsset extends AssetBundle
{
    /**
     * @var string 商品管理
     */
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/Shop/css/style.css",
    ];
    public $js = [
        "plugins/Shop/js/Shop.js",
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\AngularAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
    ];
}