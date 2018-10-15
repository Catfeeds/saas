<!--会员上课量模态框-->
<div class="modal fade" id="memberAttendClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog wB90" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header" style="padding-bottom: 0;border: none;">
                <section style="display: flex;justify-content: space-between;">
                    <span class="text-left cp glyphicon glyphicon-menu-left f20 color999" ng-click="backPTClassModal()"></span>
                    <h4 class="text-center"  >
                        会员上课量统计
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </section>
                <section class="mT6">
                    <div class="pull-left mR10" style="width: 300px;">
                        <div class="input-daterange input-group cp userTimeRecord"  >
                                <span class="add-on input-group-addon">
                                选择日期
                                </span>
                            <input type="text" readonly name="reservation" id="memberAttendClassDate"
                                   class="form-control text-center userSelectTime "/>
                        </div>
                    </div>
                    <div class="pull-left mR10">
                        <select class="form-control selectCssPd" ng-model="memberPtCourseType">
                            <option value="">请选择私课类型</option>
                            <option value="1">PT</option>
                            <option value="2">HS</option>
                            <option value="3">生日课</option>
                            <option value="4">购课赠课</option>
                        </select>
                    </div>
                    <div class="mT6">
                        <button class="btn btn-sm btn-success w100" ng-click="MemberSubmit()">确定</button>
                        <button style="margin-left: 10px;" class="btn btn-sm btn-info w100" ng-click="MemberSubmitClear()">清空</button>
                    </div>
                </section>
            </div>
            <div class="modal-body" style="padding:0 15px 15px;">
                <div class="row" style="display: flex;align-items: center;">
                    <div class="col-sm-3 pdRL0" style="display: flex;align-items: center;height: 100%;">
                        <div class="col-sm-12 col-sm-offset-1 pdRL0" style="padding-top: 15px;">
                            <div class="col-sm-12 pdRL0 text-center">
                                <img style="width: 120px;height: 120px;border-radius: 50%;" ng-src="{{pTMemberMessage.pic != null && pTMemberMessage.pic != ''? pTMemberMessage.pic :'/plugins/checkCard/img/11.png'}}" alt="" >
                            </div>
                            <div class="col-sm-12 pdRL0" style="display: flex;justify-content: center;">
                                <ul style="min-width: 160px;">
                                    <li class="col-sm-12"><span class="col-sm-6 text-right color999">姓名:</span><span class="col-sm-6" style="margin-left: -20px"><b class="color999">{{pTMemberMessage.memberName}} </b></span></li>
                                    <li class="color999 mT10 col-sm-12"><span class="col-sm-6 text-right">编号:</span><span class="col-sm-6" style="margin-left: -20px">{{pTMemberMessage.member_id}}</span></li>
                                    <li class="color999 mT10 col-sm-12"><span class="col-sm-6 text-right">性别:</span><span class="col-sm-6" style="margin-left: -20px">{{pTMemberMessage.memberDetails.sex =='1'?'男': pTMemberMessage.memberDetails.sex =='2'?'女':'暂无'}}</span></li>
                                    <li class="color999 mT10 col-sm-12"><span class="col-sm-6 text-right">手机号:</span><span class="col-sm-6" style="margin-left: -20px">{{pTMemberMessage.mobile}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 ">
                        <div class="ibox float-e-margins mT20">
                            <div class="ibox-content " >
                                <div  id="DataTables_Table_0_wrapper" class=" pdB0 dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">序号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">卡号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 180px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">课程名称
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">类型
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">课时费
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 180px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">上课时间
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr  ng-repeat="member in memberAttendClassLists">
                                            <td>{{8*(memberAttendClassNow - 1)+$index+1}}</td>
                                            <td>
                                                <span>{{member.card_number | noData:''}}</span>
                                            </td>
                                            <td>{{member.product_name | noData:''}}</td>
                                            <td>
                                                <span ng-if="member.course_type == '1'">PT</span>
                                                <span ng-if="member.course_type == '2'">HS</span>
                                                <span ng-if="member.course_type == '3'">生日课</span>
                                                <span ng-if="member.course_type == '4'">购课赠课</span>
                                                <span ng-if="member.course_type == null && member.type == '1' ">PT</span>
                                                <span ng-if="member.course_type == null && member.type == '2' ">HS</span>
                                                <span ng-if="member.course_type == null && member.type == '3' ">生日课</span>
                                                <span ng-if="member.course_type == null && member.type == '4' ">购课赠课</span>
                                                <span ng-if="member.course_type == null && member.type == null ">PT</span>
                                                <!--                                                    {{member.type == '1'?'PT':member.type == '2'?'HS':'暂无'}}-->
                                            </td>
                                            <td>{{member.money_amount | number:2}}元</td>
                                            <td>{{member.class_date}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'memberAttendClassFlag','text'=>'暂无数据','href'=>true]);?>
                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'memberAttendClassPages']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12 pd0 text-right">
                    <div class=""><b class="orangeP">总计：<span>{{memberAttendClassCount}}节</span> {{memberAttendClassAllMoney | number:2}}元</span></b></div>
                </div>
            </div>
        </div>
    </div>
</div>