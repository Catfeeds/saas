<!--  数据详情-->
<div class="modal fade" id="siteManagementDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg w80bfz" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header clearfix">
                <div class="col-sm-4">
                    <div class="w120px input-append padding0 date dateBox col-sm-6" id="dateIndex"
                         data-date="2017-06-09" data-date-format="yyyy-mm-dd">
                        <input class="span2 form-control " size="16" type="text" value="" id="dateSpan" readonly
                               ng-model="dateInput"/>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <!--                        <div class="col-sm-6 padding0" style="width: 120px;padding-left: 10px;">-->
                    <!--                            <select class="form-control" ng-change="selectionTime(aboutIntervalSection)"  ng-model="classStatus" style="padding-top: 3px;padding-right: 3px;">-->
                    <!--                                <option value="">请选择状态</option>-->
                    <!--                                <option value="1">已预约</option>-->
                    <!--                                <option value="2">进行中</option>-->
                    <!--                                <option value="3">已结束</option>-->
                    <!--                                <option value="4">旷课</option>-->
                    <!--                                <option value="5">取消预约</option>-->
                    <!--                            </select>-->
                    <!--                        </div>-->
                </div>
                <div class="col-sm-4">
                    <h4 class="modal-title modalTitleCente" id="myModalLabel">场地详情</h4>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div class="modal-body padding0">
                <div class="w50h500px padding0">
                    <div class="col-sm-4 padding0">
                        <div class="col-sm-12 h47 padding0  borderBottom">
                            <div class="col-sm-6 lineHeight modalTitleCente"><strong>时间段</strong></div>
                            <div class="col-sm-6 lineHeight modalTitleCente"><strong>预约人数</strong></div>
                        </div>
                        <ul class="col-sm-12 padding0 h400">
                            <li class="col-sm-12 padding0 h47 orderNumList"
                                ng-repeat="(key,value)  in siteDetailsLeft.orderNumList"
                                ng-click="selectionTime(key,value.timeStatus)">
                                <div class="col-sm-6 lineHeight modalTitleCente color254"
                                     ng-if="value.timeStatus == 1">{{key}}
                                </div>
                                <div class="col-sm-6 lineHeight modalTitleCente valueTimeStatus color254"
                                     ng-if="value.timeStatus == 1" data-value="{{value.timeStatus}}"><span>{{value.num}}</span>/<span>{{siteDetailsLeft.yardMessage.people_limit}}</span>
                                </div>
                                <div class="col-sm-6 lineHeight modalTitleCente" ng-if="value.timeStatus == 2">
                                    {{key}}
                                </div>
                                <div class="col-sm-6 lineHeight modalTitleCente valueTimeStatus"
                                     ng-if="value.timeStatus == 2" data-value="{{value.timeStatus}}"><span>{{value.num}}</span>/<span>{{siteDetailsLeft.yardMessage.people_limit}}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-8 myModals2ModalRigthDiv paddingLeft0 borderLeft ">
                        <div class="col-sm-12 pl0">
                            <div class="h450" style="overflow: auto;">
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            ng-click="changeSort('pic',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                            &nbsp;序号
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            ng-click="changeSort('name',sort)" colspan="1"
                                            aria-label="浏览器：激活排序列升序">&nbsp;会员名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            ng-click="changeSort('yard_name',sort)" colspan="1"
                                            aria-label="浏览器：激活排序列升序">&nbsp;手机号
                                        </th>
                                        <!--                                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"-->
                                        <!--                                                rowspan="1"-->
                                        <!--                                                ng-click="changeSort('yard_name',sort)" colspan="1"-->
                                        <!--                                                aria-label="浏览器：激活排序列升序">&nbsp;状态-->
                                        <!--                                            </th>-->
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            ng-click="changeSort('people_limit',sort)" colspan="1"
                                            aria-label="平台：激活排序列升序">&nbsp;预约时间
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            ng-click="changeSort('business_time',sort)" colspan="1"
                                            aria-label="引擎版本：激活排序列升序">&nbsp;操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="h35px">
                                        <td>序号</td>
                                        <td>会员名称</td>
                                        <td>手机号</td>
                                        <!--                                            <td>状态</td>-->
                                        <td>预约时间</td>
                                        <td>
                                            <button id="reservationMember" ng-disabled="dataParams" type="button"
                                                    class="btn-sm btn btn-success"
                                                    ng-click="reservationMember()">预约场地
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="h35px" ng-repeat="($index,w) in selectionTimeList">
                                        <td>{{nowPage*5 + $index+1}}</td>
                                        <td>{{w.username}}</td>
                                        <td>{{w.mobile}}</td>
                                        <!--                                            <td>-->
                                        <!--                                                <span ng-if="w.status == 1" class="colorYellowGreen">已预约</span>-->
                                        <!--                                                <span ng-if="w.status == 2" class="colorGreen">进行中</span>-->
                                        <!--                                                <span ng-if="w.status == 3">已结束</span>-->
                                        <!--                                                <span ng-if="w.status == 4">旷课</span>-->
                                        <!--                                                <span ng-if="w.status == 5">取消预约</span>-->
                                        <!--                                            </td>-->
                                        <td>{{w.create_at * 1000 |date:'yyyy-MM-dd HH:mm'}}</td>
                                        <td>
                                            <button type="button" ng-disabled="dataParams"
                                                    class="btn-sm btn btn-default"
                                                    ng-click="cancelReservation(w.id,w.aboutDate,w.about_interval_section)">
                                                取消预约
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="col-sm-12">
                                    <div class="col-sm-12">
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'detailInfo']); ?>
                                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'detailPages']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>