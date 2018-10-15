<?php
use backend\assets\PrivateStatisticsCtrlAsset;
PrivateStatisticsCtrlAsset::register($this);
$this->title = '私教统计';
?>
<main ng-cloak ng-controller="privateStatisticsCtrl" id="main">
    <section>
        <div class="row mT10" >
            <div class="col-sm-12" style="display: flex;flex-wrap: wrap;">
                <div class="input-daterange input-group cp userTimeRecord col-sm-4" style="margin-left: 15px;width: 290px;">
                    <span class="add-on input-group-addon">
                    选择日期
                    </span>
                    <input type="text" readonly  name="reservation" id="privateStatisticsDate" class="form-control text-center userSelectTime reservationExpire" style="width: 195px;"/>
                </div>
                <div style="max-width: 240px;margin-right: 10px;z-index: 10;">
<!--                    <select class="form-control selectCssPd" ng-change="selectHomePageVenue(homePageVenue)" ng-model="homePageVenue">-->
<!--                        <option value="">请选择场馆</option>-->
<!--                        <option value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>-->
<!--                    </select>-->
                    <select id="homePageVenueSelect123" class=" form-control"  ng-change="homePagesPtVenueChange(homePageVenue)"  style="width: 100%;padding: 6px 12px;"  ng-model="homePageVenue">
                        <option value="">请选择场馆</option>
                        <option title="{{venue.name}}" value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name |cut:true:8:'...'}}</option>
                    </select>
                </div>
                <div style="margin-right: 10px;">
                    <button class="btn btn-sm btn-success w100" ng-click="homeSearchSubmit()">确定</button>
                </div>
                <div >
                    <button class="btn btn-sm btn-info w100" ng-click="homeSearchClear()">清空</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 " >
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pd5 mT10" >
                    <div class="col-sm-12 col-lg-12 col-md-12  col-xs-12 boxFlagCss pdRL0 bgWhite">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pdRL0 " ng-click="attendClassClick()">
                            <div class="statisticsFlag attendClassBg" >
                                <div>
                                    <div><img src="/plugins/sellIndex/images/time.png" class="flagImgCss"></div>
                                    <div class="colorWhite">上课量</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 hCenter h80" >
                            <div class="colorClassBg"><span class=" f30">{{AttendClassNum}}</span> 节</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 pd5 mT10" >
                    <div class="col-sm-12 col-lg-12 col-md-12  col-xs-12 boxFlagCss pdRL0 bgWhite">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pdRL0 " ng-click="sellClassClick()">
                            <div class="statisticsFlag sellClassBg " >
                                <div>
                                    <div><img src="/plugins/sellIndex/images/money.png" class="flagImgCss"></div>
                                    <div class="colorWhite">卖课量</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 hCenter h80" >
                            <div class="sellClassColor"><span class=" f30">{{SellClassNum}}</span> 节</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 pd5 mT10" >
                    <div class="col-sm-12 col-lg-12 col-md-12  col-xs-12 boxFlagCss pdRL0 bgWhite">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pdRL0 " ng-click="birthdayClick()">
                            <div class="statisticsFlag birthdayBg " >
                                <div>
                                    <div><img src="/plugins/sellIndex/images/birthday.png" class="flagImgCss"></div>
                                    <div class="colorWhite">生日会员</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 hCenter h80" >
                            <div class="birthdayColor"><span class=" f30">{{AllBirthdayNum}}</span> 人</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bGf0f3f4" >
            <div class="col-sm-12 pd20 loderBox bgWhite" >
                <div class="mT10 mB10">
                    <div class="text-left f20 fw ">
                        <span>课量统计</span>
                    </div>
                    <div class="text-center f20 fw " >

                        <select class=" pull-left borderRadius3 borderNone fwNormal f16 mR10" ng-change="selectClassNum(classNumSelected)" ng-model="classNumSelected">
                            <option value="1" >上课量</option>
                            <option value="2">卖课量</option>
                        </select>
                        <select class=" pull-left borderRadius3 fwNormal f16" ng-model="homeSelectDate132" ng-change="selectedTimeType(homeSelectDate132)">
                            <option value="d">当日</option>
                            <option value="w">当周</option>
                            <option value="m">当月</option>
                        </select>
<!--                        <div class="pull-right borderRadius3 f16 fwNormal">-->
<!--                            <div>-->
<!--                                <span>查看详情</span>-->
<!--                                <span class="glyphicon glyphicon-menu-right"></span>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                </div>
                <div id="classNum" class="col-sm-12 pd0 lessonChart"  style="height: 500px;"></div>
                <div class="loader loaderDiv loader-animateOne">
                    <div class="loader-inner square-spin loderModel">
                        <div class="center-block"></div>
                        <p class="text-center loadP">加载中</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--上课量模态框-->

    <?= $this->render('@app/views/private-statistics/attendClassModal.php'); ?>

    <!--私教上课量模态框-->
    <?= $this->render('@app/views/private-statistics/pTAttendClassModal.php'); ?>

    <!--会员上课量模态框-->
    <?= $this->render('@app/views/private-statistics/memberAttendClassModal.php'); ?>

    <!--卖课量模态框-->
    <?= $this->render('@app/views/private-statistics/sellClassModal.php'); ?>

    <!--私教卖课详情模态框-->
    <?= $this->render('@app/views/private-statistics/pTSellClassModal.php'); ?>


    <!--生日会员模态框-->
    <?= $this->render('@app/views/private-statistics/birthdayModal.php'); ?>
</main>