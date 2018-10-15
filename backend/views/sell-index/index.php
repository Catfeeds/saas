<?php
use backend\assets\SellIndexAsset;
SellIndexAsset::register($this);
$this->title = '销售主页';
?>
<div class="container-fluid pd0" ng-controller="sellIndexCtrl" ng-cloak>
    <div class="row bGf5">
        <div class="col-sm-12 col-md-12 col-lg-12 mT10 pd0  " style="margin-left: 20px;">
            <div class="col-sm-4 col-md-4 col-lg-2 pd0" style="width: 200px;">
                <select class="form-control" style="padding: 4px 12px;" ng-model="venueSelect" ng-change="venueChange(venueSelect)">
                    <option value="">&nbsp;请选择场馆</option>
                    <option ng-repeat="x in venueList" value="{{x.id}}">{{x.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 pd0  mB10 pL15 pR15">
<!--            即将到期-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10" >
                <div class="col-sm-12 pd0 statisticsBoxCss">
                    <div class="statisticsFlag expireBg" data-toggle="modal" data-target="#expireModal" ng-click="expireUserFun()"><img src="/plugins/sellIndex/images/time.png" class="flagImgCss">
                        <span class="positionFour">即将到期</span>
                    </div>
                    <select name="mySelect" class="selectExpire mySelectDate" id="" ng-change="expireUserSelectCount(expireSelectId)" ng-model="expireSelectId">
                        <option ng-selected="expireSelectId == condition.value" ng-repeat=" condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                    </select>
                    <p class="expireP noSignP">
                        <span>{{expireUserAll != '' && expireUserAll != undefined ? expireUserAll: 0}}</span>
                        <small class="fwNormal f14">人</small></p>
                </div>
            </div>
<!--            未签到-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10" >
                <div class="col-sm-12 pd0 statisticsBoxCss">
                    <div  class="notSign statisticsFlag"  data-toggle="modal" data-target="#noSignModal" ng-click="noSignChangeLists()"><img src="/plugins/sellIndex/images/dao.png" class="flagImgCss">
                        <span >未签到</span>
                    </div>
                    <select name="mySelect" class="noSignSelect mySelectDate" id="" ng-change="noSignChangeCount(noSignSelectId)" ng-model="noSignSelectId">
                        <option value="30">一月内</option>
                        <option value="90">三月内</option>
                        <option value="180">半年内</option>
                    </select>
                    <p class="noSignP">
                        <span ng-if="noSignCountAll != null && noSignCountAll != undefined">{{noSignCountAll}}</span>
                        <span ng-if="noSignCountAll == null||noSignCountAll == undefined">0</span>
                        <small class="fwNormal f14">人</small</p>
                </div>
            </div>
<!--            生日会员-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10" >
                <div class="col-sm-12 pd0 statisticsBoxCss" >
                    <div class="statisticsFlag birthdayBg"  data-toggle="modal" data-target="#birthdayModal" ng-click="birthdayMemberClick()" ><img src="/plugins/sellIndex/images/birthday.png" class="flagImgCss">
                        <span class="positionFour">生日会员</span>
                    </div>
                    <select name="mySelect" class="mySelectDate" ng-change="birthdayMemberSelectCount(birthdayMemberSelectId)" ng-model="birthdayMemberSelectId">
                        <option  ng-repeat=" condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                    </select>
                    <p class="noSignP birthdayColor">
                        <span ng-if="birCountAll != null && birCountAll != undefind">{{birCountAll}}</span>
                        <span ng-if="birCountAll == null || birCountAll == undefind">0</span>
                        <small class="fwNormal f14">人</small>
                    </p>
                </div>
            </div>
<!--            新增会员-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10" >
                <div class="col-sm-12 pd0 statisticsBoxCss" >
                    <div class="addMemberBg statisticsFlag"  data-toggle="modal" data-target="#addUserModal" ng-click="addUserFun()"><img src="/plugins/sellIndex/images/user.png" class="flagImgCss">
                        <span  class="positionFour">新增会员</span>
                    </div>
                    <select name="mySelect" class="mySelectDate" ng-change="addMemberSelectCount(addMemberSelectedId)" ng-model="addMemberSelectedId">
                        <option  ng-repeat=" condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                    </select>
                    <p class="noSignP addMemberColor">
                        <span ng-if="countsAllNum != null && countsAllNum != undefind">{{countsAllNum}}</span>
                        <span ng-if="countsAllNum == null || countsAllNum == undefind">0</span>
                        <small class="fwNormal f14">人</small>
                    </p>
                </div>
            </div>
<!--            销售额-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10" >
                <div class="col-sm-12 pd0 statisticsBoxCss">
                    <div ng-click="saleMoneyModal()" class="cp saleMoneyBg statisticsFlag" ><img src="/plugins/sellIndex/images/money.png" class="flagImgCss">
                        <span >销售额</span>
                    </div>
                    <select name="mySelect" class="mySelectDate" ng-change="saleMoneySelectCount(selectSaleMoneyId)" ng-model="selectSaleMoneyId">
                        <option ng-repeat="condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                    </select>
                    <p class="noSignP saleMoneyColor smallYuan"><span>{{allMoney}}</span><small class="fwNormal f14" >元</small></p>
                </div>
            </div>
<!--            客流量-->
            <div class="col-lg-2 col-md-4 col-sm-4 pd5 mT10"  >
                <div class="col-sm-12 pd0 statisticsBoxCss" >
                    <div ng-click="peopleNum()" class="cp peopleNumBg statisticsFlag" ><img src="/plugins/sellIndex/images/liuliang.png" class="flagImgCss">
                        <span>客流量</span>
                    </div>
                    <select name="mySelect" class="mySelectDate" ng-change="peopleNumSelectCount(selectPeopleNumId)" ng-model="selectPeopleNumId">
                        <option ng-selected="selectedPeopleNumId == condition.value" ng-repeat=" condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                    </select>
                    <p class="noSignP peopleNumColor">
                        <span>{{peopleNumCountAll}}</span>
                        <small class="fwNormal f14">人</small>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 pdLr20" >
            <div class="col-sm-12 pd0 bgWhite" >
<!--                <p style="font-size: 16px;font-weight: bold;padding-left: 20px;padding-top: 10px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;position: relative;">-->
<!--                    <div id="countSelect">-->
<!--                        销售额统计-->
<!--                    </div>-->
<!--                    <select name="mySelect" id="mySelectChange" style="font-size: 14px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">-->
<!--                        <option value="6">半年内收入</option>-->
<!--                    </select>-->
<!--                <div class="input-append date dateBox pull-right" id="dateIndex" data-date="2017-05-25" data-date-format="yyyy-mm-dd" style="display: none;">-->
<!--                    <input class="span2 btn btn-primary btn-sm" size="16" type="text" value="{{todaySale}}" id="dateSpan"/>-->
<!--                    <span class="add-on"><i class="icon-th"></i></span>-->
<!--                </div>-->
<!--                </p>-->
                <div class="col-sm-12 pd20 loderBox" >
                    <div>
                        <div class="text-center f20 fw " >
                            <span style="margin-left: 72px;">销售额统计</span>
                            <i class="iStyle" ng-click="saleMoneyMarketChart()">查看详情></i>
                            <select class=" pull-right borderRadius3 borderNone fwNormal f16"
                                    ng-change="marketChartSelect(marketChartId)" ng-model="marketChartId">
                                <option ng-repeat="condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                            </select>
                        </div>

                    </div>
                    <div id="sellMain" class="col-sm-12 pd0" ></div>
                    <div class="loader loaderDiv loader-animate1">
                        <div class="loader-inner square-spin loderModel">
                            <div class="center-block"></div>
                            <p class="text-center loadP">加载中</p>
                        </div>
                    </div>

                    <!--                    <div id="passengerMain" ></div>-->
                </div>
            </div>
<!--            <div class="col-sm-4" style="padding-bottom: 0;padding-right: 0;padding-left: 20px;">-->
<!--                <div class="col-sm-12 pd0" style="height: 454px;overflow-y: scroll;background: #fff;">-->
<!--                    <p style="font-size: 16px;font-weight: bold;padding-left: 20px;padding-top: 10px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;">最新公告</p>-->
<!--                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;">-->
<!--                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>-->
<!--                        <p style="font-size: 14px;">最新公告</p>-->
<!--                        <div class="lineG" style="height: 1px;background: #eee;"></div>-->
<!--                    </div>-->
<!--                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">-->
<!--                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>-->
<!--                        <p style="font-size: 14px;">最新公告</p>-->
<!--                        <div class="lineG" style="height: 1px;background: #eee;"></div>-->
<!--                    </div>-->
<!--                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">-->
<!--                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>-->
<!--                        <p style="font-size: 14px;">最新公告</p>-->
<!--                        <div class="lineG" style="height: 1px;background: #eee;"></div>-->
<!--                    </div><div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">-->
<!--                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>-->
<!--                        <p style="font-size: 14px;">最新公告</p>-->
<!--                        <div class="lineG" style="height: 1px;background: #eee;"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="col-sm-12 pd0 bGf5 pd2010" >
            <div class="col-sm-4 pdLr10" >
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 bgWhite" >
                        <p class="statisticsTitle">员工业绩
                            <i class="iStyle" ng-click="staffPerformanceBtn()">查看详情></i>
                            <select ng-change="mySelectChange3q(mySelectChange3)" name="mySelect" id="mySelectChange3" ng-model="mySelectChange3">
                                <option ng-repeat="condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                            </select>
                        </p>
                        <div class="col-sm-12 pd0">
                            <div id="staffMian" class="classMain"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 pdL10R3" >
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 bgWhite" >
                        <p class="statisticsTitle">课程预约
                            <i class="iStyle" ng-click="classAppointmentBtn()">查看详情></i>
                            <select name="mySelect" ng-change="getMemberClass(classDate)" id="mySelectChange4" ng-model="classDate">
                                <option value="d">本日</option>
                                <option value="w">本周</option>
                                <option value="m">本月</option>
                            </select>
                        </p>
                        <div class="col-sm-12 pd0 loderBox">
                            <div id="classMain" class="classMain"></div>
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
            <div class="col-sm-4 pdL17R10" >
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 bgWhite" >
                        <div class="col-sm-12 pd0 loderBox" style="height: 504px;overflow-y: scroll;background: #fff;">
                            <p  class="statisticsTitle">销售排行榜
                                <i class="iStyle" ng-click="sellerTopBtn()">查看详情></i>
                                <select name="mySelect" id="sellLists" ng-change="rankSaleFun()" ng-model="rankSale">
                                    <option value="d">日排行</option>
                                    <option value="w">周排行</option>
                                    <option value="m">月排行</option>
                                </select>
                            </p>
                            <div class="loader loaderDiv loader-animate3">
                                <div class="loader-inner square-spin loderModel">
                                    <div class="center-block"></div>
                                    <p class="text-center loadP">加载中</p>
                                </div>
                            </div>
                            <div ng-repeat="sellRank in sellListsRanking"  class="col-sm-12" style="padding-left: 40px;padding-right: 20px;position: relative;margin-top: 10px;">
                                <span class="numLists" ng-if="$index != 0 && $index != 1 && $index != 2">{{$index+1}}</span>
                                <img ng-if="$index == 0" class="medal" ng-src="/plugins/sellIndex/images/u401.png">
                                <img ng-if="$index == 1"  class="medal" ng-src="/plugins/sellIndex/images/u405.png">
                                <img ng-if="$index == 2" class="medal" ng-src="/plugins/sellIndex/images/u403.png">
                                <p style="font-size: 14px;font-weight: bold;color: #333;padding: 0;">
                                    <img ng-if="sellRank.pic != null&&sellRank.pic != ''&&sellRank.pic != undefined" ng-src="{{sellRank.pic}}" style="width: 40px;height: 40px;margin-right: 10px">
                                    <img ng-if="sellRank.pic == null||sellRank.pic == ''||sellRank.pic == undefined" ng-src="/plugins/sellIndex/images/icon111.png" style="width: 40px;height: 40px;margin-right: 10px">
                                    <span >{{sellRank.name | noData:''}}</span>
                                    <span class="pull-right" style="font-weight: normal;color: #666;line-height: 40px">{{sellRank.totalPrice|number:0}}元</span>
                                </p>
                                <div class="lineG" style="height: 1px;background: #eee;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 pd0 bGf5 pd2010" >
            <div class="col-sm-12 pdL10R3" >
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0 bgWhite loderBox" >
                        <p class="statisticsTitle">客户各渠道来源
                            <i class="iStyle" ng-click="trafficSourcesBtn()">查看详情></i>
                            <select ng-change="getSourceDitch(sourceDitchId)"  ng-model="sourceDitchId">
                                <option ng-repeat="condition in  filtrateSelect"  value="{{condition.value}}">{{condition.name}}</option>
                            </select>
                        </p>
                        <div id="sourceDitchMain" class="col-sm-12 pd0" ></div>
                        <div class="loader loaderDiv loader-animate4">
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




    <!--即将到期详情模态框-->
    <?= $this->render('@app/views/sell-index/expireModal.php'); ?>

    <!--未签到详情模态框-->
    <?= $this->render('@app/views/sell-index/noSignModal.php'); ?>

    <!--生日会员详情模态框-->
    <?= $this->render('@app/views/sell-index/birthdayModal.php'); ?>

    <!--新增会员详情模态框-->
    <?= $this->render('@app/views/sell-index/addUserModal.php'); ?>


    <!--销售额详情模态框-->
    <?= $this->render('@app/views/sell-index/saleMoneyModal.php'); ?>

    <!--客流量详情模态框-->
    <?= $this->render('@app/views/sell-index/peopleNumberModal.php'); ?>

    <!--员工业绩详情模态框-->
    <?= $this->render('@app/views/sell-index/staffPerformanceModal.php'); ?>

    <!--课程预约详情模态框-->
    <?= $this->render('@app/views/sell-index/classAppointmentModal.php'); ?>

    <!--课程预约详情模态框-->
    <?= $this->render('@app/views/sell-index/sellerTopModal.php'); ?>

    <!--客户来源渠道模态框-->
    <?= $this->render('@app/views/sell-index/trafficSourcesModal.php'); ?>

    <!--查看会员信息模态框-->
    <?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>
</div>
