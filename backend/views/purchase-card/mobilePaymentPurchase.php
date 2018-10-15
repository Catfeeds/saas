<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/9/1
 * Time: 19:18
 * content:手机支付购卡
 */
use backend\assets\mobilePurchaseAsset;
mobilePurchaseAsset::register($this);
$this->title = '购卡';
?>
<main ng-controller="buyCardCtrl" class="bGWhite pRelative"  ng-cloak>
    <div  class="header">
        <div>
            <span class="glyphicon glyphicon-menu-left f24 op0 colorE5"  ></span>
        </div>
        <div class="f15 color000" ><b>购卡</b></div>
        <div class="op0">12</div>
    </div>
    <div class="pRelative">
        <form >
            <input  id="_csrf" type="hidden"
                    name="<?= \Yii::$app->request->csrfParam; ?>"
                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <div >
                <ul class="listForm " >
                    <li class="w40"><span ><img   ng-src="/plugins/purchaseCard/imgages/user.png" alt=""></span></li>
                    <li class="f16Name">姓名</li>
                    <li class="wB100">
                        <input type="text" value="name" ng-model="name" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/idCard.png" alt=""></span></li>
                    <li  class="f16Name">证件号</li>
                    <li class="wB100">
                        <input type="text"  value="{{idCard}}" ng-change="inputIdCard(idCard)" ng-model="idCard" class="form-control borderNone">
                    </li>
                </ul>
            </div>
            <div ng-if="birthDay != '' && birthDay != undefined">
                <ul class="listForm " >
                    <li class="w40 colorD9"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/bir.png" alt=""></span></li>
                    <li  class="f16Name"><label for="date" class="fwNormal">生日日期</label></li>
                    <li class="wB100 hB100">
                        <input type="text" readonly="readonly"  id="date" ng-model="birthDay" style="padding: 6px 12px;" class="borderNone  wB100 hB100">
                        <!--                        <input  class="borderNone wB100 hB100 " type="text" id="date"  />-->
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/map.png" alt="住址"></span></li>
                    <li  class="f16Name">身份证住址</li>
                    <li class="wB100">
                        <input type="text" value="{{idAddress}}" ng-model="idAddress" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40 colorD9"><span class=" color999" ><img  ng-src="/plugins/purchaseCard/imgages/address.png" alt="现居地"></span></li>
                    <li  class="f16Name">现居地</li>
                    <li class="wB100">
                        <input type="text" value="{{nowAddress}}" ng-model="nowAddress" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/phone.png" alt=""></span></li>
                    <li  class="f16Name">手机号</li>
                    <li class="wB100">
                        <input type="number" min="1" value="{{mobile}}" ng-model="mobile" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40"><span class=""><img class="wB50"  ng-src="/plugins/purchaseCard/imgages/yanzheng.png" alt=""></span></li>
                    <li  class="f16Name">验证码</li>
                    <li class="wB100 disFlex" >
                        <input  type="number" ng-model="newCode" value="{{newCode}}" class="form-control borderNone"  >
                        <button class="lf--input c-input leftTopB-radius borderNone bgTransparent w190"  type="button" ng-click="getCode()" ng-bind="paracont" ng-disabled="disabled">获取验证码</button>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="cardKind" class="bgWhite" >
                        <div class="weui-flex js-category listForm" ng-click="cardLists()">
                            <div class="w40 mLF3"><span class=""><img class="wB40"  ng-src="/plugins/purchaseCard/imgages/memberCard1.png" alt=""></span></div>
                            <p  class="weui-flex-item  mLF20" style="display: flex;"><span  style="width: 90px;display: inline-block;padding-left: 4px;">会员卡&emsp;&emsp;</span><input style="text-align: left;padding-left: 12px;" class="selectInput" type="text" readonly="readonly" placeholder="请选择会员卡" ng-model="selectMemberCardName"/></p>
                            <i id="cardKindI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan" >
                                    <label  class="weui_cell weui_check_label mBt0 js-category"  ng-repeat="card in cardItems" for="x{{card.id}}" ng-click="selectCard(card.id,card.card_name)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">{{card.card_name}}</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="x{{card.id}}">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="sourceKind" class="bgWhite" >
                        <div class="weui-flex js-category listForm" ng-click="selectSourceWarn()">
                            <div class="w40 mLF3"><span style="display: inline-block;" class=""><img class="wB40"  ng-src="/plugins/purchaseCard/imgages/source.png" alt=""></span></div>
                            <p  class="weui-flex-item  mLF20" style="display: flex;"> <span  style="width: 90px;display: inline-block;margin-left: 4px;">来源渠道&emsp;</span><input style="text-align: left;padding-left: 12px;" class="selectInput" type="text" readonly="readonly" placeholder="请选择来源渠道" ng-model="sourceName"/></p>
                            <i id="sourceKindI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan" >
                                    <label  class="weui_cell weui_check_label mBt0 js-category"  ng-repeat="source in sourceLists" for="x{{source.id}}" ng-click="selectSource(source.id,source.value)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">{{source.value}}</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="x{{source.id}}">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="consultantKind" class="bgWhite" >
                        <div class="weui-flex js-category listForm" ng-click="selectVenueWarn()">
                            <div class="w40 mLF3 colorD9"><span class="">
                                    <img  class="wB40"  ng-src="/plugins/purchaseCard/imgages/hjgw.png" alt="会籍顾问">
                                </span></div>
                            <p  class="weui-flex-item  mLF20" style="display: flex;"><span  style="width: 90px;display: inline-block;margin-left: 4px;">会籍顾问&emsp;</span><input style="text-align: left;padding-left: 12px;" class="selectInput" type="text" readonly="readonly" placeholder="请选择会籍顾问" ng-model="consultantName"/></p>
                            <i id="consultantKindI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan" >
                                    <label  class="weui_cell weui_check_label mBt0 js-category"  ng-repeat="consultant in membershipConsultantLists" for="x{{consultant.id}}" ng-click="consultantSource(consultant.id,consultant.name)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">{{consultant.name}}</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="x{{consultant.id}}">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="giftTypeKind" class="bgWhite" >
                        <div class="weui-flex js-category listForm" ng-click="selectGiftType()">
                            <div class="w40 mLF3 colorD9"><span class="">
                                    <img  class="wB40"  ng-src="/plugins/purchaseCard/imgages/gift.png" alt="赠品">
                                </span></div>
                            <p  class="weui-flex-item  mLF20" style="display: flex;"><span style="width: 90px;display: inline-block;margin-left: 4px;">赠品领取&emsp;</span><input style="text-align: left;padding-left: 12px;" class="selectInput" type="text" style="padding: 6px 12px;" readonly="readonly" placeholder="请选择赠品领取状态" ng-model="giftTypeName"/></p>
                            <i id="giftTypeKindI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan" >
                                    <label  class="weui_cell weui_check_label mBt0 js-category"   for="xType11" ng-click="giftTypeSelect(1,'未领取')">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">未领取</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="xType11">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
                                    <label  class="weui_cell weui_check_label mBt0 js-category"   for="xType22" ng-click="giftTypeSelect(2,'已领取')">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">已领取</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="xType22">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="PaymentTypeKind" class="bgWhite" >
<!--                        <div class="weui-flex  listForm  open-popup"  ng-click="selectGiftType()" data-target="#popupPayment">-->
                        <div class="weui-flex js-category  listForm  "  ng-click="selectPaymentType()" >
                            <div class="w40 mLF3 colorD9"><span class="">
                                    <img  class="wB40" ng-src="/plugins/purchaseCard/imgages/pay.png" alt="">
                                </span></div>
                            <p  class="weui-flex-item  mLF20" style="display: flex;"><span style="width: 90px;display: inline-block;margin-left: 4px;"> 支付方式&emsp;</span><input style="text-align: left;padding-left: 12px;" class="selectInput" type="text" readonly="readonly" placeholder="请选择支付方式" ng-model="PaymentMethodName"/></p>
<!--                            <i id="giftTypeKindI" class="glyphicon glyphicon-menu-right"></i>-->
                            <i id="PaymentTypeKindI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan" >

                                    <label  class="weui_cell weui_check_label mBt0 js-category" ng-repeat="Payment in PaymentMethodArr"   for="{{Payment.type}}" ng-click="PaymentMethodSelect(Payment.type,Payment.name)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">{{Payment.name}}</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="{{Payment.type}}">
                                            <span class="weui_icon_checked"></span>
                                        </div>
                                    </label>
<!--                                    <label  class="weui_cell weui_check_label mBt0 js-category"   for="wx" ng-click="PaymentMethodSelect('wx','微信')">-->
<!--                                        <div class="weui_cell_bd weui_cell_primary ">-->
<!--                                            <p class="font14">微信{{PaymentMethodTypeIsWx == 2}}</p>-->
<!--                                        </div>-->
<!--                                        <div class="weui_cell_ft">-->
<!--                                            <input type="radio" class="weui_check" name="radio1" id="wx">-->
<!--                                            <span class="weui_icon_checked"></span>-->
<!--                                        </div>-->
<!--                                    </label>-->
<!---->
<!--                                    <label ng-if="PaymentMethodTypeIsWx == 1"  class="weui_cell weui_check_label mBt0 js-category"  for="pay" ng-click="PaymentMethodSelect('pay','支付宝')">-->
<!--                                        <div class="weui_cell_bd weui_cell_primary ">-->
<!--                                            <p class="font14">支付宝</p>-->
<!--                                        </div>-->
<!--                                        <div class="weui_cell_ft">-->
<!--                                            <input type="radio" class="weui_check" name="radio1" id="pay">-->
<!--                                            <span class="weui_icon_checked"></span>-->
<!--                                        </div>-->
<!--                                    </label>-->
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
    <div class="pd10 wB100" >
        <div id="popup" class="weui-popup-container" >
            <div class="weui-popup-modal bgWhite" style="background-color: #FFF;" >
                <div  class="header">
                    <div>
                        <span class="colorTransparent" >开始</span>
                    </div>
                    <div class="f15 color000" ><b>合同</b></div>
                    <div ><a href="javascript:;" class="close-popup  bgTransparent borderNone"  id="p1">关闭</a></div>
                </div>
                <div class="weui_article">
                    <section>
                        <h2 class="textCenter" >{{introMessName}}</h2>
                        <p class="letterSpacing2"  ng-bind-html="introMess | to_Html" ></p>
                    </section>
                </div>
            </div>
        </div>

<!--        <div id="popupPayment" class="weui-popup-container" >-->
<!--            <div class="weui-popup-modal bgWhite" style="background-color: #FFF;" >-->
<!--                <div  class="header">-->
<!--                    <div class="close-popup">-->
<!--                        <span class=" glyphicon glyphicon-menu-left" ></span>-->
<!--                    </div>-->
<!--                    <div class="f15 color000" ><b>支付方式</b></div>-->
<!--                    <div ><a href="javascript:;" class="colorTransparent  bgTransparent borderNone"  id="p1">关闭</a></div>-->
<!--                </div>-->
<!--                <div class="weui_article">-->
<!--                    <section>-->
<!--                        <div class="page-category js-categoryInner">-->
<!--                            <div class="weui_cells weui_cells_access mT0" >-->
<!--                                <div class="weui_cells weui_cells_radio " >-->
<!--                                    <label  class="weui_cell weui_check_label mBt0 js-category"   for="wx1" ng-click="PaymentMethodSelect('wx','微信')">-->
<!--                                        <div class="weui_cell_bd weui_cell_primary ">-->
<!--                                            <p class="font14">微信</p>-->
<!--                                        </div>-->
<!--                                        <div class="weui_cell_ft">-->
<!--                                            <input type="radio" class="weui_check" name="radio1" id="wx1">-->
<!--                                            <span class="weui_icon_checked"></span>-->
<!--                                        </div>-->
<!--                                    </label>-->
<!---->
<!--                                    <label  class="weui_cell weui_check_label mBt0 js-category"  for="pay1" ng-click="PaymentMethodSelect('pay','支付宝')">-->
<!--                                        <div class="weui_cell_bd weui_cell_primary ">-->
<!--                                            <p class="font14">支付宝</p>-->
<!--                                        </div>-->
<!--                                        <div class="weui_cell_ft">-->
<!--                                            <input type="radio" class="weui_check" name="radio1" id="pay1">-->
<!--                                            <span class="weui_icon_checked"></span>-->
<!--                                        </div>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </section>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div id="popup1" class="weui-popup-container" >
            <div class="weui-popup-modal bgWhite" style="background-color: #FFF;">
                <div  class="header">
                    <div>
                        <span class="colorTransparent">00</span>
                    </div>
                    <div class="color000 f15" ><b>新会员入会协议</b></div>
                    <div ><a href="javascript:;" class="close-popup   bgTransparent borderNone"  id="p1">关闭</a></div>
                </div>

                <div class="weui_article">

                    <section>
                        <h2 class="textCenter">{{newMemberProtocol.name}}</h2>
                        <p class="letterSpacing2" ng-bind-html="newIntroMess | to_Html"  ></p>
                    </section>
                </div>

            </div>
        </div>

        <div class="newText" >点击"确定"即表示您阅读并同意<button   ng-click="getDealName()"   href="javascript:;" class=" open-popup f15 color000 bgTransparent borderNone" data-target="#popup1">&nbsp;&nbsp;<b >《<span class="borderB2">新会员入会协议</span>》</b></button></div>
        <div class="newText"  ng-if="cardId != null || cardId != undefined"><button  href="javascript:;" class="open-popup f15 color000 bgTransparent borderNone" data-target="#popup">&nbsp;&nbsp;<b >《<span class="borderB2">{{introMessName}}</span>》</b></button></div>
<!--                <a style="width: 100%" class="btn btn-success" href="/payment/js-api">JSAPI支付</a>-->
        <button style="width: 100%" ng-disabled="buyCardSubmitFlag" class="btn btn-success" ng-click="confirm()">确定</button>
    </div>
</main>