<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/5/24
 * Time: 9:49
 * content:课程预约详情页面
 */
use backend\assets\PrivateLessonAsset;

PrivateLessonAsset::register($this);
$this->title = '预约详情';
?>
<main ng-controller="coachLessonCtrl" class="coachLessonBox" ng-cloak>
    <div class="row" id="courseListBack" data-id="<?= $id ?>">
        <div class="ibox float-e-margins">
            <div class="ibox-title courseListBackDiv1">
                <div class="col-sm-1 col-xs-1 text-left cp" id="backPre" ng-click="backPre()">
                    <span class="glyphicon glyphicon-menu-left "></span>
                </div>
                <div class="col-sm-10 col-xs-10 text-center backPreDiv">
                    <span ng-click="preWeek(data.week1[0].class_date,next,id)"
                          class="cp f20 backPreDivSpan">&lt;</span> &emsp;<span>{{data.week1[0].class_date}} - {{data.week7[0].class_date}}</span> &emsp;<span
                        ng-click="nextWeek(pre,data.week7[0].class_date,id)" class="cp f20 backPreDivSpan">&gt;</span>
                </div>
                <div class="col-sm-1 col-xs-1">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7  courseLists">
                <div>
                    <ul class="weekDate text-center">
                        <li>星期一</li>
                        <li class="courseDate"><span
                                ng-class="dateCurrentw  == data.week1[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week1[0].class_date}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 courseLists">
                <ul class="weekDate text-center">
                    <li>星期二</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week2[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week2[0].class_date}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 courseLists">
                <ul class="weekDate text-center">
                    <li>星期三</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week3[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week3[0].class_date}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 courseLists">
                <ul class="weekDate text-center">
                    <li>星期四</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week4[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week4[0].class_date}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 courseLists">
                <ul class="weekDate text-center">
                    <li>星期五</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week5[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week5[0].class_date}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期六</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week6[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week6[0].class_date}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 ">
                <ul class="weekDate text-center">
                    <li>星期日</li>
                    <li class="courseDate"><span
                            ng-class="dateCurrentw  == data.week7[0].class_date ? 'dateCurrents': 'dateCurrent'">{{data.week7[0].class_date}}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 listsDivs3 ">
                <ul ng-repeat="course in data.week1" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm" }}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week1[0].class_date)">
                    <div class="hoverBox" ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul ng-repeat="course in data.week2" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm" }}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week2[0].class_date)">
                    <div class="hoverBox" ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul ng-repeat="course in data.week3" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week3[0].class_date)">
                    <div class="hoverBox" ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul ng-repeat="course in data.week4" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week4[0].class_date)">
                    <div class="hoverBox" ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul ng-repeat="course in data.week5" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week5[0].class_date)">
                    <div class="hoverBox" ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7 lists ">
                <ul ng-repeat="course in data.week6" ng-if="course.status == 1" class="borderR cp minHeight100"
                    ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week6[0].class_date)">
                    <div class="hoverBox"
                         style="background: #fff;width: 100%;padding: 10px;border: 1px solid #e1e1e1;border-width:1px;position: relative;"
                         ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1-7 col-sm-1-7 col-xs-1-7 col-md-1-7  lists" style="border-right: none;">
                <ul ng-repeat="course in data.week7" ng-if="course.status == 1" class="borderR cp minHeight100"
                    style="border-right: none" ng-click="scheduleCourseDetail(course.member_id,course.class_id,course)">
                    <li ng-if="course.product_name != null"><h5 class="f14">{{course.product_name}}</h5></li>
                    <li ng-if="course.class_start != null">
                        <span>{{course.class_start *1000 | date:"HH:mm"}}</span>-<span>{{course.class_end *1000 | date:"HH:mm"}}</span>
                    </li>
                    <li class="courseDate" ng-if="course.username != null">
                        <div>客户:<span>{{course.member.memberDetails.name}}</span></div>
                    </li>
                </ul>
                <div class="col-sm-12 pd0" ng-click="addCourseList(data.week7[0].class_date)">
                    <div class="hoverBox"
                         style="background: #fff;width: 100%;padding: 10px;border: 1px solid #e1e1e1;border-width:1px;position: relative;"
                         ng-click="hoverAdd()">
                        <p class="hoverBoxP">登记预约会员</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 课程详情Modal -->
    <div class="modal fade" id="scheduleCourseDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">课程详情</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 scheduleCourseDetailDiv">
                            <div>
                                <img ng-if="courseDetail.memberDetails.pic != null"
                                     ng-src="{{courseDetail.memberDetails.pic}}" alt=""
                                     style="width: 150px;height: 150px;border-radius: 50%;">
                                <img ng-if="courseDetail.memberDetails.pic == null" src="/plugins/img/user.png" alt=""
                                     style="width: 150px;height: 150px;border-radius: 50%;">
                            </div>
                            <div>
                                <ul>
                                    <li class="scheduleCourseDetailLi">姓&emsp;名: <span>{{courseDetail.name}}</span></li>
                                    <li>手机号: <span>{{courseDetail.mobile}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-8 scheduleCourseDetailDiv2">
                            <div>
                                <ul>
                                    <li class="scheduleCourseDetailDivLIAll"><h4 class="lightGreen "
                                                                                 style="font-size: 24px;">
                                            已同意预约！待上课...</h4></li>
                                    <li class="scheduleCourseDetailDivLIAll"><h2 class="lightGreen fw"
                                                                                 style="font-size: 30px;">开课时间:<span>{{courseDetail.start*1000 | date:"MM月dd日 HH:mm"}}</span>
                                        </h2></li>
                                    <li class="scheduleCourseDetailDivLIAll"><span> 共{{courseDetail.memberCourseOrderDetails.total_num}}节课  第{{courseDetail.memberCourseOrderDetails.course_num}}节</span>
                                        / <span>{{courseDetail.memberCourseOrderDetails.course_name}}</span> / <span>{{courseDetail.memberCourseOrderDetails.class_length}}分钟</span>
                                    </li>
                                    <li class="scheduleCourseDetailDivLIAll">套餐产品:<span>{{courseDetail.memberCourseOrderDetails.product_name}}</span>
                                        <span class="glyphicon glyphicon-yen">{{courseDetail.memberCourseOrderDetails.money_amount }}</span>
                                    </li>
                                    <li>下单时间: <span>{{courseDetail.create_at *1000 | date:'yyyy-MM-dd HH:mm:ss'| noData:''}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-12 text-right scheduleCourseDetailDivButton">
                                <button type="button" class="btn btn-default"
                                        ng-click="cancelOrder(courseDetail.memberCourseOrder.id)">取消预约
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 搜索会员Modal -->
    <div class="modal fade" tabindex="-1" id="searchMember" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header searchMemberHeader">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body searchMemberBody">
                    <div class="row">
                        <div class="col-sm-12 text-center searchMemberBodyDiv1">搜索会员</div>
                        <div class="col-sm-8 col-sm-offset-2 scheduleCourseDetailDivButton">
                            <div class="input-group">
                                <input type="text" class="form-control ng-pristine ng-valid ng-empty ng-touched"
                                       ng-model="keywords" ng-keyup="enterSearch($event)"
                                       placeholder="请输入中文会员姓名、会员卡号或会员手机号进行搜索..." style="height: 34px;line-height: 7px;width: 495px;">
                                <span class="input-group-btn">
                                    <button type="button" ng-click="searchMember()" ladda="searchMemberCompleteFlag"
                                            class="btn btn-success">搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="nameChooseBox" ng-if="nameChooseBoxOpen">
                                <ul>
                                    <li class="red">出现重复用户，请选择匹配的用户 ！</li>
                                    <li ng-repeat="nameChoose in nameChooseList" ng-click="nameChooseClick(nameChoose.member_id)">
                                        <span>{{nameChoose.name}}</span>
                                        <span ng-if="nameChoose.sex != 1 && nameChoose.sex != 2">&emsp;&emsp;暂无性别数据</span>
                                        <span ng-if="nameChoose.sex == 1">&emsp;&emsp;男</span>
                                        <span ng-if="nameChoose.sex == 2">&emsp;&emsp;女</span>
                                        <span style="vertical-align: middle;">&emsp;&emsp;{{nameChoose.mobile}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加课程Modal -->
    <div class="modal fade" tabindex="-1" id="addReservationCourse" role="dialog">
        <div class="modal-dialog" role="document" style="width: 680px;">
            <div class="modal-content clearfix">
                <input id="_csrf" type="hidden"
                       name="<?= \Yii::$app->request->csrfParam; ?>"
                       value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            ng-click="cancellationCourse()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myReservationCourse">预约课程</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5 addReservationCourseBodyDiv">
                            <div>
                                <img ng-if="searchMemberDetail.memberDetails.pic != null"
                                     ng-src="{{searchMemberDetail.memberDetails.pic}}" alt="">
                                <img ng-if="searchMemberDetail.memberDetails.pic == null" ng-src="/plugins/img/user.png"
                                     alt="">
                            </div>
                            <div>
                                <ul>
                                    <li class="addReservationCourseBodyDivLi">姓名:
                                        <span>{{searchMemberDetail.name}}</span></li>
                                    <li>手机号&emsp;: <span>{{searchMemberDetail.mobile}}</span></li>
                                    <li style="margin-top: 10px;">会员卡号: <span>{{searchMemberDetail.card_number}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-7  addReservationCourseBodyDiv2">
                            <div>
                                <ul class="addReservationCourseBodyDiv2Ul">
                                    <li><span class="red">*</span>私教产品</li>
                                    <li class="mL20">
                                        <div class="clearfix addReservationCourseBodyDiv2Ulli2Div"
                                             ng-click="privateCourseLists(searchMemberDetail.memberId)">
                                            <div class="fl">
                                                <img ng-src="{{privateCoursePic != null? privateCoursePic:'  '}}"
                                                   style="height: 50px;"  alt="">
                                            </div>
                                            <input value="readonly" readonly class="fl text-center cp"
                                                   ng-model="selectCourseName"/>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <ul class="addReservationCourseBodyDiv2Ul ">
                                    <li style="opacity: 0;"><span class="red">*</span>&emsp;&emsp;&emsp;&emsp;</li>
                                    <li class="mL20">
                                        <span ng-if="selectPrivateClass.total_num != null && selectPrivateClass.total_num != undefined">
                                            共{{selectPrivateClass.total_num}}节课</span>
                                        <span ng-if="selectPrivateClass.course_num != undefined">第{{selectPrivateClass.course_num }}节</span>
                                        <span ng-if="selectPrivateClass.course_name != undefined"> / {{selectPrivateClass.course_name}}</span>
                                        <span ng-if="selectPrivateClass.class_length != undefined"> / {{selectPrivateClass.class_length}}分钟</span>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 10px;">
                                <ul class="addReservationCourseBodyDiv3Ul">
                                    <li><span class="red">*</span>上课时间</li>
                                    <li class=" mL20 clearfix" style="position: relative; ">
                                        <div class="input-group clockpicker fl cp" data-autoclose="true"
                                             style="width: 90px; ">
                                            <input readonly name="dayStart" ng-model="startClass" type="text"
                                                   class="input-sm form-control text-center startClass"
                                                   placeholder="起始时间" ng-change="blueDate(startClass)">
                                        </div>
                                        <div class="input-group fl cp"
                                             ng-if="startClass != null && endClass != null && startClass != ''"
                                             style="width: 90px;margin-left: 20px; font-size: 14px; line-height: 28px; ">
                                            {{endClass |date: 'HH:mm'}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--                            55555555-->
                            <!--                            <div>-->
                            <!--                                <ul class="addReservationCourseBodyDiv2Ul">-->
                            <!--                                    <li><span class="red">*</span>私教产品</li>-->
                            <!--                                    <li class="mL20">-->
                            <!--                                        <div class="clearfix addReservationCourseBodyDiv2Ulli2Div"  ng-click="privateCourseLists(searchMemberDetail.memberId)" >-->
                            <!--                                            <div class="fl">-->
                            <!--                                                <img  ng-src="{{privateCoursePic != null? privateCoursePic:'  '}}"   alt="" >-->
                            <!--                                            </div>-->
                            <!--                                            <input  value="readonly" readonly  class="fl text-center cp"  ng-model="selectCourseName" />-->
                            <!--                                        </div>-->
                            <!--                                    </li>-->
                            <!--                                </ul>-->
                            <!--                            </div>-->
                            <!--                            <div>-->
                            <!--                                <ul class="addReservationCourseBodyDiv2Ul " >-->
                            <!--                                    <li style="opacity: 0;"><span class="red">*</span>&emsp;&emsp;&emsp;&emsp;</li>-->
                            <!--                                    <li class="mL20">-->
                            <!--                                       <span ng-if="selectPrivateClass.total_num != null && selectPrivateClass.total_num != undefined">共{{selectPrivateClass.total_num}}节课</span> <span ng-if="selectPrivateClass.course_num != undefined">第{{selectPrivateClass.course_num }}节</span><span ng-if="selectPrivateClass.course_name != undefined"> / {{selectPrivateClass.course_name}}</span><span ng-if="selectPrivateClass.class_length != undefined"> / {{selectPrivateClass.class_length}}分钟</span>-->
                            <!--                                    </li>-->
                            <!--                                </ul>-->
                            <!--                            </div>-->
                            <!--                            <div style="margin-top: 10px;">-->
                            <!--                                <ul class="addReservationCourseBodyDiv3Ul" >-->
                            <!--                                    <li ><span class="red">*</span>上课时间</li>-->
                            <!--                                    <li class=" mL20 clearfix" style="position: relative; ">-->
                            <!--                                        <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
                            <!--                                            <input  readonly name="dayStart"  ng-model="startClass"  type="text" class="input-sm form-control text-center startClass placeholder-color"  placeholder="起始时间" ng-change="blueDate(startClass)">-->
                            <!--                                        </div>-->
                            <!--                                        <div class="input-group fl cp" ng-if="startClass != null && endClass != null && startClass != ''" style="width: 90px;margin-left: 20px; font-size: 14px; line-height: 28px; ">-->
                            <!--                                                {{endClass |date: 'HH:mm'}}-->
                            <!--                                        </div>-->
                            <!--                                    </li>-->
                            <!--                                </ul>-->
                            <!--                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="button" ng-click="completeOrderCourse()" ladda="completeOrderCourseFlag"
                                    class="btn btn-success" style="padding: 4px 40px;">完成
                            </button>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--      选择会员卡模态框-->
    <div class="modal" id="chooseMemberCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">请选择会员卡</h4>
                </div>
                <div class="modal-body">
                    <label>请选择您想用来登记的会员卡号：</label>
                    <select ng-model="chooseMemberCardId" id="chooseMemberCardId"
                            style="margin-left: 20px;width: 175px;height: 30px;font-size: 16px;">
                        <option value="">请选择会员卡号</option>
                        <option ng-repeat="userInfo in allMemberCardList" value="{{userInfo.card_number}}">
                            {{userInfo.card_name}}
                        </option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ladda="chooseMemberCardIdBool"
                            ng-click="chooseMemberCardIdOk(chooseMemberCardId)">完成
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--选择课程-->
    <div class="modal fade" id="selectPrivateCourseModal" tabindex="-1" role="dialog" onload="load()">
        <div class="modal-dialog" role="document" style="width: 720px;" id="loading">
            <div class="modal-content clearfix" style="width:900px; ">
                <div class="modal-header">
                    <div class="selectPrivateCourseModalHeader">
                        <span ng-click="backAddPrivate()" class="glyphicon glyphicon-menu-left f16 cp"
                              style="color: #999;margin-top: 0px;padding: 6px 10px;"></span>
                        <h4 class=" f14">选择私课</h4>
                        <div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                </div>
                <div style="height:360px;overflow-y: scroll;">
                    <!--                    私课信息列表-->
                    <table class="table table-hover">
                        <thead>
                        <tr role="row">
                            <th>
                                图片
                            </th>
                            <th>
                                课程名称
                            </th>
                            <th>
                                剩余/总节数
                            </th>
                            <th>
                                办理日期
                            </th>
                            <th>
                                到期日期
                            </th>
                            <th>
                                办理金额
                            </th>
                            <th>
                                课时费
                            </th>
                            <th>
                                操作
                            </th>
                        </tr>
                        </thead>
                        <tbody class="courseListDataBox">
                        <tr ng-repeat="qq in aloneData">
                            <td>
                                <li class="fl">
                                    <img
                                        ng-if="qq.memberCourseOrderDetails[0].pic != '' && qq.memberCourseOrderDetails[0].pic != undefined"
                                        style="border-radius:4px; " ng-src="{{qq.memberCourseOrderDetails[0].pic}}"
                                        width="66px" height="66px" alt="">
                                    <img
                                        ng-if="qq.memberCourseOrderDetails[0].pic == '' || qq.memberCourseOrderDetails[0].pic == undefined"
                                        style="border-radius:4px; " ng-src="/plugins/user/images/noPic.png" width="66px"
                                        height="66px">
                                </li>
                            </td>
                            <td>{{qq.product_name}}</td>
                            <td>{{qq.overage_section}}/{{qq.course_amount}}</td>
                            <td>{{qq.create_at != null ? (qq.create_at *1000 | date:'yyyy-MM-dd '):'暂无数据'}}</td>
                            <td>{{qq.deadline_time != null ? (qq.deadline_time *1000 | date:'yyyy-MM-dd '):'暂无数据'}}</td>
                            <td ng-if="qq.money_amount != null">{{qq.money_amount}}元</td>
                            <td ng-if="qq.money_amount == null">暂无数据</td>
                            <td>{{ qq.one_price }}</td>
                            <td>
                                <li class="fr marginTop1">
                                    <button
                                        ng-click="selectPrivateCourse(qq.memberCourseOrderDetails[0].id,qq.memberCourseOrderDetails[0].pic,qq.product_name,qq)"
                                        style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn" ng-disabled="qq.status == '2'">选择私课
                                    </button>
                                </li>
                            </td>
                            <!--                            <ul class="clearfix courseLists courseListsww" ng-repeat="qq in aloneData"  >-->
                            <!--                                <li class="fl">-->
                            <!--                                    <img ng-if="qq.memberCourseOrderDetails[0].pic != '' && qq.memberCourseOrderDetails[0].pic != undefined" style="border-radius:4px; " ng-src="{{qq.memberCourseOrderDetails[0].pic}}" width="66px" height="66px" alt="">-->
                            <!--                                    <img ng-if="qq.memberCourseOrderDetails[0].pic == '' || qq.memberCourseOrderDetails[0].pic == undefined" style="border-radius:4px; " ng-src="/plugins/user/images/noPic.png" width="66px" height="66px" >-->
                            <!--                                </li>-->
                            <!--                                <li class="fl courseListswwLi">-->
                            <!--                                    <ul>-->
                            <!--                                        <li><h4 class="f16">{{qq.product_name}}</h4></li>-->
                            <!--                                        <li class="f12 courseListswwLiqqqq">  {{qq.memberCourseOrderDetails[0].course_name}}<span ng-if="qq.memberCourseOrderDetails[0].course_num != null">{{qq.course_amount}}节&emsp;剩{{qq.overage_section}}节</span> </li>-->
                            <!--                                        <li class="gradeImg">-->
                            <!--                                            <img ng-src="/plugins/img/x1.png" alt="">-->
                            <!--                                            <img ng-src="/plugins/img/x1.png" alt="">-->
                            <!--                                            <img ng-src="/plugins/img/x1.png" alt="">-->
                            <!--                                            <img ng-src="/plugins/img/x1.png" alt="">-->
                            <!--                                            <img ng-src="/plugins/img/x2.png" alt="">-->
                            <!--                                        </li>-->
                            <!--                                    </ul>-->
                            <!--                                </li>-->
                            <!--                                <li class="fr marginTop1" >-->
                            <!--                                    <button  ng-click="selectPrivateCourse(qq.memberCourseOrderDetails[0].id,qq.memberCourseOrderDetails[0].pic,qq.product_name,qq)" style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课</button>-->
                            <!--                                </li>-->
                            <!--                            </ul>-->
                        </tr>
                        <tr ng-repeat="ww in manyData">
                            <td>
                                <li class="fl">
                                    <img
                                        ng-if="ww.memberCourseOrderDetails[0].pic != '' && ww.memberCourseOrderDetails[0].pic != undefined "
                                        ng-src="{{ww.memberCourseOrderDetails[0].pic}}" style="border-radius:4px; "
                                        width="66px" height="66px" alt="">
                                    <img
                                        ng-if="ww.memberCourseOrderDetails[0].pic == '' || ww.memberCourseOrderDetails[0].pic == undefined "
                                        ng-src="/plugins/user/images/noPic.png" style="border-radius:4px; " width="66px"
                                        height="66px" alt="">
                                </li>
                            </td>
                            <td>{{ww.product_name}}</td>
                            <td>{{ww.overage_section}}/{{ww.course_amount}}</td>
                            <td>{{ww.create_at != null ? (ww.create_at *1000 | date:'yyyy-MM-dd '):'暂无数据'}}</td>
                            <td>{{ww.deadline_time != null ? (ww.deadline_time *1000 | date:'yyyy-MM-dd '):'暂无数据'}}</td>
                            <td>{{ww.money_amount}}元</td>
                            <td ng-if="ww.money_amount == null">暂无数据</td>
                            <td>{{ww.one_price}}</td>
                            <td>
                                </li>
                                <li class="fr marginTop5">
                                    <button
                                        ng-click="selectPrivateCourse(ww.memberCourseOrderDetails[0].id,ww.memberCourseOrderDetails[0].pic,ww.product_name,ww)"
                                        style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课
                                    </button>
                                </li>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--                    <ul class="clearfix courseListsManyData" ng-repeat="ww in manyData" >-->
                    <!--                        <li class="fl">-->
                    <!--                            <img ng-if="ww.memberCourseOrderDetails[0].pic != '' && ww.memberCourseOrderDetails[0].pic != undefined " ng-src="{{ww.memberCourseOrderDetails[0].pic}}" style="border-radius:4px; " width="66px" height="66px" alt="">-->
                    <!--                            <img ng-if="ww.memberCourseOrderDetails[0].pic == '' || ww.memberCourseOrderDetails[0].pic == undefined " ng-src="/plugins/user/images/noPic.png" style="border-radius:4px; " width="66px" height="66px" alt="">-->
                    <!--                        </li>-->
                    <!--                        <li class="fl marginTop2" >-->
                    <!--                            <ul class="marginTop3">-->
                    <!--                                <li><h4 class="f16">{{ww.product_name}}</h4></li>-->
                    <!--                                <li class="f12 marginTop6"><span ng-repeat="q in ww.memberCourseOrderDetails"><span >{{q.course_name}}{{q.course_num}}节&emsp;剩{{q.overage_section}}节</span> </span></li>-->
                    <!--                                <li class="gradeImg marginTop4">-->
                    <!--                                    <img ng-src="/plugins/img/x1.png" alt="">-->
                    <!--                                    <img ng-src="/plugins/img/x1.png" alt="">-->
                    <!--                                    <img ng-src="/plugins/img/x1.png" alt="">-->
                    <!--                                    <img ng-src="/plugins/img/x1.png" alt="">-->
                    <!--                                    <img ng-src="/plugins/img/x2.png" alt="">-->
                    <!--                                </li>-->
                    <!--                            </ul>-->
                    <!--                        </li>-->
                    <!--                        <li class="fr marginTop5" >-->
                    <!--                            <button   ng-click="selectPrivateCourse(ww.memberCourseOrderDetails[0].id,ww.memberCourseOrderDetails[0].pic,ww.product_name,ww)" style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课</button>-->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                    <!--                    暂无数据调用方法 href 取消返回主页 text改变提示信息 -->
                    <?= $this->render('@app/views/common/nodata.php', ['href' => false, 'text' => '未搜索到有效私教课程']); ?>
                </div>
            </div>
        </div>
    </div>
</main>
