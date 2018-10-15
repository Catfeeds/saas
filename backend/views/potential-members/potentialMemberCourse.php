<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/5/24
 * Time: 15:11
 */
use backend\assets\PotentialMembersAsset;
PotentialMembersAsset::register($this);

$this->title = '潜在会员约课';
?>
<main  class="container-fluid containerFluidMain"  ng-controller="potentialMemberCourseCtrl" ng-cloak>
    <div class="row"  id="courseListBack">
        <div class="ibox float-e-margins table">
            <div class="ibox-title containerSmallBox col-sm-12 col-xs-12">
                <div class="col-sm-3 col-xs-6 text-left cp"  style="display: flex;" >
                    <span id="backPre" ng-click="backPre()" class="color999999 fontSize20 glyphicon glyphicon-menu-left "></span>
                    <div style="width: 160px;margin-left: 10px;margin-top: -6px;">
                        <select ng-model="venueId" ng-change="PackVenue(venueId)"  class="form-control" style="padding: 4px 12px;min-width: 110px;">
                            <option ng-repeat="venue in venueListInfo" value="{{venue.id}}">{{venue.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-5 text-center color999999" >
                    &lt; &emsp;<span>{{data.week1[0].class_date}} - {{data.week7[0].class_date}}</span> &emsp;&gt;
                </div>
                <div class="col-sm-3 col-xs-1">
                </div>
            </div>
        </div>
        <div class="row ml0 mr0 backgroundE3EAF2">
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期一</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week1[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week1[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期二</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week2[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week2[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期三</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week3[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week3[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期四</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week4[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week4[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期五</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week5[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week5[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期六</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week6[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week6[0].class_date}}</span></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期日</li>
                    <li class="courseDate"><span ng-class="dateCurrentw  == data.week7[0].class_date ? 'dateCurrents': 'dateCurrent'" >{{data.week7[0].class_date}}</span></li>
                </ul>
            </div>
        </div>
        <div class="row ml0 mr0 borderSolidE5e5e5" >
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists mt0 ">
                <ul  ng-repeat="course in data.week1" ng-if="course.status == true" class="borderR cp"  ng-click="selectCourseSeat(course.id)">
                    <li ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm" }}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName }}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul  ng-repeat="course in data.week2" ng-if="course.status == true" class="borderR cp"   ng-click="selectCourseSeat(course.id)">
                    <li ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm" }}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul  ng-repeat="course in data.week3" ng-if="course.status == true" class="borderR cp"   ng-click="selectCourseSeat(course.id)">
                    <li ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul  ng-repeat="course in data.week4" ng-if="course.status == true"  class="borderR cp" ng-click="selectCourseSeat(course.id)">
                    <li ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists " >
                <ul  ng-repeat="course in data.week5" ng-if="course.status == true" class="borderR cp" ng-click="selectCourseSeat(course.id)">
                    <li  ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul  ng-repeat="course in data.week6" ng-if="course.status == true" class="borderR cp"  ng-click="selectCourseSeat(course.id)">
                    <li  ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7  lists borderRightNone">
                <ul  ng-repeat="course in data.week7" ng-if="course.status == true" class="borderR cp borderRightNone"  ng-click="selectCourseSeat(course.id)">
                    <li ng-if="course.courseName != null"><h5  class="f14">{{course.courseName}}</h5></li>
                    <li ng-if="course.start != null"><span>{{course.start *1000 | date:"HH:mm"}}</span>-<span>{{course.end *1000 | date:"HH:mm"}}</span></li>
                    <li class="courseDate" ng-if="course.coachName != null"><div><span>{{course.coachName}}</span> / <span>{{course.classRoomName}}</span></div></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="modalClose()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">选择座位</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <ul class="col-sm-12 textAlignCenter" >
                            <li class="col-sm-3 centerHeight" >
                                <div class="seatFlag"></div>
                                <span class="spanCenterHeight1">可选</span>
                            </li>
                            <li class="col-sm-3 centerHeight">
                                <div class="seatFlag notSelect"></div>
                                <span class="spanCenterHeight">不可选</span>
                            </li>
                            <li class="col-sm-3 centerHeight">
                                <div class="seatFlag selected"></div>
                                <span class="spanCenterHeight1">已选</span>
                            </li>
                            <li class="col-sm-3 centerHeight">
                                <div class="seatFlag selectedVip1"></div>
                                <span class="spanCenterHeight3">Vip</span>
                            </li>
                        </ul>
                    </div>
                    <div class="row mt20">
                        <div class="col-sm-12 col-xs-12 ">
                            <div class="col-sm-12" ng-repeat="w in totalRows track by $index" style="display: flex;justify-content: center; ">
                                <div  ng-if="w == item.rows" class="totalRowsDiv"  ng-repeat="($key,item) in items.seat">
                                    <!--                                //普通座位 已经选过 并且是普通座位 is_anyone == 1 是已经有人占用  is_anyone == 0 没有被人占用-->
                                    <div class="textAlignCenter seat courseSeates notSelect cp"  ng-if="item.is_anyone == 1 && item.seat_type == 1 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                        <span>{{item.seat_number}}</span>
                                    </div>
                                    <!--                                //没有选中 并且是VIP 座位 -->
                                    <div class="textAlignCenter seat courseSeates cp" ng-if="item.is_anyone == 0 && item.seat_type == 1 && item.seat_number != 0"   ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                        <span>{{item.seat_number}}</span>
                                    </div>
                                    <!--                                //VIP座位 已经选过 并且是VIP座位-->
                                    <div class="textAlignCenter seat courseSeates selectedVip notVipSelect cp"  ng-if="item.is_anyone == 1 && item.seat_type == 2 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                        <span>{{item.seat_number}}</span>
                                    </div>
                                    <!--                                //没有选中 并且是VIP 座位 -->
                                    <div class="textAlignCenter seat courseSeates selectedVip  cp" ng-if="item.is_anyone == 0 && item.seat_type == 2 && item.seat_number != 0" ng-click="seatSelect(item.id,item.seat_number,item.seat_type,$key)">
                                        <span>{{item.seat_number}}</span>
                                    </div>
                                    <div class="textAlignCenter seat courseSeates  cp" style="opacity: 0;"  ng-if="item.seat_type == 0 || item.seat_number == 0 || item.seat_type == null || item.seat_number == null" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer myModalButton">
                    <button type="button" class="btn btn-success" ng-click="appointment()">立即预约</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal2 -->
    <div class="modal fade" id="myModalComplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCom">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabelCom">完成预约</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row myModalCompleteRow">
                        <div class="col-sm-4 col-xs-4 text-right" >
                            <img class="w100" src="/plugins/checkCard/img/yes.png" alt="">
                        </div>
                        <div class="col-sm-8 col-xs-8">
                            <ul class="completeMes">
                                <li class="color33BC7B"><span>已预约成功！待使用...</span></li>
                                <li><h4 class="commentColor f20">开课时间: <span ng-if="datase.start != null">{{datase.start *1000| date:"MM月dd日 HH:mm" }}</span>&nbsp;<span></span></h4></li>
                                <li>教练: <span>{{datase.coach.name}}</span></li>
                                <li>课程: <span>{{datase.course.name}}</span></li>
                                <li><span> {{datase.classroom.name}}</span><span>{{datase.seat.seat_number}}号</span></li>
                                <li>下单时间: <span ng-if="datase.create_at != null">{{datase.create_at *1000 | date:"yyyy-MM-dd HH:mm:ss" }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <button type="button " class="padding6_20 btn btn-default btn-sm fr" data-dismiss="modal">关闭</button>
                    <button class=" padding6_20 btn btn-success btn-sm fr" ng-click="aboutPrints(printers)">打印</button>
                </div>
            </div>
        </div>
        <?=$this->render('@app/views/common/coursePrint.php')?>
</main>
