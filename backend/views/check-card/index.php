<?php
use backend\assets\CheckCardCtrlAsset;
CheckCardCtrlAsset::register($this);
$this->title = '验卡系统';
?>
<div class="container-fluid" ng-controller="checkIndexCtrl" ng-cloak>
    <div class="col-sm-12 indexCtDIv"  id="checkCardFocus" >
        <div class="panel panel-default ">
            <div class="panel-heading">
                <span  style="display: inline-block;"><b class="spanSmall">验卡管理</b></span></div>
            <div class="panel-body">
                <div>
                    <div class="col-sm-6 col-sm-offset-3">
                        <span>V</span><span>IP会员验卡</span>
                        <div class="input-group">

                            <input type="text"
                                   class="form-control cardCheckNumberInput"
                                   placeholder="请刷卡或输入会员卡号或手机号或身份证号"
                                   ng-model="cardNumber" >
                                    <span class="input-group-btn">
                                        <button type="button"
                                                class="btn btn-success ladda-button"
                                                ladda="checkButton"
                                                ng-click="checkCardNumberMember()"
                                                style="height: 34px;">搜索
                                        </button>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--        选择会员card模态框-->
    <div class="modal fade" id="selectCardModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">选择会员卡</h4>
                </div>
                <div class="modal-body">
                    <section class="row" style="display: flex;justify-content: center;margin-top: 20px;margin-bottom: 20px;">
                        <div class="col-sm-6">
                            <select class="form-control" style="padding: 4px 12px;" ng-change="selectedMemberCard()"ng-model="selectCardId" >
                                <option value="">请选择会员卡</option>
                                <option value="{{card.id}}" ng-repeat="card in allMemberCard">{{card.card_name}}</option>
                            </select>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success" ng-click="checkCardSelect(selectCardId)">验卡</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="ModalIsOK" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCom">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabelCom">完成预约</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row ModalIsOKRow">
                        <div class="col-sm-4 col-xs-4 text-right" >
                            <img src="/plugins/checkCard/img/yes.png" alt="">
                        </div>
                        <div class="col-sm-8 col-xs-8">
                            <div>进馆成功</div>
                                <div ng-if="Towel != null">请领取{{Towel.serverName}}一条</div>
                        </div>
                    </div>
                    <button type="button "  class="btn btn-default btn-sm fr ModalIsOKButton" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>
