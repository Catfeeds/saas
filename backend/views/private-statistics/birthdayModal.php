<!--生日会员模态框-->
<div style="overflow: auto;" class="modal fade" id="birthdayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB90" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header" style="padding-bottom: 0;border: none;">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="text-center"  >
                        生日会员
                    </h4>
                    <div class="row mT10 mB10">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="input-group">
                                <input type="text" class="form-control h34" ng-model="memberBirKeywords" ng-keyup="enterSearchMemberBir123($event)" placeholder="请输入会员姓名、手机号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" ng-click="searchMemberBir()">搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="display: flex;flex-wrap: wrap;">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pdL0 mT6">
                                <div class="input-daterange input-group cp userTimeRecord" >
                                        <span class="add-on input-group-addon">
                                        选择日期
                                        </span>
                                    <input type="text" readonly name="reservation" id="birthdayDate"
                                           class="form-control text-center userSelectTime " />
                                </div>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <!--                                    <select class="form-control selectCssPd" ng-change="selectBirthdayCoach(birthdayCoach)" ng-model="birthdayCoach">-->
                                <!--                                        <option value="">请选择私教</option>-->
                                <!--                                        <option value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name}}</option>-->
                                <!--                                    </select>-->
                                <select id="birthdayCoachSelect" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="birthdayCoach">
                                    <option value="">请选择私教</option>
                                    <option title="{{coach.name}}" value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name | cut:true:8:'...'}}</option>
                                </select>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <select class="form-control selectCssPd" ng-model="birthdayClass123">
                                    <option value="">剩余生日课</option>
                                    <option value="2">2节</option>
                                    <option value="1">1节</option>
                                    <option value="0">0节</option>
                                </select>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <select class="form-control selectCssPd" ng-model="memberType">
                                    <option value="">请选择会员类型</option>
                                    <option value="1">有效会员</option>
                                    <option value="2">到期会员</option>
                                </select>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6" >
                                <select class="form-control selectCssPd" ng-model="ptClassStatus">
                                    <option value="">请选择私课购买状态</option>
                                    <option value="1">已购买私课</option>
                                    <option value="2">未购买私课</option>
                                </select>
                            </div>
                            <div class="mT6">
                                <button class="btn btn-sm btn-success w100" ng-click="memberBirSubmit()">确定</button>
                                <button style="margin-left: 10px;" class="btn btn-sm btn-info w100" ng-click="memberBirSubmitClear()">清空</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- header-->

            <div class="modal-body" style="padding:0 15px 15px;"><!--body  -->
                <div class="ibox float-e-margins mT20">
                    <div class="ibox-content h580" >
                        <div  id="DataTables_Table_0_wrapper" class=" pdB0 dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" >序号
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">会员姓名
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">性别
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">手机号
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">会员年龄(岁)
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">生日
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">私教
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">私教课
                                    </th>
                                    <!--                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">剩余生日课-->
                                    <!--                                        </th>-->
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="member in allMemberBirthdayLists">
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{8*(allMemberNow - 1)+$index+1}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.name}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.sex == '1'?'男':member.sex == '2'?'女':'暂无'}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.mobile | noData:''}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.birth_date | birth}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.birth_date | noData:''}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.coachName | noData:''}}</td>
                                    <td ng-click="getMemberDataCardBtn(member.id)">{{member.course_name | noData:''}}</td>
                                    <!--                                        <td>未返回节</td>-->
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(member.id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'allMemberFlag','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'allMemberPages']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>