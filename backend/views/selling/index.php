<?php
use backend\assets\SellingAsset;
SellingAsset::register($this);
$this->title = '售卡管理';
?>
<div class="col-sm-12" ng-controller='sellingCtrl' ng-clock>
    <div class="panel panel-default " style="border: none;">
        <?=$this->render('@app/views/common/csrf.php')?>
        <div class="panel-heading headerStyle">
           <span style="display: inline-block"><b class="spanSmall">售卡管理</b></span>
        </div>
        <div class="panel-body" style="">
            <form class="form-horizontal">
                <h3 class="col-sm-12 mrb20">1.基本信息</h3>
                <div class="col-sm-12">
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            姓名
                        </label>
                        <div class="col-sm-8 inputSellCard pdr0">
                            <input type="text" class="form-control" placeholder="叫什么名字" ng-model="name"/>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            身份证号
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <input type="text" maxlength="18" class="form-control" placeholder="输入身份证号"  inputnums id="idCard" ng-model="idCard"/>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            性别
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <select class="form-control formSelectSellCard" ng-model="sex">
                                <option value="">请选择</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mrt20">
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            手机号
                        </label>
                        <div class="col-sm-8 inputSellCard inputSellCardNoBorder pdr0">
                            <input type="number" inputnums id="mobile" ng-model="mobile" class="form-control" placeholder="输入手机号"/>
                        </div>
<!--                        <div class="col-sm-3 pd0">-->
<!--                            <button class="btn btn-info btn-sm codeBtnSellCard" ng-bind="paracont" ng-disabled="disabled" ng-click="getCode()" value="获取验证码"></button>-->
<!--                        </div>-->
                    </div>
<!--                    <div class="form-group col-sm-4">-->
<!--                        <label class="col-sm-4 control-label pd0 formLabelSellCard">-->
<!--                            <span>*</span>-->
<!--                            验证码-->
<!--                        </label>-->
<!--                        <div class="col-sm-8 inputSellCard">-->
<!--                            <input type="number" class="form-control" placeholder="输入验证码" inputnums ng-model="newCode"/>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <h3 class="col-sm-12 mrt20">2.业务办理</h3>
                <div class="col-sm-12 mrt20">
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            卡种
                        </label>
                        <div class="col-sm-8 inputSellCard pdr0">
                            <select class="cardSelect form-control" name="cardList" id="cardList" ng-change="cardCateGoryArray(card)" ng-model="card" style="width: 100%;">
                                <option value="">选择卡种</option>
                                <option value="{{card}}" ng-repeat="card in cardItems" ng-init ng-if="card.card_name != null">{{card.card_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            付款方式
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <select name="sell" id="fenqi" ng-model="paymentType" class="form-control">
                                <option value="">请选择</option>
                                <option value="1">全款</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            选择销售
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <select class="form-control formSelectSellCard sellManSelect" id="saleman" ng-model="saleMan" style="width: 100%;">
                                <option value="">请选择</option>
                                <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mrt20">
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            总金额
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <input type="text" ng-model="amountMoney" ng-if="amountMoney != null && amountMoneyMax == null && amountMoneyMin == null" ng-disabled="amountMoney != null" class="form-control" placeholder="请输入金额" id="totalMoney"/>
                            <input type="text" inputnums ng-change="amountMoneyB(amountMoneyValue2)" ng-model="amountMoneyValue2"  ng-if="amountMoney == null && amountMoneyMax == null && amountMoneyMin == null" class="form-control"  placeholder="请输入金额" id="totalMoney">
                            <input type="text" inputnums ng-change="amountMoneyA(amountMoneyValue1)"  ng-model="amountMoneyValue1" ng-if=" amountMoneyValue1 == null && amountMoneyMax != null && amountMoneyMin != null" class="form-control" placeholder="请输入金额" id="totalMoney"/>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            收款方式
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <select class="form-control inputSellCard "  ng-model="paymentMethod ">
                                <option value="">请选择</option>
                                <option value="1">现金</option>
                                <option value="3">微信</option>
                                <option value="2">支付宝</option>
<!--                                <option value="4" >pos机</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            会员卡号
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <input type="number" min="0"  ng-model="initCardNumber"  class="form-control"  placeholder="请输入卡号" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mrt20">
                    <div class="form-group col-sm-4">
                        <label class="col-sm-4 control-label pd0 formLabelSellCard">
                            <span>*</span>
                            赠品
                        </label>
                        <div class="col-sm-8 inputSellCard">
                            <select class="form-control inputSellCard " ng-model="selectGift">
                                <option value="">请选择赠品</option>
                                <option value="2">已领取</option>
                                <option value="1">未领取</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <button type="button" ng-click="add()" ladda="addSellCardButtonFlag" class="btn btn-sm btn-success pull-right" id="success" style="margin-top: 20px;width: 100px;margin-right: 100px;">完成</button>
            </div>
        </div>
    </div>
</div>
