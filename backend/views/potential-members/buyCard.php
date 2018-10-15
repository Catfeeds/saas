<!--购卡-->
<div class="modal fade" id="potentialPurchaseModal" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true" ng-click="closeMotalFun()">&times;</span></button>
                <h4 class="modal-title text-center" id="exampleModalLabel">潜在会员购卡</h4>
            </div>
            <div class="modal-body potentialPurchaseModalBody" id="buyCardModalCheck" style="padding-bottom: 0">
                <div class="panel panel-default mrb0" >
                    <?=$this->render('@app/views/common/csrf.php')?>
<!--                    <div class="panel-heading"><h2 style="font-size: 18px;"><b>潜在会员</b></h2></div>-->
                    <div class="row">
                        <div class="col-sm-12">
<!--                            <div class="col-sm-12" style="padding: 30px 60px 0 80px;">-->
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12 pd0">
                                        <b>1.基本信息</b>
                                    </div>
                                    <div class="col-sm-12 pd0 mt20">
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>会员姓名</label>
                                            <div class="col-sm-8 pd0">
                                                <input type="text"
                                                       class="form-control nameInputCheck"
                                                       ng-model="name"
                                                       placeholder="姓名">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>手机号码</label>
                                            <div class="col-sm-8 pd0">
                                                <input type="text"
                                                       class="form-control mobileInputCheck"
                                                       inputnums
                                                       id="mobile"
                                                       ng-model="mobile"
                                                       placeholder="手机号" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>会员性别</label>
                                            <div class="col-sm-8 pd0">
                                                <select class="form-control"
                                                        id="idCardSelect"
                                                        ng-model="sex"
                                                        style="padding-top: 4px;height: 30px;margin: 0">
                                                    <option value="">请选择</option>
                                                    <option value="1">男</option>
                                                    <option value="2">女</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 pd0 mt10">
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>证件选择</label>
                                            <div class="col-sm-8 pd0">
                                                <select name="" class="form-control selectPd "
                                                        ng-model="buyCardSelectCredentials" ng-change="buyCardSelectCredentialsChange(buyCardSelectCredentials)">
                                                    <option value="">请选择证件</option>
                                                    <option value="1">身份证</option>
                                                    <option value="2">居住证</option>
                                                    <option value="3">签证</option>
                                                    <option value="4">护照</option>
                                                    <option value="5">户口本</option>
                                                    <option value="6">军人证</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>证件号</label>
                                            <div class="col-sm-8 pd0">
                                                <input type="text" ng-change="getBirthDay()" class="form-control idCardInputCheck" ng-model="idCard" inputnums id="idCard" placeholder="证件号号码">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red"></span>生日</label>
                                            <div class="col-sm-8 pd0">
                                                <input class="form-control " id="buyCardBirthdays" type="text" placeholder="" ng-model="buyCardBirthdays123">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 pd0 mt20">
                                        <b>2.业务办理</b>
                                    </div>
                                    <div class="col-sm-12 pd0 mt20">
<!--                                        新增场馆选项-->
                                        <div class="col-sm-4 mt20">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>选择场馆</label>
                                            <div class="col-sm-8 pd0">
                                                <select class="form-control"
                                                        id="venueCardSelect"
                                                        ng-model="venue"
        
                                                        ng-change="venueSelectChange(venue)"
                                                        style="padding-top: 4px;height: 30px;margin: 0">
                                                    <option value="">请选择</option>
                                                    <option ng-selected="defaultVenueId == venue.id" value="{{venue}}" ng-repeat="venue in venueItems" >{{venue.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt20">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>选择卡种</label>
                                            <div class="col-sm-8 pd0">
                                                <select class="form-control"
                                                        id="selectedCards"
                                                        ng-change="cardCateGoryArray(card)"
                                                        ng-model="card"
                                                        style="padding-top: 4px;">
                                                    <option value="">请选择</option>
                                                    <option  value="{{card}}"
                                                            data-module="{{card}}"
                                                            class="optionsCards"
                                                             ng-selected="card.id == defaultCardId"
                                                            ng-repeat="card in getVenueCardItems">{{card.card_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red" style="opacity: 0">*</span>购卡折扣</label>
                                                <div class="col-sm-8 pd0">
                                                    <select ng-model="discountSelect"
                                                            class="form-control"
                                                            ng-change="discountBuyChange(discountSelect)"
                                                            style="padding-top: 4px;">
                                                        <option value="">请选择</option>
                                                        <option ng-repeat="d in getBuyDiscountList" value="{{d}}">{{d.discount}}折</option>
                                                    </select>
                                                    <span class="discountWords">
                                                        <i class="glyphicon glyphicon-info-sign"></i>
                                                        <span ng-if="discountBuyCardSurplus > 0">剩余{{discountBuyCardSurplus}}张卡</span>
                                                        <span ng-if="discountBuyCardSurplus == '-1'">不限</span>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt20">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>选择销售</label>
                                            <div class="col-sm-8 pd0">
                                                <select class="form-control saleSelect"
                                                            id="saleman"
                                                            ng-model="saleMan"
                                                            style="padding-top: 4px;">
                                                    <option value="">请选择</option>
                                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>卡种金额</label>
                                                <div class="col-sm-8 pd0" style="position: relative;">
                                                    <input type="text"
                                                           class="form-control amountMoneyInput"
                                                           id="amountMoneyInputVal"
                                                           ng-model="amountMoney"
                                                           placeholder="请输入金额"
                                                           ng-change="mathAllAmountMoneyLast()"
                                                           ng-disabled="amount != null && amount != ''">
                                                         <span style="font-size: 12px;color: #999;position: absolute;top: 34px;left: 0;"
                                                      ng-if="buyCardMaxPrice != '' && buyCardMaxPrice != undefined">区间价格为：{{buyCardMinPrice}}至{{buyCardMaxPrice}}元</span>
                                                </div>
                                        </div>
                                        <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red" style="opacity: 0;">*</span>赠送天数</label>
                                                <div class="col-sm-8 pd0">
                                                    <select class="form-control"
                                                            id="selectedCardsGift"
                                                            style="padding-top: 4px"
                                                            ng-change="giftsDaysSelectChange(giftsDaysSelect)"
                                                            ng-model="giftsDaysSelect">
                                                        <option value="">请选择</option>
                                                        <option ng-repeat="g in getGiftGiveDaysList"
                                                                value="{{g}}"
                                                                ng-if="g.surplus != '0'">{{g.days}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>收款方式</label>
                                                <div class="col-sm-8 pd0">
                                                    <select class="form-control"
                                                            name="sell"
                                                            id="fenqi"
                                                            ng-model="paymentType"
                                                            style="padding-top: 4px;"
                                                            ng-change="paymentTypeChange(paymentType)">
                                                        <option value="">请选择</option>
                                                        <option value="1">全款</option>
                                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','DEPOSIT')){ ?>
                                                            <option value="2">定金</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-sm-12 mt20" style="margin-bottom: 4px;">
                                            <label class="col-sm-1 pd0 formLabel" style="padding-top: 5px;width: 90px;"><span class="red">*</span>定金金额</label>
                                            <div class="col-sm-7 pd0">
                                                <select class="form-control select2 buyCardDepositSelect1" multiple="multiple" ng-change="buyCardDepositSelectChange()" ng-model="buyCardDepositSelect" style="padding-top: 4px;">
                                                    <option ng-repeat="zzz in buyCardDepositSelectData" value="{{zzz.id}}" data-price="{{zzz.price}}">定金：{{zzz.price}}元</option>
                                                </select>
                                                <span>剩余购卡定金{{surplusPrice}}元</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                            <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>赠品领取</label>
                                            <div class="col-sm-8 pd0">
                                                <select class="form-control"
                                                        id="selectedCards"
                                                        ng-model="giftStatus"
                                                        style="padding-top: 4px;">
                                                    <option value="">请选择</option>
                                                    <option value="2">已领取</option>
                                                    <option value="1">未领取</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-sm-4 mt20" style="margin-bottom: 4px;">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>使用方式</label>
                                                <div class="col-sm-8 pd0">
                                                    <select class="form-control"
                                                            ng-model="usageMode"
                                                            style="padding-top: 4px;">
                                                        <option value="">请选择</option>
                                                        <option value="1">自用</option>
                                                        <option value="2">送人</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mt20">
                                                <label class="col-sm-3 pd0 formLabel" style="padding-top: 5px;"><span class="red" style="opacity: 0;">*</span>会员卡号</label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="text" ng-model="cardCheckNumber" class="form-control cardCheckNumber" placeholder="请输入卡号">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="width: 80%;margin: 20px;">
                                <div class="form-group addPayWayBox">
                                    <div class="col-sm-12 addSelectElement" style="margin: 5px 0;">
                                        <label class="col-sm-1 pd0 formLabel" style="padding-top: 5px;"><span class="red">*</span>付款途径</label>
                                        <div class="col-sm-8 pd0">
                                            <select class="addPayMethodSelect" ng-change="addPayPriceChange321()" ng-model="addPayPriceSelect">
                                                <option value="">请选择</option>
                                                <option value="1">现金</option>
                                                <option value="3">微信</option>
                                                <option value="2">支付宝</option>
                                                <!--                                        <option value="4" >pos机</option>-->
                                                <option value="5" >建设分期</option>
                                                <option value="6" >广发分期</option>
                                                <option value="7" >招行分期</option>
                                                <option value="8" >借记卡</option>
                                                <option value="9" >贷记卡</option>
                                            </select>
                                            <input type="text" class="addPayPrice" ng-change="addPayPriceChange()" ng-model="addPayPriceInput" style="resize: none;border-color: #0a0a0a;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 addPayWayBtnBox">
                                    <button class="btn btn-default addPayMethodButton" id="addPayWay" venuehtml ng-click="addPaySelectElement()">新增付款途径</button>
                                    总金额：<span>{{allPayWayPrice}}</span>元
                                </div>
                                <hr style="width: 80%;margin: 20px;">
                                <div class="form-group">
                                <div class="col-sm-12 pd0 mt10">
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 pd0 formLabel" style="padding-top: 5px;"><span class="red" style="opacity: 0;">*</span>购卡备注</label>
                                    </div>
                                    <div class="col-sm-12 mt10" style="padding-right: 40px;">
                                        <textarea class="form-control" rows="3" style="resize: none;border-color: #0a0a0a;" class="potentialMemberBuyCardNote" id="potentialMemberBuyCardNote"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                <div class="col-sm-12 pd0 mt10">
                                    <div style="text-align: right;">
                                        <p class="ppp">
                                            <span style="font-size: 15px;">定金:{{allDepositMoneyAmount == null ? "0":allDepositMoneyAmount}}元</span>
<!--                                            <span style="font-size: 15px;">抵券:{{sellingDataVoucher}}</span>-->
                                            <span style="font-size: 18px;color: #ff9900;font-weight: bold;">应付:{{allMathMoney}}元</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button"
                        class="btn btn-success w100"
                        ng-click="addBuyCard()"
                        id="success">完成</button>
            </div>
        </div>

    </div>
</div>