<!-- 购卡协议模态框 -->
<div class="modal fade" id="buyCardProtocolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 24px;">购卡协议</h4>
            </div>
            <div class="modal-body" style="height: 500px;overflow-y: auto">
                <div class="dealTiele" style="font-size: 18px;font-weight: bold;text-align: center;margin-bottom: 10px;"></div>
                <div class="dealBox"></div>
                <div class="noDetailsInfoShow col-sm-12 text-center">
                    <img src="/plugins/memberShip/images/nodata.png" width="260" style="margin-top: 80px;">
                    <p style="font-size: 24px;margin-top: 10px;">暂无合同信息</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- 支付方式模态框 -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 55%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 24px;">选择支付方式</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" style="margin-top: 40px;margin-bottom: 30px;">
                        <div class="col-sm-6 text-center">
                            <img src="/plugins/memberShip/images/wechat.png"
                                 width="80"
                                 class="picClick"
                                 ng-click="wechatClick()">
                        </div>
                        <div class="col-sm-6 text-center">
                            <img src="/plugins/memberShip/images/pay.png"
                                 width="80"
                                 class="picClick"
                                 ng-click="payClick()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- 二维码模态框 -->
<div class="modal fade" id="erweimaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 24px;">微信扫码支付</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="col-sm-6 col-sm-offset-3" id="qrcode">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- 支付成功模态框 -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 24px;">支付状态</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center" style="margin-top: 20px;">
                        <img src="/plugins/memberShip/images/success.png"
                             width="120"
                             style="">
                        <p style="margin-top: 20px;font-size: 22px;letter-spacing: 2px;">支付成功!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="backIndex()" style="width: 100px;">返回首页</button>
            </div>
        </div>
    </div>
</div>
<!-- 支付失败模态框 -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="font-size: 24px;">支付状态</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center" style="margin-top: 20px;">
                        <img src="/plugins/memberShip/images/error.png"
                             width="120"
                             style="">
                        <p style="margin-top: 20px;font-size: 22px;letter-spacing: 2px;">支付失败!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">重新支付</button>
            </div>
        </div>
    </div>
</div>