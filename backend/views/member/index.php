<?php
use backend\assets\MemberCtrlAsset;
MemberCtrlAsset::register($this);
$this->title = '约课管理';
?>
<!--<header>-->
<style>
    .label-success{
        background-color: #5eb95e;
    }
</style>
<div ng-controller ='indexController' ng-cloak>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12 pd0">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b class="spanSmall">约课管理</b></span>
                    </div>
                    <div class="panel-body bodyStyle">
                        <div class="col-sm-6 bodyHeader">
                            <div class="input-group">
                                <input type="text" class="form-control memberHeader"  ng-model="keywords" ng-keydown="enterSearch()" placeholder="  请输入课程名或教练名进行搜索...">
                                            <span class="input-group-btn">
                                                <button type="button" ng-click="searchAbout()" class="btn btn-primary">搜索</button>
                                            </span>
                            </div>
                        </div>
                        <br>
                        <h4 class="memberHeaderChoiceFont" style="margin: 30px 0 15px 20px;">条件筛选</h4>
                        <div class="col-sm-12 memberHeaderChoice">
                            <label for="id_label_single" style="margin-left: 15px;">
                                <select   ng-model="venueId" ng-change="searchAbout()"   class="js-example-basic-single1 js-states form-control memberHeaderVenue" id="AboutClassVenue123">
                                    <option value="">请选择场馆</option>
                                    <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>
                                    <option ng-if="VenueStautsLength" value="" ><span style="color:red;">暂无数据</span></option>
                                </select>
                            </label>
                            <label for="id_label_single" style="margin-left: 10px;">
                                <select  ng-model="course_id" ng-change="searchAbout()"   class="js-example-basic-single3 js-states form-control a10"  id="AboutClassCourse">
                                    <option value="">请选择课程</option>
                                    <option value="{{venue.id}}" ng-repeat="venue in optionClass" >{{venue.name}}</option>
                                </select>
                            </label>
<!--                            <div class="dateBox pd0">-->
                                <!-- 日历范围时间插件-->
                                <div class="input-daterange input-group cp memberHeaderTime" id="container" style="display: inline-flex;justify-content: space-between;">
                                     <span class="add-on input-group-addon" style="width: auto;">
                                        选择日期
                                         <i class="glyphicon glyphicon-calendar fa fa-calendar memberHeaderDate"></i>
                                     </span>
                                    <input type="text" ng-model="dayTime" readonly style="" name="reservation" id="reservation" class="form-control memberHeaderSelectDate" placeholder="请选择日期"/>
                                </div>
<!--                            </div>-->
                            <div class="checkbox i-checks checkbox-inline checkBigBox memberHeaderChoiceFonts noStartBigBox">
                                <input type="checkbox"  name="notStart" id="inlineCheckbox1" value="option1">
                                <label for="inlineCheckbox1" class="checkLabelBoxLabel" style="padding-left: 2px;">未开始</label>
                            </div>
                            <div class="checkbox i-checks checkbox-success checkbox-inline checkBigBox" style="margin-top: 4px;margin-right: 0">
                                <input type="checkbox"   name="attendClass"  id="inlineCheckbox2" value="option1">
                                <label for="inlineCheckbox2" style="padding-left: 2px; "  class="checkLabelBoxLabel">正上课</label>
                            </div>
                            <div class="checkbox i-checks checkbox-success checkbox-inline checkBigBox memberHeaderSelectOver">
                                <input type="checkbox"  name="finish" id="inlineCheckbox3" value="option1">
                                <label for="inlineCheckbox3" class="checkLabelBoxLabel" style="padding-left: 2px;">已结束</label>
                            </div>
                            <button class="btn btn-success btn-sm" ng-click="searchAbout()" type="button">确定</button>
                            <button type="button" ladda="searchCarding" ng-click="searchClear()" class="btn btn-sm btn-info">清空</button>



<!--                            <div class="col-sm-3 memberHeaderSelect">-->
<!--                                <div class="col-sm-12 a8" >-->
<!--                                    <label for="id_label_single">-->
<!--                                        <select   ng-model="venueId" ng-change="searchAbout()"   class="js-example-basic-single1 js-states form-control memberHeaderVenue" id="AboutClassVenue123">-->
<!--                                            <option value="">请选择场馆</option>-->
<!--                                            <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>-->
<!--                                            <option ng-if="VenueStautsLength" value="" ><span style="color:red;">暂无数据</span></option>-->
<!--                                        </select>-->
<!--                                    </label>-->
<!--                                    <label for="id_label_single"  >-->
<!--                                        <select  ng-model="course_id" ng-change="searchAbout()"   class="js-example-basic-single3 js-states form-control a10"  id="AboutClassCourse">-->
<!--                                            <option value="">请选择课程</option>-->
<!--                                            <option value="{{venue.id}}" ng-repeat="venue in optionClass" >{{venue.name}}</option>-->
<!--                                        </select>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="dateBox col-sm-4 pd0">-->
<!--                                <!-- 日历范围时间插件-->
<!--                                <div class="input-daterange input-group cp memberHeaderTime" id="container">-->
<!--                                 <span class="add-on input-group-addon">-->
<!--                                选择日期<i class="glyphicon glyphicon-calendar fa fa-calendar memberHeaderDate"></i>-->
<!--                                     </span>-->
<!--                                    <input type="text" ng-model="dayTime" readonly style="" name="reservation" id="reservation" class="form-control memberHeaderSelectDate" placeholder="请选择日期"/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">-->
<!--                                <div class="col-sm-4 pd0">-->
<!--                                    <div class="checkbox i-checks checkbox-inline checkBigBox memberHeaderChoiceFonts" style="">-->
<!--                                        <input type="checkbox"  name="notStart" id="inlineCheckbox1" value="option1">-->
<!--                                        <label for="inlineCheckbox1" class="checkLabelBoxLabel" style="padding-left: 2px;">未开始</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-sm-4 pd0">-->
<!--                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBigBox" style="margin-top: 4px;margin-right: 0">-->
<!--                                        <input type="checkbox"   name="attendClass"  id="inlineCheckbox2" value="option1">-->
<!--                                        <label for="inlineCheckbox2" style="padding-left: 2px; "  class="checkLabelBoxLabel">正上课</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-sm-4 pd0">-->
<!--                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBigBox memberHeaderSelectOver">-->
<!--                                        <input type="checkbox"  name="finish" id="inlineCheckbox3" value="option1">-->
<!--                                        <label for="inlineCheckbox3" class="checkLabelBoxLabel" style="padding-left: 2px;">已结束</label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-sm-2 pd0 buttonBoxSuccess" style="padding-left: 50px;">-->
<!--                                <button class="btn btn-success btn-sm" ng-click="searchAbout()" type="button">确定</button>-->
<!--                                <button type="button" ladda="searchCarding" ng-click="searchClear()" class="btn btn-sm btn-info">清空</button>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
        <div style="padding-left: 0;padding-right: 0;" class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="position: relative;">
                    <h5>约课信息列表&nbsp<span class="memberListDetail">点击列表查看详情</span></h5>
                    <div class="btn-group btnBox memberListDetailRight">
                        <buttton class="btn btn-sm btn-white dateBtn1" ng-click="searchDate('d')">日</buttton>
                        <buttton class="btn btn-sm btn-white dateBtn2" ng-click="searchDate('w')">周</buttton>
                        <buttton class="btn btn-sm btn-white dateBtn3" ng-click="searchDate('m')">月</buttton>
                    </div>
                </div>
                <div class="ibox-content" style="padding: 0">
                    <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting memberBodyList" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 12%;"
                                    colspan="1" ng-click="changeSort('class_date',sort)"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp日期
                                </th>
                                <th class="sorting memberBodyListWidth" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 18%;"
                                    colspan="1" ng-click="changeSort('course_name',sort)"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>&nbsp课程名称
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('classroom_name',sort)"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp教室
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('class_time',sort)"><span class="fa fa-hourglass" aria-hidden="true"></span>&nbsp课程时长
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('class_start',sort)"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp开始时间
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('class_end',sort)"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp结束时间
                                </th>
                                <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;background-color: transparent;"
                                    colspan="1" ng-click=""><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp上课人数
                                </th>
                                <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;background-color: transparent;"
                                    colspan="1" ng-click=""><span class="glyphicon glyphicon-pawn" aria-hidden="true"></span>&nbsp座位数
                                </th>
                                <!--<th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('class_end',sort)><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp上课人数
                                </th>-->
<!--                                ng-click="changeSort('class_aboutClass',sort)"-->
                                <!--<th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1" ng-click="changeSort('class_end',sort)><span class="fa fa-users" aria-hidden="true"></span>&nbsp座位数
                                </th>-->
<!--                                ng-click="changeSort('class_seatNum',sort)"-->
                                <th class="sorting memberListWidth2" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="width: 10%;"
                                    colspan="1"  ng-click="changeSort('employee_name',sort)"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp教练
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="item in items" ng-click="aboutDetail(item.id,item.peopleAmount,item.seatAmount)">
                                <td data-toggle="modal" data-target="#myModals2">{{item.class_date}}</td>
                                <td data-toggle="modal" data-target="#myModals2" style="text-align: left"><span ng-bind-html="item | classDate"><small class="label label-primary"></small></span>&nbsp;&nbsp;{{item.courseName}}</td>
                                <td data-toggle="modal" data-target="#myModals2">{{item.classroomName}}</td>
                                <td data-toggle="modal" data-target="#myModals2" >{{(item.end - item.start)/60}}</td>
                                <td data-toggle="modal" data-target="#myModals2">{{(item.start)*1000 | date:'HH:mm'}}</td>
                                <td data-toggle="modal" data-target="#myModals2">{{(item.end)*1000 | date:'HH:mm'}}</td>
                                <td data-toggle="modal" data-target="#myModals2">{{item.peopleAmount}}人</td>
                                <td data-toggle="modal" data-target="#myModals2" ng-if="item.isDelete == 1">{{item.seatAmount}}个</td>
                                <td data-toggle="modal" data-target="#myModals2" ng-if="item.isDelete == 2">座次已删除</td>
                                <td data-toggle="modal" data-target="#myModals2">
                                    <span>{{ item.employeeName | noData:'' }}</span>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?=$this->render('@app/views/common/nodata.php');?>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <?=$this->render('@app/views/common/page.php');?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </div>
    <!--motai-->
    <div style="" class="modal fade" id="myModals2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog memberDetail" style="min-width: 55%;">
            <div class="modal-content clearfix memberDetailList">
                <div class="modal-header memberDetailList2">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <div style="margin-top: 0px;" class="col-sm-12">
                        <h5 class="memberDetailFont">约课详情</h5>
                        <hr/>
                        <div class="col-sm-12">
                            <div class="col-sm-4" style="padding-left: 15px;">
                                <h4 class="memberDetailTeacher">教练：{{detailObj.employee.name }}</h4>
                                <img class="img-circle memberDateilImg" ng-src="{{detailObj.employee.pic}}">
                            </div>
                            <div class="col-sm-7 memberDetailMessage">
                                <h4>教练信息</h4>
                                <p class="memberDetailMessages" ng-if="detailObj.employee.sex == 1">教练性别：男</p>
                                <p class="memberDetailMessages" ng-if="detailObj.employee.sex == 2">教练性别：女</p>
                                <p class="memberDetailMessage2">教练电话：{{detailObj.employee.mobile | noData:''}}</p>
                                <p class="memberDetailMessage2">个人介绍：{{detailObj.employee.intro | cut:true:15:"..." | noData:''}}</p>
                            </div>
                        </div>
                        <div class="col-sm-12 pdLR0" class="memberDetailUser" style="margin-top: 25px;">
                            <div class="col-sm-2 col-sm-offset-1 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="btn-warning memberDetailUser1"></div>
                                <span class="mL6">贵族会员</span>
                            </div>
                            <div class=" col-sm-2 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="btn-success memberDetailUser1"></div>
                                <span class="mL6">vip会员</span>
                            </div>
                            <div class=" col-sm-2 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="btn-info memberDetailUser1"></div>
                                <span class="mL6">普通会员</span>
                            </div>
                            <div class=" col-sm-2 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="bg-danger memberDetailUser1"></div>
                                <span class="mL6">潜在会员</span>
                            </div>
                            <div class=" col-sm-2 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="bg-primary memberDetailUser1"></div>
                                <span class="mL6">员工约课</span>
                            </div>
                            <div class=" col-sm-2 pdR0" style="display: flex;align-items: center;width: 120px;">
                                <div class="btn-white memberDetailUser1"></div>
                                <span class="mL6">无人座位</span>
                            </div>
                        </div>
                        <div class="col-sm-12 pdLR0" style="display: flex;justify-content: center;">
                            <div class="seatBox  memberDetailPersonal">
                                <h4 class="memberDetailPersonal1">{{ peopleAmount }}/{{ seatAmount }}&nbsp;上课人数</h4>
                                <div class="seatLists  text-center contentCenter mT20" style="display: flex;justify-content: center;">
                                    <table>
                                        <tbody>
                                        <tr class="seatDetailLists" ng-repeat="(seat123,$key) in seatDetailRows">
                                            <td  ng-if="$key == seat.rows"   ng-repeat="seat in  detailObj.seats"  style="position: relative;">
                                                <section  class=" seatEditSize p4 cp m6"  ng-if="seat.seat_number != null" ng-class="{borderNone:seat.seat_number =='0'}  " >
                                                    <div class="{{seat | attrSeatClass123:detailObj.aboutClass}}"  style="display: flex;align-items: center;height: 100%;width: 100%;">
                                                        <div style="text-align: center;width: 100%;" class="">
                                                            <div class="addSeatNum"><span ng-if="(seat.seat_number == '0' && (seat.id | memberAbout:detailObj.aboutClass) != '无人') || (seat.seat_number != '0' && seat.seat_number != null)">{{seat.seat_number}}</span></div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <div ng-if="(seat.seat_number == '0' && (seat.id | memberAbout:detailObj.aboutClass) != '无人') || (seat.seat_number != '0' && seat.seat_number != null)"
                                                     title="{{seat.id | memberAbout:detailObj.aboutClass}}" class="addSeatType" data-value="" ng-bind="seat.id | memberAbout:detailObj.aboutClass|cut:true:3:'*'"></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
<!--                                <div class="seatSmallBox memberDetailSeat" ng-repeat="(index,seat) in detailObj.seats">-->
<!--                                    <div ng-hide="aboutNoSeat" ng-if="seat.seat_type != 0">-->
<!--                                        <div ng-repeat="about in detailObj.aboutClass" class="{{seat | attrSeatClass:about}} memberDetailNumber" style="">{{seat.seat_number}}</div>-->
<!--                                        <span title="{{seat.id | memberAbout:detailObj.aboutClass}}" class="memberDetailNoPersonal" ng-bind="seat.id | memberAbout:detailObj.aboutClass|cut:true:3:'***'"></span>-->
<!--                                    </div>-->
<!--                                    <div ng-show="aboutNoSeat"ng-if="seat.seat_type != 0">-->
<!--                                        <div class="{{seat | attrSeatClass}} memberDetailNumber">{{seat.seat_number}}</div>-->
<!--                                        <span class="memberDetailNoPersonal">无人</span>-->
<!--                                    </div>-->
<!--                                </div>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
