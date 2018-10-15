<!--新增会员详情模态框-->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document"  style="min-width: 1000px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <h4 class="modal-title modalTitle" id="myModalLabel" >
                            新增会员
                        </h4>
                    </div>
                    <div class="row h55">
                        <div class="col-sm-12 pd0" style="display: flex;">
                            <div class=" pd0" style="width: 290px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                        <span class="add-on input-group-addon">
                                        选择日期
                                        </span>
                                    <input type="text" readonly name="reservation" id="addUserReservation"
                                           class="form-control text-center userSelectTime " style="width: 195px;"/>
                                </div>
                            </div>
                            <div >
                                <select id="addUserAdviserSelect2" class="selectCss form-control checkSellMan" ng-model="addUserAdviser">
                                    <option value="">请选择顾问</option>
                                    <option value="{{w.id}}" ng-repeat="w in addUserAdviserListData">{{w.name}}</option>
                                </select>
                            </div>
                            <div style="margin-left: 10px;">
                                <select class="selectCss form-control"  ng-model="addUserMemberType">
                                    <option value="">请选择卡种</option>
                                    <option value="{{w.id}}" ng-repeat="w in addUserMemberTypeListData">{{w.type_name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control " ng-model="keywordAddUser" ng-keyup="enterSearchAddUser($event)" placeholder="请输入姓名、卡号、手机号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" ng-click="searchCardAddUser()">搜索</button>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-1 pd0">
                                <button  type="button"  class="btn btn-sm btn-info " ng-click="searchCardAddUserClear()">&emsp;清空&emsp;</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content modalContentBox" >
                        <div  id="DataTables_Table_0_wrapper" class="pdB0 dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" >序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('member_name',sort)">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('member_sex',sort)">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('member_mobile',sort)">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;" ng-click="changeSort('card_name',sort)">卡名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('price',sort)">金额
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('card_num',sort)">卡编号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('seller',sort)">会籍顾问
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('card_time',sort)">办卡时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="hoverTr" ng-repeat="user in addUserList">
                                    <td>{{8*(addMemberPageNow - 1) +$index + 1}}</td>
                                    <td>
                                        <span ng-if="user.name !=null">{{user.name}}</span>
                                        <span ng-if="user.name ==null">暂无数据</span>
                                    </td>
                                    <td><span ng-if="user.sex == 1">男</span>
                                        <span ng-if="user.sex == 2">女</span>
                                        <span ng-if="user.sex ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.mobile !=null">{{user.mobile}}</span>
                                        <span ng-if="user.mobile ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.card_name !=null">{{user.card_name}}</span>
                                        <span ng-if="user.card_name ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.amount_money !=null">{{user.amount_money}}</span>
                                        <span ng-if="user.amount_money ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.card_number !=null">{{user.card_number}}</span>
                                        <span ng-if="user.card_number ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.ename !=null">{{user.ename}}</span>
                                        <span ng-if="user.ename ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="user.create_at !=null">{{user.register_time*1000 | date:'yyyy-MM-dd'}}</span>
                                        <span ng-if="user.create_at ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(user.id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'addMemberInfo','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'addMemberPages']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>