<?php

use backend\assets\BlendCardCtrlAsset;
BlendCardCtrlAsset::register($this);
$this->title = '混合卡';
?>
<style>
    .mT00{
        margin-top: 0;
    }
</style>
<div  class="wrapper wrapper-content animated fadeInRight" ng-controller="blendCardController">
    <div class="row">
        <div class="col-sm-12" style="overflow: auto;">
            <div class="ibox float-e-margins" style="min-width: 1240px;">
                <div class="ibox-title">
                    <h5>混合卡表单向导</h5>
                </div>
                <div class="ibox-content">
                    <div id="example-async">
                        <h3>第一步</h3>
                        <section >
                            <!--属性内容-->
                            <div  class="fw wB100 text-center"><h2>混合卡属性</h2></div>
                            <main class="con1 wB100 m0Auto20" >
                                <div>
                                    <h4>1.卡的属性</h4>
                                    <form action="">
                                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                        <div class="clearfix" >
                                            <div class="fl  w32 " >
                                                <span class=""><strong class="red">*</strong>卡种所属场馆</span>
                                                <select  class="form-control cp"  ng-change="cardTheVenue(cardTheVenueId)" ng-model="cardTheVenueId">
                                                    <option value="" >请选择场馆</option>
                                                    <option ng-if="cardTheVenueListsFlag" value="{{venue.id}}"
                                                            ng-repeat=" venue in cardTheVenueLists"
                                                    >{{venue.name}}</option>
                                                    <option ng-if="cardTheVenueListsFlag == false" style="color: red;" disabled>暂无数据</option>
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red mT6">*</strong>卡的属性&emsp;&emsp;</span>
                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >
                                                    <option value="">请选择属性</option>
                                                    <option value="{{attr.key}}" ng-repeat="attr in attributesVal">{{attr.val}}</option>
                                                </select>
                                                <select ng-if="attributesStatus == false" class="form-control cp">
                                                    <option value="">请选择属性</option>
                                                    <option value="" disabled class="red">{{attributesVal}}</option>
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red">*</strong>卡的类型&emsp;&emsp;</span>
                                                <!--                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >-->
                                                <select ng-model="$parent.cardType" class="form-control cp"  >
                                                    <option value="">请选择类型</option>
                                                    <option value="1">瑜伽</option>
                                                    <option value="2">健身</option>
                                                    <option value="3">舞蹈</option>
                                                    <option value="4">综合</option>
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red mT6">*</strong>卡的名称&emsp;&emsp;</span>
                                                <input type="text" placeholder="至尊卡" class="form-control cp w200"
                                                       ng-blur="setCardName()"   ng-change="setCardName()"    ng-model="cardName">
                                            </div>
                                            <div class="fl  w32">
                                                <span class="w80" >卡别名</span>
                                                <input type="text" placeholder="英文名称" class="form-control cp w200"
                                                       ng-model="anotherName" >
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red mT6">*</strong>激活期限&emsp;&emsp;</span>
                                                <input ng-model="activeTime" inputnum step="1"   type="number" min="1" placeholder="多少" class="form-control cp w115">
                                                <select ng-model="activeTimeUnit"  class="form-control cp w70"  >
                                                    <option value="" disabled>请选择</option>
                                                    <option value="1" ng-selected="1">天</option>
                                                    <option value="7">周</option>
                                                    <option value="30">月</option>
                                                    <option value="90">季</option>
                                                    <option value="365">年</option>
                                                </select>
                                            </div>

                                            <div class="fl  w32">
                                                <strong class="red mT6">*</strong>
                                                <span class="">有效天数&emsp;&emsp;</span>
                                                <input ng-model="cardDuration" inputnum  type="number" min="0" placeholder="多少" class="form-control cp w115" >
                                                <select ng-model="cardDurationUnit"  class="form-control cp w70"  >
                                                    <option value="" disabled>请选择</option>
                                                    <option value="1" ng-selected="1">天</option>
                                                    <option value="7">周</option>
                                                    <option value="30">月</option>
                                                    <option value="90">季</option>
                                                    <option value="365">年</option>
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class="w80"><strong class="red mT6"></strong>单数&emsp;&emsp;</span>
                                                <input type="number" id="Singular"  ng-model="Singular" min="0" placeholder="请输入单数" class="form-control cp w200" >
                                            </div>
                                            <div class="w100 cp">
                                                <div class="col-sm-8 clearfix">
                                                    <span class="fl mT5" style="margin-top: 35px;margin-left: -12px">&nbsp;卡种照片&emsp;</span>
                                                    <div class="form-group">
                                                        <img ng-src="{{pic}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 25px;margin-left: 17px">
                                                    </div>
                                                    <div class="input-file"
                                                         style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px"
                                                         ngf-drop="setCover($file)"
                                                         ladda="uploading"
                                                         ngf-select="setCover($file);"
                                                         ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                                         ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                                        <p style="margin-left: 9px;width: 100%;height: 100%;line-height: 75px;font-size: 50px;" class="text-center">+</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="mT15">
                                    <h4>2.定价和售卖&nbsp;&nbsp;<span class="f12 color999"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;一口价和区域定价二选一</span></h4>
                                    <form >
                                        <div class="w100 cp">
                                            <strong class="red mT6">*</strong>
                                            <span >一口价&emsp;</span>
                                            <input ng-model="originalPrice" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)"   type="number" min="0" placeholder="原价0元" class="form-control w125">
                                            <input ng-model="sellPrice" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)"   type="number" min="0" placeholder="售价0元" class="form-control w125">
                                        </div>
                                        <div class="w100  cp">
                                            <strong class="red mT6">*</strong>
                                            <span >区域定价</span>
                                            <input ng-model="minPrice" ng-disabled="unable" ng-change="setUnable(disabled,unable)"   type="number" min="0" placeholder="最低价0元" class="form-control w125">
                                            <input ng-model="maxPrice" ng-disabled="unable" ng-change="setUnable(disabled,unable)"    type="number" min="0" placeholder="最高价0元" class="form-control w125">
                                        </div>
<!--                                        <div class="w100  cp">-->
<!--                                            <span >续费价&emsp;</span>-->
<!--                                            <input ng-model="renewPrice" inputnum   type="number" min="0" placeholder="0元" class="form-control w125">-->
<!--                                            <select ng-model="renewUnit"  class="form-control cp w70 mL16"  >-->
<!--                                                <option value="30">月</option>-->
<!--                                                <option value="90">季</option>-->
<!--                                                <option value="365">年</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
                                        <div class="w100 cp">
                                            <span >优惠价&emsp;&emsp;</span>
                                            <input ng-model="offerPrice" type="number" min="0" placeholder="0元" class="form-control w125">
                                        </div>
                                        <div class="w100 cp" style="margin-bottom: 10px;">
                                            <span >移动端售价&emsp;</span>
                                            <input ng-model="appSellPrice" type="number" min="0" placeholder="0元" class="form-control w125">
                                        </div>
                                        <div style="width: 100%;border-top: solid 1px #999;">
                                            <!--<div class="  cp" style="width: 100%; display: flex;margin-top: 15px;">
                                                <span style="width: 80px;margin-top: 5px;"><span class="red">*</span>普通续费</span>
                                                <input style="width: 120px;margin-left: 15px;"  type="number"  min="0" placeholder="0元" class="form-control "ng-model="OrdinaryRenewal"  >
                                            </div>
                                            <div class="" style="width: 100%; display: flex;margin-top: 6px;">
                                                <div style="margin-left: 95px;color: #999;"><i class="glyphicon glyphicon-info-sign"></i>当其它卡到期时选择此卡的续费</div>
                                            </div>-->
                                        </div>
                                        <div style="width: 100%;" class="cardValidity123">
                                            <div style="width: 100%;" class="cardValidityBox">
                                                <div style="width: 100%; display: flex;margin-top: 15px;">
                                                    <span class="" style="width: 95px;margin-top: 5px;"><strong class="red" style="opacity: 0;">*</strong>有效期续费&emsp;</span>
                                                    <input  style="width: 115px;" name="cardValidityNum"  inputnum type="number" min="0" placeholder="0" class="form-control cp " >
                                                    <select  class="form-control cp cardValidityCompany" style="width: 70px;margin-left: 15px;" >
                                                        <option value="d" ng-selected="unit" >天</option>
                                                        <option value="m">月</option>
                                                        <option value="q">季</option>
                                                        <option value="y">年</option>
                                                    </select>
                                                    <input style="width: 115px;margin-left: 15px;" name="cardValidityMoney"   type="number" min="0" placeholder="0元" class="form-control cp " >
                                                </div>
                                                <div style="width: 100%; display: flex;margin-top: 10px;">
                                                    <div style="margin-left: 95px;color: #999;"><i class="glyphicon glyphicon-info-sign"></i>此卡到期时增加此卡有效期的续费</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 100px;margin-top: 20px;">
                                            <button style="margin-left: 95px;" id="addCardValidityBtn" class="btn btn-sm btn-default" ng-click="addCardValidityHtml()" venuehtml="" >添加有效期</button>
                                        </div>
                                    </form>
                                    <div>
<!--                                        <div class="hr"></div>-->
                                        <p class="text-left">
                                            <b>时间属性</b><br><br>
                                            <span>有效天数</span>
                                            <input ng-model="timeDuration" inputnum type="number" min="0" placeholder="多少" class="form-control margin_leftw disIb w135"  >
                                            <select ng-model="timeDurationUnit"  class="selectCss11" >
                                                <option value="" disabled>请选择</option>
                                                <option value="1" ng-selected="1">天</option>
                                                <option value="7">周</option>
                                                <option value="30">月</option>
                                                <option value="90">季</option>
                                                <option value="365">年</option>
                                            </select>
                                        </p>
<!--                                        <div class="hr"></div>-->
                                        <div class="text-left">
                                            <b>次数属性</b><br><br>
                                            <span>次数</span><input ng-model="times" inputnum type="number" min="0"  class="form-control w135 disIb mL72" placeholder="几次">
                                            <span class="margin_left">扣次方式</span>
                                            <select ng-model="countMethod"class="margin_lefts selectCss2">
                                                <option value="" >请选择扣次方式</option>
                                                <option value="1">按时效扣费</option>
                                                <option value="2">按计次扣次</option>
                                            </select>
                                            <span class="margin_left">有效天数</span>
                                            <input ng-model="timesDuration" inputnum type="number" min="0" placeholder="多少" class="form-control margin_lefts disIb w135" >
                                            <select ng-model="timesDurationUnit "  class="selectCss11">
                                                <option value="" disabled>请选择</option>
                                                <option value="1" ng-selected="1">天</option>
                                                <option value="7">周</option>
                                                <option value="30">月</option>
                                                <option value="90">季</option>
                                                <option value="365">年</option>
                                            </select>
                                        </div>
<!--                                        <div class="hr"></div>-->
                                        <div class="text-left">
                                            <b>充值属性</b><br><br>
                                            <span>充值金额</span>
                                            <input ng-model="rechargePrice"  ng-keyup="calculation(rechargePrice)" type="number" min="0" placeholder="0元" class="form-control margin_leftw disIb w95" >
                                            <span>赠送金额</span>
                                            <input ng-model="rechargeGivePrice"   ng-keyup="calculation()" type="number" min="0" placeholder="0元" class="form-control margin_left disIb w95 mL0" >
                                            <span class="margin_left">有效天数</span>
                                            <input ng-model="rechargeDuration"  inputnum type="number" min="0" placeholder="多少" class="form-control margin_leftw disIb w135" >
                                            <select ng-model="rechargeDurationUnit" class="selectCss11">
                                                <option value="" disabled>请选择</option>
                                                <option value="1" ng-selected="1">天</option>
                                                <option value="7">周</option>
                                                <option value="30">月</option>
                                                <option value="90">季</option>
                                                <option value="365">年</option>
                                            </select>
                                            <p class="mL96">
                                            总金额&nbsp;<span><b ng-bind="totalPrice">0</b></span>&nbsp;元
                                            </p>
                                        </p>
                                    </div>
                                </div>
                                <div class="mT15" >
                                    <h4>3.售卖场馆</h4>
                                    <form action="">
                                        <div id="sellVenue">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class=""><strong class="red">*</strong>选择场馆&emsp;&emsp;</span>
                                                    <select ng-if="venueStatus == true"   ng-model="$parent.venueId"  class="form-control cp">
                                                        <option value="">请选择场馆</option>
                                                        <option value="{{venue.id}}"  ng-repeat="venue in optionVenue"  ng-disabled="venue.id | attrVenue:venueHttp">{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="venueStatus == false" class="form-control cp">
                                                        <option value="">请选择场馆</option>
                                                        <option value="" disabled class="red">{{optionVenue}}</option>
                                                    </select>
                                                </div>
<!--                                                <div class="fl  w32">-->
<!--                                                    <span class=""><strong style="color: red;">*</strong>售卖张数&emsp;&emsp;</span>-->
<!--                                                    <input  name="sheets" type="number" inputnum min="0" placeholder="0张" class="form-control">-->
<!--                                                </div>-->
                                                <div class="fl  w32">
                                                    <span class=""><strong class="red">*</strong>售卖张数&emsp;&emsp;</span>
                                                    <div class="clearfix cp  inputUnlimited unDivBorder" >
                                                        <input  type="number" inputnum name="sheets" min="0" value="" placeholder="0张" class="fl form-control pT0 unDivBorderInput">
                                                        <div class="checkbox i-checks checkbox-inline t4 mT0">
                                                            <label>
                                                                <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fl  w32 input-daterange cp pRelative" >
                                                    <span class=""><strong class="red">*</strong>售卖日期</span>&emsp;&emsp;
                                                    <b><input type="text" id = 'datetimeStart' class="input-sm form-control datetimeStart dateCss" name="start" placeholder="起始日期"  style="margin-left: 0;" ></b>
                                                    <b><input  type="text" id="datetimeEnd" class="input-sm form-control datetimeEnd dateCss" name="end" placeholder="结束日期" ></b>
                                                </div>
                                                <div style="width: 100%;" class="fl discountLists">
                                                    <div class=" clearfix discountBox" style="width: 100%;">
                                                        <div class="fl  w32">
                                                            <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣&emsp;&emsp;&emsp;&emsp;</span>
                                                            <div class=" cp h32" style="margin-left: 15px;">
                                                                <input type="number"  name="discount" min="0" value="" placeholder="几折" class="mp0 fl form-control pT0 ">
                                                            </div>
                                                        </div>
                                                        <div class="fl  w32">
                                                            <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣价售卖数</span>
                                                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                                                <input type="number" inputnum name="discountNum" min="0" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
                                                                <div class="checkbox i-checks checkbox-inline t4 mT0" >
                                                                    <label>
                                                                        <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div  class="fl discountBtnBox" style="width: 100%;">
                                                    <div id="addDiscount" class="cardAddBtn btn btn-default" ng-click="addDiscountHtml()" venuehtml="" >添加折扣</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addSellVenue"  style="margin-left: 105px !important;" class="btn btn-default pRelative mT15 mL93" ng-click="addVenueHtml()" venuehtml="">添加场馆</div>
                                    </form>
                                </div>
                                <div class="mT60">
                                    <h4>4.通用场馆限制</h4>
                                    <form action="">
                                        <div id="venue">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">选择场馆&emsp;&emsp;</span>
                                                    <select ng-if="applyStauts == true" ng-change="selectApply(applyId)" ng-model="$parent.applyId" class="form-control cp">
                                                        <option value="" >请选择场馆</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionApply"
                                                            ng-disabled="venue.id | attrVenue:applyHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="applyStauts == false" class="form-control cp">
                                                        <option value="">请选择场馆</option>
                                                        <option value="" disabled class="red">{{optionApply}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32 month" >
                                                    <span class="">通店限制</span>
                                                    <div class="clearfix cp inputUnlimited unDivBorder " >
                                                        <input name="times"  inputnum type="number" min="0" style="width: 135px!important;" placeholder="通店次数" class="fl form-control wB100 mL0 borderNone w115">
                                                        <div class="checkbox i-checks checkbox-inline mT0 t4" >
                                                            <label>
                                                                <input style="width: 6px;" type="checkbox" value="-1"> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                    <select  class="form-control cp w70 mL16 " name="weeks">
                                                        <option value="w">周</option>
                                                        <option value="m">月</option>
                                                    </select>
                                                </div>
<!--                                                <div class="fl  w32 month2" >-->
<!--                                                    <span class="">每日通店限制</span>-->
<!--                                                    <div class="clearfix cp inputUnlimited unDivBorder " >-->
<!--                                                        <input name='weeks'   inputnum type="number" min="0" placeholder="通店次数" class="fl form-control wB100 mL0 borderNone w115">-->
<!--                                                        <div class="checkbox i-checks checkbox-inline mT0 t4" >-->
<!--                                                            <label>-->
<!--                                                                <input type="checkbox" value="-1"> <i></i> 不限</label>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                                <div class="fl  w32 times1" style="position: relative;">
                                                    <span class="">卡的等级&emsp;&emsp;</span>
                                                    <select  class="form-control cp">
                                                        <option value="1" >请选择等级</option>
                                                        <option value="1">普通</option>
                                                        <option value="2">VIP</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addVenue" ng-click="addApplyHtml()"  class="btn btn-default pRelative mT15 mL93" venuehtml="">添加场馆</div>
                                    </form>
                                </div>

                                <div class="mT60">
                                    <h4>5.进馆时间限制&nbsp;&nbsp;<span class="f12 color999"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;每月固定日和特定星期二选择一</span></h4>
                                    <div class="clearfix">
                                        <div  class="fl w300 mT15">
                                            <p  class="text-center mB10">每月固定日(选填)</p>
                                            <div class="borderE5">
                                                <div class=" w32 clearfix timeLength" >
                                                    <span class="fl">特定时间段</span>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" >
                                                        <input name="dayStart" ng-change="setDayTime()" ng-model="dayStart" type="text" class="input-sm form-control text-center timeCss"  placeholder="起始时间" >
                                                    </div>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" >
                                                        <input name="dayEnd" ng-change="setDayTime()" ng-model="dayEnd" type="text" class="input-sm form-control text-center timeCss"  placeholder="结束时间" >
                                                    </div>
                                                </div>
                                                <table id="table" class="cp mL50" >
                                                    <tr>
                                                        <td colspan="2"   class="tdActive op0 borderNone"></td>
                                                        <td>1</td>
                                                        <td>2</td>

                                                        <td>3</td>
                                                        <td>4</td>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>7</td>
                                                        <td>8</td>
                                                        <td>9</td>
                                                        <td>10</td>
                                                        <td>11</td>
                                                        <td>12</td>
                                                    </tr>
                                                    <tr>
                                                        <td>13</td>
                                                        <td>14</td>
                                                        <td>15</td>
                                                        <td>16</td>
                                                        <td>17</td>
                                                        <td>18</td>
                                                        <td>19</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20</td>
                                                        <td>21</td>
                                                        <td>22</td>
                                                        <td>23</td>
                                                        <td>24</td>
                                                        <td>25</td>
                                                        <td>26</td>
                                                    </tr>
                                                    <tr>
                                                        <td>27</td>
                                                        <td>28</td>
                                                        <td>29</td>
                                                        <td>30</td>
                                                        <td>31</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="fl mT15 mL30">
                                            <p>特定星期选择</p>
                                            <ul class=" weekSelect" >
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="1"> <i></i> 星期一
                                                        </label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="2"> <i></i> 星期二</label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="3"> <i></i> 星期三</label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week" >
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="4"> <i></i> 星期四</label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="5"> <i></i> 星期五</label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="6"> <i></i> 星期六</label>
                                                    </div>
                                                    <div class="weekTime"></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                                <li class="" >
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="7" > <i></i> 星期日</label>
                                                    </div>
                                                    <div class="weekTime "></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                            </ul>
<!--                                            <div style="margin-top:30px;">-->
<!--                                                <p>填写卡的特定时间</p>-->
<!--                                                <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 10px;">-->
<!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                        <input ng-model="start" type="text" class="input-sm form-control text-center"  placeholder="起始时间" style="width: 100%;border-radius: 3px;">-->
<!--                                                    </div>-->
<!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                        <input ng-model="end" type="text" class="input-sm form-control text-center"  placeholder="结束时间" style="width: 100%;border-radius: 3px;margin-left: 15px;">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>                                    </div>
                                </div>
                            </main>
                        </section>
                        <h3>第二步</h3>
                        <section>
                            <div  class="fw wB100 text-center"><h2>绑定套餐</h2></div>
                            <main class="con1 wB100 mB20 mL20p"  >
                                <div>
                                    <h4>1.绑定团课课程</h4>
                                    <form action="">
                                        <div class="course" id="course">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">课程名称&emsp;</span>
                                                    <select ng-if="classStatus == true" ng-change="selectClass(classKey)" ng-model="$parent.classKey" class="form-control cp">
                                                        <option value="" >请选择课程</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionClass"
                                                            ng-disabled="venue.id | attrVenue:classHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="classStatus == false" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">{{optionClass}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">每日节数&emsp;</span>
                                                    <div class="clearfix cp inputUnlimited unDivBorder" >
                                                        <input name="times"  inputnum type="number" min="0" placeholder="0节" class="fl form-control unDivBorderInput">
                                                        <div class="checkbox i-checks checkbox-inline t4 mT0" >
                                                            <label>
                                                                <input type="checkbox" value="-1"> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addCourse" ng-click="addClassHtml()"  class="mT15 mL93 btn btn-default addCourse " venuehtml="">添加课程</div>
                                    </form>
                                </div>
                                <!-- 绑定私课-->
                                <div>
                                    <h4>2.绑定私教课程</h4>
                                    <form >
                                        <div class="course"  id="pTcourse">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">HS课程 &emsp;</span>
                                                    <select ng-if="GiveCourseFlag == true"  style="margin-left: 20px;" id="HSClass" class="form-control cp "  ng-change="selectHsPTClass()" ng-model="HSClass">
                                                        <option value=""  >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select ng-if="GiveCourseFlag == false" style="margin-left: 20px;" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">&emsp;HS节数&emsp;</span>
                                                    <div class=" cp h32 "  >
                                                        <input type="number" style="margin-left: 20px;" inputnum min="0" name="HSNum" ng-model="HSClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="fl  w32 pRelative" style="margin-top: 0;">
                                                        <span class="w80">&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div style="margin-left: 15px;">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">PT课程 </span>
                                                    <select style="margin-left: 20px;"  ng-if="GiveCourseFlag == true"  id="PTClass" class="form-control cp "  ng-change="selectHsPTClass()" ng-model="PTClass">
                                                        <option value="" >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select style="margin-left: 20px;" ng-if="GiveCourseFlag == false" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">&emsp;PT节数&emsp;</span>
                                                    <div class=" cp h32 "  >
                                                        <input style="margin-left: 20px;" type="number" inputnum min="0" name="PTNum" ng-model="PTClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="fl  w32 pRelative" style="margin-top: 0;">
                                                        <span class="w80">&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div style="margin-left: 15px;">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">生日课</span>
                                                    <select ng-if="GiveCourseFlag == true"  class="form-control cp " id="BirthdayClass"  ng-change="BirthdayClassSelect()" ng-model="BirthdayClass">
                                                        <option value="" >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select ng-if="GiveCourseFlag == false" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">&emsp;生日课节数</span>
                                                    <div class=" cp h32 "  >
                                                        <input type="number" inputnum min="0" name="birthClass" id="birthClassNum" ng-model="birthClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="clearfix   pRelative" style="margin-top: 0;width: 100%;">
                                                        <span class="w80 fl">&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div class="fl" style="margin-left: 15px;">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">每年生日都会赠送，仅生日当月有效</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!-- 绑定私课End-->
                                <div class="mT15"  ng-show="serverShow">
                                    <h4>3.绑定服务</h4>
                                    <form action="">
                                        <div class="serve" id="server">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">服务名称</span>
                                                    <select ng-if="serverStatus == true" ng-change="selectServer(serverKey)" ng-model="$parent.serverKey" class="form-control cp">
                                                        <option value="" >请选择服务</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionServer"
                                                            ng-disabled="venue.id | attrVenue:serverHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="serverStatus == false" class="form-control cp">
                                                        <option value="">请选择服务</option>
                                                        <option value="" disabled class="red">{{optionServer}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">每日数量</span>
                                                    <div class="clearfix cp inputUnlimited unDivBorder" >
                                                        <input  name="times"  inputnum type="number" min="0" placeholder="0" class="unDivBorderInput fl form-control">
                                                        <div class="checkbox i-checks checkbox-inline t4 mT0" >
                                                            <label>
                                                                <input type="checkbox" value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addServer" ng-click="addServerHtml()"  class="mT15 mL93 btn btn-default addServe" venuehtml="">添加服务</div>
                                    </form>
                                </div>
                                <div class="mT15"  ng-show="shopShow">
                                    <h4>4.扣费项目</h4>
                                    <form action="">
                                        <div class="shopping" id="shopping">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">商品名称</span>
                                                    <select style="margin-left: 0px;" ng-if="shopStatus == true" ng-change="selectShop(shopKey)" ng-model="$parent.shopKey" class="form-control cp">
                                                        <option value="" >请选择商品</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionShop"
                                                            ng-disabled="venue.id | attrVenue:shopHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="shopStatus == false" class="form-control cp">
                                                        <option value="">请选择商品</option>
                                                        <option value="" disabled class="red">{{optionShop}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">&emsp;商品数量</span>
                                                    <div class="clearfix cp inputUnlimited unDivBorder">
                                                        <input name="times"   type="number" min="0" placeholder="0" class="fl form-control unDivBorderInput">
                                                        <div class="checkbox i-checks checkbox-inline t4 mT0" >
                                                            <label>
                                                                <input style="width: 6px;" type="checkbox" value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fl mT26 mlF80"><span class="glyphicon glyphicon-yen"><b class="f18">0</b></span> 总金额</div>
                                            </div>
                                        </div>
                                        <div id="addShop" ng-click="addShopHtml()"  class="mT15 mL93 btn btn-default addShop" venuehtml="">添加商品</div>
                                    </form>
                                </div>
                                <div class="mT15" ng-show="donationShow">
                                    <h4>5.赠品</h4>
                                    <form action="">
                                        <div class="donation" id="donation">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="w80">赠品名称</span>
                                                    <select  ng-if="donationStatus == true" ng-change="selectDonation(donationKey)" ng-model="$parent.donationKey" class="form-control cp">
                                                        <option value="" >请选择赠品</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionDonation"
                                                            ng-disabled="venue.id | attrVenue:DonationHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="donationStatus == false" class="form-control cp">
                                                        <option value="">请选择赠品</option>
                                                        <option value="" disabled class="red">{{optionDonation}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="w80">商品数量</span>
                                                    <div class="clearfix cp inputUnlimited unDivBorder" >
                                                        <input name="times"  inputnum type="number" min="0" placeholder="0" class="fl form-control unDivBorderInput">
                                                        <div class="checkbox i-checks checkbox-inline t4 mT0" >
                                                            <label>
                                                                <input type="checkbox" value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="addDonation" ng-click="addDonationHtml()"  class=" mT15 mL93 btn btn-default addDonation" venuehtml="">添加商品</div>
                                    </form>
                                </div>
                            </main>
                        </section>
                        <h3>第三步</h3>
                        <section>
                            <div  class="fw wB100 text-center"><h2>转让请假设置</h2></div>
                            <main class="con1 wB100 mB15 mL20p"  >
                                <div>
                                    <h4>1.转让设置</h4>
                                    <form >
                                        <div class="clearfix" >
                                            <div class="fl  w32">
                                                <span class="">转让次数&emsp;&emsp;</span>
                                                <input ng-model="transferNumber" type="number" checknum min="0" placeholder="0次" class="form-control">
                                            </div>
                                            <div class="fl  w32">
                                                <span class="">转让金额&emsp;&emsp;</span>
                                                <input ng-model="transferPrice" type="number"  min="0" placeholder="0元" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mT15">
                                    <h4>2.请假设置</h4>
                                    <form action="">
                                        <div class="clearfix" >
                                            <div class="fl  w32">
                                                <span class="">请假总天数&emsp;</span>
                                                <input ng-model="leaveTotalDays" type="number" id="leaveTotalDays" ng-disabled="leaveDaysFlag" ng-change="setLeaveNumDisabled()" checknum min="0" placeholder="0次" class="form-control">
                                            </div>
                                            <div class="fl  w32">
                                                <span class="">最少请假天数</span>
                                                <input ng-model="leastLeaveDays" type="number" id="leastLeaveDays" ng-disabled="leaveDaysFlag" ng-change="setLeaveNumDisabled()" checknum min="0" placeholder="0天" class="form-control">
                                            </div>
                                        </div>
                                        <hr class="mT15 wB60">
                                        <div class="leaveDay" id="leaveDay">
                                            <div class="clearfix">
                                                <div class="fl  w32">
                                                    <span class="">请假次数&emsp;&emsp;</span>
                                                    <input name="times" type="number" min="0"  ng-disabled="leaveNumsFlag" ng-model="leaveNums"  ng-change="setLeaveDaysDisabled()" checknum placeholder="0次" class="form-control">
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">每次请假天数</span>
                                                    <input name="days" type="number" min="0" ng-disabled="leaveNumsFlag" ng-model="everyLeaveDays"   ng-change="setLeaveDaysDisabled()" checknum placeholder="0天" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button  ng-disabled="leaveNumsFlag"  id="addLeave" ng-click="addLeaveHtml()" class="btn btn-default addLeave mT15 mL93" venuehtml>添加请假</button>
                                    </form>
                                </div>
                            </main>
                        </section>
                        <h3>第四步</h3>
                        <section>
                            <div  class="fw wB100 text-center"><h1>合同</h1></div>
                            <main class="con1">
                                <div class="wB80 m0Auto">
                                    <div class="clearfix wB20 text-center m0Auto" >
                                        <span class="fl mT20 mB5" ><strong class="red">*</strong>请选择合同</span><br>
                                        <select ng-model="$parent.dealId" ng-change="getDealId(dealId)" class=" fl form-control cp w200" style="border-color: rgb(207,218,221);">
                                            <option value="" >请选择合同</option>
                                            <option
                                                value="{{deal.id}}"
                                                ng-repeat="deal in dealData track by $index"
                                            >{{deal.name}}</option>
                                        </select>
<!--                                        <select ng-if="dealStauts == false" class=" fl form-control cp" style="border-color: rgb(207,218,221);width: 200px; ">-->
<!--                                            <option value="" >请选择合同</option>-->
<!--                                            <option value="" disabled style="color:red;">{{dealData}}</option>-->
<!--                                        </select>-->
                                    </div>
                                    <ul id="bargainContent" class="wB100 m30Auto minH100">
                                        <li class="contract1">
                                            <h3 class="mB15 text-center">{{dataDeal.name}}</h3>
                                            <span class="heTong" ng-bind-html="dataDeal.intro | to_Html"></span>
                                        </li>
                                    </ul>

                                </div>
                            </main>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div  class="modal fade mT20 zIndex11" id="myModals8" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog w360" >
        <div  class="modal-content mB20">
            <div  class="modal-header borderNone">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h5 class="text-center f20 mB20 mT20">时间修改</h5>

                <form>
                    <div class="form-group mT10">
                        <div class=" input-daterange cp timeModalCss"  >
                            <div class="input-group clockpicker wB45 zIndex11" data-autoclose="true" >
                                <input type="text" id="weekStart" class="input-sm form-control text-center timeCss"  placeholder="起始时间" style="width: 100%;border-radius: 3px;">
                            </div>
                            <div class="input-group clockpicker wB45 zIndex11" data-autoclose="true"  >
                                <input type="text" id="weekEnd" class="input-sm form-control text-center timeCss"  placeholder="结束时间" >
                            </div>
                        </div>
                </form>

                <div  data-toggle="modal" data-target="#myModals8" class="btn mT30 btn-primary cancelTime">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</div>
                <div  data-toggle="modal" data-target="#myModals8" class="btn mT30 btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</div>
            </div>
        </div>
    </div>
   