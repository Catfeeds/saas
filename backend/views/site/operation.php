<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/22
 * Time: 9:52
 */
use backend\assets\OperationStatisticsAsset;
OperationStatisticsAsset::register($this);
$this->title='营运统计';
?>
<div class="container-fluid pd0" ng-controller="operationCtrl" ng-cloak>
    <div class="row">
        <div class="col-sm-12 pd0 bgf">
            <h1 class="operationTitle">
                <div class="input-append date dateBox" id="dateIndex" data-date="2017-06-09" data-date-format="yyyy-mm-dd">
                    <span class="dateTitle">选择日期</span>
                    <input class="span2" size="15" type="text" value="" id="dateSpan" readonly ng-model="dateInput"/>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <div style="display: inline-block;margin-left: -10%;">
                    <span class="inputTitle1 glyphicon glyphicon-info-sign">查询场馆到店总人数</span>
                    <select class="venueSelect" ng-model="venueSelect" ng-change="venueChange(venueSelect)">
                        <option value="">请选择场馆</option>
                        <option ng-repeat="x in venueList" value="{{x.id}}">{{x.name}}</option>
                    </select>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class="inputTitle2 glyphicon glyphicon-info-sign">查询异店到本店人数</span>
                    <select class="venueSelect1" ng-model="VenueAllSelect" ng-change="venueChange2(VenueAllSelect)">
                        <option value="">请选择场馆</option>
                        <option ng-repeat="y in VenueAllSelectList" ng-if="y.id != employeeVenueId" value="{{y.id}}">{{y.name}}</option>
                    </select>
                </div>
            </h1>
        </div>
        <div class="col-sm-12 pd0 pdlr10 bgf">
            <div class="col-sm-9 pd0 comBox">
                <p class="allNum">
                    <span>到店人数统计</span>
                    <span class="comSpan pull-right" data-toggle="modal" data-target="#peopleNumModal" ng-click="getMemberDetail()">查看详情>
                    </span>
                </p>
                <div class="col-sm-12 pd20">
                    <div id="main" class="pd0">

                    </div>
                    <div class="loader loaderDiv loader-animate1">
                        <div class="loader-inner square-spin loderModel">
                            <div class="center-block"></div>
                            <p class="text-center loadP">加载中</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 pd0 pdl20">
                <div class="col-sm-12 pd0 allStatistics">
                    <p class="allNum">
                        <span>总数据统计</span>
                    </p>
                    <div class="col-sm-12">
                        <p class="numPAll cursor"  data-toggle="modal" data-target="#peopleNumModal" ng-click="getMemberDetail()">{{todayPeopleNum}}</p>
                        <p class="text-center textP">到场人数</p>
                        <div class="col-sm-6 pd0 man cursor"  data-toggle="modal" data-target="#peopleNumModal" ng-click="getMemberDetail()">{{todayManNum}}<small>男</small></div>
                        <div class="col-sm-6 pd0 woman cursor"  data-toggle="modal" data-target="#peopleNumModal" ng-click="getMemberDetail()">{{todayWomanNum}}<small>女</small></div>
                        <div class="col-sm-12 pd0 lineG"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 pd0 bgf cardBox" style="padding-top: 10px;">
            <div class="col-sm-12 pd0" style="margin-bottom: 10px;display: flex;">
                <div class="input-daterange input-group cp userTimeRecord" id="container" style="width: 330px" >
                    <span class="add-on input-group-addon"">
                    选择日期
                    </span>
                    <input type="text" readonly  name="reservation" id="memberDate" class="form-control text-center userSelectTime reservationExpire" style="width: 230px"/>
                </div>
                <div class="btn btn-sm btn-success" ng-click="getList()">查看</div>
            </div>
            <div class="col-sm-6 pd0 pdr10">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 smallSBox">
                        <p class="allNum" >
                            <span>会员卡种统计</span>
                            <i ng-click="cardCountBtn()" style="float: right;font-style: normal;font-weight: 100;margin-right: 10px;cursor: pointer">查看详情></i>
                        </p>
                        <div class="col-sm-12 pd40">
                            <div id="mainCard"></div>
                            <div class="loader loaderDiv loader-animate2">
                                <div class="loader-inner square-spin loderModel">
                                    <div class="center-block"></div>
                                    <p class="text-center loadP">加载中</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 pd0 pdl10">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 smallSBox">
                        <p class="allNum">
                            <span>会员上课统计</span>
                            <i ng-click="classCountBtn()" style="float: right;font-style: normal;font-weight: 100;margin-right: 10px;cursor: pointer">查看详情></i>
                        </p>
                        <div class="col-sm-12 pd40">
                            <div id="mainClass"></div>
                            <div class="loader loaderDiv loader-animate3">
                                <div class="loader-inner square-spin loderModel">
                                    <div class="center-block"></div>
                                    <p class="text-center loadP">加载中</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--卡种统计详情模态框-->
    <?= $this->render('@app/views/site/cardCountModal.php'); ?>
    <!--会员上课统计详情模态框-->
    <?= $this->render('@app/views/site/classCountModal.php'); ?>
    <!--进店人数详情模态框-->
    <?= $this->render('@app/views/site/peopleNumModal.php'); ?>
    <!--查看会员信息模态框-->
    <?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>
</div>
