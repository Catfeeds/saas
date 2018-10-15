<?php
use backend\assets\ClassReservationAsset;

ClassReservationAsset::register($this);
$this->title = '团课预约';
?>
<div ng-controller="ReservationCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li class="orderMenu"><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li>更衣柜管理</li>-->
<!--                    <li>场地管理</li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li style="padding-left: 0;" role="presentation" class="active"><a href="/wcheck-card/index#home">进馆验卡</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile">会员详情</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile1">会员卡</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile2">私教</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile3">团教</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile4">场地</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile5">更衣柜</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile6">信息记录</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile7">请假</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile8">消费</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0">
            <div class="panel-body detialS">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-sm-12" style="padding: 0 0 10px 10px;color: #676a6cd6">< 进馆验卡 < 预约团课</div>
                            <div class="col-sm-12 pd0" style="border-bottom: 1px solid #dddddd;">
                                <div class="col-sm-2 pd0 switchCabinetArea" >
                                    <input type="text" class="form-control" id="dateIndex" value=""
                                           data-date-format="yyyy-mm-dd" placeholder="请选择日期">
                                    <ul class="checkUl" style="overflow-y: auto;border-right: 1px solid #dddddd;border-bottom: 1px solid #dddddd;min-height: 530px !important;">
                                        <li class="SiteManagement cp" style="padding-left: 15px;border-bottom: solid 1px #E5E5E5;" ng-repeat="(index, item) in data" ng-click="selectCourseSeat(item.id,item,index)">
                                            <div ng-if="item.classRoomName" style="margin: 10px 0">
                                                <h3 ng-class="{blue: (item.choose),disAbled: time.status}">{{item.courseName}}</h3>
                                                <p style="color: #867f7f; margin: 10px 0;"><span>{{item.start *1000 | date:"HH:mm" }}</span>-<span>{{item.end *1000 | date:"HH:mm"}}</span></p>
                                                <p style="color: #867f7f;"><span>教练:{{item.coachName}}</span> / <span>{{item.classRoomName}}</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-10 pd0 switchCabinetAreaCabinetNum" >
                                    <div class="ibox float-e-margins boxShowNone borderNone" style="overflow-y: auto;overflow-x: hidden;min-height: 500px;">
                                        <div class="ibox-content borderNone pd10">
                                            <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                            <div class="row textAlignCenter" ng-if="show" style="min-width: 800px;">
                                                <div class="col-sm-12 text-left" ng-if="totalRows.length" style="margin: 15px 0 40px -15px;">
                                                    <div class="centerHeight">
                                                        <div class="seatFlag optionalItem"></div>
                                                        <span>可选</span>
                                                    </div>
                                                    <div class="centerHeight">
                                                        <div class="seatFlag" style="background: #ddd"></div>
                                                        <span>不可选</span>
                                                    </div>
                                                    <div class="centerHeight">
                                                        <div class="seatFlag selected"></div>
                                                        <span>已选</span>
                                                    </div>
                                                    <div class="centerHeight">
                                                        <div class="seatFlag selectedVip1"></div>
                                                        <span>Vip</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="col-sm-12 col-xs-12" style="padding: 0 0 0 100px;">
                                                        <div class="col-sm-12" ng-repeat="w in totalRows track by $index" style="display: flex;justify-content: center; ">
                                                            <div  ng-if="w == item.rows" class="totalRowsDiv"  ng-repeat="($key,item) in items.seat">
                                                                <!--//普通座位 已经选过 并且是普通座位 is_anyone == 1 是已经有人占用  is_anyone == 0 没有被人占用-->
                                                                <div class="textAlignCenter seat courseSeates notSelect set1 itemSeates cp" style="background: #ddd !important;" ng-if="item.is_anyone == 1 && item.seat_type == 1 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                                                    <div>
                                                                        <img style="width: 100%; height: 75%;" ng-if="item.memberdetails.memberDetails.pic" ng-src="{{item.memberdetails.memberDetails.pic}}" alt="">
                                                                        <img style="width: 100%" ng-if="!item.memberdetails.memberDetails.pic" src="/plugins/checkCard/img/11.png" alt="">
                                                                    </div>
                                                                    <div class="name">
                                                                        <span style="color: #ddd;font-size: 12px;">{{item.memberdetails.memberDetails.name}}</span>
                                                                    </div>
                                                                </div>
                                                                <!--//没有选中 并且是VIP 座位 -->
                                                                <div class="textAlignCenter seat courseSeates cp" ng-if="item.is_anyone == 0 && item.seat_type == 1 && item.seat_number != 0"   ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                                                    <span style="line-height: 120px;font-size: 25px;color: #ddd">{{item.seat_number}}</span>
                                                                </div>
                                                                <!--//VIP座位 已经选过 并且是VIP座位-->
                                                                <div class="textAlignCenter seat set1 courseSeates selectedVip notVipSelect cp" style="background: #ddd !important;" ng-if="item.is_anyone == 1 && item.seat_type == 2 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                                                    <div>
                                                                        <img style="width: 100%; height: 75%;" ng-if="item.memberdetails.memberDetails.pic" ng-src="{{item.memberdetails.memberDetails.pic}}" alt="">
                                                                        <img style="width: 100%" ng-if="!item.memberdetails.memberDetails.pic" src="/plugins/checkCard/img/11.png" alt="">
                                                                    </div>
                                                                    <div class="name">
                                                                        <span style="color: #ddd;font-size: 12px;">{{item.memberdetails.memberDetails.name}}</span>
                                                                    </div>
                                                                </div>
                                                                <!--//没有选中 并且是VIP 座位 -->
                                                                <div class="textAlignCenter set1 seat courseSeates cp" ng-if="item.is_anyone == 0 && item.seat_type == 2 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                                                    <div>
                                                                        <img style="width: 100%; height: 75%;" src="/plugins/checkCard/img/vip.png">
                                                                    </div>
                                                                    <div class="name">
                                                                        <span style="color: #ddd">{{item.seat_number}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="textAlignCenter seat courseSeates cp" style="display: none;"  ng-if="item.seat_type == 0 || item.seat_number == 0 || item.seat_type == null || item.seat_number == null" ></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-sm btn-success" ng-click="appointment(printers)">立即预约</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalComplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCom">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabelCom">完成预约</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row myModalCompleteRow ">
                        <div class="col-sm-4 col-xs-4 text-right" >
                            <img class="w100"  src="/plugins/checkCard/img/yes.png" alt="">
                        </div>
                        <div class="col-sm-8 col-xs-8">
                            <ul class="completeMes">

                                <li class="color33BC7B"><span>已预约成功！待使用...</span></li>
                                <li><h4 class="commentColor f20">开课时间: <span>{{datase.start *1000 | date:"MM月dd日 HH:mm" }}</span>&nbsp;<span></span></h4></li>
                                <li>教练: <span>{{datase.coach.name}}</span></li>
                                <li>课程: <span>{{datase.course.name}}</span></li>
                                <li><span> {{datase.classroom.name}}</span><span>{{datase.seat.seat_number}}号</span></li>
                                <li>下单时间: <span>{{datase.create_at *1000 | date:"yyyy-MM-dd HH:mm:ss" }}</span></span></li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default btn-sm fr padding" data-dismiss="modal">关闭</button>
                    <button class="padding btn btn-success btn-sm fr mr20" ng-click="printTicket(printers)">打印</button>
                </div>
            </div>
        </div>
    </div>
</div>
