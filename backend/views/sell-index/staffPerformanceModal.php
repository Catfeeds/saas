<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4 0004
 * Time: 18:00
 */
 -->
<!--员工业绩详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="staffPerformanceModal">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">员工业绩</h4>
            </div>
            <div class="modal-body">
            <!--筛选框和搜索框-->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6" style="padding-left: 0;padding-right: 0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly name="reservation" id="staffPerformanceDate" class="form-control text-center userSelectTime " style="width: 100%">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pdL0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="请输入员工姓名..." style="width: 100%;" ng-model="staffKeywords">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" style="padding-top: 4px;padding-bottom: 4px" ng-click="searchStaffBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pdL0">
                        <button class="btn btn-small btn-default" style="padding-top: 4px;padding-bottom: 4px" ng-click="clearStaffBtn()">清空</button>
                    </div>
                </div>
            <!--列表开始-->
                <div class="row" style="margin-top: 20px">
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                style="background-color: transparent;">员工姓名
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="background-color: transparent;">职位
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="background-color: transparent;">会员姓名
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="平台：激活排序列升序" style="background-color: transparent;">手机号
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序">业务行为
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序">业务名称
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序" ng-click="staffChangeSort('sell_money',sort)">金额
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序" ng-click="staffChangeSort('create_at',sort)">缴费时间
                            </th>
                            <th class="" tabindex="0" rowspan="1" colspan="1"  style="background-color: transparent;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in staffDetailList">
                            <td>{{i.eName | noData:''}}</td>
                            <td>{{i.position | noData:''}}</td>
                            <td>{{i.memberName | noData:''}}</td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.note | noData:''}}</td>
                            <td>{{i.card_name | noData:''}}</td>
                            <td>{{i.total_price | noData:''}}元</td>
                            <td>{{i.pay_money_time * 1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(i.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'staffPerformancePage']);?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'staffPerformanceNoData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>