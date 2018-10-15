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
</head>
<body ng-app="App" class="fixed-sidebar full-height-layout gray-bg bodyApp" >
<?php $this->beginBody() ?>

<!--左侧导航开始-->
<div id="wrapper" class="wrapperBackgroundColor" ng-controller="adminCtrl" >
    <!--左侧导航开始- navbar-static-side -->
    <nav class="navbar-default navbar-static-side animated fadeInLeft" role="navigation" id="navLeft"
         ng-cloak>
        <!--修改样式class="nav-close"-->
        <!--        <div ><i class="fa fa-times-circle"></i>-->
        <!--        </div>-->
        <div class="sidebar-collapse">
            <ul class="nav sideMenuAll" id="side-menu">
                <li ng-repeat="(index, item) in listItemsTitleData" ng-click="bigLi(index)" ng-mouseenter="show(index)" ng-mouseleave="hide(indx)" class='hidden-folded padder m-t m-b-sm text-muted text-xs marginLeft0 christmas'>
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
    <div id="page-wrapper" class="gray-bg dashbard-1 pageWrappersss" >
        <div class="row border-bottom pageWrapperBottom" >
            <nav class="navbar clearFix pageWrapperBottomNav" role="navigation">
                                <div class="navbar-header">
                                    <button type="button" ng-disabled="!isBtn" class="navbar-minimalize minimalize-styl-2 btn btn-info" ng-click="bigSmall()">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </div>
                <div class="userName fr userNamess" >
                    <div class="nameImgBox cp">
                        <div class="userNameImg">
                            <img  ng-src="{{listData.pic != null ?listData.pic :'/plugins/checkCard/img/11.png'}}" class="headImg imgBorder" />
                            <!--                            <img ng-src="/plugins/checkCard/img/11.png" class="headImg " ng-if="listData.pic == null || listData.pic ==undefined" />-->
                        </div>
                    </div>
                    <div class="userNameDetail cp">
                        <div>
                            <ul>
                                <li class="NameMess ">
                                    <div class="userNameBigImg">
                                        <img ng-src="{{listData.pic ?listData.pic :'/plugins/checkCard/img/11.png'}}" class="headImg imgBorder"/>
                                        <!--                                        <img src="/plugins/checkCard/img/11.png" class="headImg imgBorder" ng-if="listData.pic == null"  />-->
                                    </div>
                            <span class="fontSize" title="<?= isset(Yii::$app->user->identity) ? backend\models\Admin::setAdminByEmployee() : ''; ?>">
                                <?= isset(Yii::$app->user->identity) ? backend\models\AuthRole::getAdminRolesName() : ''; ?>
                                :<br>
                                <?=isset(Yii::$app->user->identity)?\common\models\Func::phoneHide(backend\models\Admin::setAdminByEmployee(),'name'):'';?>
                            </span>
                                </li>
                                <li class="NameMessNews"><a href="#"><span class="glyphicon glyphicon-envelope"
                                                                           aria-hidden="true"></span> 我的消息</a></li>
                                <li class="personageSet"><a href="/personal-center"><span
                                            class="glyphicon glyphicon-cog" aria-hidden="true"></span> 个人设置</a></li>
                                <li class="exit"  ng-click="signOut()"><span>退出</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <?= $content ?>
    </div>
    <!--右侧部分结束-->
</div>
<?= $this->render('@app/views/common/loading.php'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

