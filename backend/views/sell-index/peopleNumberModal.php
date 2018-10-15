<!--客流量详情模态框-->
<div class="modal fade" id="peopleNumberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document " style="min-width: 1100px;" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <h4 class="modal-title modalTitle" id="myModalLabel" >
                            客流量
                        </h4>
                    </div>
                    <div class="row h55">
                        <div class="col-sm-12 pL0" style="display: flex;">
                            <div  style="width: 296px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon"">
                                    选择日期
                                    </span>
                                    <input type="text"  readonly name="reservation" id="peopleNumberReservation"
                                           class="form-control text-center userSelectTime " style="width: 195px;"/>
                                </div>
                            </div>
                            <div style="margin-left: 10px;min-width: 120px;">
                                <select id="peopleNumAdviserIdSelect2" class="selectCss form-control checkSelectG checkSellMan" ng-model="peopleNumAdviserId">
                                    <option value="">请选择顾问</option>
                                    <option value="{{w.id}}" ng-repeat="w in peopleNumAdviserLIstData">{{w.name}}</option>
                                </select>
                            </div>
                            <div style="margin-left: 10px;min-width: 120px;">
                                <select class="selectCss form-control checkSelectG" ng-model="peopleNumCoachId">
                                    <option value="">请选择教练</option>
                                    <option value="{{w.id}}" ng-repeat="w in peopleNumInfoListData">{{w.name}}</option>
                                </select>
                            </div>
                            <div style="margin-left: 10px;min-width: 120px;">
                                <select class="selectCss form-control checkSelectG" ng-model="peopleNumCardId">
                                    <option value="">请选择卡种</option>
                                    <option value="{{w.id}}" ng-repeat="w in peopleNumCardListData">{{w.type_name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-4 pd0" style="margin-left: 10px;">
                                <div class="input-group">
                                    <input type="text" class="form-control " ng-model="keywordPeopleNumber" ng-keyup="enterSearchPeopleNumber($event)" placeholder="请输入姓名、卡号、手机号、卡名称进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-primary" ng-click="searchCardPeopleNumber()">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <div style="margin-left: 10px;">
                                <button  type="button" class="btn btn-sm  btn-info" ng-click="searchCardPeopleNumberClear()">&emsp;清空&emsp;</button>
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
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;" ng-click="changePeopleNumSort('',sort)">序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;" ng-click="changePeopleNumSort('entry_time',sort)">进场时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;" ng-click="changePeopleNumSort('member_name',sort)">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;" ng-click="changePeopleNumSort('member_sex',sort)">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changePeopleNumSort('member_cardId',sort)">会员卡号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changePeopleNumSort('member_mobile',sort)">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changePeopleNumSort('card_name',sort)">卡名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changePeopleNumSort('member_counselorId',sort)">会籍顾问
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changePeopleNumSort('member_coachId',sort)"> 教练
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"> 操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  ng-repeat="people in peopleNumLists">
                                    <td>{{8*(peopleNumNowPage - 1)+$index+1}}</td>
                                    <td>{{people.entry_time *1000 | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                    <td>{{people.member.memberDetails.name  | noData:''}}</td>
                                    <td>{{people.member.memberDetails.sex=='1'?'男':'女'  | noData:''}} </td>
                                    <td>{{people.card_number  | noData:''}}</td>
                                    <td>{{people.member.mobile  | noData:''}}</td>
                                    <td>{{people.card_name  | noData:''}}</td>
                                    <td>{{people.member.employee.name  | noData:''}}</td>
                                    <td>{{people.privateName | noData:''}}</td>
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(people.member_id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'peopleNumInfo','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'peopleNumPages']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>