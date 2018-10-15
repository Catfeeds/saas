<?php

use backend\assets\newTimeCardAsset;
newTimeCardAsset::register($this);
$this->title = '时间卡';
?>
<style>
    .discountBtnBox{
        margin-left: 100px;margin-top: 10px;
    }
    .discountL15{
        margin-left: 0px !important;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight" ng-controller="timeCardController">
    <div class="row">
        <div class="col-sm-12" style="overflow: auto;">
            <div class="ibox float-e-margins" style="min-width: 1240px;">
                <div class="ibox-title">
                    <h5>时间卡表单向导</h5>
                </div>
                <div class="ibox-content">
                    <div id="example-async">
                        <h3>第一步</h3>
                        <section >
                            <!--属性内容-->
                            <div  class="fw text-center"><h2>时间卡属性</h2></div>
                            <main class="con1 wB100 m0Auto20"  >
                                <div>
                                    <h4>1.卡的属性</h4>
                                    <form action="">
                                        <input  id="_csrf" type="hidden"
                                               name="<?= \Yii::$app->request->csrfParam; ?>"
                                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                                        <div class="clearfix" >
                                            <div class="fl  w32 " >
                                                <span class=""><strong class="red">*</strong>卡种所属场馆</span>
                                                <select  class="form-control cp cardTheVenueDefault"  ng-change="cardTheVenue(cardTheVenueId)" ng-model="cardTheVenueId">
                                                    <option value="" >请选择场馆</option>
                                                    <option ng-if="cardTheVenueListsFlag" value="{{venue.id}}"data-type="{{venue.identity}}"
                                                            ng-repeat=" venue in cardTheVenueLists"
                                                    >{{venue.name}}</option>
                                                    <option ng-if="cardTheVenueListsFlag == false" style="color: red;" disabled>暂无数据</option>
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class="w80"><strong class="red">*</strong>卡的属性&emsp;</span>
<!--                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >-->
                                                <select ng-model="$parent.attributes" class="form-control cp"  >
                                                    <option value="">请选择属性</option>
<!--                                                    <option value="{{attr.key}}" ng-repeat="attr in attributesVal">{{attr.val}}</option>-->
                                                    <option value="1">个人</option>
                                                    <option value="2">家庭</option>
                                                    <option value="3">公司</option>
                                                </select>
<!--                                                <select ng-if="attributesStatus == false" class="form-control cp">-->
<!--                                                    <option value="">请选择属性</option>-->
<!--                                                    <option value="" disabled class="red">{{attributesVal}}</option>-->
<!--                                                </select>-->
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
<!--                                                    <option value="5">VIP</option>-->
                                                </select>
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red">*</strong>卡的名称&emsp;&emsp;</span>
                                                <input type="text" placeholder="至尊卡" class="form-control cp w180"
                                                 ng-blur="setCardName()"   ng-change="setCardName()"    ng-model="cardName" >
                                           </div>
                                            <div class="fl  w32">
                                                <span  class="w80" ><span style="opacity: 0;">*</span>&emsp;卡别名</span>
                                                <input type="text" placeholder="英文名称" class="form-control cp w180"
                                                       ng-model="anotherName" >
                                            </div>
                                            <div class="fl  w32">
                                                <span class=""><strong class="red">*</strong>激活期限&emsp;&emsp;</span>
                                                <input   type="number" inputnum   name="num" min="0" placeholder="多少天" class="form-control w115 cp" ng-model="activeTime">
                                                <select  class="form-control cp w70" ng-model="activeUnit" >
                                                    <option value="1" ng-selected="unit"  >天</option>
                                                    <option value="7">周</option>
                                                    <option value="30">月</option>
                                                    <option value="90">季</option>
                                                    <option value="365">年</option>
                                                </select>
                                            </div>

                                            <div class="fl  w32">
                                                <span class=""><strong class="red">*</strong>有效天数&emsp;&emsp;</span>
                                                <input   inputnum type="number" min="0" placeholder="多少天" class="form-control cp w115" ng-model="duration">
                                                <select  class="form-control cp w70" ng-model="durationUnit"  >
                                                    <option value="1" ng-selected="unit" >天</option>
                                                    <option value="7">周</option>
                                                    <option value="30">月</option>
                                                    <option value="90">季</option>
                                                    <option value="365">年</option>
                                                </select>
                                            </div>

                                            <div class="fl  w32">
                                                <span  class="w80" >&emsp;&emsp;<strong class="red"></strong>单数</span>
                                                <input id="Singular" type="number"  ng-model="Singular" inputnum min="0" placeholder="请输入单数" class="form-control cp w180">
                                            </div>
                                            <div class="fl  w32">
                                                <span  class="w80" style="line-height: 1;">带人卡</span>
                                                <input  type="radio" ng-click="withoutHuman()" name="bring" id="bring-false" value="0" style="width: 65px;margin-left: -5px;" checked="checked"/>
                                                <span style="width: 55px;margin-left: -20px;line-height: 11px;">不带人</span>
                                                <input type="radio" ng-click="withPeople()" name="bring" id="bring-true" value="1"  style="width: 65px;margin-left: -35px;"/>
                                                <span style="line-height: 11px;margin-left: -17px;">带人</span>
                                                <input ng-model="bring" ng-change="withPeopleNum(bring)" inputnum type="number" id="bring-num" name="bring-name"  min="1" max="5" style="width:70px" disabled />
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
                                    <h4>2.定价和售卖&nbsp;&nbsp;<span class="f12 color999" ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;一口价和区域定价二选一</span></h4>
                                    <form >
                                        <div class="w100 cp">
                                            <span ><strong class="red">*</strong>一口价&emsp;&emsp;</span>
                                            <input id="areaMinPrice1"   type="number"   min="0"  placeholder="原价0元" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" class="form-control w125" ng-model="originalPrice">
                                            <input id="areaMinPrice2" type="number"  min="0"  placeholder="售价0元" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" class="form-control w125" ng-model="sellPrice" >
                                        </div>
                                        <div class="w100  cp">
                                            <span ><strong class="red">*</strong>区域定价&emsp;</span>
                                            <input id="areaMinPrice1s"  type="number" inputnum  min="0" placeholder="最低价0元" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control w125" ng-model="areaMinPrice" >
                                            <input id="areaMinPrice2s"  type="number" inputnum  min="0" placeholder="最高价0元" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control w125" ng-model="areaMaxPrice">
                                        </div>
<!--                                        <div class="w100  cp">-->
<!--                                            <span >续费价&emsp;</span>-->
<!--                                            <input   type="number" checknum  min="0" placeholder="续费价0元" class="form-control w125"ng-model="renewPrice"  >-->
<!--                                            <select  class="form-control cp w70 mL16" ng-model="renewUnit"  >-->
<!--                                                <option value="30">月</option>-->
<!--                                                <option value="90">季</option>-->
<!--                                                <option value="365">年</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
                                        <div class="w100 cp">
                                            <span >优惠价&emsp;</span>
                                            <input type="number" inputnum min="0" placeholder="0元" class="form-control w125"ng-model="offerPrice">
                                        </div>
                                        <div class="w100 cp" style="border-bottom: solid 1px #999;padding-bottom: 10px;">
                                            <span >移动端售价&emsp;</span>
                                            <input type="number" inputnum min="0" placeholder="0元" class="form-control w125"ng-model="appSellPrice">
                                        </div>
                                        <div style="width: 100%;">
                                           <!-- <div class="  cp" style="width: 100%; display: flex;margin-top: 15px;">
                                                <span style="width: 80px;margin-top: 5px;"><span class="red">*</span>普通续费</span>
                                                <input style="width: 120px;margin-left: 15px;"  type="number" inputnum min="0" placeholder="0元" id="OrdinaryRenewal" class="form-control "ng-model="OrdinaryRenewal"  >
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
                                                    <input style="width: 115px;margin-left: 15px;" name="cardValidityMoney"   type="number" inputnum min="0" placeholder="0元" class="form-control cp " >
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
                                </div>
                                <div class="mT15">
                                    <h4>3.售卖场馆</h4>
                                    <form action="">
                                        <div id="sellVenue">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class=""><strong class="red">*</strong>选择场馆&emsp;&emsp;</span>
                                                    <select ng-if="venueStatus == true" class="form-control cp"  ng-change="selectVenue(venueId)" ng-model="$parent.venueId">
                                                        <option value="" >请选择场馆</option>
                                                        <option value="{{venue.id}}"
                                                                ng-repeat=" venue in optionVenue"
                                                                ng-disabled="venue.id | attrVenue:venueHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="venueStatus == false" class="form-control cp">
                                                        <option value="">请选择场馆</option>
                                                        <option value="" disabled class="red">{{optionVenue}}</option>
                                                    </select>
                                                </div>
<!--                                                <div class="fl  w32">-->
<!--                                                    <span class=""><strong style="color: red;">*</strong>售卖张数&emsp;&emsp;</span>-->
<!--                                                    <input type="number" inputnum name="sheets" min="0" placeholder="0张" class="form-control">-->
<!--                                                </div>-->
                                                <div class="fl  w32">
                                                    <span class=""><strong class="red">*</strong>售卖张数&emsp;&emsp;</span>
                                                    <div class="clearfix cp h32 inputUnlimited unlimitedDivOne" >
                                                        <input  type="number" inputnum name="sheets" min="0" value="" placeholder="0张" class="fl form-control pT0 unlimitedInputOne">
                                                        <div class="checkbox i-checks checkbox-inline t4" >
                                                            <label>
                                                                <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fl  w32 input-daterange cp pRelative" >
                                                    <span class=""><strong class="red">*</strong>售卖日期&emsp;&emsp;</span>
                                                    <b><input type="text" id = 'datetimeStart' class="input-sm form-control datetimeStart dateCss" name="start" placeholder="起始日期" autocomplete="off" style="margin-left: 0;" ></b>
                                                    <b><input type="text" id="datetimeEnd" class="input-sm form-control datetimeEnd dateCss" name="end" autocomplete="off" placeholder="结束日期" ></b>
                                                </div>
                                                <div style="width: 100%;" class="fl discountLists">
                                                    <div class=" clearfix discountBox" style="width: 100%;">
                                                        <div class="fl  w32">
                                                            <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣&emsp;&emsp;&emsp;&emsp;</span>
                                                            <div class=" cp h32" >
                                                                <input type="number"  name="discount" inputnum min="0" value="" placeholder="几折" class="mp0 fl form-control pT0 ">
                                                            </div>
                                                        </div>
                                                        <div class="fl  w32">
                                                            <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣价售卖数</span>
                                                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                                                <input type="number" inputnum name="discountNum" min="1" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
                                                                <div class="checkbox i-checks checkbox-inline t4" >
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
                                        <div id="addSellVenue" ng-click="addVenueHtml()"  class="btn btn-default" venuehtml>添加场馆</div>
                                    </form>
                                </div>

                                <div class="mT60">
                                    <h4>4.通用场馆限制<span class="f12 color999" ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;本场馆通店次数需要单独设置, <span >信息不填写完整不会保存</span></span></h4>
                                    <form action="">
                                        <div id="venue">
                                            <div class="clearfix" >
                                                <div class="fl mT30  w32 applyVenueType" >
                                                    <span class=""><strong class="red">*</strong>场馆类型&emsp;&emsp;</span>
                                                    <select class="form-control cp" id="applyTypeDefaultSelect" ng-change="selectApplyVenueTypeOne(applyType,cardTheVenueId)"  ng-model="applyType"  name='applyVenueType'>
                                                        <option ng-selected="applyTypeDefaultSelectFlag == '' || applyTypeDefaultSelectFlag == undefined" value="">场馆类型</option>
                                                        <option ng-selected="applyTypeDefaultSelectFlag == 1" value="1">普通</option>
                                                        <option ng-selected="applyTypeDefaultSelectFlag == 2" value="2">尊爵</option>
                                                    </select>
                                                </div>
                                                <div class="fl mT30  w32 pRelative" ng-click="selectApplyClick123($parent.applyId)">
                                                    <span class=""><strong class="red">*</strong>选择场馆&emsp;&emsp;</span>
                                                    <select  autocomplete="off"     ng-change="selectApply(applyId)" id="selectApplyOne"  multiple="multiple" ng-model="$parent.applyId"   class="form-control cp applySelectVenue js-example-basic-multiple">
                                                        <option value="{{venue.id}}"
                                                                ng-if="applyType == 1"
                                                                ng-repeat=" venue in applyTypeVenueLists1"
                                                                ng-disabled="venue.id | attrVenue:generalVenuesNoRepeat"
                                                        >{{venue.name}}</option>
                                                        <option value="{{venue.id}}"
                                                                ng-if="applyType == 2"
                                                                ng-repeat=" venue in applyTypeVenueLists2"
                                                                ng-disabled="venue.id | attrVenue:extrawellVenuesNoRepeat"
                                                        >{{venue.name}}</option>
                                                    </select>
<!--                                                    <select ng-if="applyStauts == false" class="form-control cp">-->
<!--                                                        <option value="">请选择场馆</option>-->
<!--                                                        <option value="" disabled class="red">{{optionApply}}</option>-->
<!--                                                    </select>-->
                                                </div>
                                                <div class="fl mT30  w32 month">
                                                    <span class=""><strong class="red">*</strong>通店限制</span>
                                                    <div class="clearfix cp h32 inputUnlimited" style="">
                                                        <input type="number" inputnum min="0" value="" placeholder="通店次数" name='times' class="fl form-control pT0">
                                                        <div class="checkbox i-checks checkbox-inline t4" >
                                                            <label>
                                                                <input style="width: 6px;" type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                    <select class="form-control cp w70 mL16" name="weeks">
                                                        <option value="w">周</option>
                                                        <option value="m">月</option>
                                                    </select>
                                                </div>
                                                <div class="fl mT30 w32 input-daterange cp pRelative" >
                                                    <span class="">进馆时间&emsp;&emsp;</span>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                                        <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" autocomplete="off" placeholder="起始时间">
                                                    </div>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
                                                        <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" autocomplete="off"  placeholder="结束时间">
                                                    </div>
                                                </div>
<!--                                                <div class="fl  w32 month2">-->
<!--                                                    <span class="">每周通店限制</span>-->
<!--                                                    <div class="clearfix cp h32 inputUnlimited openShopWeek" >-->
<!--                                                        <input   type="number" inputnum min="0" value="" placeholder="通店次数"  name='weeks'   class="fl form-control pT0">-->
<!--                                                        <div class="checkbox i-checks checkbox-inline t4" >-->
<!--                                                            <label>-->
<!--                                                                <input type="checkbox" value="" name="limit"> <i></i> 不限</label>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                                <div class="fl mT30 w32 times1">
                                                    <span class=""><strong class="red">*</strong>卡的等级&emsp;&emsp;</span>
                                                    <select class="form-control cp" name='times1' style="margin-left: 0px;">
<!--                                                        <option value="1">请选择等级</option>-->
                                                        <option value="1">普通卡</option>
                                                        <option value="2">VIP卡</option>
                                                    </select>
                                                </div>
                                                <div class="fl mT30 about">
                                                    <div class="checkbox i-checks checkbox-inline t4">
                                                        <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addVenue" ng-click="addApplyHtml()"  class="btn btn-default pRelative mL100T15" venuehtml>添加场馆</div>
                                    </form>
                                </div>
                                <div class="mTB60">
                                    <h4>5.进馆时间限制&nbsp;&nbsp;<span  class="f12 color999"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;每月固定日和特定星期二选择一</span></h4>
                                    <div class="clearfix">
                                        <div  class="fl w300 mT15">
                                            <p class="text-center mB10">每月固定日(选填)</p>
                                            <div class="border1">
                                                <div class=" w32 clearfix pRelative w250 mT20B10" >
                                                    <span class="fl">特定时间段</span>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" >
                                                        <input name="dayStart" ng-model="dayStart" ng-change="setDayTime()" type="text" class="input-sm form-control text-center borderRadius3 wB100" autocomplete="off"  placeholder="起始时间" >
                                                    </div>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" >
                                                        <input name="dayEnd" ng-model="dayEnd" ng-change="setDayTime()" type="text" class="input-sm form-control text-center borderRadius3 wB100"  autocomplete="off" placeholder="结束时间" >
                                                    </div>
                                                </div>
                                                <table id="table" class="cp">
                                                    <tr>
                                                        <td colspan="2"  class="tdActive null"></td>
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
                                        <div class="fl mT15 mL30" >
                                            <p>特定星期选择</p>
                                            <ul class=" weekSelect">
                                                <li class="">
                                                    <div class="checkbox i-checks checkbox-inline week">
                                                        <label>
                                                            <input name="weeksTime" type="checkbox" value="1"> <i></i> 星期一</label>
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
                                                            <input name="weeksTime" type="checkbox" value="7"> <i></i> 星期日</label>
                                                    </div>
                                                    <div class="weekTime "></div>
                                                    <button class="btn btn-default btn-sm addTime disNone" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                </li>
                                            </ul>
<!--                                            <div style="margin-top:30px;">-->
<!--                                                <p>填写卡的特定时间</p>-->
<!--                                                <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 10px;">-->
<!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                        <input type="text" class="input-sm form-control text-center" ng-blur="blur()" placeholder="起始时间" style="width: 100%;border-radius: 3px;" ng-model="start">-->
<!--                                                    </div>-->
<!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                        <input type="text" class="input-sm form-control text-center"  placeholder="结束时间" style="width: 100%;border-radius: 3px;margin-left: 15px;" ng-model="end">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </main>
                        </section>
                        <h3>第二步</h3>
                        <section>
                            <div  class="fw text-center"><h2>绑定套餐</h2></div>
                            <main class="con1 wB100 bindingCombo secondSteps">
                                <div>
                                    <h4>1.绑定团课课程</h4>
                                    <form >
                                        <div class="course"  id="course">
                                            <div class="clearfix leagueCourseList123" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">课程名称&emsp;&emsp;</span>
                                                    <select  multiple="multiple" name="leagueCourseList" class="form-control leagueCourseList cp js-example-basic-multiple"  ng-change="selectClass(classKey)" ng-model="$parent.classKey" style="margin-left: 15px;max-height: 60px !important;overflow-y: scroll; ">
<!--                                                        <option value="" >请选择课程</option>-->
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionClass"
                                                            ng-disabled="venue.id | attrVenue:classArr1234"
                                                        >{{venue.name}}</option>
                                                    </select>
<!--                                                    <select ng-if="classStatus == false" class="form-control cp">-->
<!--                                                        <option value="">请选择课程</option>-->
<!--                                                        <option value="" disabled class="red">{{optionClass}}</option>-->
<!--                                                    </select>-->
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">每日节数&emsp;&emsp;</span>
                                                    <div class="clearfix cp h32 inputUnlimited border1 mL15"  >
                                                        <input type="number" inputnum min="0" name="times"  placeholder="0节" class="fl form-control pT0 w100 borderNone mL0 mT0">
                                                        <div class="checkbox i-checks checkbox-inline t4" >
                                                            <label>
                                                                <input type="checkbox" value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="addCourse" style="margin-top: 40px;" ng-click="addClassHtml()" class="btn btn-default addCourse" venuehtml>添加课程</div>
                                    </form>
                                </div>
                                <!-- 绑定私课-->
                                <div>
                                    <h4>2.绑定私教课程</h4>
                                    <form >
                                        <div class="course"  id="pTcourse">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">HS课程&emsp; &emsp;</span>
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
                                                    <span class="">HS节数&emsp;&emsp;</span>
                                                    <div class=" cp h32 "  >
                                                        <input type="number" style="margin-left: 20px;" inputnum min="0" name="HSNum" ng-model="HSClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="fl  w32 pRelative" style="margin-top: 0;">
                                                        <span class="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div style="">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">PT课程&emsp; &emsp;</span>
                                                    <select style="margin-left: 20px;"  ng-if="GiveCourseFlag == true"  id="PTClass" class="form-control cp "  ng-change="selectPTClass()" ng-model="PTClass">
                                                        <option value="" >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select style="margin-left: 20px;" ng-if="GiveCourseFlag == false" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">PT节数&emsp;&emsp;</span>
                                                    <div class=" cp h32 "  >
                                                        <input style="margin-left: 20px;" type="number" inputnum min="0" name="PTNum" ng-model="PTClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="fl  w32 pRelative" style="margin-top: 0;">
                                                        <span class="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div style="">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">生日课&emsp;&emsp;&emsp;</span>
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
                                                    <span class="">生日课节数&emsp;</span>
                                                    <div class=" cp h32 "  >
                                                        <input type="number" inputnum min="0" name="birthClass" id="birthClassNum" ng-model="birthClassNum"  placeholder="0节" class="fl form-control pT0 w100  mL0 mT0">
                                                    </div>
                                                </div>
                                                <div class="fl " style="width: 100%;">
                                                    <div class="fl  w32 pRelative" style="margin-top: 0;">
                                                        <span class="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                                                        <div style="">
                                                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign">每年生日都会赠送，仅生日当月有效</i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!-- 绑定私课End-->
                                <div class="mT15"   ng-show="myService">
                                    <h4>3.绑定服务</h4>
                                    <form >
                                        <div class="serve"  id="server">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative">
                                                    <span class="">服务名称&emsp;&emsp;</span>
                                                    <select ng-if="serverStatus == true" class="form-control cp"  ng-change="selectServer(serverKey)" ng-model="$parent.serverKey" >
                                                        <option value="" >请选择服务</option>
                                                        <option value="{{server.id}}"
                                                                ng-repeat="server in optionServer"
                                                                ng-disabled="venue.id | attrVenue:serverHttp"
                                                        >{{server.name}}</option>
                                                    </select>
                                                    <select ng-if="serverStatus == false" class="form-control cp">
                                                        <option value="">请选择服务</option>
                                                        <option value="" disabled class="red">{{optionServer}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">每日数量&emsp;&emsp;</span>
                                                    <div class="clearfix cp h32 inputUnlimited mL15 border1" >
                                                        <input   type="number" inputnum min="0" name="times" placeholder="0" class="fl form-control pT0">
                                                        <div class="checkbox i-checks checkbox-inline t4" >
                                                            <label>
                                                                <input type="checkbox"  value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="addServer" ng-click="addServerHtml()" class="btn btn-default addServe addBtn" venuehtml>添加服务</div>
                                    </form>
                                </div>
<!--                          -->

                                <div class="mT15"   ng-show="myDonation">
                                    <h4>4.赠品</h4>
                                    <form >
                                        <div class="donation "  id="donation">
                                            <div class="clearfix" >
                                                <div class="fl  w32 pRelative" >
                                                    <span class="">赠品名称&emsp;&emsp;</span>
                                                    <select ng-show="donationStatus" class="form-control cp"  ng-change="selectDonation(donationKey)" ng-model="$parent.donationKey" >
                                                        <option value="" >请选择赠品</option>
                                                        <option value="{{donation.id}}"
                                                                ng-repeat="donation in optionDonation"
                                                                ng-disabled="donation.id | attrVenue:DonationHttp"
                                                        >{{donation.goods_name}}</option>
                                                    </select>
                                                    <select ng-hide="donationStatus" class="form-control cp">
                                                        <option value="">请选择赠品</option>
                                                        <option value="" disabled class="red">{{optionDonation}}</option>
                                                    </select>
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">商品数量&emsp;&emsp;</span>
                                                    <div class="clearfix cp h32 inputUnlimited border1 mL15" >
                                                        <input   type="number" inputnum min="0" name='times' placeholder="0" class="fl form-control pT0">
                                                        <div class="checkbox i-checks checkbox-inline t4" >
                                                            <label>
                                                                <input type="checkbox" value=""> <i></i> 不限</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div  id="addDonation" ng-click="addDonationHtml()"  class="addBtn btn btn-default addDonation" venuehtml>添加商品</div>
                                    </form>
                                </div>
                            </main>
                        </section>
                        <h3>第三步</h3>
                        <section>
                            <div class="wB100 text-center fw"  ><h2>转让请假设置</h2></div>
                            <main class="con1 wB100 bindingCombo" >
                                <div>
                                    <h4>1.转让设置</h4>
                                    <form >
                                        <div class="clearfix" >
                                            <div class="fl  w32">
                                                <span class="">转让次数&emsp;&emsp;</span>
                                                <input type="number" min="0" ng-model="transferNumber" checknum placeholder="0次" class="form-control">
                                            </div>
                                            <div class="fl  w32">
                                                <span class="">转让金额&emsp;&emsp;</span>
                                                <input type="number" min="0"  ng-model="transferPrice"  placeholder="0元" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mT15">
                                    <h4>2.请假设置</h4>
                                    <form >
                                        <div class="clearfix" >
                                            <div class="fl  w32">
                                                <span class="">请假总天数&emsp;</span>
                                                <input type="number" min="0"  ng-disabled="leaveDaysFlag1" checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled(leaveDaysTotal)" id="leaveDaysTotal" ng-model="leaveDaysTotal" placeholder="0天" class="form-control">
                                            </div>
                                            <div class="fl  w32">
                                                <span class="">每次最低天数</span>
                                                <input type="number" min="0"  ng-disabled="leaveDaysFlag1" checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled(leaveTimesTotal)" id="leaveTimesTotal" ng-model="leaveTimesTotal" placeholder="0天" class="form-control">
                                            </div>
                                        </div>
                                        <hr class="mL15 wB60" >
                                        <div class=" leaveDay"  id="leaveDay">
                                            <div class="clearfix">
                                                <div class="fl  w32">
                                                    <span class="">请假次数&emsp;&emsp;</span>
                                                    <input type="number" min="0"  ng-disabled="leaveNumsFlag" ng-model="leaveNums" ng-change="seLeaveDaysDisabled(leaveNums)"  checknum name="times" placeholder="0次" class="form-control">
                                                </div>
                                                <div class="fl  w32">
                                                    <span class="">每次请假天数</span>
                                                    <input type="number" min="0" ng-disabled="leaveNumsFlag" ng-model="everyLeaveDays" ng-change="seLeaveDaysDisabled(everyLeaveDays)" checknum name="days" placeholder="0天" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button   ng-click="addLeaveHtml()" ng-disabled="leaveNumsFlag" id="addLeave"   class="btn btn-default addLeave addBtn"  venuehtml="">添加请假</button>
                                        <div class="mL15 wB60" >
                                            <span class="fa fa-info-circle">请假次数和每次请假天数同时输入才能生效</span>
                                        </div>
                                        <hr class="mL15 wB60" >
                                        <div class="studentLeaveDay"  id="studentLeaveDay">
                                            <div class="clearfix" >
                                                <div class="fl  w32" style="width: 100%;">
                                                    <span class=""><strong class="red">*</strong>学生卡请假</span>
                                                    <input type="number"  min="0"   ng-model="winterNum"   checknum name="winterNum" placeholder="暑假天数" class="form-control">
                                                    <input type="number" min="0"    ng-model="summerNum"   checknum name="summerNum" placeholder="寒假天数" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
<!--                                    <button class="btn btn-default" ng-click="getStudentLeaveDays()">获取学生卡请假</button>-->
                                </div>
                            </main>
                        </section>
                        <h3>第四步</h3>
                        <section>
                            <div  class="wB100 fw text-center"><h1>合同</h1></div>
                            <main class="con1">
                                <div class="wB80 margin0Auto" >
                                    <div class="clearfix wB20 margin0Auto text-center">
                                        <span class="fl mL20 mB5"><strong class="red">*</strong>请选择合同</span><br>
<!--                                        <span class="fl mL20 mB5" >请选择合同</span>-->
                                        <select  ng-model="$parent.dealId" ng-change="getDealId(dealId)" class=" fl form-control cp w200 border1" >
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
                                    <ul id="bargainContent">
                                        <li class="contract1">
                                            <h3 class="text-center mB15" >{{dataDeal.name}}</h3>
                                            <span class="contractCss" ng-bind-html="dataDeal.intro | to_Html"></span>
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

<!--模态卡-->
<div style="margin-top: 20px;z-index:11;" class="modal fade" id="myModals8" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 20%;">
        <div  class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h5 style="margin: 20px 10px;text-align: center;font-size: 20px;">时间修改</h5>

                <form>
                    <div style="margin-top: 10px;" class="form-group">
                        <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 10px; z-index: 11; justify-content: space-around;">
                            <div class="input-group clockpicker" data-autoclose="true" style="width: 45%;z-index: 11;">
                                <input type="text" id="weekStart" class="input-sm form-control text-center" autocomplete="off"  placeholder="起始时间" style="border-radius: 3px;">
                            </div>
                            <div class="input-group clockpicker" data-autoclose="true" style=" position: relative;width: 45%;z-index: 11;">
                                <input type="text" id="weekEnd" class="input-sm form-control text-center" autocomplete="off"  placeholder="结束时间" style="border-radius: 3px;z-index: 11;">
                            </div>
                        </div>
                </form>

                <div style="margin-top: 30px;" data-toggle="modal" data-target="#myModals8" class="btn btn-primary cancelTime">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</div>
                <div style="margin-top: 30px;" data-toggle="modal" data-target="#myModals8" class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</div>
            </div>
        </div>
    </div>