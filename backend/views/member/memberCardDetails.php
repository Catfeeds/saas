<!--会员卡续费模态框-->
<div class="modal fade" id="myModals15" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div style="margin-top: 40px;width: 85%;min-width: 720px;max-width: 1180px;" class="modal-dialog">
        <div style="border: none;" class="modal-content">
            <div style="border: none;position: relative;" class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center"
                    style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">续费</h3>
                <div class="row">
                    <div class="col-sm-12 pd0 greyBoxInfo">
                        <span><i class="glyphicon glyphicon-info-sign"></i>该卡可续费期限为{{allStartTimesRenewCard*1000|date:'yyyy-MM-dd'}}&nbsp;——&nbsp;{{allEndTimesRenewCard*1000|date:'yyyy-MM-dd'}}</span>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 pdLr0"
                     style="margin-top: 60px; border: 1px solid #eee;border-width: 0 1px 0 0;height: 420px;margin-bottom: 60px;">
                    <div class="col-sm-12 col-md-12 pd0">
                        <div class="col-sm-12 pd0 text-center" style="margin-bottom: 20px;">
                            <img ng-if="cardInfo.pic == null || cardInfo.pic == ''" style="width: 280px;height: 170px;" ng-src="../plugins/img/card111.png">
                            <img ng-if="cardInfo.pic != null && cardInfo.pic != ''" style="width: 280px;height: 170px;" ng-src="{{cardInfo.pic}}">
                        </div>
                        <div class="col-md-2 pd0 text-center"></div>
                        <div class="col-md-10 pdLr0" style="padding-left: 20px;">
                            <p style="font-size: 18px;font-weight: bold;">{{cardInfo.card_name}}</p>
                            <p class="upsateInfoP">办卡金额:{{cardInfo.amount_money}}</p>
                            <p class="upsateInfoP">会员卡号:{{cardInfo.card_number}}</p>
                            <p class="upsateInfoP">剩余天数:<span id="daysSpan">{{remainingDate}}</span></p>
                            <p class="upsateInfoP">到期时间:{{cardInfo.invalid_time*1000 |date:'yyyy-MM-dd'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7" style="margin-top: 60px;">
                    <form class="form-horizontal">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group" style="margin-bottom: 18px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;">*</span>续费方式</label>
                            <div class="col-sm-6" style="margin-top: 4px;">
                                <select class="form-control renewTypeSelect pdt4px"
                                        ng-model="renewTypeSelect"
                                        ng-change="renewTypeSelectChange(renewTypeSelect)">
                                    <option value="1">普通续费</option>
                                    <option value="2">增加此卡有效期</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"
                             style="margin-bottom: 18px;"
                             ng-if="renewTypeSelect == '2'">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;">*</span>有效时间</label>
                            <div class="col-sm-6" style="margin-top: 4px;" ng-click="renewEffectiveTimeChangeClick()">
                                <select id="renewEffectiveTimeValue" class="form-control renewTimeSelect pdt4px"
                                        ng-change="renewEffectiveTimeChange(renewEffectiveTimeValue)"
                                        ng-model="renewEffectiveTimeValue">
                                    <option value="">请选择</option>
                                    <option ng-repeat="rew in renewEffectiveTimeList"
                                            value="{{rew}}">{{rew.day}}{{rew.type == 'd'?'天':rew.type == 'm'?'月(30天)':rew.type == 'q'?'季(90天)':rew.type == 'y'?'年(365天)':''}}
                                        最少{{rew.price}}元
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group cardFormGroup" ng-if="renewTypeSelect == '1'">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;">*</span>卡种名称</label>
                            <div class="col-sm-6">
                                <select class="form-control"
                                        ng-model="renewCardType"
                                        ng-change="getRenewCardInfo(renewCardType)" style="padding-top: 4px;">
                                    <option value="">请选择</option>
                                    <option value="{{type}}"
                                            ng-repeat="type in renrewCardTypeList">{{type.card_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;" ng-if="renewTypeSelect == '1'">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                    style="color: red;"></span>续费卡号</label>
                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control cardNumInput"
                                       placeholder="请输入卡号"
                                       ng-model="renewMemberCardNumber">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                    style="color: red;">*</span>续费价格</label>
                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control renewPriceSelect"
                                       ng-model="renewPrice"
                                       ng-change="priceChange()">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px;padding-top: 0"><span
                                    style="color: red;">*</span>选择销售</label>
                            <div class="col-sm-6">
                                <select class="form-control"
                                        style="padding-top: 4px;"
                                        ng-model="seller">
                                    <option value="">请选择</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px;padding-top: 0"><span
                                    style="color: red;">*</span>付款方式</label>
                            <div class="col-sm-6">
                                <select class="form-control"
                                        style="padding-top: 4px;"
                                        ng-model="chosePayType" ng-change="getPayMethod(chosePayType)">
                                    <option value="">请选择</option>
                                    <option value="1">全款</option>
                                    <option value="2">定金</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <ul class="a58">
                                <li class="col-sm-3 control-label" style="padding-top: 0"><span class="red">*</span>定金金额</li>
                                <li class="col-sm-6 mL20" style="margin-left: 0">
                                    <select class="js-example-basic-single payMoneyType form-control" multiple="multiple" ng-model="payMoneyTypes" ng-change="getEarnest(payMoneyTypes) ">
                                        <option ng-repeat="i in payMoneyType" value="{{i.id}}" data-price="{{i.price}}">定金：{{i.price}}元</option>
                                    </select>
                                    <div>剩余续费定金{{classSurplusPrice}}元</div>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span
                                    style="color: red;">*</span>使用期限</label>
                            <div class="col-sm-6" style="margin-top: 10px;">
                                <p class="renewTime cardTimeWords">{{renewStartDat*1000 |date:'yyyy-MM-dd'}}至{{renewTermEnd*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;opacity: 0;">*</span>续费备注</label>
                            <div class="col-sm-6" style="margin-left: 0;">
                                 <textarea class="form-control" ng-model="renewCardNote" style="overflow-y: auto;height: 100px;margin-top: 10px;resize: none;"></textarea>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-12 renewMoneyInfoBox">
                        <p ng-if="renewTypeSelect == '1'">新卡金额：{{renewCardAllMoney}}元</p>
                        <p>续费金额：{{renCardRecondMoney}}元</p>
                    </div>
                </div>
                <span class="btn btn-success" style="width: 120px;position: absolute;bottom: 25px;right: 40px;"
                      ng-click="renrewSuccess()"
                      ladda="checkButton">续 费</span>
            </div>
        </div>
    </div>
</div>
<!--会员卡升级模态框-->
<div class="modal fade" style="" tabindex="-1" id="memberCardUpgradeModal" role="dialog">
    <div style="margin-top: 40px;width: 85%;min-width: 720px;max-width: 1180px;" class="modal-dialog">
        <div style="border: none;" class="modal-content clearfix">
            <div style="border: none;position: relative;" class="modal-header clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">升级</h3>
                <div style="text-align: center;margin: 15px auto" >
                    <img src="../plugins/user/images/info.png" style="width: 40px;height: 40px;">
                    <b style="color: orange;font-size: 14px;">注:该功能不支持跨店升级</b>
                </div>
                <div class="col-sm-5 pdLr0" style=" border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-12 text-center pd0" style="margin-bottom: 20px;">
                            <img ng-if="cardInfo.pic == null || cardInfo.pic == ''" style="width: 280px;height: 190px;" ng-src="../plugins/img/card111.png">
                            <img ng-if="cardInfo.pic != null && cardInfo.pic != ''" class="img-rounded" style="width: 280px;height: 190px;" ng-src="{{cardInfo.pic}}">
                        </div>
                        <div class="col-sm-2 pdLr0"></div>
                        <div class="col-sm-10 pdLr0" style="padding-left: 20px;">
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
                <div class="col-sm-7" style="padding-left: 40px;">
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
                                        ng-model="upSateCardTypeValue"
                                        ng-change="upSateCardTypeChange()">
                                    <option value="">期限升级</option>
                                    <option value="1">折现升级</option>
                                </select>
                                <span class="upSateSelectTitle" title="按当前时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue == '1'" ><i class="glyphicon glyphicon-info-sign"></i>按当前时间为升级后的新卡开始时间</span>
                                <span class="upSateSelectTitle" title="按老卡开始时间为升级后的新卡开始时间"
                                      ng-if="upSateCardTypeValue != '1'"><i class="glyphicon glyphicon-info-sign"></i>按老卡办卡时间为升级后的新卡开始时间</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 2px"><span
                                    style="color: red;">*</span>卡种名称</label>
                            <div class="col-sm-6" >
                                <select class="form-control discountSelect" style="padding: 4px 12px;"
                                        ng-model="upsateCardType"
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
                                        ng-model="getDiscountListValue" style="padding: 4px 12px;"
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
                                <input type="text"
                                       class="form-control cardNumInput"
                                       id="upcardConversionMoneyInput"
                                       placeholder="请输入折算金额"
                                       ng-model="upcardConversionMoney">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>
                                付款方式
                            </label>
                            <div class="col-sm-6" style="">
                                <select class="form-control discountSelect"
                                        style="padding: 4px 12px;" ng-model="choseUpPayType" ng-change="getUpPayMethod(choseUpPayType)">
                                    <option value="">请选择</option>
                                    <option value="1">全款</option>
                                    <option value="2">定金</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <ul class="a58">
                                <li class="col-sm-3 control-label"><span class="red">*</span>定金金额</li>
                                <li class="col-sm-6 mL20" style="margin-left: 0">
                                    <select class="js-example-basic-single payUpMoneyType form-control" multiple="multiple" ng-model="payUpMoneyTypes" ng-change="getUpEarnest(payUpMoneyTypes) ">
                                        <option ng-repeat="i in payUpMoneyType" value="{{i.id}}" data-price="{{i.price}}">定金：{{i.price}}元</option>
                                    </select>
                                    <div>剩余升级定金{{classSurplusPrice}}元</div>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                    style="color: red;"></span>升级卡号</label>
                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control cardNumInput"
                                       placeholder="请输入卡号"
                                       ng-model="upcardNumber">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;">
                                <span style="color: red;">*</span>
                                选择销售
                            </label>
                            <div class="col-sm-6" style="">
                                <select class="form-control discountSelect"
                                        style="padding-top: 4px;"
                                        ng-model="seller">
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
<!--会员卡信息修改模态框-->
<div class="modal fade" id="myModals18" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 40%;">
        <div style="padding-bottom: 20px;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-info"
                    style="font-size: 24px;text-align: left;margin-top: 20px;margin-left: 10px;font-weight: normal;">
                    修改</h3>
                <div class="col-sm-12 pd0" style="margin-top: 10px;height: 2px;background: #e1e1e1;"></div>
                <form style="padding-left: 10px;padding-right: 10px;">
                    <div class="col-sm-12 pd0">
<!--                        修改卡种名称-->
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">卡种名称:</label>
                            <input type="text"
                                   class="form-control"
                                   id="cardName"
                                   ng-model="cardName"
                                   placeholder="请输入卡种名称">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">会员卡号:</label>
                            <input type="text"
                                   class="form-control"
                                   id="exampleInputName2"
                                   ng-model="number"
                                   placeholder="请输入卡号">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label style="font-size: 16px;font-weight: normal;color: #333;">卡种金额:</label>
                            <input type="text"
                                   class="form-control"
                                   id="money"
                                   ng-model="money"
                                   placeholder="请输入金额">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label style="font-size: 16px;font-weight: normal;color: #333;">选择卡种:</label>
                            <select name="" id="" class="form-control" ng-model="cardTypeId" style="padding: 0 0 0 10px;">
                                <option value="">请选择卡种</option>
                                <option ng-repeat="cardTypes in cardTypeList" value="{{cardTypes.id}}">{{cardTypes.card_name}}&emsp;&emsp; {{cardTypes.name==null? ' ': cardTypes.name}} &emsp;&emsp;编号：{{cardTypes.id}}</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label style="font-size: 16px;font-weight: normal;color: #333;">办卡日期:</label>
                            <input
                                class="form-control"
                                id="buyCardDate"
                                data-date-format="yyyy-mm-dd"
                                placeholder="请选择办卡日期"
                                ng-model="buyCardDate"
                                readonly
                            />
                            <span style="font-size: 12px;color: #999;font-weight: normal"><i class="glyphicon glyphicon-info-sign"></i>当前的办卡日期为{{cardInfo.create_at*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                        </div>
<!--                        ng-show="status != 4"-->
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="" style="font-size: 16px;font-weight: normal;color: #333;">激活日期:</label>
                            <input
                                class="form-control"
                                id="useCardDate"
                                data-date-format="yyyy-mm-dd hh:ii"
                                placeholder="请选择激活日期"
                                ng-model="useCardDate"
                                readonly
                            >
                        </div>
<!--                        ng-show="status != '4'"-->
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">
                                到期日期:&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 13px;"><strong>友情提示：</strong>修改到期日期，必须修改激活日期</span></label>
                            <input
                                class="form-control"
                                id="expireDate"
                                data-date-format="yyyy-mm-dd hh:ii"
                                placeholder="请选择登记日期"
                                ng-model="expireDate"
                                readonly
                            >
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">转让次数:</label>
                            <input type="text" min="0" checknum
                                   class="form-control"
                                   id="exampleInput2"
                                   ng-model="assignment"
                                   ng-change="assignmentNumber()"
                                   placeholder="请输入转让次数">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">卡的属性:</label>
                            <select ng-model="cardAttributeEdit" ng-change="memberAttribute()" class="form-control cp mL10 selectPd"  >
                                <option value="1">个人</option>
                                <option value="2">公司</option>
                                <option value="3">家庭</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">请假类型:</label>
                            <select ng-model="cardLeaveType" ng-change="cardTypeCharge()" class="form-control cp mL10 selectPd"  >
                                <option value="">正常请假</option>
                                <option value="1">学生请假</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">延期开卡:</label>
                            <input
                                class="form-control"
                                id="postponeDate"
                                data-date-format="yyyy-mm-dd hh:ii"
                                placeholder="请选择延期开卡日期"
                                ng-model="postponeDate"
                                readonly
                            >
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">延期原因:</label>
                            <textarea
                                style="resize: none;"
                                class="form-control"
                                id="postponeCause1"
                                placeholder="请输入延期开卡原因"
                                ng-model="postponeCause1"
                            ></textarea>
                        </div>
                    </div>
                </form>
                <button class="btn btn-success center-block" style="margin-top: 20px;width: 100px;" ng-click="updateCardInfo()">修改</button>
            </div>
        </div>
    </div>
</div>
<!--会员卡转让模态框-->
<div  class="modal fade" id="myModals17" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div style="margin-top: 40px;width: 85%; min-width: 720px;max-width: 1000px;" class="modal-dialog">
        <div style="border: none;" class="modal-content clearfix">
            <div style="border: none;position: relative;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="text-center"
                    style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">转卡</h3>
                <div class="col-sm-12 col-xs-12 text-center" style="padding-top: 40px;height: 580px;">
                    <img src="../plugins/user/images/info.png">
                    <p style="font-size: 20px;color: #999;margin: 20px;">本操作将会把{{cardInfo.card_name}}转移给指定会员</p>
                    <form class="form-horizontal">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="col-sm-10 col-xs-12  col-sm-offset-1">
                            <div class="col-sm-12 col-xs-12 pd0" style="padding-left: 40px;">
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="inputEmail6" class="col-sm-3 col-xs-4 control-label"
                                           style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                            style="color: red;">*</span>手机号码</label>
                                    <div class="col-sm-6 col-xs-6 positionRelative" style="min-width: 277px;">
                                        <div class="input-group">
                                            <input type="number" class="form-control" inputnum ng-model="mobile" ng-change="changeNameNumber()">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" ng-click="searchUserClick()"
                                                        style="font-size: 12px;box-shadow: none;padding: 5.6px 16px;">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="small col-sm-6 col-sm-offset-2" style="margin-top: -10px;">
                                <p style="margin-left: -20px;"><span class="glyphicon glyphicon-info-sign"></span>请输入完整的手机号进行查询</p>
                            </div>
                            <div class="col-sm-12 col-xs-12 pd0" style="padding-left: 40px;">
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="inputEmail6" class="col-sm-3 col-xs-4 control-label"
                                           style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                            style="color: red;">*</span>会员姓名</label>
                                    <div class="col-sm-6 col-xs-8" style="min-width: 277px;">
                                        <select class="turnCardDel" ng-model="name" readonly style="width: 100%;height: 32px;border-radius: 2px;border: 1px solid #cfdadd;font-size: 14px;">
<!--                                            <option value="">请选择会员</option>-->
                                            <option ng-repeat="turnCard in turnCardData" value="{{turnCard.id}}">
                                                <span>{{turnCard.memberName}}</span>
                                                <span>&emsp;/&emsp;</span>
                                                <span>{{turnCard.venueName}}</span>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 pd0" style="padding-left: 40px;">
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="inputEmail6" class="col-sm-3 col-xs-4 control-label"
                                           style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                            style="color: red;">*</span>转卡费用</label>
                                    <div class="col-sm-6 col-xs-8" style="min-width: 277px;">
                                        <input type="text" class="form-control" id="inputEmail3" ng-model="transferPrice">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-xs-12 text-center">
                    <button class="btn btn-success" ladda="transferCardButtonFlag" style="width: 100px;" ng-click="giveCard()">转 卡</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--会员卡详情信息模态框-->
<div style="margin-left: 100px;" class="modal fade" id="membershipCardDetails" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div style="margin-top: 40px;width: 90%;" class="modal-dialog">
        <div style="border: none;" class="modal-content clearfix">
            <div class="membershipCardDetailsBox">
                <div  class="modal-header border1none">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="text-center" style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">会员卡详情</h3>
                </div>
                <div class="modal-body">
                    <div style="height: 700px;overflow: auto;">
                        <div class="mt50">
                            <br>
                            <section class="margin0Auto w300 h180">
                                <img ng-if="memberCardDetails.pic == null || memberCardDetails.pic == ''" ng-src="../plugins/user/images/card.png" style="width: 280px;height: 180px;background-size: 100% 100%;">
                                <img class="img-rounded" ng-if="memberCardDetails.pic != null && memberCardDetails.pic != ''" ng-src="{{memberCardDetails.pic}}" style="width: 280px;height: 180px;background-size: 100% 100%;">
                            </section>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>1.基本属性</strong></p>
                            <div class="col-sm-12 sectionMt">
                                <div class="col-sm-3">
                                    卡的属性:
                                    <strong ng-if="memberCardDetails.attributes == 1">个人</strong>
                                    <strong ng-if="memberCardDetails.attributes == 2">家庭</strong>
                                    <strong ng-if="memberCardDetails.attributes == 3">公司</strong>
                                </div>
                                <div class="col-sm-3">卡的名称:<strong>{{memberCardDetails.card_name}}</strong></div>
                                <div class="col-sm-3">激活期限:
                                    <strong>{{memberCardDetails.active_limit_time | noData:'天'}}</strong>
                                </div>
                                <div class="col-sm-3">有效天数:<strong>{{memberCardDetails.duration | noData:'天'}}</strong></div>
                                <div class="col-sm-3">可带人数:<strong>{{memberCardDetails.bring | noData:'人'}}</strong></div>
                                <div class="col-sm-3">
                                    卡的类型:
                                    <strong ng-if="memberCardDetails.type == 1">瑜伽</strong>
                                    <strong ng-if="memberCardDetails.type == 2">健身</strong>
                                    <strong ng-if="memberCardDetails.type == 3">舞蹈</strong>
                                    <strong ng-if="memberCardDetails.type == 4">综合</strong>
                                    <strong ng-if="memberCardDetails.type == null">暂无数据</strong>
                                </div>
                                <div class="col-sm-6">
                                    所属场馆:
                                    <strong ng-if="memberCardDetails.venueName != null">{{memberCardDetails.venueName}}</strong>
                                    <strong ng-if="memberCardDetails.venueName == null">暂无数据</strong>
                                </div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>2.定价和售卖</strong></p>
                            <div class="col-sm-12 sectionMt">
                                <div class="col-sm-3">
                                    <strong>售价:{{memberCardDetails.amount_money}}元</strong>
                                </div>
                                <div class="col-sm-3">续费价:
                                    <strong>{{memberCardDetails.ordinary_renewal | noData:'元'}}</strong>
                                </div>
                                <div class="col-sm-3">优惠价:
                                    <strong>{{memberCardDetails.offer_price | noData:'元'}}</strong>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>3.通用场馆限制:</strong></p>
                            <div class="sectionMt" ng-repeat="(keys132,Venue123) in memberCardDetails.goVenue"">
                                <div class="col-sm-3 col-xs-6 lH30">通用场馆:
                                    <span ng-if="Venue123.name == null || Venue123.name == ''">
                                        <span ng-repeat="ven in  Venue123.organization">
                                            <span title="{{ven.name}}">{{ven.name |cut:true:4:'...'}} <span ng-if="$index != Venue123.organization.length-1">,</span>  </span>
                                        </span>
                                    </span>
                                    <span ng-if="Venue123.name != null && Venue123.name != ''">
                                        <span >{{Venue123.name}}</span>
                                    </span>
                                </div>
                                <div class="col-sm-3 col-xs-6 lH30">进馆时间:
                                    <span ng-if="Venue123.apply_start != null && Venue123.apply_start != ''">{{Venue123.apply_start*1000 | date:'HH:mm'}} - {{Venue123.apply_end*1000 | date:'HH:mm'}}</span>
                                    <span ng-if="Venue123.apply_start == null || Venue123.apply_start == ''">{{'暂无数据'}}<span>
                                </div>
                                <div class="col-sm-3 col-xs-6 lH30">通店限制:
                                    <span ng-if="Venue123.week_times != null && Venue123.week_times != 0 && Venue123.week_times != ''">{{Venue123.week_times == -1 ? '不限': Venue123.week_times}}/周</span>
                                    <span ng-if="Venue123.total_times != null && Venue123.total_times != ''">{{Venue123.total_times == -1 ? '不限': Venue123.total_times}}/月</span>
                                    <span ng-if="Venue123.total_times == null && Venue123.week_times == null">{{'暂无数据'}}</span>
                                </div>
                                <div class="col-sm-3 col-xs-6 lH30">
                                    卡的等级: <span>{{Venue123.level == 1 ? '普通卡': Venue123.level == 2 ? 'VIP卡' : '暂无数据'}}</span>
                                </div>
                                <div class="col-sm-12 col-xs-6 lH30" style="margin-top: 4px;margin-bottom: 8px;">
                                    预约团课时，不受团课预约设置限制：<span>{{Venue123.about_limit == -1 ? '启用': Venue123.about_limit == 1 ? '不启用' : '暂无数据'}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <br>
                            <br>
                            <p><strong>4.进馆时间设置:</strong></p>
                            <div class="sectionMt" ng-if="cardTimeDay.day == null && cardTimeDay1.weeks == null">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <b>暂无数据</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 sectionMt" ng-if="cardTimeDay.day != null">
                                <div class="border1">
                                    <span>每月固定日</span>
                                    <div>
                                        <table id="table" class="cp">
                                            <tbody>
                                            <tr>
                                                <td style="cursor: pointer;height: 33px;width: 33px;" ng-repeat="w in cardTimeDay.day">{{w}}号</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt25"><span class="fontSize16">特定时间段</span><span class="fontSize20 ml30">{{cardTimeDay.start}} 至 {{cardTimeDay.end}}</span></div>
                                </div>
                            </div>
                            <div class="col-sm-12"  ng-if="cardTimeDay1.weeks != null">
                                <ul class="weekSelect">
                                    <li class="ml30" ng-repeat="(index,w) in cardTimeDay1.weeks">
                                        <div class="checkbox i-checks checkbox-inline week">
                                            <label id="weeksTime1">星期{{w | week}}</label>
                                        </div>
                                        <div class="weekTime">{{cardTimeDay1.startTime[index]}}    到    {{cardTimeDay1.endTime[index]}}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>5.团课套餐</strong></p>
                            <div class="col-sm-12 sectionMt">
<!--                                <div class="col-sm-6 mb30" ng-repeat="mcClass in memberCardDetails.cardCategory.class">-->
<!--                                    <div class="col-sm-6">课程名称:<strong ng-repeat="($k,classOne) in mcClass.arr">{{classOne.name}}<span ng-if="$k != mcClass.arr.length -1">,</span></strong></div>-->
<!--                                    <div class="col-sm-6">每日节数:<strong>{{mcClass.number == -1 ? '不限' : mcClass.number}}</strong></div>-->
<!--                                </div>-->
                                <div class="col-sm-6 mb30" ng-repeat="mcClass in memberCardDetails.bindMemberCard.class">
                                    <div class="col-sm-6">课程名称:<strong ng-repeat="($k,classOne) in mcClass.arr">{{classOne.name}}<span ng-if="$k != mcClass.arr.length -1">,</span></strong> </div>
                                    <div class="col-sm-6">每日节数:
                                        <!--                                        <strong ng-if="memberCardDetails.cardCategory.bindPack[index].number > 0">{{memberCardDetails.cardCategory.bindPack[index].number}}</strong>-->
                                        <!--                                        <strong ng-if="memberCardDetails.cardCategory.bindPack[index].number < 0">不限</strong>-->
                                        <strong>{{mcClass.number == -1 ? '不限' : mcClass.number}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <div class="mt50">-->
<!--                            <section><strong>6.服务套餐</strong></section>-->
<!--                            <section class="col-sm-12 sectionMt">-->
<!--                                <div class="col-sm-6 mb30" ng-repeat='(index,w) in memberCardDetails.cardCategory.sever'>-->
<!--                                    <section class="col-sm-6">服务名称: <strong>{{w.name}}</strong></section>-->
<!--                                    <section class="col-sm-6">每日数量:-->
<!--                                        <strong ng-if="memberCardDetails.cardCategory.bindPack[index].number > 0">{{memberCardDetails.cardCategory.bindPack[index].number}}</strong>-->
<!--                                        <strong ng-if="memberCardDetails.cardCategory.bindPack[index].number < 0">不限</strong>-->
<!--                                    </section>-->
<!--                                </div>-->
<!--                            </section>-->
<!--                        </div>-->
                        <div class="mt50">
                            <br>
                            <p><strong>6.赠品</strong></p>
                            <div class="col-sm-12 sectionMt">
                                <div class="col-sm-6 mb30" ng-if="memberCardDetails.bindGift!=null" ng-repeat='giftOne in memberCardDetails.bindGift'>
                                    <div class="col-sm-6">赠品: <strong>{{giftOne.goods_name}}</strong></div>
                                    <div class="col-sm-6">数量:<strong>{{giftOne.number == -1 ?'不限': giftOne.number}}</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>7.转让:</strong></p>
                            <div class="col-sm-12 sectionMt">
                                <div class="col-sm-3">转让次数: <strong>{{memberCardDetails.transfer_num | noData:''}}</strong> </div>
                                <div class="col-sm-3">转让金额: <strong>{{memberCardDetails.transfer_price | noData:''}}</strong></div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>8.请假:</strong></p>
                            <div ng-if="memberCardDetails.leave_total_days == null &&  memberCardDetails.leave_least_days == null && memberCardDetails.leave_days_times == 'null' && memberCardDetails.total_summer_vacation == null  && memberCardDetails.total_winter_vacation == null">
                                <strong>暂无数据</strong>
                            </div>
                            <div>
                                <div class="col-sm-12 sectionMt" ng-if="memberCardDetails.leave_total_days != null  && memberCardDetails.leave_least_days != null">
                                    <div class="col-sm-3">请假总天数:<strong>{{memberCardDetails.leave_total_days}}</strong></div>
                                    <div class="col-sm-3">每次最低天数:<strong>{{memberCardDetails.leave_least_days}}</strong></div>
                                </div>
                                <div class="col-sm-12 sectionMt" ng-if="memberCardDetails.leave_total_days == null && memberCardDetails.leave_least_days == null">
                                    <div class="col-sm-6" ng-repeat="w in leaveLongIimit">
                                        <div class="col-sm-6">每次请假天数:<strong >{{w[0]}}</strong></div>
                                        <div class="col-sm-6">请假次数:<strong>{{w[1]}}</strong></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 sectionMt" ng-if="memberCardDetails.total_summer_vacation != null  && memberCardDetails.total_winter_vacation != null">
                                    <div class="col-sm-3">暑假天数:<strong>{{memberCardDetails.total_summer_vacation}}</strong></div>
                                    <div class="col-sm-3">寒假天数:<strong>{{memberCardDetails.total_winter_vacation}}</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt50">
                            <br>
                            <p><strong>9.合同:</strong></p>
                            <div class="col-sm-12 sectionMt">
                                <div class="col-sm-3">合同:<strong>{{memberCardDetails.dealName | noData:''}}</strong> </div>
                                <main class="col-sm-12 pdLR0 mT20" style="min-height:200px;max-height: 400px;overflow-y: scroll;border: solid 1px #5E5E5E;">
                                    <ul id="bargainContent" style="padding: 20px;">
                                        <li class="contract1">
                                            <span class="contractCss" ng-bind-html="memberCardDetails.intro | to_Html"></span>
                                        </li>
                                    </ul>
                                </main>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--会员卡赠送天数模态框-->
<div class="modal fade" id="giftDaysModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="">
        <div class="modal-content clearfix">
            <div class="modal-header text-center modal-title-words">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">赠送天数</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 pdWidth40">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label ft999">
                                    <span class="red">*</span>
                                    赠送天数
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-control"
                                            style="padding-top: 4px;"
                                            ng-model="giftsDaysSelect"
                                            ng-change="giftsDaysSelectChange(giftsDaysSelect)">
                                        <option value="">请选择</option>
                                        <option ng-repeat="g in getGiftGiveDaysList"
                                                ng-if="g.surplus != '0' || g.surplus != 0"
                                                value="{{g}}">{{g.days}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mrt40">
                                <label class="col-sm-3 control-label ft999">
                                    <span class="red">*</span>
                                    赠送备注
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" ng-model="giftTextarea" style="height: 80px;resize: none;"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <p class="daysP">总天数：<span>{{giftGiveAllMathDays}}</span></p>
                        <p class="daysP">有效期：<span ng-if="getGiftGiveDaysListAllDays != ''">{{cardInfo.create_at*1000|date:'yyyy-MM-dd'}}</span>至<span ng-if="getGiftGiveDaysListAllDays != ''">{{getGiftGiveDaysListAllMath*1000|date:'yyyy-MM-dd'}}</span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="text-align: center;">
                <button type="button"
                        class="btn btn-success w100"
                        ng-click="postGiftDaysInfo()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--会员卡属性匹配模态框-->
<div class="modal fade" id="matchingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog matchingModal" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center">属性匹配</h3>
            </div>
            <div class="modal-body clearfix">
                <div class="row col-sm-8 col-sm-offset-2">
                    <div class="col-md-12">
                        <select name="" class="form-control" ng-model="chooseVenue" ng-change="chooseVenueChange(chooseVenue)" style="padding-top: 4px;margin: 15px 0;">
                            <option value="">请选择场馆</option>
                            <option ng-repeat="venues in optionVenue" value="{{venues.id}}">{{venues.name}}</option>
                        </select>
                        <select class="form-control" id="selectedCards" ng-change="cardCateGoryArray(chooseNewCardType)" ng-model="chooseNewCardType"
                                ng-click="isChooseVenue()" style="padding-top: 4px;margin: 15px 0;">
                            <option value="">请选择卡种</option>
                            <option class="optionsCards" ng-repeat="cardItems in getVenueCardItems" value="{{cardItems.id}}">{{cardItems.card_name + '&emsp;&emsp;编号：' + cardItems.id}}</option>
                        </select>
                    </div>
                    <div class="col-md-12 waring-tit">
                        <span class="glyphicon glyphicon-warning-sign" style="color: orange;"></span>
                        <span>只能搜索在售卖期内卡种</span>
                    </div>
                    <div class="chooseCardType">
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchCardType1">卡的属性
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchCardType2">卡的类型
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchWithPeople">是否带人
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchVenueLimit">通用场馆限制
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchTimeLimit">进馆时间限制
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchGroupClass">团课套餐
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchLeave">请假
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchGift">赠品
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchTransfer">转让
                            </label>
                        </div>
<!--                        <div class="col-md-6">-->
<!--                            <label class="checkbox-inline">-->
<!--                                <input type="checkbox" ng-model="matchContract">合同-->
<!--                            </label>-->
<!--                        </div>-->
                        <div class="col-md-6">
                            <label class="checkbox-inline">
                                <input type="checkbox" ng-model="matchValidityRenew">有效期续费
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="col-md-2 pd0">备注</div>
                        <div class="col-md-10 pd0">
                            <textarea class="form-control" rows="3" style="resize: none;" ng-model="matchCardTypeNote"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-click="matchCardTypeComplete()" ladda="checkButton">完成</button>
            </div>
        </div>
    </div>
</div>
<!--会员卡续费记录修改-->
<div class="modal" id="moneyUpsateModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:35%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center modal-title-words">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center">修改续费记录</h3>
            </div>
            <div class="modal-body" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-sm-12" style="padding: 20px 10px;">
                        <form class="form-horizontal">
                            <div class="form-group moneyListFormMarginTop">
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>缴费时间：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               id="moneyListDateBox"
                                               class="form-control"
                                               placeholder="请输入办卡时间"
                                               ng-model="moneyListDate">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>激活时间：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               id="moneyListActiveTimeBox"
                                               class="form-control"
                                               placeholder="请输入激活时间"
                                               ng-model="moneyListActiveTime">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>缴费名称：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="请输入办卡名称" ng-model="moneyListCardName">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>缴费金额：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="请输入金额"
                                               ng-change="chargeMoney(moneyUpsateInputVal)"
                                               ng-model="moneyUpsateInputVal">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>会籍顾问：</label>
                                    <div class="col-sm-9">
                                        <select class=" form-control" ng-change="chargeSellId()" ng-model="sellName"
                                                id="coachId" style="padding: 0px 8px;">
                                            <option value="">请选择</option>
                                            <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                                {{theAdviser.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>到期日期：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control"
                                               id="moneyListDueDateBox"
                                               placeholder="请输入到期日期"
                                               ng-model="moneyListDueDate">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>行为：</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control"
                                               ng-model="moneyListCategory">
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top: 40px;">
                                    <button class="btn btn-success center-block w100"
                                            ng-click="moneyUpsateModalSuccess()">完成</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--新增会员卡续费记录模态框-->
<div class="modal" id="addNewCardRenewRecordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 35%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center">新增续费记录</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group moneyListFormMarginTop">
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>缴费时间：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       id="addNewCardRenewRecordTimeBox"
                                       placeholder="请输入办卡时间"
                                       ng-model="addNewCardRenewRecordTime">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>激活时间：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       id="addNewCardRenewRecordActiveTimeBox"
                                       placeholder="请输入办卡时间"
                                       ng-model="addNewCardRenewRecordActiveTime">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>缴费名称：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       placeholder="请输入办卡名称"
                                       ng-model="addNewCardRenewRecordName">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>缴费金额：</label>
                            <div class="col-sm-9">
                                <input type="number"
                                       class="form-control"
                                       placeholder="请输入金额"
                                       ng-model="addNewCardRenewRecordMoney">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>会籍顾问：</label>
                            <div class="col-sm-9">
                                <select class=" form-control"
                                        ng-model="addNewCardRenewRecordSeller"
                                        id="coachId"
                                        style="padding: 0px 8px;">
                                    <option value="">请选择</option>
                                    <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                        {{theAdviser.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>到期日期：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       id="addNewCardRenewRecordEndBox"
                                       placeholder="请输入到期日期"
                                       ng-model="addNewCardRenewRecordEnd">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>行为：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       ng-model="addNewCardRenewRecordActive">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success center-block w100"
                        ng-click="addNewCardRenewRecord()">完成</button>
            </div>
        </div>
    </div>
</div>