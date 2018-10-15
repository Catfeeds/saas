<?php
use backend\assets\WcheckCardAsset;

WcheckCardAsset::register($this);
$this->title = '进馆验卡';
?>
<div ng-controller="CheckCardCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li class="orderMenu"><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li><a href="/foreign-field-management/index">场地管理</a></li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <?php if(\backend\rbac\Config::isShow('weiluyou/yankaxiangqing')): ?>
                        <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" ng-click="enterCard()" data-toggle="tab">验卡详情</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('	weiluyou/huiyuanxiangqing')): ?>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" ng-click="getMembersData()">会员详情</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/huiyuanka')): ?>
                        <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab" ng-click="getMembersData()">会员卡</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/sijiao')): ?>
                        <li role="presentation"><a href="#profile2" aria-controls="profile2" role="tab" data-toggle="tab" ng-click="chargeClassinfo()">私教</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/tuanjiao')): ?>
                        <li role="presentation"><a href="#profile3" aria-controls="profile3" role="tab" data-toggle="tab" ng-click="groupClassInfo()">团教</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('	weiluyou/changdi')): ?>
                        <li role="presentation"><a href="#profile4" aria-controls="profile4" role="tab" data-toggle="tab" ng-click="yardrecordClassinfo()">场地</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/gengyigui')): ?>
                        <li role="presentation"><a href="#profile5" aria-controls="profile5" role="tab" data-toggle="tab" ng-click="getCabinetData()">更衣柜</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/xinxijilu')): ?>
                        <li role="presentation"><a href="#profile6" aria-controls="profile6" role="tab" data-toggle="tab" ng-click="getEntryRecordData()">信息记录</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/qingjia')): ?>
                        <li role="presentation"><a href="#profile7" aria-controls="profile7" role="tab" data-toggle="tab" ng-click="automaticLeave()">请假</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/xiaofei')): ?>
                        <li role="presentation"><a href="#profile8" aria-controls="profile8" role="tab" data-toggle="tab" ng-click="getHistoryData()">消费</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0">
            <div class="panel-body detialS">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-sm-7 col-xs-7" style="margin-bottom: 20px">
                                <div style="padding: 6px;float: left;"><span>进馆验卡:</span></div>
                                <div class="input-group" style="width: 400px">
                                    <input type="text" class="form-control" ng-keyup="enterSearch($event)" ng-model="cardNumber" placeholder="请刷卡或输入卡号、手机号、身份证号..." style="height: 30px;line-height: 7px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-success" ng-click="checkCardNumberMember()" style="margin-left: 13px; width: 102px; height: 30px; background-color: #3A85DE; border-radius: 4px 4px 4px 4px; border: 1px solid #FFFFFF;">搜索</button>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-5 text-right">
                                <a class="btn btn-sm btn-default" ng-disabled="noClick" ng-click="class()" href="javascript:void(0)">预约团课</a>
                                <a class="btn btn-sm btn-default" ng-disabled="noClick" ng-click="field()">预约场地</a>
                                <button class="btn btn-sm btn-warning" ng-disabled="noClick" ng-click="leaveWork()" style="padding: 5px 25px">请假</button>
                                <button class="btn btn-sm btn-success" ng-disabled="noClick" ng-click="makeSure(memberData.memberCard_id)" style="padding: 5px 25px; width: 160px; height: 30px;">进馆</button>
                            </div>
                            <div class="col-sm-12 nn" style="border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;">
                                <div class="row">
                                    <div class="col-sm-3 col-lg-2" style="padding-top: 10px">
                                        <div class="input-file ladda-button btn uploader pd0"
                                             id="imgFlagClass"
                                             style="padding: 0;width: 100%;">
                                            <img ng-src="{{memberData.pic}}" width="100%" height="210px" ng-if="memberData.pic">
                                            <img ng-src="/plugins/user/images/noPic.png" ng-if="!memberData.pic" style="float: left;margin:0;width: 100%;">
                                        </div>
                                        <div class="form-group size20" style="margin-top: 30px;">姓名:{{memberData.name | noData:''}}</div>
                                        <div class="form-group size13" ng-if="memberData.sex == 1">性别:男</div>
                                        <div class="form-group size13" ng-if="memberData.sex == 2">性别:女</div>
                                        <div class="form-group size13" ng-if='memberData.mobile !=0'>手机号:{{memberData.mobile|noData:''}}</div>
                                        <div class="form-group size13">会员类型:{{memberData.member_type=='1' ? '正式会员': memberData.member_type=='2'?'潜在会员' : '失效会员'|noData:''}}</div>
                                        <div class="form-group size13">
                                            会员状态:
                                            <span
                                                ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime  && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                                            正常 <span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 0 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 5 && currentTime < memberData.invalid_time">
                                            挂起状态
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==2">
                                            异常状态,该卡进行了跨店升级！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && memberData.newCardNum == null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.quit_status == 1">
                                            会员卡已退费，异常状态！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && memberData.newCardNum != null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==1">
                                            卡已升级，异常状态，升级后卡号为：{{memberData.newCardNum}}
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 1 && currentTime < memberData.invalid_time && memberData.status != 2">
                                            团课爽约，冻结状态·请联系有解冻权限的人员解冻该卡！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 2 && currentTime < memberData.invalid_time && memberData.status != 2">
                                            会员卡冻结状态·请联系有解冻权限的人员解冻该卡！
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))  && memberData.main_card_status == 1">
                                            通店状态<span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))&& memberData.main_card_status == 0">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                            <span ng-if="memberData.status == 2">会员已冻结·请联系管理员解冻该会员！</span>
                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 1">
                                            卡未激活·请刷卡激活！
                                        </span>

                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 2">
                                            此卡送人中，请补全资料...
                                        </span>
                                            <!-- jbq -->
                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 0">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 1 && memberData.nowLeaveStatus.status == 1 && memberData.status != 2 ">请假中！请先销假
                                        </span>
                                            <span ng-if=" currentTime > memberData.invalid_time && memberData.status != 2">卡已到期·请及时续费！</span>
                                            <!--                    卡激活后即将到期-->
                                        <span
                                            ng-if="((carFifteenDate <= currentTime && currentTime<= disabledDate && memberData.mc_status == 1 && memberData.status != 2) ) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times) || (memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 1)">
                                            即将到期
                                        </span>
                                        <span
                                            ng-if="((carFifteenDate <= currentTime  && memberData.mc_status == 1 && memberData.status != 2)) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 0)">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                        </div>
                                        <div class="form-group size13">会籍顾问:{{memberData.employeeName|noData:''}}</div>
                                        <div class="form-group size13" ng-if="memberData.cabinet != null">租赁柜:{{memberData.cabinet.type_name|noData:''}}/{{memberData.cabinet.end_rent*1000 | noData:''| date:'yyyy/MM/dd'}}</div>
                                        <div class="form-group size13" ng-if="memberData.cabinet == null">租赁柜:暂未购买</div>
                                        <div class="form-group size13">备注:{{memberData.note?memberData.note:'暂无'}}</div>
                                    </div>
                                    <div class="col-sm-6 col-lg-7" style="border-right: 1px solid #ddd;border-left: 1px solid #ddd">
                                        <div class="qq">
                                            <div class="ibox" style="padding-top: 10px;border: 0;box-shadow: none;">
                                                <div  class="notSign1 notSign statisticsFlag disB" style="position: relative">
                                                    <span >{{statisticsData.enter ? statisticsData.enter : '0'}}</span>
                                                    <span >近30天进馆次数</span>
                                                </div>
                                                <div  class="notSign2 notSign statisticsFlag disB" style="position: relative">
                                                    <span >{{statisticsData.course.type1 ? statisticsData.course.type1 : '0'}}</span>
                                                    <span >近30天上团课次数</span>
                                                </div>
                                                <div  class="notSign3 notSign statisticsFlag disB" style="position: relative">
                                                    <span >{{statisticsData.course.type2  ? statisticsData.course.type2 : '0'}}</span>
                                                    <span >累计爽约团课次数</span>
                                                </div>
                                                <div  class="notSign4 notSign statisticsFlag disB" style="position: relative">
                                                    <span >{{statisticsData.course.type3 ? statisticsData.course.type3 : '0'}}</span>
                                                    <span >近30天私课上课量</span>
                                                </div>
                                            </div>
                                            <div class="panel panel-default mm">
                                                <div class="panel-heading" style="padding: 10px 0 0 10px;border: 1px solid #ddd;position: relative">
                                                    <h5>团课预约</h5>
                                                    <a href="/wcheck-card/index#profile3" class="searchDetial"><span><<查看详情</span></a>
                                                </div>
                                                <div class="panel-body aa" style="padding: 0;">
                                                    <table class="fixTable table table-bordered" style="margin-bottom: 0">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 15%">课程</th>
                                                            <th style="width: 30%">时间</th>
                                                            <th style="width: 15%">场地</th>
                                                            <th style="width: 10%">状态</th>
                                                            <th style="width: 30%">操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody ng-class="{'minHeight': !allCourse.length}" style="height:130px;">
                                                        <tr ng-repeat="item in allCourse">
                                                            <td style="width: 15%">{{item.course.name}}</td>
                                                            <td style="width: 30%">{{(item.start)*1000 | date:'yyyy/MM/dd'}} {{(item.start)*1000 | date:'HH:mm'}} -
                                                                {{(item.end)*1000 | date:'HH:mm'}}
                                                            </td>
                                                            <td style="width: 15%">{{item.classroom.name}}</td>
                                                            <td style="width: 10%" ng-if="item.is_print_receipt == 2">未打印</td>
                                                            <td style="width: 10%" ng-if="item.is_print_receipt == 1">已打印</td>
                                                            <td style="width: 10%" ng-if="item.is_print_receipt != 1 && item.is_print_receipt != 2">暂无打印信息</td>
                                                            <td style="width: 30%" class="checkPrint">
                                                                <button ng-disabled="(item.start | checkPrint:printSetting:1)" class="btn btn-default  btn-sm" ng-click="aboutPrints(item)">打印</button>
                                                                <button ng-disabled="(item.start | checkPrint:cancel_time:2)"  class="btn btn-default  btn-sm" ng-click="removeAboutClass(item)">取消预约</button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'aboutNoOneData', 'text' => '无预约记录', 'href' => true]); ?>
                                                </div>
                                            </div>
                                            <div class="panel panel-default mm">
                                                <div class="panel-heading" style="padding: 10px 0 0 10px;border: 1px solid #ddd;position: relative">
                                                    <h5>场地预约</h5>
                                                    <a href="/wcheck-card/index#profile4" class="searchDetial"><span><<查看详情</span></a>
                                                </div>
                                                <div class="panel-body aa" style="padding: 0;">
                                                    <table class="fixTable table table-bordered scrolltable" style="margin-bottom: 0">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 20%">场地</th>
                                                            <th style="width: 35%">时间段</th>
                                                            <th style="width: 15%">状态</th>
                                                            <th style="width: 30%">操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody ng-class="{'minHeight': !siteReservationListData.length}" style="height:130px;">
                                                        <tr ng-repeat="item in siteReservationListData">
                                                            <td style="width: 20%">{{item.yard_name}}</td>
                                                            <td style="width: 35%">{{item.aboutDate}} {{item.about_interval_section}}</td>
                                                            <td style="width: 15%" ng-if="item.is_print_receipt == 2">未打印</td>
                                                            <td style="width: 15%" ng-if="item.is_print_receipt == 1">已打印</td>
                                                            <td style="width: 15%" ng-if="item.is_print_receipt != 1 && item.is_print_receipt != 2">暂无打印信息</td>
                                                            <td style="width: 30%" class="checkPrint">
                                                                <button ng-disabled="(item.start | checkPrint:printSetting:1)" class="btn btn-default  btn-sm" ng-click="aboutPrintsField(item)">打印</button>
                                                                <button ng-disabled="(item.start | checkPrint:cancel_time:2)"  class="btn btn-default  btn-sm" ng-click="cancelReservationYard(item)">取消预约</button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'siteReservationListDataBool', 'text' => '无预约记录', 'href' => true]); ?>
                                                </div>
                                            </div>
                                            <div class="panel panel-default mm">
                                                <div class="panel-heading" style="padding: 10px 0 0 10px;border: 1px solid #ddd;position: relative">
                                                    <h5>进馆记录</h5>
                                                    <a href="/wcheck-card/index#profile6" class="searchDetial"><span><<查看详情</span></a>
                                                </div>
                                                <div class="panel-body aa" style="padding: 0;">
                                                    <table class="fixTable table table-bordered" style="margin-bottom: 0">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 35%">场馆</th>
                                                            <th style="width: 20%">进馆时间</th>
                                                            <th style="width: 20%">进馆会员卡</th>
                                                            <th style="width: 25%">卡号</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody ng-class="{'minHeight': !entryDatas.length}" style="height:130px;">
                                                        <tr ng-repeat="item in entryDatas">
                                                            <td style="width: 35%">{{item.name}}</td>
                                                            <td style="width: 20%">{{(item.entry_time)*1000 | date:'yyyy-MM-dd'}}</td>
                                                            <td style="width: 20%">{{(item.memberCard.card_name)}}</td>
                                                            <td style="width: 25%">{{(item.memberCard.card_number)}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'dataInfo', 'text' => '无进馆记录', 'href' => true]); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-lg-3 pp" style="overflow-y: auto; padding-top: 10px">
                                        <div class="form-group cardBord" ng-repeat="(index, item) in allCardData" ng-click="cardClick(item, index)" ng-class="{check2: item.isBorder}">
                                            <div class="">
                                                <div class="col-sm-7 col-xs-7" style="padding-top: 10px;">
                                                    <span class="size20">{{item.card_name}}</span>
                                                </div>
                                                <div class="col-sm-5  col-xs-5 text-right" style="padding-top: 10px;">
                                                    <!--<div class="size20 nomal" ng-if="!item.leaveRecordOneMemberCard">-->
                                                    <div class="size20 nomal" ng-if="s < item.invalid_time *1000">
                                                        <span class="size20 nomal" ng-if="item.status == '1' && !item.leaveRecordOneMemberCard">正常</span>
                                                        <span class="size20 nomal" style="color:#fd8887" ng-if="item.status == '2'">异常</span>
                                                        <span class="size20 nomal" style="color: #ffd600d6" ng-if="item.status == '3'">冻结</span>
                                                        <span class="size20 nomal" style="color: #896cd0" ng-if="item.status == '4' && !item.leaveRecordOneMemberCard">未激活</span>
                                                        <span class="size20 nomal" style="color: #fad733" ng-if="item.status == '5'">挂起</span>
                                                        <span class="size20 nomal" style="color: #fad733" ng-if="item.leaveRecordOneMemberCard">请假</span>
                                                    </div>
                                                    <div ng-if="s > item.invalid_time *1000">
                                                        <span class="size20 nomal" style="color: #ddd" ng-if="item.status == '6'">已过期</span>
                                                        <span class="size20 nomal" style="color: #fad733">已到期</span>
                                                    </div>
                                                </div>
                                                <div style="position: absolute;left: 15px;bottom: 10px;">
                                                    <div class="size12 mgB">卡号:{{item.card_number}}</div>
                                                    <div class="size12 mgB">有效期:{{item.active_time *1000 | noData:''| date:'yyyy/MM/dd'}} - {{item.invalid_time *1000 | noData:''| date:'yyyy/MM/dd'}}</div>
                                                    <!--                                                    <div class="size12 mgB">剩余有效天数:{{item.active_time *1000 | noData:''| date:'yyyy/MM/dd' - item.invalid_time*1000 | noData:''| date:'yyyy/MM/dd' | noData:'天'}}</div>-->
                                                    <div class="form-group size12" ng-if="item.cardCategory.category_type_id == '1'">剩余有效天数:{{item.dd| noData:''}}天</div>
                                                    <div class="form-group size12" ng-if="item.cardCategory.category_type_id == '2'">剩余有效次数:{{item.total_times - item.consumption_times | noData:''}}次</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="row">
                            <div class="col-sm-12 vv" style="overflow-y: auto;">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class="col-sm-3">
                                            <div class="input-file ladda-button btn uploader pd0"
                                                 id="imgFlagClass"
                                                 style="padding: 0;width: 100%; text-align: left">
                                                <img ng-src="{{memberData.pic}}" width="65%" height="210px" ng-if="memberData.pic">
                                                <img ng-src="/plugins/user/images/noPic.png" ng-if="!memberData.pic" style="float: left;margin:0;width: 65%;">
                                            </div>
                                            <div class="form-group size20" style="margin-top: 10px;">姓名:{{memberData.name | noData:''}}</div>
                                            <div class="form-group size13" style="margin-top: 10px;">会员编号:{{memberData.card_number | noData:''}}</div>
                                            <div class="form-group size13" ng-if="memberData.sex == 1">性别:男</div>
                                            <div class="form-group size13" ng-if="memberData.sex == 2">性别:女</div>
                                            <div class="form-group size13" ng-if='memberData.mobile !=0'>手机号:{{memberData.mobile|noData:''}}</div>
                                            <div class="form-group size13" ng-if='memberData.mobile !=0'>生日:{{memberData.birth_date|noData:''}}</div>
                                            <div class="form-group size13">会员类型:{{memberData.member_type == '1'? '正式会员':memberData.member_type == '2'?'潜在会员':''|noData:''}}</div>
                                            <div class="form-group size13">
                                                会员状态:
                                            <span
                                                ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime  && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                                            正常 <span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && memberData.main_card_status == 0 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == false &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 5 && currentTime < memberData.invalid_time">
                                            挂起状态
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==2">
                                            异常状态,该卡进行了跨店升级！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && memberData.newCardNum == null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.quit_status == 1">
                                            会员卡已退费，异常状态！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 2 && memberData.newCardNum != null && currentTime < memberData.invalid_time && memberData.status != 2 && memberData.s_type ==1">
                                            卡已升级，异常状态，升级后卡号为：{{memberData.newCardNum}}
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 1 && currentTime < memberData.invalid_time && memberData.status != 2">
                                            团课爽约，冻结状态·请联系有解冻权限的人员解冻该卡！
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 3 && memberData.recent_freeze_reason == 2 && currentTime < memberData.invalid_time && memberData.status != 2">
                                            会员卡冻结状态·请联系有解冻权限的人员解冻该卡！
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))  && memberData.main_card_status == 1">
                                            通店状态<span style="color: #ff9933;font-size: 24px;" ng-if="(memberData.mc_status == 1 && memberData.cabinet != null &&  cabinetFifteenDate<=currentTime && currentTime<= cabinetExpire)">(柜子即将到期)</span>
                                        </span>
                                        <span
                                            ng-if="(memberData.mc_status == 1 && currentTime < memberData.invalid_time && memberData.nowLeaveStatus.length != undefined && memberData.status != 2 && memberData.is_apply == true &&  carFifteenDate > currentTime && (memberData.cardCategory.category_type_id != 2 || ( memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times)))&& memberData.main_card_status == 0">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                                <span ng-if="memberData.status == 2">会员已冻结·请联系管理员解冻该会员！</span>
                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 1">
                                            卡未激活·请刷卡激活！
                                        </span>

                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 1 && memberData.memberCard[0].usage_mode == 2">
                                            此卡送人中，请补全资料...
                                        </span>
                                                <!-- jbq -->
                                        <span
                                            ng-if="memberData.mc_status == 4 && memberData.status != 2 && memberData.main_card_status == 0">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                        <span
                                            ng-if="memberData.mc_status == 1 && memberData.nowLeaveStatus.status == 1 && memberData.status != 2 ">请假中！请先销假
                                        </span>
                                                <span ng-if=" currentTime > memberData.invalid_time && memberData.status != 2">卡已到期·请及时续费！</span>
                                                <!--                    卡激活后即将到期-->
                                        <span
                                            ng-if="((carFifteenDate <= currentTime && currentTime<= disabledDate && memberData.mc_status == 1 && memberData.status != 2) ) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id == 2 && memberData.consumption_times < memberData.total_times) || (memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 1)">
                                            即将到期
                                        </span>
                                        <span
                                            ng-if="((carFifteenDate <= currentTime  && memberData.mc_status == 1 && memberData.status != 2)) && memberData.nowLeaveStatus.status != 1 && memberData.status != 2 &&memberData.mc_status == 1 && ((memberData.cardCategory.category_type_id != 2) && memberData.main_card_status == 0)">
                                            暂无法进馆，主卡未到！( 主卡卡号：{{ memberData.main_card_number }} )
                                        </span>
                                            </div>
                                            <div class="form-group size13">会籍顾问:{{memberData.employeeName|noData:''}}</div>
                                            <div class="form-group size13">私教名称:{{memberData.coach.name|noData:''}}</div>
                                            <div class="form-group size13">证件号码:{{memberData.id_card|noData:''}}</div>
                                            <div class="form-group size13">IC卡号:{{memberData.custom_ic_number|noData:''}}</div>
                                            <div class="form-group size13">家庭住址:{{memberData.family_address?memberData.family_address:'暂无'}}</div>
                                            <div class="form-group size13" ng-if="memberData.cabinet != null">租赁柜:{{memberData.cabinet.type_name|noData:''}}/{{memberData.cabinet.end_rent*1000 | noData:''| date:'yyyy/MM/dd'}}</div>
                                            <div class="form-group size13" ng-if="memberData.cabinet == null">租赁柜:暂未购买</div>
                                            <div class="form-group size13">备注:{{memberData.note?memberData.note:'暂无'}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile1">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <b class="spanSmall">会员卡</b>
                            </div>
                            <div class="panel-body" style="padding: 0">
                                <div id="DataTables_Table_0_wrapper"
                                     class="dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover"
                                           id="DataTables_Table_0"
                                           aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">卡名称
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">卡号
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">办理日期
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">有效期
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">总次数
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">剩余次数
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">总金额
                                            </th>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">会籍顾问
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in allCardData">
                                            <td>{{item.card_name}}</td>
                                            <td>{{item.card_number}}</td>
                                            <td>{{item.create_at *1000 | noData:''|
                                                date:'yyyy/MM/dd'}}</td>
                                            <td>{{item.active_time *1000 | noData:''|
                                                date:'yyyy/MM/dd'}} - {{item.invalid_time *1000 |
                                                noData:''| date:'yyyy/MM/dd'}}</td>
                                            <td>{{item.total_times?item.total_times:'暂无'}}</td>


                                            <td>{{item.total_times - item.consumption_times?item.total_times - item.consumption_times:'暂无'}}</td>


                                            <td>{{item.amount_money|
                                                noData:'元'}}</td>
                                            <td>{{item.employee.name| noData:''}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'memberCardPages']); ?>
                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'memberCardNoDataShow', 'text' => '无会员卡记录', 'href' => true]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile2">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanSmall">私教</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0">
                                <table class="table table-striped table-bordered table-hover" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">私教课程
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">剩余/总节数
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">办理日期
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">到期日期
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">办理金额
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">办理私教
                                        </th>
                                        <th  tabindex="0"
                                             aria-controls="DataTables_Table_0" rowspan="1"
                                             colspan="1" aria-label="浏览器：激活排序列升序">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <tr ng-repeat = 'charge in chargeList' ng-click="getChargeClassDetail(data.id,charge.id)">
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.product_name | noData:''}}
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.overage_section | noData:''}}/{{charge.course_amount | noData:''}}
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.create_at *1000 | noData:''| date:'yyyy/MM/dd'}}
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.deadline_time *1000 | noData:''| date:'yyyy/MM/dd'}}
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.money_amount | noData:'元'}}
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals9">
                                            {{charge.employeeS.name | noData:''}}
                                        </td>
                                        <td class="tdBtn2">
                                            &nbsp;<button class="btn btn-sm btn-danger" ng-click="delChargeClass(charge.id)">删除</button></td>
                                    </tr>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'privatePages']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'chargeNotData','text'=>'无私教记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile3">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span><b class="spanSmall">团教</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0">
                                <table class="table table-striped table-bordered table-hover"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">场馆
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">卡名称
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">课程
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">场地
                                        </th>
                                        <!--                                                            <th class="sorting"tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">上课总次数</th>-->
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">日期时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">打印小票
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">刷手环时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">上课情况
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">教练
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat='group in groupList'>
                                        <td>
                                            {{group.groupClass.organization.name | noData:''}}
                                        </td>
                                        <td>
                                            {{group.memberCard.card_name}}
                                        </td>
                                        <td>
                                            {{group.groupClass.course.name | noData:''}}
                                        </td>
                                        <td>
                                            {{group.groupClass.classroom.name | noData:''}}
                                        </td>
                                        <td>{{group.class_date |
                                            noData:''}}&nbsp{{group.start*1000 | date:'HH:mm' }}
                                        </td>
                                        <td ng-if="group.is_print_receipt == 1">已打印</td>
                                        <td ng-if="group.is_print_receipt == 2">未打印</td>
                                        <td>{{  group.in_time*1000 | noData: '' | date:'yyyy/MM/dd HH:mm'  }}</td>
                                        <td><span ng-if=group.status==1>已预约</span>
                                            <span ng-if=group.status==2>已取消</span>
                                            <span ng-if=group.status==3>上课中</span>
                                            <span ng-if=group.status==4>已下课</span>
                                            <span ng-if=group.status==5>已下课</span>
                                            <span ng-if=group.status==6>已爽约</span>
                                            <span ng-if=group.status==7>已爽约</span>
                                        </td>
                                        <td>{{group.employee.name | noData:''}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'pageGroup']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'groupNotData','text'=>'无团课记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile4">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanSmall">场地</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0;">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 100px; font-size: 12px; color: rgba(140,140,140,1)">场地名称
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">卡名称
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">预约时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 100px; font-size: 12px; color: rgba(140,140,140,1)">预约区间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">操作
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="info in recordList">
                                        <td title="{{info.name}} - {{info.vName}}">
                                            {{info.name}} - {{info.vName}}
                                        </td>
                                        <td>
                                            {{info.card_name}}
                                        </td>
                                        <td>
                                            <span>{{info.create_at*1000 | date:"yyyy-MM-dd HH:mm"}}</span>
                                        </td>
                                        <td>
                                            {{(info.about_start*1000) | date:"yyyy-MM-dd HH:mm"}} - {{(info.about_end*1000) | date:"yyyy-MM-dd HH:mm"}}
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm hoverBtn tdBtn ng-scope" ng-if="info.status == 1 || info.status == 2" ng-click="cancelReservationYard(info)">取消场地预约
                                            </button>
                                            <button class="btn btn-error btn-sm hoverBtn tdBtn ng-scope" ng-if="info.status == 5" ng-disabled="info.status == 5">已取消场地
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'pageRecord']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'recordNotData','text'=>'无场地记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile5">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanSmall">更衣柜</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0;">
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 100px; font-size: 12px; color: rgba(140,140,140,1)">更衣柜名称
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">柜号
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">租用日期
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 100px; font-size: 12px; color: rgba(140,140,140,1)">消费日期
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">金额
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">行为
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            style="width: 120px; font-size: 12px; color: rgba(140,140,140,1)">经办人
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="cabinet in cabinets">
                                        <td>{{cabinet.type_name | noData:''}}</td>
                                        <td>{{cabinet.cabinet_number | noData:''}}</td>
                                        <td>{{cabinet.start_rent *1000 | noData:''| date:'yyyy/MM/dd'}} - {{cabinet.end_rent *1000 | noData:''| date:'yyyy/MM/dd'}}</td>
                                        <td ng-if="cabinet.rent_type == '退租金'">{{cabinet.back_rent *1000 | noData:''|
                                            date:'yyyy/MM/dd'}}</td>
                                        <td ng-if="cabinet.rent_type != '退租金'">{{cabinet.create_at *1000 | noData:''|
                                            date:'yyyy/MM/dd'}}
                                        </td>
                                        <td>{{cabinet.price | noData:'元'}}</td>
                                        <td>{{cabinet.rent_type}}</td>
                                        <td ng-if="cabinet.name != null && cabinet.name != ''">
                                            {{cabinet.name}}
                                        </td>
                                        <td ng-if="cabinet.name == null || cabinet.name == ''">
                                            暂无数据
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'cabinetPages']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'cabinetNoDataShow','text'=>'无柜子记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile6">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        <select class="form-control" ng-model="selectState"
                                                ng-change="SelectMessage(selectState)"
                                                style="padding-top: 0;padding-bottom: 0;display: inline-block; width: 200px; height: 30px; border: 1px solid #BBBBBB;">
                                            <option value="">到场离场信息</option>
                                            <option value="1">赠品记录</option>
                                            <option value="2">行为记录</option>
                                            <option value="3">送人记录</option>
                                            <option value="4">私教课延期</option>
                                            <option value="5">赠送天数</option>
                                            <option value="6">定金信息</option>
                                            <option value="7">会籍记录</option>
                                            <option value="8">转卡记录</option>
                                            <option value="9">私教变更</option>
                                            <option value="10">IC卡绑定</option>
                                        </select>
                                    </div>
                                    <div  ng-show="selectState == ''" class="col-sm-6 text-right">
<!--                                        margin-top: 10px;-->
                                        <div class="col-sm-2" style="float: right;width: 102px;">
                                            <button class="btn btn-default btn-sm"
                                                    style=" background-color: #3A85DE; color:#ffffff !important;width: 100%" ng-click="initBackDateTimeInfo()">清空</button>
                                        </div>
                                        <div class="col-sm-4"style="float: right">
                                            <input type="text"
                                                    id="datetimeStart"
                                                    class="input-sm form-control"
                                                    name="start" placeholder="请输入日期查看"
                                                    ng-model="entryTime"
                                                    ng-change="searchEntry()">
<!--                                            position:absolute;top: 6px;right: 89px;width: 160px;text-align:left;font-size: 13px;font-weight:normal;cursor: pointer; margin-right: 45px;-->
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0;float: right;padding-top: 6px;">
                                            <span>日期</span>
                                        </div>
<!--                                        position: absolute;top: 6px;right: 20px; background-color: #3A85DE; color:#ffffff !important; width: 102px; height: 30px;-->
                                    </div>
                                    <div  ng-show="selectState == '6'" class="col-xs-6">
                                        <span class="pull-right" style="color: orange;font-size: 16px;font-weight: 700;line-height: 30px;min-width: 100px;margin-left: 20px;">
                                        定金:{{depositAllMoney?depositAllMoney:'0'}} 元
                                    </span>
                                        <select class="form-control pull-right" ng-change="depositSelectChange(depositSelect)" ng-model="depositSelect" style="display: inline-block;max-width: 160px;padding: 4px 12px;">
                                            <option value="">请选择缴费定金</option>
                                            <option value="1">购卡定金</option>
                                            <option value="2">购课定金</option>
                                            <option value="3">续费定金</option>
                                            <option value="4">卡升级定金</option>
                                            <option value="5">课升级定金</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="padding: 0;">
                                <div ng-show="selectState == ''" >
                                    <div class="ibox-content" style="padding: 0">
                                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th  tabindex="0"
                                                         aria-controls="DataTables_Table_0" rowspan="1"
                                                         colspan="1" aria-label="浏览器：激活排序列升序">场馆
                                                    </th>
                                                    <th  tabindex="0"
                                                         aria-controls="DataTables_Table_0" rowspan="1"
                                                         colspan="1" aria-label="浏览器：激活排序列升序">卡种名称
                                                    </th>
                                                    <th  tabindex="0"
                                                         aria-controls="DataTables_Table_0" rowspan="1"
                                                         colspan="1" aria-label="浏览器：激活排序列升序">进馆时间
                                                    </th>
                                                    <th  tabindex="0"
                                                         aria-controls="DataTables_Table_0" rowspan="1"
                                                         colspan="1" aria-label="浏览器：激活排序列升序">离场时间
                                                    </th>
                                                    <th  tabindex="0"
                                                         aria-controls="DataTables_Table_0" rowspan="1"
                                                         colspan="1" aria-label="浏览器：激活排序列升序">总时长
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat='entry in entrys'>
                                                    <td>{{entry.name | noData:''}}
                                                    <td>{{entry.card_name | noData:''}}
                                                    </td>
                                                    <td ng-if="entry.entry_time != 'et' ">{{entry.entry_time *1000 | date:'yyyy/MM/dd HH:mm'}}</td>
                                                    <td ng-if="entry.entry_time == 'et' ">暂无数据</td>
                                                    <td ng-if="entry.leaving_time != 'lt' ">{{entry.leaving_time *1000 | date:'yyyy/MM/dd HH:mm'}}</td>
                                                    <td ng-if="entry.leaving_time == 'lt' ">暂无数据</td>
                                                    <td ng-if="entry.entry_time !='et' && entry.leaving_time !='lt'">{{entry.abc}}小时</td>
                                                    <td ng-if="entry.entry_time =='et' || entry.leaving_time =='lt'">暂无数据</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/pagination.php',['page'=>'entryPages']);?>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'entryNoDataShow','text'=>'无进场记录','href'=>true]);?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 1">
                                    <div class="ibox-content" style="padding: 0;">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper form-inline a26" role="grid">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0"
                                                aria-describedby="DataTables_Table_0_info"
                                                style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">物品名称
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">数量
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">赠送日期
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">领取日期
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">操作
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="x in giftList">
                                                    <td>{{x.name|noData:''}}</td>
                                                    <td>
                                                        <span ng-if="x.num != '-1' && x.num != -1">{{x.num}}</span>
                                                        <span ng-if="x.num == '-1' || x.num == -1">不限</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="x.create_at != null && x.create_at != ''">{{x.create_at*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                                        <span ng-if="x.create_at == null && x.create_at == ''">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="x.get_day != null && x.get_day != ''">{{x.get_day*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                                        <span ng-if="x.get_day == null && x.get_day == ''">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success w100 btn-sm" ng-click="receiveGift(x.id)" ng-if="x.status == 1">领取</button>
                                                        <span ng-if="x.status ==2">已领取</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'giftPages']); ?>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'giftNoDataShow', 'text' => '无赠品记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 2">
                                    <div class="ibox-content" style="padding: 0;">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                            <table class="table table-striped table-bordered table-hover" style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th class=" a28" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">行为
                                                    </th>
                                                    <th class=" a28" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">时间
                                                    </th>
                                                    <th class=" a28" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="item in behaviorRecordLists">
                                                    <td ng-if="item.behavior == 1">延期开卡</td>
                                                    <td ng-if="item.behavior == 2">解冻</td>
                                                    <td ng-if="item.behavior == 3">冻结</td>
                                                    <td>{{item.create_at*1000|date:'yyyy-MM-dd'}}</td>
                                                    <td>{{item.note ? item.note : '暂无'}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/pagination.php',['page'=>'behaviorRecordPages']);?>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'behaviorRecordFlag','text'=>'无行为记录','href'=>true]);?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 3">
                                    <div class="ibox-content"
                                         style="padding: 0;">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper form-inline a26"
                                             role="grid">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0"
                                                aria-describedby="DataTables_Table_0_info"
                                                style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th class=" a28"
                                                        tabindex="0"
                                                        aria-controls="DataTables_Table_0"
                                                        rowspan="1"
                                                        colspan="1" a
                                                        ria-label="浏览器：激活排序列升序">卡名称
                                                    </th>
                                                    <th class=" a28"
                                                        tabindex="0"
                                                        aria-controls="DataTables_Table_0"
                                                        rowspan="1"
                                                        colspan="1"
                                                        aria-label="浏览器：激活排序列升序">卡号
                                                    </th>
                                                    <th class=" a28"
                                                        tabindex="0"
                                                        aria-controls="DataTables_Table_0"
                                                        rowspan="1"
                                                        colspan="1"
                                                        aria-label="浏览器：激活排序列升序">被赠送人
                                                    </th>
                                                    <th class=" a28"
                                                        tabindex="0"
                                                        aria-controls="DataTables_Table_0"
                                                        rowspan="1"
                                                        colspan="1"
                                                        aria-label="浏览器：激活排序列升序">赠送时间
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="xx in  memberSendCardList">
                                                    <td>{{xx.card_name}}</td>
                                                    <td>{{xx.card_number}}</td>
                                                    <td>{{xx.name}}</td>
                                                    <td>{{xx.send_time*1000 |date:'yyyy-MM-dd'}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoSendCardRecordDataShow','text'=>'暂无送人记录','href'=>true]);?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 4">
                                    <div class="ibox-content" style="padding: 0;height: 400px;overflow-y: auto;">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper form-inline a26" role="grid">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0"
                                                aria-describedby="DataTables_Table_0_info"
                                                style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">课程名称
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">数量
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">延期天数
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">到期日期
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">操作人
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="d in delayPrivateRecordList">
                                                    <td>{{d.course_name|noData:''}}</td>
                                                    <td>{{d.course_num|noData:''}}</td>
                                                    <td>{{d.postpone_day|noData:''}}</td>
                                                    <td>
                                                        <span ng-if="d.due_day == null">暂无数据</span>
                                                        <span ng-if="d.due_day != null">{{d.due_day*1000|date:'yyyy-MM-dd'}}</span>
                                                    </td>
                                                    <td>{{d.remark|noData:''}}</td>
                                                    <td>{{d.employee.name|noData:''}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'priDelayNoDataShow', 'text' => '无延期记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 5">
                                    <div class="ibox-content" style="padding: 0;height: 400px;overflow-y: auto;">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper form-inline a26" role="grid">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0"
                                                aria-describedby="DataTables_Table_0_info"
                                                style="position: relative;">
                                                <thead>
                                                <tr role="row">
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器 ：激活排序列升序">卡名
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器 ：激活排序列升序">赠送类型
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">赠送天数
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">赠送时间
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="gifts in giftDaysInfoRecondData">
                                                    <td>{{gifts.card_name | noData:''}} </td>
                                                    <td>
                                                        <span ng-if="gifts.type == '1'">新办卡的赠送</span>
                                                        <span ng-if="gifts.type == '2'">其他赠送</span>
                                                    </td>
                                                    <td>{{gifts.num | noData:''}}</td>
                                                    <td>
                                                        <span ng-if="gifts.create_at != null">{{gifts.create_at*1000 | date:'yyyy-MM-dd'}}</span>
                                                        <span ng-if="gifts.create_at == null">暂无数据</span>
                                                    </td>
                                                    <td>{{gifts.note | noData:''}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'giftNoDataInfoHaShow', 'text' => '无赠送记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="selectState == 6">
                                    <div class="ibox-content" style="padding: 0;min-height: 200px;overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr role="row">
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">定金类型</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">金额</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">有效期</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">付款方式</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">缴定金日期</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="zzz in getDepositInfoData">
                                                <td ng-if="zzz.type == '1' || zzz.type == 1">购卡定金</td>
                                                <td ng-if="zzz.type == '2' || zzz.type == 2">购课定金</td>
                                                <td ng-if="zzz.type == '3' || zzz.type == 3">续费定金</td>
                                                <td ng-if="zzz.type == '4' || zzz.type == 4">卡升级定金</td>
                                                <td ng-if="zzz.type == '5' || zzz.type == 5">课升级定金</td>
                                                <td ng-if="zzz.type == undefined || zzz.type == null || zzz.type == ''">暂无数据</td>
                                                <td>{{zzz.price | number:'2' | noData:''}}</td>
                                                <td>{{zzz.start_time*1000 | date:'yyyy-MM-dd'}}&nbsp;-&nbsp;{{zzz.end_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                <td ng-if="zzz.pay_mode == '1' || zzz.pay_mode == 1">现金</td>
                                                <td ng-if="zzz.pay_mode == '2' || zzz.pay_mode == 2">支付宝</td>
                                                <td ng-if="zzz.pay_mode == '3' || zzz.pay_mode == 3">微信</td>
                                                <td ng-if="zzz.pay_mode == '4' || zzz.pay_mode == 4">pos刷卡</td>
                                                <td ng-if="zzz.pay_mode == '5' || zzz.pay_mode == 5">建设分期</td>
                                                <td ng-if="zzz.pay_mode == '6' || zzz.pay_mode == 6">广发分期</td>
                                                <td ng-if="zzz.pay_mode == '7' || zzz.pay_mode == 7">招行分期</td>
                                                <td ng-if="zzz.pay_mode == '8' || zzz.pay_mode == 8">借记卡</td>
                                                <td ng-if="zzz.pay_mode == '9' || zzz.pay_mode == 9">贷记卡</td>
                                                <td>{{zzz.pay_money_time*1000 | date:'yyyy-MM-dd'}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'depositNoDataShow', 'text' => '暂无定金记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div ng-if="selectState == 7">
                                    <div class="ibox-content" style="padding: 0;min-height: 200px;overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr role="row">
                                                <th rowspan="1" colspan="1">会籍姓名</th>
                                                <th rowspan="1" colspan="1">创建时间</th>
                                                <th rowspan="1" colspan="1">行为</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="CCRecord in consultantChangeRecord">
                                                <td>{{ CCRecord.name }}</td>
                                                <td>{{ CCRecord.created_at*1000 | date:'yyyy-MM-dd' }}</td>
                                                <td ng-if="CCRecord.behavior == 1">入馆</td>
                                                <td ng-if="CCRecord.behavior == 2">办卡</td>
                                                <td ng-if="CCRecord.behavior == 3">修改</td>
                                                <td ng-if="CCRecord.behavior == 4">续费</td>
                                                <td ng-if="CCRecord.behavior == 5">升级</td>
                                                <td ng-if="CCRecord.behavior == null || CCRecord.behavior == undefined || CCRecord.behavior == ''">暂无数据</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/pagination.php',['page'=>'consultantChangePage']); ?>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'consultantChangeRecordNoData', 'text' => '无会籍变更记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div ng-if="selectState == 8">
                                    <div class="ibox-content" style="padding: 0;min-height: 200px;overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr role="row">
                                                <th class="a28" rowspan="1" colspan="1">转出方</th>
                                                <th class="a28" rowspan="1" colspan="1">转入方</th>
                                                <th class="a28" rowspan="1" colspan="1">转卡卡号</th>
                                                <th class="a28" rowspan="1" colspan="1">转卡费用</th>
                                                <th class="a28" rowspan="1" colspan="1">操作时间</th>
                                                <th class="a28" rowspan="1" colspan="1">操作人</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="turnCardRecord in turnCardRecordList">
                                                <td>{{turnCardRecord.fromName + ' ' + turnCardRecord.fromMobile}}</td>
                                                <td>{{turnCardRecord.toName + ' ' + turnCardRecord.toMobile}}</td>
                                                <td>{{turnCardRecord.card_number}}</td>
                                                <td>{{turnCardRecord.transfer_price + '元'}}</td>
                                                <td>{{turnCardRecord.transfer_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                <td ng-if="turnCardRecord.name == undefined || turnCardRecord.name == '' || turnCardRecord.name == null">暂无数据</td>
                                                <td ng-if="turnCardRecord.name !='' && turnCardRecord.name != undefined && turnCardRecord.name != null">{{turnCardRecord.name}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'noTransferData', 'text' => '无转卡记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div ng-if="selectState == 9">
                                    <div class="ibox-content" style="padding: 0;min-height: 200px;overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr role="row">
                                                <th class="a28" rowspan="1" colspan="1">私教姓名</th>
                                                <th class="a28" rowspan="1" colspan="1">创建时间</th>
                                                <th class="a28" rowspan="1" colspan="1">行为</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="PTCRecord in privateTeachChangeRecord">
                                                <td>{{ PTCRecord.name }}</td>
                                                <td>{{ PTCRecord.created_at*1000 | date:'yyyy-MM-dd' }}</td>
                                                <td ng-if="PTCRecord.behavior == 1">入馆</td>
                                                <td ng-if="PTCRecord.behavior == 2">办卡</td>
                                                <td ng-if="PTCRecord.behavior == 3">修改</td>
                                                <td ng-if="PTCRecord.behavior == 4">续费</td>
                                                <td ng-if="PTCRecord.behavior == 5">升级</td>
                                                <td ng-if="PTCRecord.behavior == null || PTCRecord.behavior == undefined || PTCRecord.behavior == ''">暂无数据</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/pagination.php',['page'=>'privateChangePage']); ?>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'privateChangeRecordNoData', 'text' => '无私教变更记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div ng-if="selectState == 10">
                                    <div class="ibox-content" style="padding: 0;min-height: 200px;overflow: auto;">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                            <table class="table table-striped table-bordered table-hover dataTable">
                                                <thead>
                                                <tr role="row">
                                                    <th class="a28" rowspan="1" colspan="1">IC卡号</th>
                                                    <th class="a28" rowspan="1" colspan="1">绑定时间</th>
                                                    <th class="a28" rowspan="1" colspan="1">解绑时间</th>
                                                    <th class="a28" rowspan="1" colspan="1">状态</th>
                                                    <th class="a28" rowspan="1" colspan="1">操作人</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="i in icCardListInfo">
                                                    <td>{{i.custom_ic_number | noData:''}}</td>
                                                    <td>
                                                        <span ng-if="i.create_at != null && i.create_at != ''">{{i.create_at * 1000 | date:'yyyy-MM-dd'}}</span>
                                                        <span ng-if="i.create_at == null || i.create_at == ''">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="i.unbundling != null && i.unbundling != '' && i.unbundling != '0'">{{i.unbundling * 1000 | date:'yyyy-MM-dd'}}</span>
                                                        <span ng-if="i.unbundling == null || i.unbundling == '' || i.unbundling == '0'">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="i.status == '1'">已绑定</span>
                                                        <span ng-if="i.status == '2'">已解绑</span>
                                                    </td>
                                                    <td>{{i.name | noData:''}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/pagination.php',['page'=>'icCardPage']); ?>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'icCardNoData', 'text' => '无IC卡绑定记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile7">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanSmall">请假</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0;">
                                <table
                                    class="table table-striped table-bordered table-hover"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">卡名称
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">登记时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">请假时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">销假时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">请假时长
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">请假原因
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">请假类型
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">请假途径
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">销假
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <tr ng-repeat = 'vacate in leaveList'>
                                        <td>
                                            {{vacate.card_name | noData:''}}
                                        </td>
                                        <td>
                                            {{vacate.create_at *1000 | noData:''| date:'yyyy/MM/dd'}}
                                        </td>
                                        <td>
                                            {{vacate.leave_start_time *1000 | noData:''| date:'yyyy/MM/dd'}}
                                        </td>
                                        <td>
                                            {{vacate.terminate_time *1000 | noData:''| date:'yyyy/MM/dd'}}
                                        </td>
                                        <td>
                                            {{vacate.leave_length | noData:'天'}}
                                        </td>
                                        <td title="{{ vacate.note }}">
                                            {{vacate.note |cut:true:4:'...' | noData:''}}
                                        </td>
                                        <td>
                                            <span ng-if="vacate.leave_type == '1'">正常请假</span>
                                            <span ng-if="vacate.leave_type == '2'">特殊请假</span>
                                            <span ng-if="vacate.leave_type == '3'">学生请假</span>
                                            <span ng-if="vacate.leave_type != '1' && vacate.leave_type != '2' && vacate.leave_type != '3'">暂无数据</span>
                                        </td>
                                        <td>
                                            <span ng-show="vacate.source == 0 || vacate.source == 1">{{ vacate.employeeName == null ? '暂无数据' : vacate.employeeName }}</span>
                                            <span ng-show="vacate.source == 2 || vacate.source == 3 || vacate.source == 4 ">{{ MemberData.name | noData:'' }}</span>
                                        </td>
                                        <td>
                                            <span ng-if="vacate.source == 1 || vacate.source == 0">电脑</span>
                                            <span ng-if="vacate.source == 2">小程序</span>
                                            <span ng-if="vacate.source == 3">公众号</span>
                                            <span ng-if="vacate.source == 4">APP</span>
                                        </td>
                                        <td>
                                            <div ng-if="vacate.status == 1" class="btn btn-sm btn-default"
                                                 ng-click="removeLeave(vacate.id,vacate.status)"
                                                <?php if (!\backend\models\AuthRole::canRoleByAuth('checkCard', 'XIAOJIA')) { ?>
                                                    disabled
                                                <?php } ?>
                                            >销假
                                            </div>
                                            <div ng-if="vacate.status == 2" class="btn btn-sm btn-default">
                                                已销假
                                            </div>
                                            <div ng-if="vacate.status == 4" class="btn btn-sm btn-default">
                                                已登记
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'pageLearve']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'leaveNotData','text'=>'无请假记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile8">
                        <div class="panel panel-default vv" style="overflow-y: auto;">
                            <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanSmall">消费</b></span>
                            </div>
                            <div class="panel-body" style="padding: 0;">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">消费时间
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">消费金额/次数
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">业务行为
                                        </th>
                                        <th tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序">备注
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="expense in expenses">
                                        <td>{{expense.consumption_date *1000 | noData:''| date:'yyyy/MM/dd HH:mm'}}</td>
                                        <td><span ng-if=expense.type==1>{{expense.consumption_amount | noData:'元'}}</span>
                                            <span ng-if=expense.type==2>{{expense.consumption_times | noData:'次'}}</span>
                                            <span ng-if=expense.type==3>{{expense.consumption_amount | noData:'元'}}</span>

                                        </td>
                                        <td>{{expense.category}}</td>
                                        <td title="{{expense.remarks|noData:''}}">
                                            <span ng-if="expense.remarks">{{expense.remarks | cut:true:15:'...'}}</span>
                                            <span ng-if="!expense.remarks">无</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'payPages']);?>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoDataShow','text'=>'无消费记录','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--选择会员card模态框-->
    <div class="modal fade" id="selectCardModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">选择会员卡</h4>
                </div>
                <div class="modal-body">
                    <section class="row" style="display: flex;justify-content: center;margin-top: 20px;margin-bottom: 20px;">
                        <div class="col-sm-6">
                            <select class="form-control" style="padding: 4px 12px;" ng-change="selectedMemberCard()"ng-model="selectCardId" >
                                <option value="">请选择会员卡</option>
                                <option value="{{card.id}}" ng-repeat="card in allMemberCard">{{card.card_name}}</option>
                            </select>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success" ng-click="checkCardSelect(selectCardId)">验卡</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--    请假-->
    <div class="modal fade" id="leaveWorkModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">请假</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- 请假类型-->
                        <div class="col-sm-12 mT20 hCenter" >
                            <div class="col-sm-2 mT05" style="margin-left: -5px">
                                <strong style="color: red;">*</strong>请假类型
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <select  style="padding: 4px 12px;" id="selectLeaveType" ng-change="selectLeaveType(leaveTypeChecked)" ng-model="leaveTypeChecked" ng-init="leaveTypeChecked = '0'" class="form-control a48 ">
                                    <option value="">请选择请假类型</option>
                                    <option value="1" ng-if="!studentLeaveType">正常请假</option>
                                    <option value="2" ng-if="!studentLeaveType">特殊请假</option>
                                    <option value="3" ng-if="studentLeaveType == '1'">学生请假</option>
                                </select>
                            </div>
                        </div>
                        <!-- 新增-->
                        <div class="col-sm-12 mT20 hCenter" ng-if="(leaveData1 && leaveTypeChecked =='1') || leaveTypeChecked =='3'">
                            <div class="col-sm-2 mT05" style="margin-left: -5px">
                                <strong style="color: red">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26">
                                <select id="selectLeaveDays" ng-change="selectLeaveDaysOne(leave1)"
                                        ng-model="leave1" class="form-control a48" style="padding: 0 5px">
                                    <option value="" ng-selected="morenFlag">请选择请假天数</option>
                                    <option ng-if="LeaveDays != '' && LeaveDays != null && studentLeaveType == null"
                                            ng-repeat="(key,leave) in LeaveDays" value={{key}}>
                                        请假{{leave[0]}}天，还剩{{leave[1]}}次
                                    </option>
                                    <option ng-if="studentLeaveType == '1'"
                                            ng-repeat="(key,leave) in leaveStyle.student_leave_limit" value={{key}}>
                                        学生假期{{leave[0]}}天，还剩{{leave[1]}}次
                                    </option>
                                    <option
                                        ng-if="leaveTotalDays != '' && leaveLeastDays != ''&& leaveTotalDays != null && leaveLeastDays != null && studentLeaveType == null"
                                        value="aaa">可以请假{{leaveTotalDays}}天，最少请假{{leaveLeastDays}}天
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!--新增请假开始日期-->
                        <div class="col-sm-12 hCenter" style="margin-top: 20px">
                            <div class="col-sm-2 mT05" style="margin-left: -5px">
                                <strong style="color: red">*</strong>开始日期
                            </div>
                            <div class="col-sm-8 mLF26">
                                <div class="input-append date " id="dataLeave1" data-date-format="yyyy-mm-dd">
                                    <div style="float: left;">
                                        <input readonly class=" form-control h30 leaveDateStartInput"
                                               type="text"
                                               ng-change="startLeaveDate(startLeaveDay)"
                                               placeholder="开始日期"
                                               ng-model="startLeaveDay" style="width: 160px; height: 30px;"/>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>

                                <div class="input-append date" id="dataLeaveEnd" data-date-format="yyyy-mm-dd">

                                    <div style="float: left; margin-left: 8px;">
                                        <input readonly class=" form-control h30 leaveDateEndInput"
                                               type="text"
                                               ng-change="endLeaveDate(endLeaveDay)"
                                               placeholder="结束日期"
                                               ng-model="endLeaveDay" style="width: 160px; height: 30px;"/>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mT20"  ng-if="leaveTypeCheckedA == '2'&& endLeaveDay !=''&& startLeaveDay !=''&& leaveDays123 >0">
                            <div class="col-sm-2 mT05" style="margin-left: -5px">
                                <strong style="color: red;opacity: 0">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <span class="f16" style="color: #FF9900;">{{leaveDays123}} </span>天
                            </div>
                        </div>
                        <div class="col-sm-12 mT20 hCenter"
                             ng-if="leaveTypeCheckedA == '1'">
                            <div class="col-sm-2" style="margin-left: -5px">
                                <strong style="color: red;opacity: 0">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <span class="f16 leaveAllDaysSpans" style="color: #FF9900;"></span>天
                            </div>
                        </div>
                        <div class="col-sm-12  mT20 userNote">
                            <div class="col-sm-2 mT05">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备注
                            </div>
                            <div class="col-sm-8">
                                <textarea style="width: 330px; height: 100px;" id="leaveCause" class="a50" style="resize: none;border-color: #0a0a0a;" placeholder="请假原因"></textarea>
                                <div class="a51" style="margin-top: 8px; color: #8C8C8C;">请假说明:</div>
                                <div class="a51" style="margin-top: 8px; color: #8C8C8C;">1.系统会在请假开始时间到达时自动执行此次请假</div>
                                <div class="a51" style="margin-top: 8px; color: #8C8C8C;">2.会员如果在请假时间内签到，会员可以手动结束请假</div>
                                <div class='a51' style="margin-top: 8px; color: #8C8C8C;">3.当请假天数结束时，会员的请假会自动结束</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button ng-click="submitLeave(memberData.id)"
                            type="button"
                            class="btn btn-success  btn-sm a52"
                            ladda="laddaButton">
                        <span ng-if="leaveTypeChecked != '2'">完成</span>
                        <span ng-if="leaveTypeChecked == '2'">提交申请</span>
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?= $this->render('@app/views/common/field.php') ?>
    <?= $this->render('@app/views/common/print.php') ?>
</div>
