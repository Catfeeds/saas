<?php
/* @var $this yii\web\View */
use backend\assets\AccessRegisterCtrlAsset;
AccessRegisterCtrlAsset::register($this);
$this->title = '进馆登记';
?>
<main ng-controller="accessRegisterCtrl" class="bGWhite pRelative"  ng-cloak>
    <div  class="header">
        <div>
            <span class="glyphicon glyphicon-menu-left f24 op0 colorE5"  ></span>
        </div>
        <div class="f15 color000" ><b>进馆登记</b></div>
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
                    <li id="sourceKind" class="bgWhite" >
                        <div class="weui-flex js-category listForm" ng-click="selectSourceWarn()">
                            <div class="w40 mLF3"><span class=""><img class="wB40"  ng-src="/plugins/purchaseCard/imgages/memberCard1.png" alt=""></span></div>
                            <p  class="weui-flex-item f16Name mLF20">来源渠道&emsp;<input class="selectInput" type="text" readonly="readonly" placeholder="请选择来源渠道" ng-model="sourceName"/></p>
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
                            <div class="w40 mLF3 colorD9"><span class="glyphicon glyphicon-user">
<!--                                    <img class="wB40"  ng-src="/plugins/purchaseCard/imgages/memberCard1.png" alt="">-->
                                </span></div>
                            <p  class="weui-flex-item f16Name mLF20">会籍顾问&emsp;<input class="selectInput" type="text" readonly="readonly" placeholder="请选择会籍顾问" ng-model="consultantName"/></p>
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
        </form>
    </div>
    <div class="pd10 wB100" >
<!--        <div id="popup" class="weui-popup-container" >-->
<!--            <div class="weui-popup-modal bgWhite" style="background-color: #FFF;" >-->
<!--                <div  class="header">-->
<!--                    <div>-->
<!--                        <span class="colorTransparent" >开始</span>-->
<!--                    </div>-->
<!--                    <div class="f15 color000" ><b>合同</b></div>-->
<!--                    <div ><a href="javascript:;" class="close-popup  bgTransparent borderNone"  id="p1">关闭</a></div>-->
<!--                </div>-->
<!--                <div class="weui_article">-->
<!--                    <section>-->
<!--                        <h2 class="textCenter" >{{introMessName}}</h2>-->
<!--                        <p class="letterSpacing2"  ng-bind-html="introMess | to_Html" ></p>-->
<!--                    </section>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
        <button ng-click="confirm()" type="button" class="btn btn-success" style="background-color:#2FBF79;width: 100%; ">确认</button>
    </div>
</main>


