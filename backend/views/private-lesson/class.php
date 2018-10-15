<?php
use backend\assets\PrivateLessonAsset;

PrivateLessonAsset::register($this);
$this->title = '私教上课';
?>
<div class="col-sm-12" id="PrivateTimetable" ng-controller="privateClassCtrl" ng-cloak>
    <div class="panel panel-default ">
        <div class="panel-heading">
            <span style="display: inline-block"><span style="display: inline-block" class="spanSmall"><b>私教上课</b></span>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body col-sm-12 panelBody">
            <div class="tab-tb-1 PrivateTimetable1" ng-cloak>
                <div class="row">
                    <div class="col-sm-2 venueSelect2">
                        <select class="js-states form-control" ng-change="venueChange(myValue)"
                                ng-model="myValue" id="classVenueChange">
                            <option value="" ng-selected>请选择场馆</option>
                            <option value="{{venue.id}}" ng-repeat="venue in venuesLists">{{venue.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-2 ">
                        <select class="form-control cp" ng-change="classStatusChange(classStatus)"
                                ng-model="classStatus" id="classStatusChange" style="padding: 4px 12px;">
                            <option value="3" ng-selected>上课中</option>
                            <option value="1" >待审核</option>
                            <option value="4" >已下课</option>
                            <option value="6" >已爽约</option>
                            <option value="5" >未下课打卡</option>
                            <option value="">全部</option>
                        </select>
                    </div>
                    <div class="col-sm-5" style="padding-top:10px ;">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="keywords" ng-keyup="enterSearch($event)"
                                   placeholder="请输入私教名称进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" ng-click="searchCard()">搜索</button>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pd0">
                    <div class="col-sm-8 pd0">
                        <div class="ibox-content iboxContent1">
                            <div class="row">
                                <div class="col-sm-6" style="display: none;">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                </div>
                            </div>
                            <table class="table  table-bordered table-hover dataTables-example dataTable"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                        style="width: 100px;background-color: #FFF;"></span>头像
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('employee_name',sort)" aria-label="浏览器：激活排序列升序"
                                        style="width: 140px;"></span>私教
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('about_status',sort)" aria-label="浏览器：激活排序列升序"
                                        style="width: 140px;">状态
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('class_date',sort)" aria-label="平台：激活排序列升序"
                                        style="width: 140px;"></span>日期
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('order_type',sort)" aria-label="引擎版本：激活排序列升序"
                                        style="width: 140px;">类型
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('memberDetails_name',sort)"
                                        aria-label="引擎版本：激活排序列升序" style="width: 140px;">会员名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('memberDetails_name',sort)"
                                        aria-label="引擎版本：激活排序列升序" style="width: 140px;">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('memberDetails_name',sort)"
                                        aria-label="引擎版本：激活排序列升序" style="width: 140px;">卡号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" ng-click="changeSort('about_start',sort)" aria-label="引擎版本：激活排序列升序"
                                        style="width: 140px;">上课时间
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cp aboutClassList " ng-repeat="($index,course) in privateClass"
                                    ng-click="courseMemberDetail(course,$index)" ng-if="course.status != 2" ng-cloak>
                                    <td>
                                        <img ng-if="course.pic == null || course.pic == '' "
                                             ng-src="/plugins/user/images/pt.png" alt=""
                                             style="width: 40px;height: 40px;border-radius: 50%">
                                        <img ng-if="course.pic != null && course.pic != '' " ng-src="{{course.pic}}"
                                             alt="" style="width: 40px;height: 40px;border-radius: 50%">
                                    </td>
                                    <td>
                                        {{course.name}}
                                    </td>
                                    <td>
                                        <small class="label label-warning" ng-if="course.status == 1">待审核</small>
                                        <small style="background-color: #27c24c;" class="label label-warning" ng-if="course.status == 3">上课中</small>
                                        <small class="label label-default" ng-if="course.status == 4">已下课</small>
                                        <small class="label label-info" ng-if="course.status == 5">未下课打卡</small>
                                        <small class="label label-danger" ng-if="course.status == 6">已爽约</small>
<!--                                        <small class="label label-danger" ng-if="course.status == 1 && currentTimeS > course.end">已过期</small>-->
                                    </td>
                                    <td>{{course.class_date | noData:''}}</td>
                                    <td>
<!--                                        {{course.member.memberCourseOrder.course_type == 1 ?'PT':course.member.memberCourseOrder.course_type == 2?:'HS':course.member.memberCourseOrder.course_type == 3?:'生日课':'暂无'}}-->
                                        <span ng-if="course.course_type == '1'">PT</span>
                                        <span ng-if="course.course_type == '2'">HS</span>
                                        <span ng-if="course.course_type == '3'">生日课</span>
                                        <span ng-if="course.course_type == '4'">购课赠送</span>
                                        <span ng-if="course.course_type == null && course.type == '1' ">PT</span>
                                        <span ng-if="course.course_type == null && course.type == '2' ">HS</span>
                                        <span ng-if="course.course_type == null && course.type == '3' ">生日课</span>
                                        <span ng-if="course.course_type == null && course.type == '4' ">购课赠送</span>
                                        <span ng-if="course.course_type == null && course.type == null ">PT</span>
                                    </td>
                                    <td>{{course.memberName | noData:''}}</td>
                                    <td>{{course.mobile | noData:''}}</td>
                                    <td>{{course.card_number | noData:''}}</td>
                                    <td>{{(course.start)*1000 | date:'HH:mm'}} - {{(course.end)*1000 | date:'HH:mm'}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php'); ?>
                            <?= $this->render('@app/views/common/pagination.php'); ?>
                        </div>
                    </div>
                    <div class="col-sm-4 pd0">
                        <div class="row displayNone displayNone1" id="memberDetail" style="padding: 0;">
                            <div class="col-sm-12 text-center">
                                <img ng-src="{{memberDetail.member.memberDetails.pic}}" alt=""
                                     ng-if="memberDetail.member.memberDetails.pic != null">
                                <img ng-src="/plugins/img/user.png" alt=""
                                     ng-if="memberDetail.member.memberDetails.pic == null">
                            </div>
                            <div class="col-sm-12 " style="margin: 0 auto;float: none;width: 85%;display: block;">
                                <ul id="courseMessageLists">
                                    <li style="font-size: 18px;color: #51D76A;font-weight: 700;"
                                        ng-if="memberDetail.status == 3">上课中，待下课...
                                    </li>
                                    <li style="font-size: 18px;color: #999;font-weight: 700;"
                                        ng-if="memberDetail.status == 4">已下课
                                    </li>
                                    <li style="font-size: 18px;color: #ff9933;font-weight: 700;"
                                        ng-if="memberDetail.status == 1 && currentTimeS <= memberDetail.end">审核中，待上课...
                                    </li>
                                    <li style="font-size: 18px;color: #ff9933;font-weight: 700;"
                                        ng-if="(memberDetail.status == 1 || memberDetail.status ==  6)&& currentTimeS > memberDetail.end">
                                        已过期，未登记上课
                                    </li>
                                    <li style="font-size: 22px;color: #ff9933;font-weight: 700;"
                                        ng-if="memberDetail.status == 1 || memberDetail.status ==  6">开课时间：<span>{{(memberDetail.start)*1000 | date:'MM月dd日 HH:mm'}}</span>
                                    </li>
                                    <li style="font-size: 22px;color: #999999;font-weight: 700;" ng-if="memberDetail.status == 3 || memberDetail.status == 4">登记上课时间：
                                        <span ng-if="memberDetail.actual_start != 0">{{(memberDetail.actual_start)*1000 | date:'MM月dd日 HH:mm'}}</span>
                                        <span ng-if="memberDetail.actual_start == 0">{{(memberDetail.start)*1000 | date:'MM月dd日 HH:mm'}}</span>
                                    </li>
                                    <li style="font-size: 22px;color: #999999;font-weight: 700;" ng-if="memberDetail.status == 4">确认下课时间：
                                        <span ng-if="memberDetail.actual_end != 0">{{(memberDetail.actual_end)*1000 | date:'MM月dd日 HH:mm'}}</span>
                                        <span ng-if="memberDetail.actual_end == 0">{{(memberDetail.end)*1000 | date:'MM月dd日 HH:mm'}}</span>
                                    </li>
<!--                                    <li style="font-size: 22px;color: #51D76A;font-weight: 700;"-->
<!--                                        ng-if="memberDetail.status == 3">下课时间：<span>{{(memberDetail.end)*1000 | date:'MM月dd日 HH:mm'}}</span>-->
<!--                                    </li>-->
                                    <li class="courseMessage" ng-if="memberDetail.member.username != null">会员姓名：<span>{{memberDetail.member.memberDetails.name}}</span>
                                    </li>
                                    <li class="courseMessage">
                                        手机号：<span>{{memberDetail.member.mobile | noData:''}}</span></li>
                                    <li class="courseMessage"
                                        ng-if="memberDetail.memberCourseOrderDetails.product_name != null">私课：<span>{{memberDetail.memberCourseOrderDetails.product_name}}</span>
                                    </li>
                                    <li class="courseMessage">进度：<span>第{{memberDetail.memberCourseOrderDetails.course_num}}节</span>
                                        / <span>{{memberDetail.memberCourseOrderDetails.course_name}}</span> / <span>{{memberDetail.memberCourseOrderDetails.class_length}}分钟</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-12  teachPrivately" style="display: flex;justify-content: space-around;">
                                <!--                                -->
                                <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseOn', 'CLASSOVER')) { ?>
                                    <button type="button" class="btn btn-sm btn-success"
                                            ng-if="memberDetail.status == 3"
                                            ng-click="confirmFinishClass(memberDetail.member.mobile,courseId,memberDetail.end)"
                                            data-toggle="modal">确认下课
                                    </button>
                                <?php } ?>

                                <!--      这是临时改的 不要删！！！！！！！！！！！          data-toggle="modal" data-target="#fingerprintVerification"                        -->
                                <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseOn', 'CLASSON')) { ?>
                                    <button type="button" class="btn btn-sm btn-success"
                                            ng-if="memberDetail.status == 1 || memberDetail.status == 6 "
                                            ng-disabled="currentTimeS > memberDetail.end || current_date !== memberDetail.class_date"
                                            ng-click="registerClass(courseId)">登记上课
                                    </button>
                                <?php } ?>
                                <!--                                    <button style="padding: 4px 30px;margin-left: 20px;" type="button" class="btn btn-sm btn-default" ng-if="memberDetail.status == 2" ng-click="aheadFinishClass(memberDetail.id)">提前下课</button>-->
                                <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseOn', 'CANCLEGROUP')) { ?>
                                    <button type="button" class="btn btn-sm btn-default"
                                            ng-disabled="currentTimeS > memberDetail.end"
                                            ng-if="memberDetail.status == 1 || memberDetail.status == 6  "
                                            ng-click="cancelClass(courseId)">取消课程
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- 确认下课模态框-->
    <div class="modal fade" id="finishClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <?= $this->render('@app/views/common/csrf.php') ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">下课验证</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group mt20">
                            <label class="col-sm-3 control-label">选择方式</label>
                            <div class="col-sm-6">
                                <select class="form-control" style="padding-top: 4px;" ng-model="selectionMethod"
                                        ng-change="selectionChange()">
                                    <option value="">请选择方式</option>
                                    <option value="2">短信通知</option>
                                    <option value="1">验证码</option>
                                    <option value="3" ng-if="fingerprintData != null">指纹打卡</option>
                                    <option value="4" ng-if="fingerprintData == null">指纹验证</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt20 codeBox" ng-if="selectionMethod == 1">
                            <label class="col-sm-3 control-label">验证码</label>
                            <div class="col-sm-6">
                                <input type="number" id="codeInput" inputnum class="form-control" placeholder="请输入验证码" ng-model="newCode"/>
                            </div>
                            <button type="button" class="btn btn-info" ng-bind="paracont" ng-disabled="disabled" ng-click="getCode()">获取验证码
                            </button>
                        </div>
                        <div class="form-group mt20 newsBox" ng-if="selectionMethod == 2">
                            <p class="text-center" style="font-size: 14px;"><span
                                    class="glyphicon glyphicon-info-sign"></span>&nbsp;将会以短信形式通知会员下课</p>
                        </div>
                        <div ng-if="selectionMethod == 4" style="width: 200px;height: 40px;margin: 20px auto;">
                            <div id="fpRegisterDiv" style="display: inline; height: 80px;width: 110px;margin: 0 auto;" class="btn btn-info">
                                <a id="fpRegister"
                                   onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'
                                   title="请安装指纹驱动或启动该服务" class="showGray mt20"
                                   onmouseover="this.className='showGray'" style="color: ghostwhite;">点击登记指纹</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success w100" ng-click="finishCode()">完成下课</button>
                </div>
            </div>
        </div>
    </div>
    <!--                指纹上课 验证 -->
    <div class="modal fade" id="fingerprintVerification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="fingerprintVerification()"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel" ng-if="confirmFinishClassBOOL == 1">
                        指纹上课验证</h4>
                    <h4 class="modal-title text-center" id="myModalLabel" ng-if="confirmFinishClassBOOL == 2">
                        指纹下课验证</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group mt20">
                            <div class="col-sm-6" style="width: 100%;height: 400px;">
                                <div id="comparisonDiv" class="box" style="display: none">
                                    <h2>指纹比对</h2>
                                    <div class="list">
                                        <canvas id="canvasComp" width="430" height="320"
                                                style="background: url('/plugins/privateLesson/image/base_fpVerify.jpg') rgb(243, 245, 240);"></canvas>
                                        <input type="button" ng-if="confirmFinishClassBOOL == 1"
                                               class="btn btn-success btn-sm" value="验证" ng-click='closeCompas()'/>
                                        <input type="button" ng-if="confirmFinishClassBOOL == 2"
                                               class="btn btn-success btn-sm" value="验证" ng-click='closeCompas2()'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div style="width: 100%;height: 50px;">
                        <button type="button" style="display: block; margin: 0 auto;text-align: center;"
                                class="btn btn-success w100"  ng-click="fingerprintVerification()">关闭
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--                指纹登记 -->
    <div class="modal fade" id="fingerprintInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">
                        指纹登记</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group ">
                            <div class="col-sm-6" style="width: 100%;height: 450px;">
                                <!--    验证指纹-->
                                <div id="box" class="box" style="display: none;">
                                    <h2>指纹登记</h2>
                                    <div class="list">
                                        <canvas id="canvas" width="430" height="450"
                                                style="background: rgb(243, 245, 240)"></canvas>
                                        <input type="hidden" id="whetherModify" name="whetherModify" alt=""
                                               value="111" />
                                        <div
                                            style="position: absolute; left: 310px; top: 325px; width: 70px; height: 28px;">
                                            <button type="button" class="btn btn-success btn-sm button-form" id="submitButtonId" name="makeSureName"
                                                    onclick="submitEvent()">确定</button>
                                            <!-- ${common_edit_ok}:确定 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div style="width: 100%;height: 50px;">
                        <button type="button"  ng-disabled="true" id="clickFingerprint" style="display: block; margin: 0 auto;text-align: center;"
                                class="btn btn-success w100" ng-click="clickFingerprint()">验证指纹
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>