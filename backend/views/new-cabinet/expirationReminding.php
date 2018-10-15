<!--
/**
 * Created by PhpStorm.
 * User: 程丽明
 * Date: 2017/12/13
 * Time: 16:10
 * content:柜子到期短信提醒模态框
 */
-->
<!-- 柜子到期短信提醒模态框Modal -->
<div class="modal fade" id="expirationRemindingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%;min-width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >到期提醒</h4>
            </div>
            <section class="row">
                <div class="col-sm-12 col-xs-12" style="display: flex;flex-wrap: wrap;">
                    <div class="mL10">
                        <select class="form-control selectPd" style="width: 120px;" ng-model="cabinetData" ng-change="getCabinet()">
                            <option value="">全部区域</option>
                            <option value="{{cabinet.id}}" ng-repeat="cabinet in cabinetType">
                                {{cabinet.type_name}}
                            </option>
                        </select>

                    </div>
                    <div class="mL10">
                        <select class="form-control selectPd" style="width: 140px;"ng-model="cabinetDay" ng-change="getDay()">
                            <option value="">选择到期时间</option>
                            <option value="d">当日</option>
                            <option value="w">当周</option>
                            <option value="m">当月</option>
                        </select>
                    </div>
                    <div class="mL10">
                            <button type="button" class="btn btn-success" style="width: 50px;padding: 4px 8px;" ng-click="searchCabinetS()">搜索</button>
                    </div>
                </div>
            </section>
            <div class="modal-body">
                <div class="row">
                    <div class="ibox float-e-margins borderNone" >
                        <div class="ibox-content pd0" style="border: none;padding: 0px;">
                            <div  id="DataTables_Table_0_wrapper" class="pB0 dataTables_wrapper form-inline" role="grid">
                                <table class="table table-bordered table-hover dataTables-example dataTable">
                                    <thead>
                                    <tr role="row">
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 70px;background-color: #FFF;">序号</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;">区域</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 110px;background-color: #FFF;">柜号</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 110px;background-color: #FFF;">型号</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;">会员姓名</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;">手机号</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;">到期日期</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat='data in datas'>
                                        <td>{{8*(hua-1)+ $index +1}}</td>
                                        <td>{{data.type_name | noData:''}}</td>
                                        <td>{{data.cabinet_number | noData:''}}</td>
                                        <td ng-if="data.cabinet_model ==1">大柜</td>
                                        <td ng-if="data.cabinet_model ==2">中柜</td>
                                        <td ng-if="data.cabinet_model ==3">小柜</td>
                                        <td>{{data.name | noData:''}}</td>
                                        <td>{{data.mobile | noData:''}}</td>
                                        <td>{{data.end_rent*1000 | date:'yyyy-MM-dd'| noData:''}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php',['name' => 'cabinetNoDataShow','text' => '无即将到期会员数据', 'href' => true]); ?>
                                <?=$this->render('@app/views/common/pagination.php',['page' =>'cabinet']);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-success"ng-click="sendCabinet()" ladda="sendBtnStatus">批量发送短信</button>
                </center>
            </div>
        </div>
    </div>
</div>
