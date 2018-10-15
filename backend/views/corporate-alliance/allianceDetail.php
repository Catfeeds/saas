<!--通店详情的模态框-->
<div class="modal fade" id="applyShopDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog w55" role="document">
        <div class="row">
            <div class="modal-content clearfix">
                <div class="modal-header pdbox40">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="closeApplyModal()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center pdl20" id="myModalLabel">申请通店</h4>
                    <div class="col-sm-6 text-center pd0 tabBoxShop tabBox1 tabBoxDDD tabBoxShopActive" ng-click="tabDetailsShop()">
                        通店详情
                    </div>
                    <div class="col-sm-6 text-center pd0 tabBoxShop tabBox2 tabBoxDDD" ng-click="tabRecordShop()">
                        申请记录
                    </div>
                </div>
                <!--通店通过-->
                <div class="successApply modalBox" ng-if="detailsName == contactNameddd && detailsStatus == '1' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/query.png" src="/plugins/img/query.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">已通过通店申请。</p>
                                <p class="text-center shopTextTitleP3">通店日期:{{start_apply*1000|date:'yyyy-MM-dd'}}至{{end_apply*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-white center-block w120" ng-click="cancelNot()">取消通店</button>
                    </div>
                </div>
                <!--通店被拒绝-->
                <div class="failApply modalBox" ng-if="detailsName == contactNameddd && detailsStatus == '3' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/mistake.png" src="/plugins/img/mistake.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">通店申请被拒绝。</p>
                                <p class="text-center shopTextTitleP3">{{start_apply*1000|date:'yyyy-MM-dd'}}至{{end_apply*1000|date:'yyyy-MM-dd'}}不可申请</p>
                                <p class="text-center shopTextTitleP3">很抱歉，暂不接受通店申请!</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-white center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
                <!--申请记录-->
                <div class="ApplyRecord">
                    <div class="modal-body modalApplyList">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins borderNone">
                                    <div class="ibox-content pd10">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pdm0" role="grid">
                                            <table class="table table-hover dataTables-example dataTable">
                                                <thead>
                                                <tr role="row">
                                                    <th class="w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">申请时间</th>
                                                    <th class="w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">申请状态</th>
                                                    <th class="w200" tabindex="0" rowspan="1" colspan="1">备注</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="b in applyRecordInfoList track by $index">
                                                    <td>
                                                        <span ng-if="b.start_apply != null">{{b.start_apply*1000|date:'yyyy-MM-dd'}}</span>
                                                        <span ng-if="b.start_apply == null">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="b.status == null">暂无数据</span>
                                                        <span ng-if="b.status == '1'">已通过</span>
                                                        <span ng-if="b.status == '2'">等待通过</span>
                                                        <span ng-if="b.status == '3'">未通过</span>
                                                        <span ng-if="b.status == '4'">取消</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="b.note != null">{{b.note}}</span>
                                                        <span ng-if="b.note == null">暂无数据</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/pagination.php',['page'=>'listPages']);?>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'noDataListShow','text'=>'暂无数据','href'=>true]);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--通店到期-->
                <div class="expireApply modalBox" ng-if="detailsName == contactNameddd && end_apply < todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">通店已到期。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-success center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
                <!--申请取消-->
                <div class="cancelApply modalBox" ng-if="detailsName == contactNameddd && detailsStatus == '4' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">申请已取消。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-success center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
                <!--等待审批-->
                <div class="waitApply modalBox" ng-if="detailsName == contactNameddd && detailsStatus == '2' && end_apply >= todayTime">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <img ng-src="/plugins/img/query.png" src="/plugins/img/query.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP2">已申请，请等待对方通过...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white center-block w120" ng-click="waitForApplyShopModalClose()">关闭</button>
                    </div>
                </div>
                <!--被申请详情-->
                <div class="detailsApplyCover modalBox" ng-if="detailsName != contactNameddd && detailsStatus == '2' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP4 mrt10">申请通店等待中。</p>
                                <p class="text-center shopTextTitleP5 mrt10">通店日期:{{start_apply*1000|date:'yyyy-MM-dd'}}至{{end_apply*1000|date:'yyyy-MM-dd'}}</p>
                                <p class="text-center shopTextTitleP6 mrt10">申请通过并在对方店面会员卡通店设置选择本店后，则对方店面会员可单向到本店进行消费。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <div class="col-sm-12">
                            <div class="col-sm-8 col-sm-offset-2 pd0 btnInfoBox">
                                <button type="button" class="btn btn-success w120 poBtn1" ng-click="argeeApplyShopSuccess()">通过申请</button>
                                <button type="button" class="btn btn-white w120 poBtn2" ng-click="refuseApplyShop()">拒绝申请</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--被申请拒绝-->
                <div class="failApplyCover modalBox" ng-if="detailsName != contactNameddd && detailsStatus == '3' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/mistake.png" src="/plugins/img/mistake.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">通店申请已拒绝。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-white center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
                <!--被申请成功-->
                <div class="successApplyCover modalBox" ng-if="detailsName != contactNameddd && detailsStatus == '1' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/query.png" src="/plugins/img/query.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">通店申请已接受。</p>
                                <p class="text-center shopTextTitleP3">通店日期:{{start_apply*1000|date:'yyyy-MM-dd'}}至{{end_apply*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-white center-block w120" ng-click="cancelNot()">取消通店</button>
                    </div>
                </div>
                <!--被申请取消-->
                <div class="cancelApplyCover modalBox" ng-if="detailsName != contactNameddd && detailsStatus == '4' && end_apply >= todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">申请已取消。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-success center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
                <!--被通店到期-->
                <div class="expireApply modalBox" ng-if="detailsName != contactNameddd && end_apply < todayTime">
                    <div class="modal-body modalBody">
                        <div class="row">
                            <div class="col-sm-12 text-center pdt30">
                                <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                            </div>
                            <div class="col-sm-12">
                                <p class="text-center shopTextTitleP3">通店已到期。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modalFooter">
                        <button type="button" class="btn btn-success center-block w120" ng-click="applyShopDetailsModalClose()">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>