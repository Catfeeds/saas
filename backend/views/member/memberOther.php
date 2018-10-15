<!--私课延期模态框-->
<div class="modal fade " id="postponeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">延期</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <ul>
                            <li class="col-sm-12 text-center"><img src="/plugins/img/exclamation.png " alt="" style="width: 100px;"></li>
                            <li class="col-sm-12 text-center mT10" style="font-size: 16px;color: #999;">本操作将会把会员 <span style="color: #000;font-size: 18px;">{{privateLessonTemplet.name}}</span>剩余<span style="color: #000;font-size: 18px;">{{privateLessonTemplet.overage_section}}</span>节进行延期</li>
                            <li class="col-sm-12 text-center mT10" style="display: flex;justify-content: center;color:#999;">
                                <div style="display: flex;align-items: center"><span style="color:red;">*</span>延期天数&emsp;&emsp;</div>
                                <div>
                                    <input ng-change="postponeDaysBlur(postponeDays123)" 
                                           ng-model="postponeDays123" 
                                           style="width: 200px;" 
                                           type="number" 
                                           class="form-control" 
                                           inputnum 
                                           placeholder="几天">
                                </div>
                            </li>
                            <li class="col-sm-12 text-center mT10">
                                <span style="opacity: 0;">延期</span>
                                <span style="color:#999;" >到期日期为 <span style="color:#ff9933;">{{postponeEndTime123}}</span></span>
                            </li>
                            <li class="col-sm-12 text-center mT10" style="display: flex;justify-content: center;color:#999;">
                                <div style="display: flex;align-items: center"><span style="color:red;">*</span>延期备注&emsp;&emsp;</div>
                                <div>
                                    <textarea class="form-control" style="width: 200px;resize: none;" ng-model="delayPrivateRemarks"></textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer " style="text-align: center;">
                <button ladda="postponeBtnFlag" style="width: 100px;" type="button" class="btn btn-success btn-sm" ng-click="postponeBtnSubmit()">确定</button>
            </div>
        </div>
    </div>
</div>
<!--请假-->
<div class="modal fade" id="myModalsLeave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="min-width: 720px">
        <div class="modal-content clearfix" >
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
                        <div class="col-sm-12 mT20 hCenter">
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>选择卡种
                            </div>
                            <div class="col-sm-8">
                                <select name="" id="selectCard" ng-change="selectOneMemberCard(card_id)"
                                        ng-model="card_id" class="form-control a48" style="padding: 4px 12px;">
                                    <option value="">请选择会员卡</option>
                                    <option ng-repeat="card in cards" value="{{card.id}}">{{card.card_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 mT20 hCenter" >
                            <div class="col-sm-4" style="margin-left: -5px">
                                <strong style="color: red">*</strong>请假类型
                            </div>
                            <div class="col-sm-8 " >
                                <select  style="padding: 4px 12px;" id="selectLeaveType" ng-change="selectLeaveType(leaveTypeChecked)" ng-model="leaveTypeChecked"  ng-init="leaveTypeChecked = '0'" class="form-control a48 ">
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
                            <div class="col-sm-8">
                                <select id="selectLeaveDays" ng-change="selectLeaveDaysOne(leave1)"
                                        ng-model="leave1" class="form-control a48">
                                    <option value="" ng-selected="morenFlag">请选择请假天数</option>
                                    <option ng-if="LeaveDays != '' && LeaveDays != null && studentLeaveType == null"
                                            ng-repeat="(key,leave) in LeaveDays track by $index" value={{key}}>
                                        请假{{leave[0]}}天，还剩{{leave[1]}}次
                                    </option>
                                    <option ng-if="studentLeaveType == '1'"
                                            ng-repeat="(key,leave) in leaveStyle.student_leave_limit track by $index" value={{key}}>
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
            <div class="modal-footer text-center mT20" style="border-top: none;">
                <button ng-click="submitLeave(memberData.id)" type="button" class="btn btn-success width100" ladda="laddaButton">
                    <span ng-if="leaveTypeChecked != '2'">完成</span><span ng-if="leaveTypeChecked == '2'">提交申请</span>
                </button>
                <button type="button" class="btn btn-default width100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--定金-->
<div class="modal" id="deposit" role="dialog" aria-labelledby="deposit1qq" >
    <div class="modal-dialog" role="document" style="width: 720px;" >
        <div class="modal-content clearfix" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;"  >定金</h4>
            </div>
            <div class="modal-body" style="padding: 60px auto;">
                <form>
                    <div class="row ">
                        <?=$this->render('@app/views/common/csrf.php')?>
                        <div class="form-group  col-sm-6  mT20 centerHeight">
                            <div class="col-sm-4  text-right">
                                <div for="recipient-name" class="control-label"><span class="red">*</span>定金类型:</div>
                            </div>
                            <div class="col-sm-8 pd0" >
                                <select ng-model="depositPayType" class="form-control" style="padding: 4px 12px;" ng-change="depositChange(depositPayType)">
                                    <option value="">请选择定金类型</option>
                                    <option value="1">购卡定金</option>
                                    <option value="2">购课定金</option>
                                    <option value="3">续费定金</option>
                                    <option value="4">卡升级定金</option>
                                    <option value="5">课升级定金</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  col-sm-6   mT20 centerHeight">
                            <div class="col-sm-4   text-right">
                                <div for="recipient-name" class="control-label"><span class="red">*</span>金额:</div>
                            </div>
                            <div class="col-sm-8 pd0">
                                <input type="number" inputnum  autocomplete="off" ng-model="depositMoney" class="form-control  " id="recipient-name" placeholder="请输入金额">
                            </div>
                        </div>
<!--                        <div class="form-group  col-sm-6  mT20 centerHeight">-->
<!--                            <div class="col-sm-4   text-right">-->
<!--                                <div for="recipient-name" checknum  class="control-label">抵券:</div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-8 pd0">-->
<!--                                <input type="number"  autocomplete="off" ng-model="depositToRoll" class="form-control control-label depositInput" id="recipient-name" placeholder="请输入金额">-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="form-group  col-sm-6  mT20 centerHeight">
                            <div class="col-sm-4  text-right">
                                <div for="recipient-name" class="control-label"><span class="red">*</span>有效期:</div>
                            </div>
                            <div class="col-sm-8 pd0" >
                                <div  class=" input-daterange input-group"  style="width: 100%;">
                                    <input type="text"  readonly name="reservation" id="subscriptionDate" class=" form-control " value="" placeholder="选择时间"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-sm-6  mT20 centerHeight">
                            <div class="col-sm-4  text-right">
                                <div for="recipient-name" class="control-label"><span class="red">*</span>付款方式:</div>
                            </div>
                            <div class="col-sm-8 pd0" >
                                <select ng-model="depositPayMode" class="form-control" style="padding: 4px 12px;">
                                    <option value="">请选择</option>
                                    <option value="1">现金</option>
                                    <option value="3">微信</option>
                                    <option value="2">支付宝</option>
<!--                                    <option value="4">pos机</option>-->
                                    <option value="5">建设分期</option>
                                    <option value="6">广发分期</option>
                                    <option value="7">招行分期</option>
                                    <option value="8" >借记卡</option>
                                    <option value="9" >贷记卡</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  col-sm-6  mT20 centerHeight">
                            <div class="col-sm-4  text-right">
                                <div for="recipient-name" class="control-label"><span class="red">*</span>
                                    <span ng-if="depositPayType == 2 || depositPayType == 5">选择私教:</span>
                                    <span ng-if="depositPayType != 2 && depositPayType != 5">选择销售:</span>
                                </div>
                            </div>
                            <div class="col-sm-8 pd0" >
                                <select ng-model="sellName" class="form-control" style="padding: 4px 12px;">
                                    <option value="" ng-if="depositPayType == 2 || depositPayType == 5">请选择私教</option>
                                    <option value="" ng-if="depositPayType != 2 && depositPayType != 5">请选择销售</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <span type="button"  class="btn btn-success w100" ladda="depositButtonFlag" id="success" ng-click="depositSubmit()">完成</span>
            </div>
        </div>
    </div>
</div>
<!--冻结备注-->
<div class="modal" tabindex="-1" role="dialog" id="freezeRemark">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">{{statusId == 2 ? '解冻':'冻结'}}</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-sm-10">
                        <div class="text-left f16"><span class="red">*</span><span>{{statusId == 2 ? '解冻':'冻结'}}</span>原因:</div>
                        <textarea class="f14" name="" id="freezeContent"  rows="6" maxlength="300" style="width: 100%;text-indent: 2em;margin-top: 10px;resize: none;" placeholder="请输入原因，字数不能超过300字"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-default w100"
                        data-dismiss="modal">取消</button>
                <button type="button"
                        class="btn btn-success w100"
                        ng-click="confirmFreeze()"
                        ng-disabled="freezeBtnSuccessPost">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>