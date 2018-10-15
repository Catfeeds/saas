<?php
use backend\assets\MemberShipAsset;
MemberShipAsset::register($this);
$this->title = '新会员入会-注册';
?>
<div class="container-fluid pd0" ng-controller="memberShipController" style="height: 100%;">
    <?=$this->render('@app/views/common/csrf.php')?>
    <div class="col-sm-12 pd0 registerBgBox text-center">
        <img src="/plugins/memberShip/images/bg.png"
             width="1200px"
             style="position: absolute;bottom: 0;opacity: .25;">
            <div style="font-size: 50px;color: wheat;margin-top: 350px">
                <span>此界面已暂停服务，请使用相关应用程序前去注册</span>
            </div>
<!--        <div class="col-sm-8 col-sm-offset-2 bgBox">-->
<!--            <h1 class="logo">-->
<!--                <img src="/plugins/memberShip/images/logo.png" width="200px">-->
<!--                <p class="logoWord">填写资料</p>-->
<!--                <span class="delectBtn pull-right old" ng-click="old()"><span class="fa fa-user"></span>&nbsp;有卡会员登录</span>-->
<!--            </h1>-->
<!--            <form class="form-inline mrt80">-->
<!--                <div class="form-group col-sm-6 text-center registerForm">-->
<!--                    <label>会员姓名</label>-->
<!--                    <input type="text"-->
<!--                           class="form-control"-->
<!--                           ng-model="memberName"-->
<!--                           id="memberName">-->
<!--                </div>-->
<!--                <div class="form-group col-sm-6 text-center registerForm">-->
<!--                    <label>手机号码</label>-->
<!--                    <input type="number" class="form-control mobileInput" ng-model="memberMobile">-->
<!--                </div>-->
<!--                <div class="form-group col-sm-6 text-center registerForm mrt80">-->
<!--                    <label>会员性别</label>-->
<!--                    <select ng-model="memberSex" id="memberSex">-->
<!--                        <option value="">请选择</option>-->
<!--                        <option value="1">男</option>-->
<!--                        <option value="2">女</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="form-group col-sm-6 text-center registerForm mrt80">-->
<!--                    <label>验&nbsp;&nbsp;证&nbsp;&nbsp;码</label>-->
<!--                    <input type="text" class="form-control w180" ng-model="memberCode">-->
<!--                    <input class="btn btn-warning codeBTN"-->
<!--                           style="width: 124px!important;color: #fff!important;"-->
<!--                           readonly-->
<!--                           ng-click="getCode()"-->
<!--                           ng-model="paracont"-->
<!--                           ng-disabled="disabled"/>-->
<!--                </div>-->
<!--                <div class="form-group col-sm-6 text-center registerForm mrt80">-->
<!--                    <label>身份证号</label>-->
<!--                    <input type="text"-->
<!--                           class="form-control"-->
<!--                           ng-model="memberIDcard"-->
<!--                           id="memberIDcard">-->
<!--                </div>-->
<!--<!--                <div class="form-group col-sm-6 text-center registerForm mrt80">-->
<!--<!--                    <label>设置密码</label>-->
<!--<!--                    <input type="password" class="form-control" id="">-->
<!--<!--                </div>-->
<!--                <div class="form-group col-sm-12 mrt80 positionRelative">-->
<!--                    <button class="formSubmit btn btn-warning center-block" ng-click="postMemberInfo()">去买卡</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
    </div>
</div>