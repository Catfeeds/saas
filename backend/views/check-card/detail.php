<?php
use backend\assets\CheckCardCtrlAsset;

CheckCardCtrlAsset::register($this);
$this->title = '会员信息';
?>
<div class="col-sm-12 dataId  MemberInfoDetail pdLr0" ng-controller="checkCardCtrl" ng-cloak data-id="<?= $id; ?>">
    <div class="col-sm-3">
        <h5 class="memberInfoDetailH5">
            <a href="/check-card/index?c=33">
                <span class="glyphicon glyphicon-menu-left "></span>
            </a>
        </h5>
        <div class="col-sm-12 text-center memberInfoDetailDiv1">
            <div>
                <input id="_csrf" type="hidden"
                       name="<?= \Yii::$app->request->csrfParam; ?>"
                       value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                <div class="input-file ladda-button btn ng-empty uploader pd0"
                     id="imgFlagClass"
                     ng-if="memberData.pic == null"
                     ngf-drop="uploadCover($file,'update')"
                     ladda="uploading"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                    <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'upload')) { ?>
                        ngf-select="uploadCover($file,'update')"
                    <?php } ?>
                           style="padding: 0;height: 155px;width: 155px;">
                    <img ng-src="{{memberData.pic}}" style="border-radius: 50%;width: 150px;height: 150px" ng-if="memberData.pic != null">
                    <img ng-src="/plugins/checkCard/img/11.png" style="width: 150px;height: 150px;" ng-if="memberData.pic == null">
                </div>
                <div class="input-file ladda-button btn ng-empty uploader pd0"
                     id="imgFlagClass"
                     ng-if="memberData.pic != null"
                     ngf-drop="uploadCover($file,'update')"
                     ladda="uploading"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                    <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'UPDATEUPLOAD')) { ?>
                        ngf-select="uploadCover($file,'update')"
                    <?php } ?>
                     style="padding: 0;height: 155px;width: 155px;">
                    <img ng-src="{{memberData.pic}}" style="border-radius: 50%;width: 150px;height: 150px" ng-if="memberData.pic != null">
                    <img ng-src="/plugins/checkCard/img/11.png" style="width: 150px;height: 150px;" ng-if="memberData.pic == null">
                </div>
            </div>
        </div>
       

        <div class="marginLeft30" style="padding: 0 6px;">
            <div class="lineHeight30">会员姓名:{{memberData.name | noData:''}}
<!--                --><?php //if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'UPDATEVENUE')) { ?>
<!--                 <span-->
<!--                     ng-click="updateMemberInVenue(memberData.venue_id)"-->
<!--                     class="btn btn-success btn-sm"-->
<!--                     type="submit"-->
<!--                     style="min-width: 60px;margin-bottom: 2px;">-->
<!--                             <a href="" style="color:#fff;margin-top: 5px;">修改归属场馆</a>-->
<!--                 </span>&nbsp;&nbsp;-->
<!--                --><?php //} ?>
            </div>
            <div class="lineHeight30">所属场馆:{{memberData.venueName|noData:''}}</div>
            <div class="lineHeight30">会员卡号:{{memberData.card_number|noData:''}}</div>
            <div class="lineHeight30">卡的名称:{{memberData.cardName|noData:''}}</div>
            <div class="lineHeight30"ng-if="leaveType == null">请假类型:正常请假</div>
            <div class="lineHeight30"ng-if="leaveType == 1">请假类型:学生请假</div>
            <!--            <div style="line-height: 30px">会员编号:{{memberData.id}}</div>-->
            <div class="lineHeight30" ng-if="memberData.sex == 1">会员性别:男</div>
            <div class="lineHeight30" ng-if="memberData.sex == 2">会员性别:女</div>
            <div class="lineHeight30" ng-if='memberData.mobile !=0'>手机号码:{{memberData.mobile|noData:''}}
                <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'UPDATEMOBILE')) { ?>
             <span ng-click="phoneAndSexEdit(memberData.mobile,memberData.sex)" class="btn btn-success btn-sm" type="submit" style="min-width: 60px;margin-bottom: 2px;">
<!--                   style="margin-left: 34px;">-->
                                             <a href=""
                                                style="color:#fff;margin-top: 5px;">
                                                修改</a>
                                        </span>&nbsp;&nbsp;
                <?php } ?>
            </div>
            <div class="lineHeight30" ng-if='memberData.mobile ==0'>手机号码:暂无数据
                <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'UPDATEMOBILE')) { ?>
             <span  ng-click="phoneAndSexEdit()" class="btn btn-success btn-sm" type="submit" style="min-width: 60px;margin-bottom: 2px;">
<!--                   style="margin-left: 34px;">-->
                                             <a href=""
                                                style="color:#fff;margin-top: 5px;">
                                                修改</a>
                                        </span>&nbsp;&nbsp;
                <?php } ?>
            </div>
            <div class="lineHeight30">会籍顾问:{{memberData.employeeName|noData:''}}</div>
            <div class="lineHeight30">私教名称:{{memberData.coach.name|noData:''}}</div>
            <div class="lineHeight30" ng-if="memberData.cabinet != null">柜子号码:{{memberData.cabinet.type_name}}&nbsp;<em
                    style="font-size: 18px;font-weight: 700"> {{memberData.cabinet.cabinet_number}}</em></div>
            <div class="lineHeight30 displayFlexJustifyContentCenter" data-toggle="modal" data-target="#myModals2"
                 ng-click="getMemberDataCard(memberData.id,memberData.memberCard_id)"><b class="viewUserDetails">点击查看用户详情</b>
            </div>
            <div class="col-sm-12 pdLr0">
                <div class="col-sm-4 pdLr0 clearfix self-Adaption">
                    <button ng-if="memberData.nowLeaveStatus.length == 0 && memberData.vice_card != 1" ng-disabled="((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times >= memberData.total_times) || currentTime> disabledDate)" data-toggle="modal" ng-click="leaveBut(memberData.id,memberData.memberCard_id)"
                          class="btn btn-sm btn-primary fl clearfixSpan1 " type="submit">
                                                 <a>请假</a>
                    </button>
                    <button ng-if="memberData.nowLeaveStatus.length != 0"
                        <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'XIAOJIA')) { ?>
                            ng-click="removeMemberLeave(memberData.nowLeaveStatus.id)"
                        <?php } ?>
                        <?php if (!\backend\models\AuthRole::canRoleByAuth('checkCard', 'XIAOJIA')) { ?>
                            disabled
                        <?php } ?>
                            class="btn btn-sm btn-default fl clearfixSpan1" type="submit" style="color: #000;">
                    <!--                            class="btn btn-sm btn-default fl " type="submit" style="color: #000;margin-top: 20px;min-width: 60px;">-->
                                                 <a style="color: #000;">销假</a>
                    </button>
                </div>
                <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'GROUND')) { ?>
                <div class="col-sm-4 pdLr0 clearfix self-Adaption self-btns"  ng-if="memberData.main_card_status == 1 || memberData.main_card_status == 0">
                    <button ng-click="fieldModals(backDetailId)" ng-disabled="((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times >= memberData.total_times) || currentTime> disabledDate)" class="btn btn-sm btn-success  clearfixSpan1" type="button" class="btn btn-sm btn-primary fl clearfixSpan1" >
                        <a>场地</a>
                    </button>
                </div>
                <?php } ?>

                <?php if (\backend\models\AuthRole::canRoleByAuth('checkCard', 'ABOUT')) { ?>
<!--                    <div class="col-sm-4 pdLr0 clearfix self-Adaption self-btn" style="margin-top:20px;" ng-if="memberData.main_card_status == 1">-->
                    <div class="col-sm-4 pdLr0 clearfix self-Adaption self-btn" ng-if="memberData.main_card_status == 1 || memberData.main_card_status == 0">
                        <a ng-click="aboutCourse(backDetailId)" class="pull-left clearfixA">
                            <button ng-disabled="((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times >= memberData.total_times)|| currentTime> disabledDate)"
                                    class="btn btn-info btn-sm clearfixSpan1"
                                                                                           type="submit">约课</button></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-9 marginTop30">
        <div class="row divBox1">
            <div class="mL15 clearfix" style="display: flex;align-items: center;">
                <div class="fl">
                <!-- 异常图标-->
                <img class="memberDataStatusImg fl"
                     ng-if="memberData.mc_status != 1 || memberData.main_card_status == 0 || currentTime > memberData.invalid_time || memberData.nowLeaveStatus.length == undefined || (carFifteenDate <= currentTime && currentTime<= disabledDate && memberData.mc_status == 1)  || memberData.status == 2 || (memberData.cardCategory.category_type_id == 2 && memberData.consumption_times >= memberData.total_times)"
                     src="/plugins/img/exclamation.png ">
                <!-- 正常图标-->
                <img class="memberDataStatusImg fl"
                     ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined &&  currentTime < carFifteenDate && memberData.status != 2 && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 &&  memberData.consumption_times < memberData.total_times)) )"
                     src="/plugins/img/query.png">
                </div>
                <section class="fl marginLeft10" style="max-width: 800px;">
<!--                    没有租柜子的情况下-->
                    <div class="sectionDivColor1"
                         ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime  && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                        正常状态 <span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                    </div>
                    <div class="sectionDivColor"
                         ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 0 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                        暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                    </div>
                    <div  class="sectionDivColor"
                    ng-if="memberData.mc_status == 5 && currentTime < memberData.invalid_time">
                        挂起状态
                    </div>
                    <div  class="sectionDivColor col-md-12"
                          ng-if="memberData.mc_status == 2 && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==2">
                        异常状态,该卡进行了跨店升级！
                    </div>
                    <div  class="sectionDivColor col-md-12"
                          ng-if="memberData.mc_status == 2 && memberData.newCardNum == null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.quit_status == 1">
                        会员卡已退费，异常状态！
                    </div>
                    <div  class="sectionDivColor col-md-12"
                          ng-if="memberData.mc_status == 2 && memberData.newCardNum != null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==1">
                        卡已升级，异常状态，升级后卡号为：{{memberData.newCardNum}}
                    </div>
                    <div  class="sectionDivColor col-md-12"
                          ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 1 && currentTime < memberData.invalid_time && memberData.status != 2">
                        团课爽约，冻结状态·请联系有解冻权限的人员解冻该卡！
                    </div>
                    <div  class="sectionDivColor col-md-12"
                          ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 2 && currentTime < memberData.invalid_time && memberData.status != 2">
                        会员卡冻结状态·请联系有解冻权限的人员解冻该卡！
                    </div>
                    <div  class="sectionDivColor1"
                          ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))  && memberData.main_card_status == 1">
                        通店状态<span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                    </div>
<!--                    <div  class="sectionDivColor1"-->
<!--                          ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && currentTime < cabinetFifteenDate && cabinetFifteenDate != undefined && (memberData.cardCategory.category_type_id != 2 || (memberData.cardCategory.category_type_id == 2 &&  memberData.consumption_times < memberData.total_times)))">-->
<!--                        通店状态-->
<!--                    </div>-->
                    <div  class="sectionDivColor"
                          ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))&& memberData.main_card_status == 0">
                        暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                    </div>
                    <div class="sectionDivColor" ng-if="memberData.status == 2">会员已冻结·请联系管理员解冻该会员！</div>
                    <div class="sectionDivColor"
                         ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 1">
                        卡未激活·请刷卡激活！
                    </div>
                   
                     <div class="sectionDivColor"
                         ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 2">
                        此卡送人中，请补全资料...
                    </div>
                    <!-- jbq -->
                    <div class="sectionDivColor"
                         ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 0">
                        暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                    </div>
                    <div class="sectionDivColor"
                         ng-if="memberData.mc_status == 1 && memberData.nowLeaveStatus.status == 1 && memberData.status != 2 ">请假中！请先销假
                    </div>
                    <div class="sectionDivColor" ng-if=" currentTime > memberData.invalid_time && memberData.status != 2">卡已到期·请及时续费！</div>
<!--                    卡激活后即将到期-->
                    <div class="sectionDivColor"
                         ng-if="((carFifteenDate <= currentTime && currentTime<= disabledDate && memberData.mc_status == 1 && memberData.status != 2) ) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times) || (memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 1)">
                        即将到期
                    </div>
                    <div class="sectionDivColor"
                        ng-if="((carFifteenDate <= currentTime  && memberData.mc_status == 1 && memberData.status != 2)) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 0)">
                        暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                    </div>
                    <div class="sectionDivColor" ng-if="memberData.cardCategory.category_type_id == 2 && currentTime<= disabledDate && memberData.mc_status == 1 && memberData.cardCategory.category_type_id == 2 && (memberData.consumption_times >= memberData.total_times)">次数用完</div>
                    <!--                    <div style="color: #00CC00;font-size: 15px;">请取毛巾一套</div>-->
                    <div>本周到场{{memberData.entryWeek}}次/本月到场{{memberData.entryMonth}}次/一年内到场{{memberData.entryYear}}次
                    </div>
                    <div ng-if="memberData.fewDays == 0">
                        此卡第一次进馆
                    </div>
                    <div ng-if="absentTimes != 0">
                        您的爽约次数为：{{absentTimes}}次
                    </div>
                    <div ng-if="memberData.active_time != ''&& memberData.active_time != null && memberData.active_time != undefined">
                        您的卡有效期为:
                        <span style="color: #ff9933;font-size: 14px;">{{memberData.active_time*1000 | date:'yyyy-MM-dd'}}</span>
                        至
                        <span style="color: #ff9933;font-size: 14px;">{{memberData.invalid_time*1000 | date:'yyyy-MM-dd'}}</span>
                    </div>
                    <div ng-if="todayTimesTemp > memberData.fewDays && memberData.fewDays > 0 && memberData.status == '1'">
                        今天第一次进馆
                    </div>
                    <div ng-if="memberData.fewDays > 0">
                        上次进馆时间为：{{memberData.fewDays*1000|date:'yyyy-MM-dd HH:mm:ss'}}
                    </div>
                    <div ng-if=" currentTime > memberData.invalid_time && memberData.status != 2">
                        <span >
                            您的卡到期时间为:
                            <b style="color: #FF9900;">{{memberData.invalid_time *1000 | date:'yyyy-MM-dd'}}</b>
                            ;
                        </span>
                    </div>
                    <div class="sectionDivColor3" ng-if="memberData.classRecord != null">
                        该会员已有{{memberData.classRecord.length}}次旷课记录，达到三次将锁卡三天不能预约课程
                    </div>
                    <div class="sectionDivColor4"
                         ng-if="carFifteenDate <= currentTime && currentTime<= disabledDate && memberData.mc_status == 1">
                        您的卡还有 <span style="font-size: 14px;color: #FF9900;"><span ng-if="intervalExpire > 0">{{intervalExpire}}天</span><span>{{intervalExpireHours}}时</span></span>到期，到期时间为: <span
                            style="font-size: 14px;color: #FF9900;">{{expireDateCh}}</span></div>
                    <div class="lineHeight30"
                         ng-if="memberData.mc_status == 1 && memberData.status != 2 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire">
                        更衣柜 <span style="color: #ff9933;font-size: 14px;">{{memberData.cabinet.cabinet_number}}</span>还有
                        <span style="color: #ff9933;font-size: 14px;">{{cabinetExpireDay}}天</span>到期，到期时间为: <span
                            style="color: #ff9933;font-size: 14px;">{{cabinetExpireDateCh | noData:'' }}</span></div>
                    <div ng-if="AllExpirePrivateCourse.length > 0">
                        <div ng-repeat="privateCourse in AllExpirePrivateCourse" ng-if="currentTime >= (privateCourse.deadline_time - 15*24*60*60) ||(carFifteenDate <= currentTime && currentTime<= disabledDate && privateCourse.deadline_time>=(memberData.invalid_time -15*24*60*60))">您的{{privateCourse.product_name}}即将到期，到期时间为 <b style="color: #FF9900;">{{privateCourse.deadline_time *1000 | date:'yyyy-MM-dd'}}</b>;</div>
                    </div>
                </section>
            </div>
            <div class="col-sm-11 mL15 checkCardTable ">
                <div class="ibox float-e-margins">
                    <div class="ibox-title checkCardTableBoxTitle">
                        <h5>预约课程</h5>
                    </div>
                    <div class="ibox-content checkCardTableBox">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>场馆</th>
                                <th>课程</th>
                                <th>时间</th>
                                <th>场地</th>
                                <th>教练</th>
                                <th>位置</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody style="overflow-y: scroll;">
                            <tr ng-repeat="item in aboutDatas" ng-if="item.status == 1">
                                <td>{{item.venueName}}</td>
                                <td>{{item.course.name}}</td>
                                <td>{{(item.start)*1000 | date:'yyyy/MM/dd'}} {{(item.start)*1000 | date:'HH:mm'}} -
                                    {{(item.end)*1000 | date:'HH:mm'}}
                                </td>
                                <td>{{item.classroom.name}}</td>
                                <td>{{item.coach.name}}</td>
                                <td>{{item.seat.rows}}排{{item.seat.seat_number}}号</td>
                                <td ng-if="item.is_print_receipt == 2">未打印</td>
                                <td ng-if="item.is_print_receipt == 1">已打印</td>
                                <td ng-if="item.is_print_receipt != 1 && item.is_print_receipt != 2">暂无打印信息</td>
                                <td class="checkPrint">
                                    <button ng-disabled="(item.start | checkPrint:printSetting:1)" class="btn btn-default  btn-sm" ng-click="aboutPrints(item)">打印</button>
                                    <button ng-disabled="(item.start | checkPrint:cancel_time:2)"  class="btn btn-default  btn-sm" ng-click="removeAboutClass(item.id)">取消预约</button>
                                </td>
<!--                                <td ng-if="(item.start | checkPrint:printSetting) === true">-->
<!--                                    已开课-->
<!--                                </td>-->
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'aboutNoData', 'text' => '无预约记录', 'href' => true]); ?>
                    </div>
                </div>

                <div class="ibox float-e-margins">
                    <div class="ibox-title checkCardTableBoxTitle">
                        <h5>场地预约</h5>
                    </div>
                    <div class="ibox-content checkCardTableDiv2" style="overflow:auto;height: 180px;">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>场馆</th>
                                <th>场地</th>
                                <th>时间段</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="con in siteReservationListData">
                                <td>{{con.venueName}}</td>
                                <td>{{con.yard_name}}</td>
                                <td>{{con.aboutDate}} {{con.about_interval_section}}</td>
                                <td ng-if="con.is_print_receipt == 2">未打印</td>
                                <td ng-if="con.is_print_receipt == 1">已打印</td>
                                <td ng-if="con.is_print_receipt != 1 && con.is_print_receipt != 2">暂无打印信息</td>
                                <td>
                                    <button class="btn btn-default  btn-sm" ng-click="aboutPrintsField(con)">打印</button>
                                <button class="btn btn-default  btn-sm" ng-click="removeDataSite(con.id,siteReservationListData.cardId,con, con.about_interval_section)">取消预约</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php', ['text' => '无预约记录', 'name' => 'siteReservationListDataBool','href' => true]); ?>
                    </div>
                </div>

                <div class="ibox float-e-margins">
                    <div class="ibox-title checkCardTableBoxTitle">
                        <h5>进馆记录</h5>
                    </div>
                    <div class="ibox-content checkCardTableDiv2">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-sm-4">场馆</th>
                                <th>日期</th>
                                <th>时间</th>
                            </tr>
                            </thead>
                            <tbody style="overflow-y: scroll;">
                            <tr ng-repeat="con in entryDatas">
                                <td>{{con.name}}</td>
                                <td>{{(con.entry_time)*1000 | date:'yyyy-MM-dd'}}</td>
                                <td>{{(con.entry_time)*1000 | date:'HH:mm'}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php', ['text' => '无进馆记录', 'href' => true]); ?>
                    </div>
                </div>

                <div ng-if="viceData == true" class="ibox float-e-margins">
                    <div class="ibox-title checkCardTableBoxTitle">
                        <h5>副卡信息</h5>
                    </div>
                    <div class="ibox-content checkCardTableDiv2">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-sm-4">副卡卡号</th>
                                <th>状态</th>
                                <th>绑定会员</th>
                                <th>手机号</th>
                                <th>绑定日期</th>
                            </tr>
                            </thead>
                            <tbody style="overflow-y: scroll;">
                            <tr ng-repeat="con in viceCards">
                                <td>{{ con.card_number }}</td>
                                <td ng-if="con.member.memberDetails.name">已绑定</td>
                                <td ng-if="!con.member.memberDetails.name">未绑定</td>
                                <td ng-if="con.member.memberDetails.name">{{ con.member.memberDetails.name }}</td>
                                <td ng-if="!con.member.memberDetails.name">暂无</td>
                                <td ng-if="con.member.mobile">{{ con.member.mobile }}</td>
                                <td ng-if="!con.member.mobile">暂无</td>
                                <td ng-if="con.create_at">{{ con.create_at*1000|date:'yyyy-MM-dd HH:mm:ss' }}</td>
                                <td ng-if="!con.create_at">暂无</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-12 text-right">
                        <div class="dataTables_paginate paging_simple_numbers"
                             id="DataTables_Table_0_paginate" style="margin-bottom: 100px">
                            <?= $this->render('@app/views/common/pagination.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer divFooterBox">
            <ul class="clearfix">
                <li class="fr marginRight30">
                    <button id="makeSure" ng-disabled="memberData.main_card_status == 0" class="btn btn-success" ng-click="makeSure(memberData.memberCard_id)">确定
                    </button>
                </li>
                <li class="fr marginRight15">
                    <button class="btn btn-default" ng-disabled="aboutNoOneData"   ng-click="printTicket('day')">确定并打印整天课堂</button>
                </li>
                <li class="fr marginRight15">
                    <select class="form-control cp selectStyle"
                            ng-disabled="memberData.cardCategory.category_type_id != 4"
                            ng-if="memberData.cardCategory.category_type_id == 1">
                        <option value="1">按{{memberData.cardName}}时间卡消费</option>
                    </select>
                    <select class="form-control cp selectStyle"
                            ng-disabled="memberData.cardCategory.category_type_id != 4"
                            ng-if="memberData.cardCategory.category_type_id == 2">
                        <option value="1">按{{memberData.cardName}}次卡消费</option>
                    </select>
                    <select class="form-control cp selectStyle"
                            ng-disabled="memberData.cardCategory.category_type_id != 4"
                            ng-if="memberData.cardCategory.category_type_id == 3">
                        <option value="1">按{{memberData.cardName}}充值卡消费</option>
                    </select>
                    <select class="form-control cp selectStyle"
                            ng-disabled="memberData.cardCategory.category_type_id == 4"
                            ng-if="memberData.cardCategory.category_type_id == 4"
<!--                        <option value="">请选择消费方式</option>-->
<!--                        <option value="1">按{{memberData.cardName}}混合时间段消费</option>-->
                        <option value="1">按{{memberData.cardName}}混合卡消费</option>
                    </select>
                </li>
            </ul>
        </div>

        <div class="modal fade" id="fieldModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content clearfix" style="width: 700px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <div class="col-sm-2 mLF26" style="font-size: 16px;margin-top: 6px">预约时间</div>
                        <div class="col-sm-3 mLF26">
                            <div class="input-append date " id="dataLeave12" data-date-format="yyyy-mm-dd">
                                <input readonly class=" form-control h30 venueDateStartInput"
                                       type="text"
                                       placeholder="请选择开始日期"
                                       ng-model="startVenue"
                                />
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <h3 class="text-center " id="myModalLabel">
                            场地预约
                        </h3>
                    </div>
                    <div class="modal-body p0">
                        <div style="height: 400px;">
                            <div class="col-sm-12 borderBottom" style="padding: 20px 0 20px 0;">
                                <div class="col-sm-4 p0">
                                    <div class="col-sm-12 textAlignCenter"><strong>场地名称</strong></div>
                                </div>
                                <div class="col-sm-8 p0">
                                    <div class="col-sm-4 textAlignCenter"><strong>时间段</strong></div>
                                    <div class="col-sm-4 textAlignCenter "><strong>预约人数</strong></div>
                                    <div class="col-sm-4 textAlignCenter"><strong>操作</strong></div>
                                </div>
                            </div>
                            <div class="col-sm-12 p0">
                                <div class="col-sm-4 p0" id="contain" style="height: 320px;overflow: auto;">
                                    <div ng-click="selectSiteManagement(w.id,$index)" ng-repeat="($index,w) in listDataItems" class="SiteManagement pt10px borderBottom cursorPointer" style="padding: 10px 20px;">
                                        <div>
                                            <h3>{{w.yard_name}}</h3>
                                            <p class="pt10px">开放时间:{{w.business_time}}</p>
                                            <p class="pt10px">最多人数:{{w.people_limit}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 p0" style="height: 320px;overflow: auto;">
                                    <div class="col-sm-12 p0 borderBottom ths cursorPointer" ng-repeat="(key,value) in siteDetailsLeft.orderNumList" style="padding: 10px 0;">
                                        <div class="col-sm-4 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{key}}</div>
                                        <div class="col-sm-4 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                        <div class="col-sm-4 textAlignCenter lineHeight30 " ng-if="value.timeStatus == 2">{{key}}</div>
                                        <div class="col-sm-4 textAlignCenter lineHeight30 " ng-if="value.timeStatus == 2">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                        <div class="col-sm-4 textAlignCenter td">
                                            <button type="button" class="btn btn-sm btn-success" ng-click="siteReservation(key,1)" ng-disabled="isAboutYardStatus" ng-if="value.timeStatus == 2 && value.isAbout == false">预约</button>
                                            <button type="button" class="btn btn-sm btn-success" ng-if="value.timeStatus == 2 && value.isAbout == true" ng-click="cancelReservation(w.id,1,key)">取消预约</button>
<!--                                            ng-disabled="isAboutYardStatus"-->
                                            <button type="button"  class="btn btn-sm btn-default" data-toggle="modal" data-target="#siteManagementDetails" ng-click="siteManagementDetails(key,value.timeStatus)" >详情</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="siteManagementDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content clearfix" style="width: 750px;height: 500px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h3 class="text-center myModalLabel1" id="myModalLabel">
                            场地详情
                        </h3>
                    </div>
                    <div class="modal-body p0">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <td>姓名</td>
                                <th>场地名称</th>
                                <th>手机号</th>
                                <th>预约时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="h35px">
                                <td>序号</td>
                                <td>姓名</td>
                                <td>场地名称</td>
                                <td>手机号</td>
                                <td>预约时间</td>
                                <td>
                                    <button ng-click="siteReservation(aboutIntervalSection,2)" ng-disabled="isAboutYardStatus"  id="reservationMember"  type="button" class="btn-sm btn btn-success">
                                        预约场地
                                    </button>
                                </td>
                            </tr>
                            <tr ng-repeat="($index,w) in selectionTimeList" class="cursorPointer">
                                <td>{{nowPage*5 + $index+1}}</td>
                                <td>{{w.username}}</td>
                                <td>{{w.yard_name}}</td>
                                <td>{{w.mobile}}</td>
                                <td>{{w.create_at *1000 |date:'yyyy-MM-dd HH:mm' }}</td>
                                <td>
                                    <button  ng-click="cancelReservation(w.id,2,w.about_interval_section)" type="button" class="btn-sm btn btn-default">
                                        取消预约
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'detailInfos']); ?>
                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'detailPages']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 720px;">
                <div class="modal-content clearfix">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center">编辑手机号</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 heightCenter" >
                                <div class="form-group col-sm-4 col-sm-offset-1 text-right "><span class="red f16">*</span>输入手机号</div>
                                <div class="form-group col-sm-4 text-center">
                                    <input type="text" ng-if="memberData.mobile != 0" class="form-control" id="editMobile"
                                           maxlength="11" value="{{memberData.mobile}}" placeholder="请输入手机号">
                                    <input type="text" ng-if="memberData.mobile == 0" class="form-control" id="editMobile"
                                           maxlength="11" placeholder="暂无数据">
                                </div>
                            </div>
                            <div class="col-sm-12 heightCenter">
                                <div  class="col-sm-4 col-sm-offset-1 text-right "><span class="red f16">*</span>性别</div>
                                <div class="col-sm-4 text-center">
                                    <select class="form-control selectPd" ng-model="memberDefaultSex">
                                        <option value="">请选择性别</option>
                                        <option value="1" ng-selected="memberDefaultSexFlag ==1">男</option>
                                        <option value="2" ng-selected="memberDefaultSexFlag ==2">女</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer " style="text-align: center;">
                        <button id="submitMobile" style="width: 100px;" type="button" class="btn btn-success "
                                ng-click="updateMobile(memberData.id)">
                            完成
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            <!--            <div class="modal-dialog">-->
            <!--                <div class="modal-content">-->
            <!--                    <div class="modal-header">-->
            <!--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
            <!--                            &times;-->
            <!--                        </button>-->
            <!--                        <h3 class="text-center myModalLabel1" id="myModalLabel">-->
            <!--                            编辑手机号-->
            <!--                        </h3>-->
            <!--                    </div>-->
            <!--                    <div class="modal-body " style="margin-left: 0px;">-->
            <!--                        <div class="col-sm-12" style="margin-left: 0px;">-->
            <!--                            <div class="form-group col-sm-4 text-right">输入手机号</div>-->
            <!--                            <div class="form-group col-sm-6 text-center">-->
            <!--                                <input type="text" ng-if="memberData.mobile != 0" class="form-control" id="editMobile"-->
            <!--                                       maxlength="11" value="{{memberData.mobile}}" placeholder="请输入手机号">-->
            <!--                                <input type="text" ng-if="memberData.mobile == 0" class="form-control" id="editMobile"-->
            <!--                                       maxlength="11" placeholder="暂无数据">-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-sm-12">-->
            <!--                            <div  class="col-sm-4 text-right">性别</div>-->
            <!--                            <div class="col-sm-6 text-center">-->
            <!--                                <select class="form-control" ng-model="memberDefaultSex">-->
            <!--                                    <option value="1" selected>男</option>-->
            <!--                                    <option value="2">女</option>-->
            <!--                                </select>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!---->
            <!--                    </div>-->
            <!--                    <div class="modal-footer">-->
            <!--                        <center>-->
            <!--                            <button id="submitMobile" type="button" class="btn btn-success  btn-lg"-->
            <!--                                    ng-click="updateMobile(memberData.id)">-->
            <!--                                完成-->
            <!--                            </button>-->
            <!--                        </center>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
        <div class="modal fade" id="myModalsVenue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 720px;">
                <div class="modal-content clearfix">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center">修改归属场馆</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 heightCenter">
                                <div  class="col-sm-4 col-sm-offset-1 text-right "><span class="red f16">*</span>场馆</div>
                                <div class="col-sm-4 text-center">
                                    <select class="form-control selectPd" ng-model="currentVenueId">
                                        <option value="">请选择场馆</option>
                                        <option value="{{currentArr.id}}" ng-repeat="currentArr in currentVenue" ng-selected="memberDefaultSexFlag ==1">{{currentArr.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer " style="text-align: center;">
                        <button id="submitMobile" style="width: 100px;" type="button" class="btn btn-success "
                                ng-click="updateCurrentVenue(memberData.id)">
                            完成
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            <!--            <div class="modal-dialog">-->
            <!--                <div class="modal-content">-->
            <!--                    <div class="modal-header">-->
            <!--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
            <!--                            &times;-->
            <!--                        </button>-->
            <!--                        <h3 class="text-center myModalLabel1" id="myModalLabel">-->
            <!--                            编辑手机号-->
            <!--                        </h3>-->
            <!--                    </div>-->
            <!--                    <div class="modal-body " style="margin-left: 0px;">-->
            <!--                        <div class="col-sm-12" style="margin-left: 0px;">-->
            <!--                            <div class="form-group col-sm-4 text-right">输入手机号</div>-->
            <!--                            <div class="form-group col-sm-6 text-center">-->
            <!--                                <input type="text" ng-if="memberData.mobile != 0" class="form-control" id="editMobile"-->
            <!--                                       maxlength="11" value="{{memberData.mobile}}" placeholder="请输入手机号">-->
            <!--                                <input type="text" ng-if="memberData.mobile == 0" class="form-control" id="editMobile"-->
            <!--                                       maxlength="11" placeholder="暂无数据">-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-sm-12">-->
            <!--                            <div  class="col-sm-4 text-right">性别</div>-->
            <!--                            <div class="col-sm-6 text-center">-->
            <!--                                <select class="form-control" ng-model="memberDefaultSex">-->
            <!--                                    <option value="1" selected>男</option>-->
            <!--                                    <option value="2">女</option>-->
            <!--                                </select>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!---->
            <!--                    </div>-->
            <!--                    <div class="modal-footer">-->
            <!--                        <center>-->
            <!--                            <button id="submitMobile" type="button" class="btn btn-success  btn-lg"-->
            <!--                                    ng-click="updateMobile(memberData.id)">-->
            <!--                                完成-->
            <!--                            </button>-->
            <!--                        </center>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
        <!--请假-->
        <?= $this->render('@app/views/check-card/checkCardLeave.php'); ?>
    </div>
    <?= $this->render('@app/views/common/print.php') ?>
    <?= $this->render('@app/views/common/printOneDay.php') ?>
    <?= $this->render('@app/views/common/field.php') ?>
    <?= $this->render('memberDetail') ?>
</div>
