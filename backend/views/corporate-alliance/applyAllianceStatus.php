<!--申请状态模态框-->
<div class="modal fade" id="myModalRecordApplyState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog w55" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header pdbox40 pdt10 pdm20">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="refuseApplyShopDetailsModalClose()"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center pdl20" id="myModalLabel">申请通店</h4>
            </div>
            <!--被申请通过-->
            <div class="modal-body modalBody4GetShopSuccess displayNone">
                <div class="row">
                    <div class="col-sm-12 text-center pdt30">
                        <img ng-src="/plugins/img/query.png" src="/plugins/img/query.png" width="120px">
                    </div>
                    <div class="col-sm-12">
                        <p class="text-center shopTextTitleP3 mrt10">已确认同意对方的通店申请。</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooter4GetShopSuccess displayNone">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-white w120 center-block" ng-click="refuseApplyShopDetailsModalClose()">关闭</button>
                </div>
            </div>
            <!--被申请不通过-->
            <div class="modal-body modalBody4GetShopFail displayNone">
                <div class="row">
                    <div class="col-sm-12 pdt30">
                        <form class="form-horizontal">
                            <div class="form-group col-sm-10 col-sm-offset-1">
                                <label class="col-sm-6 control-label"><span class="red">*</span>不可再次申请时长</label>
                                <div class="col-sm-6">
                                    <select class="form-control selectNotApply" ng-model="notApplyLength">
                                        <option value="">请选择</option>
                                        <option value="15">15天</option>
                                        <option value="30">一个月</option>
                                        <option value="60">两个月</option>
                                        <option value="180">半年</option>
                                        <option value="360">一年</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-10 col-sm-offset-1">
                                <label class="col-sm-6 control-label">备注</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" placeholder="填写拒绝原因" ng-model="note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooter4GetShopFail displayNone">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-success w120 center-block" ng-click="noGetApplyShopFail()">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>