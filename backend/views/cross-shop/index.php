<?php
use backend\assets\CrossShopAsset;
CrossShopAsset::register($this);
$this->title = '跨店升级';
?>
<div class="container-fluid" style="background-color: #fff;" ng-controller= "crossShopCtrl" ng-cloak>
    <div class="col-sm-12 content">
        <h1 class="corssTitle">会员跨店升级</h1>
        <div class="col-sm-4 col-sm-offset-4" style="margin-top: 40px;">
            <form class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-9 pd0">
                        <input type="text" class="form-control contentInput" placeholder="请输入卡号进行搜索" ng-model="cardNumber">
                    </div>
                    <div class="col-sm-3 pd0">
                        <button class="btn btn-success contentBtn" type="button" ng-click="searchCardNumber()">确定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--会员卡升级模态框-->
    <div class="modal fade" style="" id="memberUpModal" role="dialog">
        <div style="margin-top: 40px;width: 85%;min-width: 720px;max-width: 1180px;" class="modal-dialog">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;position: relative;padding-bottom: 100px;" class="modal-header clearfix">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center"
                        style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">升级</h3>
                    <div class="col-sm-6 pdLr0"
                         style="margin-top: 60px; border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                        <div class="col-sm-12 pd0">
                            <div class="col-sm-6 col-sm-offset-3 text-right pd0">
                                <img style="width: 250px;height: 170px;" src="../plugins/img/card111.png">
                            </div>
                            <div class="col-sm-6 col-sm-offset-3 pdLr0" style="padding-left: 20px;min-width: 182px;">
                                <p class="mrt20" style="font-size: 18px;font-weight: bold;">
                                    {{cardData.card_name}}&nbsp;&nbsp;
                                    <span class="oldCardTitle">旧卡</span>
                                </p>
                                <p class="upsateInfoP mrt20">剩余金额:{{cardData.amount_money}}</p>
                                <p class="upsateInfoP mrt20">卡种卡号:{{cardData.card_number}}</p>
                                <p class="upsateInfoP mrt20">到期时间:{{cardData.invalid_time *1000 |date:'yyyy-MM-dd'}}</p>
                                <hr class="line mrt20">
                                <p class="upsateInfoP mrt20">会员姓名:{{cardData.name}}</p>
                                <p class="upsateInfoP mrt20" ng-if="cardData.sex == 1">会员性别:男</p>
                                <p class="upsateInfoP mrt20" ng-if="cardData.sex == 2">会员性别:女</p>
                                <p class="upsateInfoP mrt20">所属场馆:{{cardData.venueName}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 40px;margin-top: 60px;">
                        <form class="form-horizontal">
                            <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group" >
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>升级方式</label>
                                <div class="col-sm-6">
                                    <select class="form-control upSateCardTypeSelect positionRelative"
                                            style="padding: 0 12px"
                                            ng-model="upSateCardTypeValue"
                                            ng-change="upSateCardTypeChange()">
                                        <option value="">期限升级</option>
                                        <option value="1">折现升级</option>
                                    </select>
                                <span class="upSateSelectTitle" title="按当前时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue == '1'" ><i class="glyphicon glyphicon-info-sign"></i>按当前时间为升级后的新卡开始时间</span>
                                <span class="upSateSelectTitle" title="按老卡开始时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue != '1'"><i class="glyphicon glyphicon-info-sign"></i>按老卡开始时间为升级后的新卡开始时间</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <label class="col-sm-3 control-label" style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 2px"><span style="color: red;">*</span>选择场馆</label>
                                <div class="col-sm-6" style="">
                                    <select class="form-control typeSelect"
                                            id="venueCardSelect"
                                            style="padding: 0 12px"
                                            ng-model="venue"
                                            ng-change="venueSelectChange(venue)">
                                        <option value="">请选择</option>
                                        <option ng-selected="defaultVenueId == venue.id" value="{{venue}}" ng-repeat="venue in venueItems" >{{venue.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 2px"><span
                                        style="color: red;">*</span>卡种名称</label>
                                <div class="col-sm-6" style="">
                                    <select class="form-control typeSelect"
                                            ng-model="upsateCardType"
                                            style="padding: 0 12px"
                                            ng-change="getUpsateCardType(upsateCardType)">
                                        <option value="">请选择</option>
                                        <option value="{{up}}"
                                                ng-repeat="up in cardList">
                                            {{up.card_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>卡种价格</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           class="form-control upsateCardMoneySelect"
                                           ng-model="upsateCardMoney"
                                           ng-blur="upsateCardMoneySelectBlur()"
                                           disabled/>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;"></span>卡种折扣</label>
                                <div class="col-sm-6">
                                    <select class="form-control discountSelect positionRelative"
                                            ng-model="getDiscountListValue"
                                            style="padding: 0 12px"
                                            ng-change="discountMath(getDiscountListValue)">
                                        <option value="">请选择</option>
                                        <option value="{{g}}" ng-repeat="g in getDiscountList">{{g.discount}}</option>
                                    </select>
                                    <span class="discountSelectTitle"><i class="glyphicon glyphicon-info-sign"></i>{{residueCard}}张</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 26px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>折算金额</label>
                                <div class="col-sm-6">
                                    <input type="number"
                                           min="1"
                                           class="form-control cardNumInput"
                                           id="upcardConversionMoneyInput"
                                           placeholder="请输入折算金额"
                                           ng-model="upcardConversionMoney">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;"></span>升级卡号</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           checknum
                                           class="form-control cardNumInput"
                                           placeholder="请输入卡号"
                                           ng-model="upcardNumber">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px">
                                    <span style="color: red;">*</span>
                                    选择销售
                                </label>
                                <div class="col-sm-6" style="margin-top: 6px;">
                                    <select class="form-control sellerSelect2"
                                            style="padding-top: 4px;"
                                            id="sellerSelect2"
                                            ng-model="seller"
                                            ng-change="selectSeller(seller)">
                                        <option value="">请选择</option>
                                        <option value="{{sale.id}}" ng-repeat="sale in saleInfoList">{{sale.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span
                                        style="color: red;">*</span>使用期限</label>
                                <div class="col-sm-6" style="margin-top: 10px;">
                                    <p class="renewTime cardTimeUpsateWords">
                                        <span>{{upsateCardTimeStart*1000 |date:'yyyy-MM-dd'}}</span>
                                        至
                                        <span>{{upsateCardEnd*1000|date:'yyyy-MM-dd'}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px">
                                    <span style="color: red;opacity: 0">*</span>
                                    升级备注
                                </label>
                                <div class="col-sm-6" style="margin-left: 0">
                                 <textarea class="form-control" ng-model="upSateNote" style="overflow-y: auto;height: 100px;margin-top: 10px;resize: none;">

                                            </textarea>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12 renewMoneyInfoBox">
                            <p>新卡价格：{{newCardSellPrice}}元</p>
                            <p>补交金额：<span class="newCardPricePay"></span>元</p>
                        </div>
                    </div>
                <span class="btn btn-success"
                      style="width: 120px;position: absolute;bottom: 40px;right: 40px;"
                      ng-click="successUpdate()"
                      ladda="updateCardButtonFlag">升 级</span>
                </div>
            </div>
        </div>
    </div>


</div>
