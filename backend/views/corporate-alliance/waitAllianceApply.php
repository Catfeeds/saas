<!--等待申请的模态框-->
<div class="modal fade" id="waitForApplyShopModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center pdl20" id="myModalLabel">申请通店</h4>
            </div>
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
                <button type="button" class="btn btn-white center-block w120" ng-click="waitForApplyShopModalClose3()">关闭</button>
            </div>
        </div>
    </div>
</div>