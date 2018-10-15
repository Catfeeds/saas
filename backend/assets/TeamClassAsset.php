<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * 团课统计- 团课统计、课程环比 - 最受欢迎教练、最受欢迎时段、最受欢迎课程、课程对比
 * @author zhujunzhe@itsports.club
 * @create 2018/1/26 am
 */
class TeamClassAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "plugins/teamClass/css/style.css"
    ];
    public $js = [
        "plugins/teamClass/js/teamClassCtrl.js"

    ];
    public $depends = [
        'backend\assets\AdminAsset',
        'backend\assets\AngularAsset',
        'backend\assets\LaddaAsset',
        'backend\assets\CommonAsset',
        'backend\assets\DatesAsset',
        'backend\assets\BootstrapSelectAsset'
    ];
}
