<?php
use backend\assets\MemberShipAsset;
MemberShipAsset::register($this);
$this->title = '新会员入会-主页';
?>
<div class="container-fluid pd0" ng-controller="memberShipController" style="height: 100%;">
    <div class="col-sm-12 pd0 indexBgBox">
        <img src="/plugins/memberShip/images/bg.png" width="1200px" style="position: absolute;bottom: 0;opacity: .1;">
        <div class="col-sm-8 col-sm-offset-2 positionRelative">
            <div class="loader indexAnimateBox">
                <div class="loader-inner ball-scale-multiple">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <h1 class="logo">
                <img src="/plugins/memberShip/images/index-logo.png" width="200px">
            </h1>
            <p class="text-center indexTitle">迈步智能健身购卡服务</p>
            <p class="text-center indexTitle2">PURCHASE&nbsp;&nbsp;SERVICE</p>
            <div class="col-sm-10 col-sm-offset-1" style="margin-top: 180px;">
                <a class="btn btn-white leftBtn" ng-click="old()">
                    <span class="fa fa-user"></span>
                    有卡会员购卡
                </a>
                <a class="btn btn-white rightBtn" ng-click="new()">
                    <span class="fa fa-user-plus"></span>
                    无卡会员购卡
                </a>
            </div>
        </div>
    </div>
</div>
