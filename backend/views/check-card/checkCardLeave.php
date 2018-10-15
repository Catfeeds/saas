<!--请假-->
<div class="modal fade" id="myModalsLeave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix" style="width: 800px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center a40" id="myModalLabel">
                    请假
                </h3>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 dataId a41">
                    <div class="col-sm-3 text-left a42">
                        <div class="a43">
                            <img ng-src="{{MemberData.pic}}" ng-if="MemberData.pic!=null"
                                 style="width: 150px;height: 150px">
                        </div>
                        <div class="a44" style="margin-bottom: 20px">
                            <img src="/plugins/checkCard/img/11.png" ng-if="MemberData.pic==null"
                                 style="width: 150px;height: 150px;margin-bottom: 20px">
                        </div>
                        <h4 style="margin-left: 32px;margin-top: 10px;font-size: 16px">姓名:<span>{{MemberData.name}}</span>
                            <!--                                <span-->
                            <!--                                    class="a45">{{memberFlag}}</span></h4>-->
                            <div class="a46">总计天数:{{allDays}}天</div>
                            <div class="a46">剩余天数: <span>{{limitedDays}}</span>天</div>
                    </div>
                    <div class="col-sm-1 a47"></div>
                    <div class="col-sm-8 a47">
                        <!--                                请假类型-->
                        <div class="col-sm-12 mT20 hCenter" >
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>请假类型
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <select  style="padding: 4px 12px;" id="selectLeaveType" ng-change="selectLeaveType(leaveTypeChecked)" ng-model="leaveTypeChecked" ng-init="leaveTypeChecked = '0'" class="form-control a48 ">
                                    <option value="">请选择请假类型</option>
                                    <option value="1" ng-if="studentLeaveType == null">正常请假</option>
                                    <option value="2" ng-if="studentLeaveType == null">特殊请假</option>
                                    <option value="3" ng-if="studentLeaveType == '1'">学生请假</option>
                                </select>
                            </div>
                        </div>
                        <!--                            新增-->
                        <div class="col-sm-12 mT20 hCenter" ng-if="(leaveData1 && leaveTypeChecked =='1') || leaveTypeChecked =='3'">
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26">
                                <select id="selectLeaveDays" ng-change="selectLeaveDaysOne(leave1)"
                                        ng-model="leave1" class="form-control a48">
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
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>开始日期
                            </div>
                            <div class="col-sm-8 mLF26">
                                <div class="input-append date " id="dataLeave1" data-date-format="yyyy-mm-dd">
                                    <input readonly class=" form-control h30 leaveDateStartInput"
                                           type="text"
                                           ng-change="startLeaveDate(startLeaveDay)"
                                           placeholder="请选择开始日期"
                                           ng-model="startLeaveDay"/>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 hCenter" style="margin-top: 20px">
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>结束日期
                            </div>
                            <div class="col-sm-8 mLF26">
                                <div class="input-append date" id="dataLeaveEnd" data-date-format="yyyy-mm-dd">
                                    <input readonly class=" form-control h30 leaveDateEndInput"
                                           type="text"
                                           ng-change="endLeaveDate(endLeaveDay)"
                                           placeholder="请选择结束日期"
                                           ng-model="endLeaveDay"/>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mT20 hCenter"  ng-if="leaveTypeCheckedA == '2'&& endLeaveDay !=''&& startLeaveDay !=''&& leaveDays123 >0  ">
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red;opacity: 0">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <span class="f16" style="color: #FF9900;">{{leaveDays123}} </span>天
                            </div>
                        </div>
                        <div class="col-sm-12 mT20 hCenter"
                             ng-if="leaveTypeCheckedA == '1'">
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red;opacity: 0">*</strong>请假天数
                            </div>
                            <div class="col-sm-8 mLF26" >
                                <span class="f16 leaveAllDaysSpans" style="color: #FF9900;"></span>天
                            </div>
                        </div>
                        <div class="col-sm-12 userNote">
                            <div class="col-sm-4" style="margin-left: -1px">
                                备注内容
                            </div>
                            <div class="col-sm-8">
                                <textarea id="leaveCause" class="a50" style="resize: none;border-color: #0a0a0a;"></textarea>
                                <div style="margin-bottom: 10px;color: #999;margin-left: -26px">请假说明:</div>
                                <div class="a51">1.系统会在请假开始时间到达时自动执行此次请假</div>
                                <div class="a51">2.会员如果在请假时间内签到，会员可以手动结束请假</div>
                                <div class='a51'>3.当请假天数结束时，会员的请假会自动结束</div>
                                <!--                                        <div style="margin-bottom: 10px;color: #999;margin-left: -26px;"><p>4.例:<b>'2017-05-20'</b>日请假,选择日期为 <strong>2017-05-20 - 2017-05-21</strong></p> </div>-->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <center>
                    <button ng-click="submitLeave(memberData.id)"
                            type="button"
                            class="btn btn-success  btn-sm a52"
                            ladda="laddaButton">
                        <span ng-if="leaveTypeChecked != '2'">完成</span><span ng-if="leaveTypeChecked == '2'">提交申请</span>
                    </button>
                </center>
            </div>
        </div>
    </div>
</div>