<!--    调柜模态框-->
<div class="modal" id="checkCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: auto;">
    <div class="modal-dialog wB70" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" >会员调柜</h4>
            </div>
            <div class="modal-body row pB0 pT0 pL15" >
                <div class="col-sm-12 pd0">
                    <div class="col-sm-3 pd0 switchCabinetArea" >
                        <ul class="checkUl">
                            <li class="listCabinetStyle"   ng-repeat="cabinet in allCabinet" ng-click="cabinetStyleList(cabinet.id,$index,cabinet)">{{cabinet.type_name}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-9 pd0 switchCabinetAreaCabinetNum" >
                        <div class="ibox float-e-margins boxShowNone borderNone" >
                            <div class="ibox-content borderNone pd10" >
                                <div  id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pB0" role="grid">
                                    <table class="table table-bordered table-hover dataTables-example dataTable">
                                        <thead>
                                        <tr role="row">
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">柜号</th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">型号</th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat=" unLeasedCabinet in  unLeasedCabinetLists">
                                            <td>{{unLeasedCabinet.cabinet_number}}</td>
                                            <td>
                                                <span ng-if="unLeasedCabinet.cabinet_model == 1">大柜</span>
                                                <span ng-if="unLeasedCabinet.cabinet_model == 2">中柜</span>
                                                <span ng-if="unLeasedCabinet.cabinet_model == 3">小柜</span>
                                                <span ng-if="unLeasedCabinet.cabinet_model == null">暂无数据</span>
                                            </td>
                                            <td class="tdBtn">

                                                <!--                                            点击选择的触发按钮-->
                                                <button class="btn btn-sm btn-success w100"   data-toggle="modal" ng-click="selectSwitchCabinetBtn(unLeasedCabinet)" data-target="#checkCabinetSuccess">选择</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer borderTopNone" >
                <!--                    <button type="button" class="btn btn-success" style="width: 100px">完成</button>-->
            </div>
        </div>
    </div>
</div>