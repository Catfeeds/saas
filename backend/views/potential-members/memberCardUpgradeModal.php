<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4 0004
 * Time: 15:19
 */
 -->
<!--送人卡升级模态框-->
<div class="modal fade" tabindex="-1" id="memberCardUpgradeModal" role="dialog">
    <div style="margin-top: 40px;width: 85%;min-width: 720px;max-width: 1180px;" class="modal-dialog">
        <div style="border: none;" class="modal-content">
            <div style="border: none;position: relative;" class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">升级</h3>
                <div style="text-align: center;margin: 15px auto" >
                    <img src="../plugins/user/images/info.png" style="width: 40px;height: 40px;">
                    <b style="color: orange;font-size: 14px;">注:该功能不支持跨店升级</b>
                </div>
                <div class="col-sm-5" style="border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                    <div class="row">
                        <div class="col-sm-12 pd0 text-center" style="margin-bottom: 20px;">
                            <img style="width: 260px;height: 170px;" src="../plugins/img/card111.png">
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10" style="padding-left: 20px;min-width: 182px;">
                            <p style="font-size: 18px;font-weight: bold;">
                                {{cardInfo.card_name}}&nbsp;&nbsp;
                                <span class="oldCardTitle">旧卡</span>
                            </p>
                            <p class="upsateInfoP">剩余金额:{{cardInfo.amount_money}}</p>
                            <p class="upsateInfoP">卡种卡号:{{cardInfo.card_number}}</p>
                            <p class="upsateInfoP">剩余天数:<span id="daysSpan">{{remainingDate}}</span></p>
                            <p class="upsateInfoP">到期时间:{{cardInfo.invalid_time *1000 |date:'yyyy-MM-dd'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" style="padding-left: 40px;margin-top: 60px;">
                    <form class="form-horizontal">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>升级方式
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control upSateCardTypeSelect positionRelative" ng-model="upSateCardTypeValue" ng-change="upSateCardTypeChange()" style="padding-top: 4px;padding-bottom: 4px;">
                                    <option value="">期限升级</option>
                                    <option value="1">折现升级</option>
                                </select>
                                <span class="upSateSelectTitle" title="按当前时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue == '1'" ><i class="glyphicon glyphicon-info-sign"></i>按当前时间为升级后的新卡开始时间</span>
                                <span class="upSateSelectTitle" title="按老卡开始时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue != '1'"><i class="glyphicon glyphicon-info-sign"></i>按老卡开始时间为升级后的新卡开始时间</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>卡种名称
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control typeSelect" ng-model="upsateCardType" ng-change="getUpsateCardType(upsateCardType)">
                                    <option value="">请选择</option>
                                    <option value="{{up}}" ng-repeat="up in upcardList">{{up.card_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>卡种价格
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control upsateCardMoneySelect" ng-model="upsateCardMoney" readonly/>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;"></span>卡种折扣
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control discountSelect positionRelative" ng-model="getDiscountListValue" ng-change="discountMath(getDiscountListValue)">
                                    <option value="">请选择</option>
                                    <option value="{{g}}" ng-repeat="g in getDiscountList">{{g.discount}}</option>
                                </select>
                                <span class="discountSelectTitle"><i class="glyphicon glyphicon-info-sign"></i>{{residueCard}}张</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>折算金额
                            </label>
                            <div class="col-sm-6">
                                <input type="text"  class="form-control cardNumInput convertMoney" placeholder="请输入折算金额" ng-model="convertMoney" ng-change="convertMoneyChange()">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span style="color: red;"></span>升级卡号</label>
                            <div class="col-sm-6">
                                <input type="text" checknum class="form-control cardNumInput" placeholder="请输入卡号" ng-model="upcardNumber">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px">
                                <span style="color: red;">*</span>
                                选择销售
                            </label>
                            <div class="col-sm-6" style="margin-top: 8px;">
                                <select class="form-control sellerSelect" style="padding-top: 4px;" ng-model="seller">
                                    <option value="">请选择</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span style="color: red;">*</span>使用期限</label>
                            <div class="col-sm-6" style="margin-top: 10px;">
                                <p class="renewTime cardTimeUpsateWords">{{upsateCardTimeStart*1000 |date:'yyyy-MM-dd'}}至{{upsateCardEnd*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-12 renewMoneyInfoBox">
                        <p>卡种金额：{{newCardSellPrice}}元</p>
                        <p>补交金额：<span class="newCardPricePay"></span>元</p>
                    </div>
                </div>
                <span class="btn btn-success" style="width: 120px;position: absolute;bottom: 40px;right: 40px;" ng-click="successUpdate()" ladda="updateCardButtonFlag">升 级</span>
            </div>
        </div>
    </div>
</div>
