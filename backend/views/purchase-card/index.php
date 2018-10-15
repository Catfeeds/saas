<?php
/* @var $this yii\web\View */
use backend\assets\PurchaseCardCtrlAsset;
PurchaseCardCtrlAsset::register($this);
$this->title = '会员登记';
?>
<main ng-controller="purchaseCardCtrl" style="background-color: #FFF;position: relative;" ng-cloak>
    <div  class="header">
       <div>
           <span class="glyphicon glyphicon-menu-left f24 "  style="opacity: 0;font-size: 24px;color: #e5e5e5;"></span>
       </div>
        <div style="color: #000;font-size: 15px"><b>会员登记</b></div>
        <div style="opacity: 0;">12</div>
    </div>
    <div style="position: relative;">
        <form >
            <input  id="_csrf" type="hidden"
                    name="<?= \Yii::$app->request->csrfParam; ?>"
                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class=""><img   ng-src="/plugins/purchaseCard/imgages/user.png" alt=""></span></li>
                    <li class="f16Name">姓名</li>
                    <li style="width: 100%">
                        <input type="text" value="name" ng-model="name" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/idCard.png" alt=""></span></li>
                    <li  class="f16Name">证件号</li>
                    <li style="width: 100%">
                        <input type="text" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" value="{{idCard}}" ng-model="idCard" class="form-control borderNone">
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/map.png" alt=""></span></li>
                    <li  class="f16Name">身份证住址</li>
                    <li style="width: 100%">
                        <input type="text" value="{{idAddress}}" ng-model="idAddress" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class="glyphicon glyphicon-globe" style="color: #999;"></span></li>
                    <li  class="f16Name">现居地</li>
                    <li style="width: 100%">
                        <input type="text" value="{{nowAddress}}" ng-model="nowAddress" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/phone.png" alt=""></span></li>
                    <li  class="f16Name">手机号</li>
                    <li style="width: 100%">
                        <input type="text" value="{{mobile}}" ng-model="mobile" class="form-control borderNone"  >
                    </li>
                 </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li style="width: 40px;"><span class=""><img style="width: 50%;"  ng-src="/plugins/purchaseCard/imgages/yanzheng.png" alt=""></span></li>
                    <li  class="f16Name">验证码</li>
                    <li style="width: 100%;display: flex;" >
                        <input  type="text" ng-model="newCode" value="{{newCode}}" class="form-control borderNone"  >
                        <button class="lf--input c-input leftTopB-radius borderNone" style="background-color: transparent;width: 190px;" type="button" ng-click="getCode()" ng-bind="paracont" ng-disabled="disabled">获取验证码</button>
                    </li>

                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li  id="company" class="" >
                        <div class="weui-flex js-category listForm" >
                            <div  style="width: 40px;margin-left: -3px;"><span class="" ><img  style="width: 40%;"  ng-src="/plugins/purchaseCard/imgages/address.png" alt=""></span></div>
                            <p style="margin-left: -20px;" class="weui-flex-item f16Name">选择场馆 <input style="border: none;color: #000;text-align: center;" type="text" readonly="readonly" placeholder="请选择场馆" ng-model="companyName"/></p>

                            <i id="companyI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access" style="margin-top: 0px;">
                                <div class="weui_cells weui_cells_radio" style="margin-top: 0px; border-bottom: solid 1px #e5e5e5;   max-height: 100px;overflow-y: scroll;">
                                    <label style="" class="weui_cell weui_check_label mBt0" ng-repeat="companyData in companyDatas"   for="x{{companyData.id}}" ng-click="selectCompany(companyData.id,companyData.name,companyData.pid)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p style="font-size: 14px;">{{companyData.name}}</p>
                                        </div>
                                        <div class="weui_cell_ft">
                                            <input type="radio" class="weui_check" name="radio1" id="x{{companyData.id}}">
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
                        <li  id="cardKind"  class="" >
                            <div class="weui-flex js-category listForm" ng-click="cardLists()">
                                <div  style="width: 40px;margin-left: -3px;"><span class=""><img style="width: 40%;"  ng-src="/plugins/purchaseCard/imgages/memberCard1.png" alt=""></span></div>
                                <p style="margin-left: -20px;" class="weui-flex-item f16Name">会员卡 <input style="border: none;color: #000;text-align: center;" type="text" readonly="readonly" placeholder="请选择会员卡" ng-model="selectMemberCardName"/></p>

                                <i  id="cardKindI" class="icon icon-74"></i>
                            </div>
                            <div class="page-category js-categoryInner">
                                <div class="weui_cells weui_cells_access" style="margin-top: 0px;">
                                    <div class="weui_cells weui_cells_radio" style="margin-top: 0px; border-bottom: solid 1px #e5e5e5;   height: 100px;overflow-y: scroll;">
                                            <label style="" class="weui_cell weui_check_label mBt0"  ng-repeat="card in cardItems" for="x{{card.id}}" ng-click="selectCard(card.id,card.card_name)">
                                                <div class="weui_cell_bd weui_cell_primary ">
                                                    <p style="font-size: 14px;">{{card.card_name}}</p>
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
        </form>
    </div>
    <div style="padding: 10px;width: 100%;">
        <div id="popup" class="weui-popup-container" >
            <div class="weui-popup-modal" style="background-color: #FFF;">
                <div  class="header">
                    <div>
                        <span style="color: transparent;">00</span>
                    </div>
                    <div style="color: #000;font-size: 15px"><b>合同</b></div>
                    <div ><a href="javascript:;" class="close-popup  " style="background-color: transparent;border: none;" id="p1">关闭</a></div>
                </div>
<!--                <h2 class="title text-center">新会员入会协议</h2>-->

                <div class="weui_article">

                    <section>
                        <h2 style="text-align: center;">{{introMessName}}</h2>
                        <p style="letter-spacing: 2px;" ng-bind-html="introMess | to_Html" ></p>
                    </section>
                </div>

            </div>
        </div>

        <div id="popup1" class="weui-popup-container" >
            <div class="weui-popup-modal" style="background-color: #FFF;">
                <div  class="header">
                    <div>
                        <span style="color: transparent;">00</span>
                    </div>
                    <div style="color: #000;font-size: 15px"><b>新会员入会协议</b></div>
                    <div ><a href="javascript:;" class="close-popup" style="background-color: transparent;border: none;" id="p1">关闭</a></div>
                </div>

                <div class="weui_article">

                    <section>
                        <h2 style="text-align: center;">{{newMemberProtocol.name}}</h2>
                        <p style="letter-spacing: 2px;" ng-bind-html="newMemberProtocol.intro | to_Html"></p>
                    </section>
                </div>

            </div>
        </div>

        <div style="width: 100%;font-size: 14px;text-align: center;margin-bottom: 10px;color:#999;" >点击"确定"即表示您阅读并同意<button   ng-click="getDealName()"  style="color: #000;border: none;background-color: transparent;font-size: 15px" href="javascript:;" class=" open-popup " data-target="#popup1">&nbsp;&nbsp;<b >《<span style="border-bottom: solid 2px #000;">新会员入会协议</span>》</b></button></div>
        <div style="width: 100%;font-size: 14px;text-align: center;margin-bottom: 10px;color:#999;" ng-if="cardId != null || cardId != undefined"><button   style="color: #000;border: none;background-color: transparent;font-size: 15px" href="javascript:;" class="open-popup " data-target="#popup">&nbsp;&nbsp;<b >《<span style="border-bottom: solid 2px #000;">{{introMessName}}</span>》</b></button></div>
        <button ng-click="confirm()" type="button" class="btn btn-success" style="background-color:#2FBF79;width: 100%; ">确认</button>
    </div>
</main>


