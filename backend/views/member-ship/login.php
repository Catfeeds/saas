<?php
use backend\assets\MemberShipAsset;
MemberShipAsset::register($this);
$this->title = '新会员入会-登录';
?>
<div class="container-fluid pd0" ng-controller="memberShipController" style="height: 100%;">
    <?=$this->render('@app/views/common/csrf.php')?>
    <div class="col-sm-12 pd0 registerBgBox">
        <img src="/plugins/memberShip/images/bg.png"
             width="1200px"
             style="position: absolute;bottom: 0;opacity: .25;">
        <div class="col-sm-8 col-sm-offset-2 bgBox">
            <h1 class="logo">
                <img src="/plugins/memberShip/images/logo.png" width="200px">
                <p class="logoWord">有卡会员验证</p>
                <span class="delectBtn pull-right old" ng-click="new()"><span class="fa fa-user-plus"></span>&nbsp;无卡会员注册</span>
            </h1>
            <div class="col-sm-6 col-sm-offset-3">
                <form class="form-horizontal mrt80" style="margin-top: 140px;">
                    <div class="form-group text-center registerForm">
                        <label>手机号码</label>
                        <input type="number" class="form-control" ng-model="oldMemberMobile">
                    </div>
                    <div class="form-group text-center registerForm mrt80 pd0">
                        <label>验&nbsp;&nbsp;证&nbsp;&nbsp;码</label>
                        <input type="text" class="form-control w180" ng-model="oldMemberCode">
                        <input class="btn btn-warning codeBTN"
                               style="width: 124px!important;color: #fff!important;"
                               readonly
                               ng-click="getCardCode()"
                               ng-model="paracont"
                               ng-disabled="disabled"/>
                    </div>
                    <div class="form-group col-sm-12 mrt80 positionRelative">
                        <button class="formSubmit btn btn-warning center-block" ng-click="postOldMemberInfo()">去买卡</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
