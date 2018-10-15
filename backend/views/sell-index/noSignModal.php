<!--未签到详情模态框-->
<div class="modal fade" id="noSignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document " style="min-width: 1000px;" >
        <div class="modal-content clearfix">
            <div class="modal-header" style="padding-bottom: 0;border-width: 0;">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <h4 class="modal-title modalTitle" id="myModalLabel" >
                            未签到
                        </h4>
                    </div>
                    <div class="row h55">
                        <div class="col-sm-5 pd0">
                            <div class="col-sm-8 pd0">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon"">
                                    选择日期
                                    </span>
                                    <input type="text"  readonly name="reservation" id="noSignReservation" class="form-control text-center userSelectTime " style="width: 195px;"/>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <select id="noSignListIdSelect2" class="selectCss form-control checkSellMan" ng-model="noSignListId">
                                    <option value="">选择顾问</option>
                                    <option value="{{w.id}}" ng-repeat="w in noSignListData">{{w.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control " ng-model="keywordsNoSign" ng-keyup="enterSearchNoSign($event)" placeholder="  请输入姓名、卡号、手机号进行搜索...">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="searchCardNoSign()">搜索</button>
                                    </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-info " ng-click="searchCardNoSignClear()">&emsp;清空&emsp;</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content modalContentBox" >
                                <div  id="DataTables_Table_0_wrapper" class="pdB0 dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" >序号
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('member_name',sort)">姓名
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('member_sex',sort)">性别
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('member_mobile',sort)">手机号
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('seller',sort)">会籍顾问
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('entry_time',sort)">最近到场
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeNotSort('entry_time',sort)">未到天数
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="hoverTr" ng-repeat="no in noSignList">
                                            <td>{{8*(noSignPageNow - 1)+ $index + 1}}</td>
                                            <td>
                                                <span >{{no.name | noData:''}}</span>
                                            </td>
                                            <td>
                                                <span ng-if="no.sex == 1">男</span>
                                                <span ng-if="no.sex == 2">女</span>
                                                <span ng-if="no.sex == null">暂无数据</span>
                                            </td>
                                            <td>
                                                <span >{{no.mobile| noData:''}}</span>
                                            </td>
                                            <td>
                                                <span >{{no.ename | noData:''}}</span>
                                            </td>
                                            <td>
                                                <span ng-if="no.entry_time != null">{{no.entryRecord.entry_time*1000 | date:'yyyy-MM-dd hh:mm:ss' | noData:''}}</span>
                                                <span ng-if="no.entry_time == null">暂无数据</span>
                                            </td>
                                            <td>
                                                <span ng-if="no.entry_time != null">{{(currentNowTimeS - no.entryRecord.entry_time)/(60*60*24) | number:0}}</span>
                                                <span ng-if="no.entry_time == null">暂无数据</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(no.id)">查看详情</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'noSignInfo','text'=>'暂无数据','href'=>true]);?>
                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'reNotPages']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>