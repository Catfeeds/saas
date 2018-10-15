<?php

namespace backend\rbac\assets;

use yii\web\AssetBundle;
use backend\rbac\Config;

abstract class AssetAbstraction extends AssetBundle
{
    /**
     * @describe 初始化类
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     */
    public function init()
    {
        $this->sourcePath = Config::$sourcePath;
        $this->depends = Config::$assets;

        $js = $this->js;
        array_unshift($js, Config::$publicJs);
        $this->js = $js;

        $css = $this->css;
        array_unshift($css, Config::$publicCss);
        $this->css = $css;

        parent::init();
    }
}