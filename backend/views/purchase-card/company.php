<?php
/* @var $this yii\web\View */
use backend\assets\BuyCardCtrlAsset;
BuyCardCtrlAsset::register($this);
$this->title = '会员登记';
?>
<main ng-controller="goBuyCardCtrl" class="bGWhite pRelative"  ng-cloak>
    <div  class="header">
       <div>
           <span class="glyphicon glyphicon-menu-left f24 op0 colorE5"  ></span>
       </div>
        <div class="f15 color000" ><b>会员登记</b></div>
        <div class="op0">12</div>
    </div>
    <div class="pRelative">
        <section >
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
            <div >
                <ul class="listForm " >
                    <li class="w40 colorD9"><span class="glyphicon glyphicon-calendar"></span></li>
                    <li  class="f16Name"><label for="date" class="fwNormal">生日日期</label></li>
                    <li class="wB100 hB100">
                        <input type="text" readonly="readonly"  id="date" ng-model="birthDay" class="borderNone wB100 hB100">
<!--                        <input  class="borderNone wB100 hB100 " type="text" id="date"  />-->
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/map.png" alt=""></span></li>
                    <li  class="f16Name">身份证住址</li>
                    <li class="wB100">
                        <input type="text" value="{{idAddress}}" ng-model="idAddress" class="form-control borderNone"  >
                    </li>
                </ul>
            </div>
            <div >
                <ul class="listForm " >
                    <li class="w40 colorD9"><span class="glyphicon glyphicon-globe color999" ></span></li>
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
                        <input  type="text" ng-model="newCode" value="{{newCode}}" class="form-control borderNone"  >
                        <button class="lf--input c-input leftTopB-radius borderNone bgTransparent w190"  type="button" ng-click="getCode()" ng-bind="paracont" ng-disabled="disabled">获取验证码</button>
                    </li>
                </ul>
            </div>
            <div class="page-bd">
                <ul>
                    <li id="company" class="bgWhite" >
                        <div class="weui-flex js-category listForm" >
                            <div class="w40 mLF3"  ><span class="" ><img  class="wB40"  ng-src="/plugins/purchaseCard/imgages/address.png" alt=""></span></div>
                            <p  class="weui-flex-item f16Name mLF20">选择场馆<input class="selectInput" type="text" readonly="readonly" placeholder="请选择场馆" ng-model="companyName"/></p>

                            <i id="companyI" class="icon icon-74"></i>
                        </div>
                        <div class="page-category js-categoryInner">
                            <div class="weui_cells weui_cells_access mT0" >
                                <div class="weui_cells weui_cells_radio selectFan"  >
                                    <label style="" class="weui_cell weui_check_label mBt0" ng-repeat="companyData in companyDatas"   for="x{{companyData.id}}" ng-click="selectCompany(companyData.id,companyData.name,companyData.pid)">
                                        <div class="weui_cell_bd weui_cell_primary ">
                                            <p class="font14">{{companyData.name}}</p>
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
                        <li id="cardKind" class="bgWhite" >
                            <div class="weui-flex js-category listForm" ng-click="cardLists()">
                                <div class="w40 mLF3"><span class=""><img class="wB40"  ng-src="/plugins/purchaseCard/imgages/memberCard1.png" alt=""></span></div>
                                <p  class="weui-flex-item f16Name mLF20">会员卡&emsp;<input class="selectInput" type="text" readonly="readonly" placeholder="请选择会员卡" ng-model="selectMemberCardName"/></p>
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
        </section>
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
        <div class="newText"  ng-if="cardId != null && cardId != undefined" >点击"确定"即表示您阅读并同意<button   ng-click="getDealName()"   class=" open-popup f15 color000 bgTransparent borderNone" data-target="#popup1"><b ng-if="newMemberProtocol != 'null'&& newMemberProtocol !=undefined " >《<span class="borderB2">新会员入会协议</span>》</b></button></div>
        <div class="newText"  ng-if="cardId != null && cardId != undefined"><button  class="open-popup f15 color000 bgTransparent borderNone" data-target="#popup">&nbsp;&nbsp;<b >《<span class="borderB2">{{introMessName}}</span>》</b></button></div>
        <button ng-click="confirmRes()"  type="button" class="btn btn-success" style="background-color:#2FBF79;width: 100%; ">确认</button>
    </div>
</main>


