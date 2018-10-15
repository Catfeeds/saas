<div class="modal fade" tabindex="-1" role="dialog" id="ManageDetailModal" style="color: #999;">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body container-fluid">
                <div class="row">
                    <br />
                    <div class="col-lg-6 col-lg-offset-4">
                        <p><span>柜子型号&nbsp;:&nbsp;</span>{{cabinetXingHao}}</p>
                    </div>
                    <br />
                    <br />
                    <div class="col-lg-6 col-lg-offset-4">
                        <p><span>柜子类别&nbsp;:&nbsp;</span>{{cabinetLeiBie}}</p>
                    </div>
                    <br />
                    <br />
                    <div class="col-lg-6 col-lg-offset-4">
                        <p><span>柜子号码&nbsp;:&nbsp;</span>{{cabinetHaoMa}}</p>
                    </div>
                    <br />
                    <br />
                    <div class="col-lg-6 col-lg-offset-4">
                        <p><span>柜子数量&nbsp;:&nbsp;</span>{{cabinetShuLiang}}</p>
                    </div>
                    <br />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning"  ng-click="CabinetTypeModify(id, cabinetShuLiang, cabinetHaoMa, model, type)">修改</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>