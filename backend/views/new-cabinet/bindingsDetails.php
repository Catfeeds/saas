<!--    已绑定详情模态框-->
<div class="modal fade" id="boundCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB50" role="document" style="width: 65%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title col-sm-6 showBoxTitle" ng-class="{false:'activeBox',true:''}[isShowBox]" ng-click="showBoxClick(2)" id="myModalLabel" style="display: inline-block;float: unset;cursor:pointer;">消费记录</h4>
                <h4 class="modal-title col-sm-5 showBoxTitle" ng-class="{true:'activeBox',false:''}[isShowBox]" ng-click="showBoxClick(1)" id="myModalLabel2" style="display: inline-block;float: left;cursor:pointer;">基本信息</h4>
            </div>
            <div ng-show="showBox == 1">
                <div class="modal-body row" >
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-5 iconBox">
                            <img class="imgHeaderW100" ng-src="{{cabinetDetail.pic}}" ng-if="cabinetDetail.pic != null">
                            <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" ng-if="cabinetDetail.pic == null">
                            <p class="iconName col-sm-12"><span class="col-sm-7" style="text-align: right">姓名:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.name}}</span></p>
                            <p class="mobile  col-sm-12"><span class="col-sm-7" style="text-align: right">手机号:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.mobile}}</span></p>
                            <p class="userId col-sm-12"><span class="col-sm-7" style="text-align: right">会员编号:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.member_id}}</span></p>
                        </div>
                        <div class="col-sm-7">
                            <div class="col-sm-9 col-sm-offset-2 infoBox pT40 f14" >
                                <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                    <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                    <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                    <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                </p>
                                <p>总共金额:<span>{{cabinetDetail.price |number:2}}</span>元</p>
                                <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                <p>剩余天数:<span>{{cabinetDetail.surplusDay | noData:''}}</span>天</p>
                                <p>有效期至:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                <p>备注信息:<span>{{cabinetDetail.remark | noData:''}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'UPDATE')) { ?>
                    <button type="button" class="btn btn-info w100" ng-click="editUnBinding(cabinetDetailOne.cabinet_id,'isBind')" data-toggle="modal" data-target="#revise">修改</button>
                <?php } ?>
                <button type="button" ng-if="cabinetDetailOne.status==2 && cabinetDetailOne.end_rent > cabinetCurrentTime/1000" class="btn btn-success w100"  ng-click="switchCabinet(cabinetDetailOne)">调柜</button>
                <button type="button" class="btn btn-warning w100"  ng-click="renewCabinet(cabinetDetailOne)" data-toggle="modal" data-target="#renewCabinet">续柜</button>
                <button type="button" class="btn btn-white w100"  ng-click="quitCabinet(cabinetDetailOne.cabinet_id,cabinetDetailOne.memberCabinetId, cabinetDetailOne)" data-toggle="modal" data-target="#backCabinet">退柜</button>
                <!--                                            冻结的触发按钮-->
                <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==2"   ng-click="freezeCabinet(cabinetDetailOne.cabinet_id)">冻结</button>
                <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==4" ng-click="cancelFreezeCabinet(cabinetDetailOne.cabinet_id)" >取消冻结</button>
                <button type="button" style="color: #fff;" class="btn w100" data-toggle="modal" data-target="#boundCabinet">关闭</button>
            </div>
            </div>
            <div ng-show="showBox == 2">
                    <div class="ibox-content">
                        <div id="DataTables_Table_0_wrapper"
                             class="dataTables_wrapper form-inline a26" role="grid">
                            <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info"
                                    style="position: relative;">
                                <thead>
                                <tr role="row">
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">消费行为
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">消费金额
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">租用日期
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">消费日期
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">赠送时间
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                    </th>
                                    <th class="a28" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序">备注
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="w in memberConsumListData">
                                    <td>{{w.rent_type}}</td>
                                    <td>{{w.price}}</td>
                                    <td>{{w.start_rent *1000 | noData:''| date:'yyyy/MM/dd'}} - {{w.end_rent *1000 | noData:''| date:'yyyy/MM/dd'}}</td>
                                    <td ng-if="w.rent_type == '退租金'">{{w.back_rent *1000 | noData:''|
                                        date:'yyyy/MM/dd'}}</td>
                                    <td ng-if="w.rent_type != '退租金'">{{w.create_at *1000 | noData:''|
                                        date:'yyyy/MM/dd'}}
                                    </td>
                                    <td ng-if="w.give_month != null && w.give_month != 0 && w.give_month != ''">{{w.give_month}}
                                        <span ng-if="w.give_type != null">
                                            <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 1">天</span>
                                            <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 2">月</span>
                                        </span><span ng-if="w.give_type == null">月</span></td>
                                    <td ng-if="w.give_month == null || w.give_month == 0 || w.give_month == ''">0</td>
<!--                                    <td>-->
<!--                                        {{w.name | noData}}-->
<!--                                    </td>-->
                                    <td ng-if="w.name != null && w.name != undefined && w.name != ''">{{w.name}}</td>
                                    <td ng-if="w.name == null || w.name == undefined || w.name == ''">暂无数据</td>
                                    <td ng-if="w.remark != null && w.remark != undefined && w.remark != ''">{{w.remark }}</td>
                                    <td ng-if="w.remark == null || w.remark == undefined || w.remark == ''">暂无数据</td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/pagination.php',['page'=>'recordPages']); ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>