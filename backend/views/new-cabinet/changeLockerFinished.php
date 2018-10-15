<!--    调柜完成模态框-->
<div class="modal fade" id="checkCabinetSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB50" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" >调柜</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0 text-center mT30 mB30 f18" >
                    <p class="mT10" >从 <span>{{cabinetDetail.type_name}}区&emsp;{{cabinetDetail.cabinet_number}}</span></p>
                    <p class="mT10 fw" >调到 <span>{{oldTypeName}}区&emsp;{{selectCabinetDetail.cabinet_number}}</span></p>
                    <p class="mT10" >到期时间 <span>{{switchCabinetEndDate | noData:''}}</span></p>
                </div>
            </div>
            <div class="modal-footer">
                <span class="mR20 f14" >应补金额：<span class="moneyCss" >{{selectSwitchCabinetPrice | number:2}}<small class="f14">元</small></span></span>
                <button type="button" ladda="completeSwitchCabinetBtnFlag" ng-click="completeSwitchCabinetBtn()" class="btn btn-success w100" >完成</button>
            </div>
        </div>
    </div>
</div>