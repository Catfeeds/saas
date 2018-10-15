<!-- 上课收入详情模态框 -->
<div class="modal fade"
     id="classDetailsModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog"
         role="document"
         style="width: 85%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"
                    id="myModalLabel">
                    上课收入详情
                </h4>
                <div>
                    <form class="form-inline text-left">
                        <div class="input-daterange input-group dateInput" id="container">
                            <span class="add-on input-group-addon smallFont">选择日期</span>
                            <input type="text"
                                   readonly
                                   name="dateClick"
                                   id="couserDateSelect"
                                   class="form-control text-center userSelectTime userSelectDate"/>
                        </div>
                        <div class="form-group">
                            <select class="form-control venueSelect"
                                    ng-model="couserTypeClass">
                                <option value="">课程分类</option>
                                <option value="1">PT</option>
                                <option value="2">HS</option>
                                <option value="3">生日课</option>
                            </select>
                        </div>
                        <!--                                <div class="form-group">-->
                        <!--                                    <select class="form-control venueSelect"-->
                        <!--                                            ng-model="couserTypeSelect">-->
                        <!--                                        <option value="">课种筛选</option>-->
                        <!--                                    </select>-->
                        <!--                                </div>-->
                        <button type="submit"
                                class="btn btn-default btn-sm"
                                ng-click="initCouserSearch()">清空</button>
                        <button type="submit"
                                class="btn btn-info btn-sm"
                                ng-click="searchCouerOp(c.id)">搜索</button>
                    </form>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3 pd0 text-center infoBox">
                            <img class="img-circle"
                                 src="/plugins/checkCard/img/11.png"
                                 ng-src="/plugins/checkCard/img/11.png"
                                 ng-if="couserInfoList.pic == null || couserInfoList.pic == ''"
                                 width="150">
                            <img class="img-circle"
                                 ng-src="{{couserInfoList.pic}}"
                                 ng-if="couserInfoList.pic != null && couserInfoList.pic != ''"
                                 width="150">
                            <p class="infoName">教练姓名：{{couserInfoList.name|noData:''}}</p>
                            <p class="infoOther">教练职位：{{couserInfoList.position|noData:''}}</p>
                            <p class="infoOther">教练级别：{{couserInfoList.level|noData:''}}</p>
                            <p class="infoOther">手机号码：{{couserInfoList.mobile|noData:''}}</p>
                        </div>
                        <div class="col-sm-9 pd0 text-center rightContentBox">
                            <div class="col-sm-12 contentBox pd0">
                                <div class="ibox float-e-margins tableBox">
                                    <div class="ibox-content" style="padding: 0">
                                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                               id="DataTables_Table_0"
                                               aria-describedby="DataTables_Table_0_info" style="margin-bottom: 0;">
                                            <thead>
                                            <tr role="row">
                                                <th class="bgw"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 140px;">序号</th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 222px;">会员姓名</th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 222px;">手机号</th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 222px;">上课节数</th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    aria-controls="DataTables_Table_0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 222px;">上课金额</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="cou in classCouserList">
                                                <td ng-click="showUserList(cou.id)">{{8*(nowPage2-1)+$index+1}}</td>
                                                <td ng-click="showUserList(cou.id)">{{cou.name}}</td>
                                                <td ng-click="showUserList(cou.id)">{{cou.mobile}}</td>
                                                <td ng-click="showUserList(cou.id)">{{cou.token_num}}</td>
                                                <td ng-click="showUserList(cou.id)">{{cou.token_money}}</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/pagination.php',['page'=>'attendClassPages']); ?>
                                        <?=$this->render('@app/views/common/nodata.php',['name'=>'couserNoDataShow','text'=>'暂无信息','href'=>true]);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <span>节数:<span class="orangeSpan">{{allCouserClass}}</span></span>
                <span>上课金额:<span class="orangeSpan">{{classCouserMoney}}</span></span>
            </div>
        </div>
    </div>
</div>