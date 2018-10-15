<?php
/**
 * Created by PhpStorm.
 * User: 梁咳咳
 * Date: 2017/3/16
 * Time: 15:31
 */
use yii\helpers\Html;
use backend\assets\AngularAsset;
use backend\assets\IndexAsset;
use backend\assets\ToastrAsset;

AngularAsset::register($this);
ToastrAsset::register($this);
IndexAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        /*.navbar-static-side {*/
            /*background: none;*/
        /*}*/
        .nav-header{
            background: none;
        }
    </style>
</head>
<body ng-app="App" class="fixed-sidebar full-height-layout gray-bg"
      style='overflow:hidden;font-family: "Microsoft YaHei", 微软雅黑, "Helvetica Neue", Helvetica, Tahoma, Arial, "WenQuanYi Micro Hei", sans-serif'
      ;>
<?php $this->beginBody() ?>
<!--左侧导航开始-->
<div id="wrapper" class="wrapperBackgroundColor" >
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side animated fadeInLeft" role="navigation" id="navLeft"
        ng-cloak ng-controller="adminCtrl">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav sideMenuAll" id="side-menu">
                <li ng-repeat="(index, item) in listItemsTitleData" ng-click="bigLi(index)" ng-mouseenter="show(index)" ng-mouseleave="hide(indx)" class='hidden-folded padder m-t m-b-sm text-muted text-xs marginLeft0 christmas' ng-if='item.id == idItems.itemId'>
                    <a>
                        <i class="{{item.icon}}"></i>
                        <span class='nav-label fontSize12 templetName'>{{item.name}}</span>
                    </a>
                    <ul ng-show="item.isErUl" class='nav nav-second-level' ng-class="{title: isSmall}">
                        <li ng-repeat="items in item.module">
                            <a href="/{{items.route}}">
                                <i class="{{items.icon}}"></i><strong>{{items.name}}</strong>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="" class="gray-bg dashbard-1 pageWrappersss" >
        <?= $content ?>
    </div>
    <!--右侧部分结束-->
</div>
<?= $this->render('@app/views/common/loading.php'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

