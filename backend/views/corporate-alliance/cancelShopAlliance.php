<!--取消通店的模态框-->
<div class="modal fade" id="notApplyShopClose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center pdl20" id="myModalLabel">申请通店</h4>
            </div>
            <!--                取消通店-->
            <div class="modal-body modalBody">
                <div class="row">
                    <div class="col-sm-12 text-center pdt30">
                        <img  ng-src="/plugins/img/exclamation.png" src="/plugins/img/exclamation.png" width="120px">
                    </div>
                    <div class="col-sm-12">
                        <p class="text-center shopTextTitleP3">取消后则无法通店。</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooter">
                <button type="button" class="btn btn-success center-block w120" ng-click="successCancel()">确定取消</button>
            </div>
        </div>
    </div>
</div>