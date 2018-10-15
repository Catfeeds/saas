<?php
use backend\assets\MemberShipAsset;
MemberShipAsset::register($this);
$this->title = '新会员入会-卡详情';
?>
<div class="container-fluid pd0" ng-controller="memberShipController" style="height: 100%;">
    <div class="col-sm-12 pd0" ng-controller="memberShipBuyCardController">
        <?=$this->render('@app/views/common/csrf.php')?>
        <div class="col-sm-12 pd0 detailsBgBox">
            <div class="col-sm-8 col-sm-offset-2 positionRelative">
                <div class="col-sm-12 pd0">
                    <span class="nameTitleUser pull-right">尊敬的{{memberLoginName}},您好！</span>
                    <span class="glyphicon glyphicon-home homeBtn pull-right" ng-click="home()"></span>
                    <span class="glyphicon glyphicon-remove delectBtn pull-right" ng-click="close()"></span>
                    <img src="/plugins/memberShip/images/title.png" width="50">
                </div>
                <div class="col-sm-5">
                    <img src="/plugins/memberShip/images/card-pic.png" class="col-sm-12" style="margin-top: 140px;">
                </div>
                <div class="col-sm-7">
                    <p class="cardDetailsName">会员卡名称：
                        <span class="cardDetailsNameBlod">{{detailsList.card_name}}</span>
                    </p>
                    <hr class="detailsHr col-sm-12 pd0">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-6 pd0 text-left">
                            <p class="cardInfoWords">卡种类型：
                                <span>{{detailsList.type_name|noData:''}}</span>
                            </p>
                            <p class="cardInfoWords text-left">转让价格：
                                <span ng-if="detailsList.transfer_price != null">{{detailsList.transfer_price|noData:''}}元</span>
                                <span ng-if="detailsList.transfer_price == null">暂无数据</span>
                            </p>
                            <p class="cardInfoWords">请假天数：
                                <span ng-if="detailsList.leave_total_days != null">{{detailsList.leave_total_days}}天</span>
                                <span ng-if="detailsList.leave_total_days == null">暂无数据</span>
                            </p>
                        </div>
                        <div class="col-sm-6 pd0 text-right">
                            <p class="cardInfoWords text-left">卡有效期：
                                <span ng-if="detailsList.duration != null">{{detailsList.duration}}天</span>
                                <span ng-if="detailsList.duration == null">暂无数据</span>
                            </p>
                            <p class="cardInfoWords text-left">转让次数：
                                <span ng-if="detailsList.transfer_number != null">{{detailsList.transfer_number}}次</span>
                                <span ng-if="detailsList.transfer_number == null">暂无数据</span>
                            </p>
                            <p class="cardInfoWords text-left">最低请假：
                                <span ng-if="detailsList.leave_least_Days != null">{{detailsList.leave_least_Days}}天</span>
                                <span ng-if="detailsList.leave_least_Days == null">暂无数据</span>
                            </p>
                        </div>
                        <div class="col-sm-12 pd0">
                            <p class="cardInfoWords" style="margin-top: 0;">通用场馆：
                                <span ng-if="detailsVenueList != undefined && detailsVenueList != '' && detailsVenueList != ''"
                                      ng-repeat="venue in detailsVenueList">{{venue.venueName}}、</span>
                                <span ng-if="detailsVenueList == undefined || detailsVenueList == '' || detailsVenueList == ''">暂无数据</span>
                            </p>
                        </div>
                        <hr class="detailsHr col-sm-12 pd0">
                        <div class="col-sm-12 pd0" ng-if="detailsClassList.length != 0">
                            <p class="cardInfoWords">团教课程</p>
                            <ul class="col-sm-12 pd0 classNameTicBox">
                                <li>
                                    <div class="classNameTic" ng-repeat="class in detailsClassList" title="{{class.name}}">{{class.name|cut:true:4:' ...'}}&nbsp;<span ng-if="class.number != '-1'">{{class.number}}</span><span ng-if="class.number == '-1'">不限</span>次/天</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 pd0" ng-if="detailsProList.length != 0">
                            <p class="cardInfoWords">赠送私教课程</p>
                            <ul class="col-sm-12 pd0 classNameTicBox">
                                <li>
                                    <div class="classNameTic" ng-repeat="pro in detailsProList" title="{{pro.name}}{{pro.number}}节">{{pro.name|cut:true:5:' ...'}}{{pro.number}}节</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 pd0" ng-if="detailsGiftList.length != 0">
                            <p class="cardInfoWords">赠品</p>
                            <ul class="col-sm-12 pd0 classNameTicBox">
                                <li>
                                    <div class="classNameTic" ng-repeat="gift in detailsGiftList" title="{{gift.name}}">{{gift.name|cut:true:4:'...'}}<span ng-if="gift.number != '-1'">{{gift.number}}</span><span ng-if="gift.number == '-1'">不限</span>{{gift.unit|noData:''}}</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 pd0">
                            <p class="money" style="margin-top: 20px;">
                                ￥
                                <span ng-if="detailsList.endMaxPrice != null ">{{detailsList.endMaxPrice}}</span>
                            </p>
                            <p class="protocol" style="margin-top: 20px;">
                                <label>
                                    <input class="checkProtocol" type="checkbox">
                                </label>
                                <a class="lookPro" data-toggle="modal" data-target="#buyCardProtocolModal">同意迈步智能健身购卡协议</a>
                            </p>
                            <button 
                                class="btn btn-warning buyBtn"
                                ng-click="goBuy()">立即购买</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--模态框-->
        <?= $this->render('@app/views/member-ship/modal.php'); ?>
    </div>
</div>
