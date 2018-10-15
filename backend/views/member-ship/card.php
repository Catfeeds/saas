<?php
use backend\assets\MemberShipAsset;
MemberShipAsset::register($this);
$this->title = '新会员入会-选择卡种';
?>
<div class="container-fluid pd0" ng-controller="memberShipController" style="height: 100%;">
    <?=$this->render('@app/views/common/csrf.php')?>
    <div class="col-sm-12 pd0 cardBgBox" style="overflow: hidden">
        <img src="/plugins/memberShip/images/card-bg.png" width="1900" style="position: absolute">
        <div class="col-sm-8 col-sm-offset-2 positionRelative">
            <span class="nameTitleUser pull-right">尊敬的{{memberLoginName}},您好！</span>
            <span class="glyphicon glyphicon-home homeBtn pull-right" ng-click="home()"></span>
            <span class="glyphicon glyphicon-remove delectBtn pull-right" ng-click="close()"></span>
            <div class="col-sm-9">
                <ul class="ulCardBox col-sm-12">
                    <li class="cardCategoryTitle" style="display: inline-block">
                        <div class="cardCategoryTitleBox addCardCategoryTitleBox" style="display: inline-block" ng-click="cardTypeYoga()">瑜伽</div>
                    </li>
                    <li class="cardCategoryTitle" style="display: inline-block">
                        <div class="cardCategoryTitleBox" style="display: inline-block" ng-click="cardTypeBody()">健身</div>
                    </li>
                    <li class="cardCategoryTitle" style="display: inline-block">
                        <div class="cardCategoryTitleBox" style="display: inline-block" ng-click="cardTypeDance()">舞蹈</div>
                    </li>
                    <li class="cardCategoryTitle" style="display: inline-block">
                        <div class="cardCategoryTitleBox" style="display: inline-block" ng-click="cardTypeMore()">综合</div>
                    </li>
                    <li class="cardCategoryTitle" style="display: inline-block">
                        <div class="cardCategoryTitleBox" style="display: inline-block"  ng-click="cardTypeVip()">VIP</div>
                    </li>
                </ul>
            </div>
            <div class="col-sm-12 bigbox">
                <div class="noCardInfoShow col-sm-12 text-center">
                    <img src="/plugins/memberShip/images/nodata.png" width="260" style="margin-top: 80px;">
                    <p style="font-size: 24px;margin-top: 10px;">抱歉，暂无该类型卡种信息</p>
                </div>
                <div class="col-sm-4"
                     style="margin-top: 60px;cursor: pointer;"
                     ng-repeat="card in cardList"
                     ng-click="choiceBuyCard(card)">
                    <div class="col-sm-10 col-sm-offset-1 h180">
                        <div class="col-sm-12 cardImg">
                            <p class="imgWord">会&nbsp;员&nbsp;卡</p>
                            <p class="imgWord2">MemberCard</p>
                            <p class="text-center imgWord3">
                                <span ng-if="card.card_type == 1">瑜伽卡</span>
                                <span ng-if="card.card_type == 2">健身卡</span>
                                <span ng-if="card.card_type == 3">舞蹈卡</span>
                                <span ng-if="card.card_type == 4">综合卡</span>
                                <span ng-if="card.card_type == 5">VIP卡</span>
                            </p>
                            <p class="text-center imgWord4">{{card.card_name}}</p>
                            <p class="text-center imgWord5">{{card.duration}}天</p>
                        </div>
                    </div>
                    <p class="col-sm-12 text-center cardName">{{card.card_name}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
