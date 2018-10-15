
<!--即将到期详情模态框-->
<div class="modal fade" id="expireModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document" style="min-width: 1000px;" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row">
                    <h4 class="modal-title modalTitle" id="myModalLabel" >
                        即将到期
                    </h4>
                </div>
                <div class="row h55">
                    <div class="col-sm-5 pd0">
                        <div class="col-sm-8 pd0">
                            <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                <span class="add-on input-group-addon"">
                                选择日期
                                </span>
                                <input type="text" readonly  name="reservation" id="reservation" class="form-control text-center userSelectTime reservationExpire" style="width: 195px;"/>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <select id="expireAdviserSelect2" class=" form-control selectCss checkSellMan" ng-model="expireAdviser" >
                                <option value="">选择顾问</option>
                                <option value="{{w.id}}" ng-repeat="w in adviserListData">{{w.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" class="form-control " ng-model="expireKeywords" ng-keyup="enterSearchExpire($event)" placeholder=" 请输入姓名、卡号、手机号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" ng-click="searchCardExpire()">搜索</button>
                                </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-sm   btn-info  " ng-click="searchCardExpireClear()">&emsp;清空&emsp;</button>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content modalContentBox" >
                        <div  id="DataTables_Table_0_wrapper" class="pdB0 dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" >序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeEXSort('member_name',sort)">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeEXSort('member_sex',sort)">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeEXSort('member_mobile',sort)">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"  ng-click="changeEXSort('seller',sort)">会籍顾问
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"  ng-click="changeEXSort('card_name',sort)">卡种名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"  ng-click="changeEXSort('card_number',sort)">卡号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"  ng-click="changeEXSort('card_name',sort)">办卡时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;"   ng-click="changeEXSort('invalid_time',sort)">到期时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="hoverTr" ng-repeat="ex in expireUserList">
                                    <td>{{8*(EXPageNow-1)+$index+1}}</td>
                                    <td>
                                        <span >{{ex.name | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span ng-if="ex.sex == 1">男</span>
                                        <span ng-if="ex.sex == 2">女</span>
                                        <span ng-if="ex.sex == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span >{{ex.mobile | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span >{{ex.ename | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span >{{ex.card_name | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span >{{ex.card_number | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span ng-if='ex.create_at != null'>{{ex.create_at*1000 | date:'yyyy-MM-dd' }}</span>
                                        <span ng-if='ex.create_at == null'>暂无数据</span>
                                    </td>
                                    <td>
                                        <span>{{ex.invalid_time*1000 | date:'yyyy-MM-dd' }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(ex.id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'expireUserInfo','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'EXPages']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>