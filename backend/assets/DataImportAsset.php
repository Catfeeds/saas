<?php
namespace backend\assets;

use yii\web\AssetBundle;

class DataImportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/data-import/css/index.css",
    ];
    public $js = [
        "plugins/data-import/js/dataImportController.js",
    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\CustomAsset',
        'backend\assets\AngularAsset',
        'backend\assets\DatesAsset',
        'backend\assets\NewDateAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\BootstrapSelectAsset'
    ];
}