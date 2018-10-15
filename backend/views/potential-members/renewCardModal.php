<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4 0004
 * Time: 15:30
 */
 -->
<!--送人卡续费模态框-->
<div class="modal fade" id="renewCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div style="margin-top: 40px;width: 70%;min-width: 720px;max-width: 1180px;" class="modal-dialog">
        <div style="border: none;" class="modal-content">
            <div style="border: none;position: relative;" class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="text-center" style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">续费</h3>
                <div class="col-sm-5" style="margin-top: 60px; border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                    <div class="row pd0">
                        <div class="col-sm-12 pd0 text-center"  style="margin-bottom: 20px;">
                            <img style="width: 260px;height: 170px;" src="../plugins/img/card111.png">
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10" style="padding-left: 20px;min-width: 182px;;">
                            <p style="font-size: 18px;font-weight: bold;">{{cardInfo.card_name}}</p>
                            <p class="upsateInfoP">办卡金额:{{cardInfo.amount_money}}</p>
                            <p class="upsateInfoP">剩余天数:<span id="daysSpan">{{remainingDate}}</span></p>
                            <p class="upsateInfoP">到期时间:{{cardInfo.invalid_time *1000 |date:'yyyy-MM-dd'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" style="padding-left: 40px;margin-top: 60px;">
                    <form class="form-horizontal">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group" style="margin-bottom: 18px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>续费方式</label>
                            <div class="col-sm-6" style="margin-top: 4px;">
                                <select class="form-control renewTypeSelect pdt4px" ng-model="renewTypeSelect" style="padding-top: 4px;">
                                    <option value="">请选择续费方式</option>
                                    <option value="1">普通续费</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span style="color: red;">*</span>卡种名称</label>
                            <div class="col-sm-6 select2ContentBox">
                                <select class="form-control typeSelect" ng-model="renewCardType" ng-change="getRenewCardInfo(renewCardType,type.ordinary_renewal)">
                                    <option value="">请选择</option>
                                    <option value="{{type}}" ng-repeat="type in renrewCardTypeList">{{type.card_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span style="color: red;"></span>续费卡号</label>
                            <div class="col-sm-6">
                                <input type="text" checknum class="form-control" placeholder="请输入卡号" ng-model="cardNumber">

                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span style="color: red;">*</span>续费价格</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control renewPrice" ng-model="renewPrice" ng-change="priceChange()">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span style="color: red;">*</span>选择销售</label>
                            <div class="col-sm-6 select2ContentBox">
                                <select class="form-control sellerSelect" ng-model="sellerSelect">
                                    <option value="">请选择</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px;padding-top: 0">
                                <span style="color: red;">*</span>付款方式</label>
                            <div class="col-sm-6">
                                <select class="form-control" style="padding-top: 4px;" ng-model="chosePayType">
                                    <option value="">请选择</option>
                                    <option value="1">全款</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span style="color: red;">*</span>使用期限</label>
                            <div class="col-sm-6" style="margin-top: 10px;">
                                <p class="renewTime cardTimeWords">{{renewStartDat*1000 |date:'yyyy-MM-dd'}}至{{renewTermEnd*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-12 renewMoneyInfoBox">
                        <p>总金额：{{renewCardAllMoney}}元</p>
                        <p>续费金额：{{renCardRecondMoney}}元</p>
                    </div>
                </div>
                <span class="btn btn-success" style="width: 120px;position: absolute;bottom: 20px;right: 40px;" ng-click="renewCardPost()" ladda="checkButton">续 费</span>
            </div>
        </div>
    </div>
</div>
