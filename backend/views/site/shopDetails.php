

<!--进店人数详情模态框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 18px;margin-bottom: 20px;">今日到店详情</h4>
                <div class="ibox float-e-margins">
                    <div class="ibox-content" style="height: 500px;overflow-y: scroll;">
                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">进场时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">会员卡号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">刷卡种类
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">会籍顾问
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">教练
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="hoverTr" ng-repeat="item in userItems">
                                    <td>{{(item.entry_time*1000) | date:"HH:mm:ss"}}</td>
                                    <td>
                                        <span ng-if="item.memberName != null">{{item.memberName}}</span>
                                        <span ng-if="item.memberName == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.memberSex == 2">女</span>
                                        <span ng-if="item.memberSex == 1">男</span>
                                        <span ng-if="item.memberSex != 1 && item.memberSex != 2">不详</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.card_number != null">{{item.card_number}}</span>
                                        <span ng-if="item.card_number == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.mobile != 0">{{item.mobile}}</span>
                                        <span ng-if="item.mobile == 0">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.card_name != null">{{item.card_name}}</span>
                                        <span ng-if="item.card_name == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.counselorName != null">{{item.counselorName}}</span>
                                        <span ng-if="item.counselorName == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.coach_name != null">{{item.coach_name}}</span>
                                        <span ng-if="item.coach_name == null">暂无数据</span>
                                    </td>
                                </tr>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'groupNoDataShow','text'=>'暂无信息','href'=>true]);?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="pull-right allNumPeople">共<span>{{datePeopleNum}}</span>人</p>
            </div>
        </div>
    </div>
</div>