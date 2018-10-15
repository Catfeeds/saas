<?php
/* @var $this yii\web\View */
use backend\assets\HomePageAsset;
HomePageAsset::register($this);
$this->title = '系统主页';
?>
<style>
    body{
        overflow: hidden;
    }
</style>
<div class="container-fluid" ng-controller="homepageController">
    <div class="row">
        <div class="col-sm-12" style="padding: 0">
            <div class="col-sm-12 bgImg" style="padding: 0;background: url('/plugins/img/background.png')center center / cover no-repeat ;">
                <nav class="navbar clearFix" role="navigation" style="margin-bottom: 0">

                    <div class="userName fr" style="#z-index: 1">
                        <div class="nameImgBox cp"><div class="userNameImg">
<!--                                <img class="headImg" ng-src="{{listData.pic}}"/>-->
                                <img class="headImg"  ng-src="{{listData.pic!=null?listData.pic:'/plugins/checkCard/img/11.png'}}" />
<!--                                <img class="headImg" ng-if="listData.pic == null" ng-src="/plugins/checkCard/img/11.png"/>-->
                            </div></div>
                        <div class="userNameDetail cp">
                            <div>
                                <ul>
                                    <li class="NameMess ">
                                        <div class="userNameBigImg">
<!--                                            <img class="headImg" ng-src="{{listData.pic}}" style="border: solid 1px #fff">-->
                                            <img class="headImg" ng-src="{{listData.pic!=null?listData.pic:'/plugins/checkCard/img/11.png'}}" >
<!--                                            <img class="headImg" ng-if="listData.pic == null" ng-src="/plugins/checkCard/img/11.png"/>-->
                                        </div>
                            <span style="font-size: 15px" title="<?=isset(Yii::$app->user->identity)?backend\models\Admin::setAdminByEmployee():'';?>"><?=isset(Yii::$app->user->identity)?backend\models\AuthRole::getAdminRolesName():'';?>:
                                <br>
                                <?=isset(Yii::$app->user->identity)?\common\models\Func::phoneHide(backend\models\Admin::setAdminByEmployee(),'name'):'';?>
                            </span>
                                    </li>
                                    <li class="NameMessNews"><a href="#"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> 我的消息</a></li>
                                    <li class="personageSet"><a href="/personal-center"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 个人设置</a></li>

                                    <li class="exit" ng-click="signOut()"><span>退出</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
<!--                <img src="/plugins/img/bgtext.png" style="position: absolute;top: 50%;left: 50%;margin-top: -225px;margin-left: -167px;">-->
            </div>
        </div>
    </div>
</div>

