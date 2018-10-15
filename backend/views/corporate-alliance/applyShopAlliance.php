<!--申请通店的模态框-->
<div class="modal fade" id="applyShopAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="applyShopOkContactClose()"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center pdl20" id="myModalLabel">申请通店</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                    </div>
                    <div class="col-sm-12">
                        <p class="text-center shopTextTitleP">申请通店</p>
                        <p class="text-center mrt10 pdlr70">申请通过并在会员卡通店设置选择此品牌后，则本店会员可单向到申请的店面进行消费。</p>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 pd0 inputShopBox">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label shopLabel">
                                    <span class="red">*</span>
                                    申请公司</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="请输入公司名称" ng-model="beApply">
                                </div>
                            </div>
                            <div class="form-group mrt10">
                                <label class="col-sm-3 control-label shopLabel">
                                    <span class="red">*</span>
                                    通店日期</label>
                                <div class="col-sm-9 pd0">
                                    <div class="input-append date dateBox col-sm-6 pdr5" id="dateStartIndex" data-date-format="yyyy-mm-dd" ng-model="dateStartInput">
                                        <input class="span2 form-control bacW" size="16" type="text" value="" id="dateStartSpan" placeholder="起始日期" ng-model="startApply">
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <div class="input-append date dateBox col-sm-6 pdl5" id="dateEndIndex" data-date-format="yyyy-mm-dd" ng-model="dateEndInput">
                                        <input class="span2 form-control bacW" size="16" type="text" value="" id="dateEndSpan" placeholder="结束日期" ng-model="endApply">
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success center-block w120" ng-click="applyShopOkContact()">确认申请</button>
            </div>
        </div>
    </div>
</div>