<?php
use backend\assets\CardCtrlAsset;
CardCtrlAsset::register($this);
$this->title = '次卡';
?>
<div class="wrapper wrapper-content animated fadeInRight" ng-controller="cardController">
    <div class="row">
        <div class="col-sm-12" style="overflow: auto;">
            <div class="ibox float-e-margins" style="min-width: 1080px;">
                <div class="ibox-title">
                    <h5>制定次卡</h5>
                </div>
                <div class="ibox-content">
                    <div id="wizard">
                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                        <h1>第一步 次卡</h1>
                        <div class="step-content">
                            <div class="m-t-md step-content1 pd0">
                                <div class="col-sm-12 pd0 boxContent">
                                    <form class="form-inline formBox1" >
                                        <p class="titleP">1.基本属性</p>
                                        <div class="col-sm-12 pd0">
                                            <div class="form-group mT10 col-sm-4 pd0">
                                                <span class="col-sm-3 pd0"><strong class="red">*</strong>卡种所属场馆</span>
                                                <div class="col-sm-8 pd0">
                                                    <select  class="form-control  cp"  ng-change="cardTheVenue(cardTheVenueId)" ng-model="cardTheVenueId" style="width: 180px;">
                                                        <option value="" >请选择场馆</option>
                                                        <option ng-if="cardTheVenueListsFlag" value="{{venue.id}}"
                                                                ng-repeat=" venue in cardTheVenueLists"
                                                        >{{venue.name}}</option>
                                                        <option ng-if="cardTheVenueListsFlag == false" style="color: red;" disabled>暂无数据</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mT10 col-sm-4 pd0" >
                                                <label for="exampleInputName2 " class="numCardLabel col-sm-3 pd0" ><span class="red">*</span>卡的属性</label>
                                                <div class="col-sm-8 pd0">
                                                    <select  ng-model="$parent.attributes" class="form-control w-100">
                                                        <option value="">请选择属性</option>
                                                        <option value="1">个人</option>
                                                        <option value="2">公司</option>
                                                        <option value="3">家庭</option>
<!--                                                        <option value="{{attr.key}}" ng-repeat="attr in attributesVal">{{attr.val}}</option>-->
                                                    </select>
<!--                                                    <select ng-if="attributesStatus == false" class="form-control cp">-->
<!--                                                        <option value="">请选择属性</option>-->
<!--                                                        <option value="" disabled class="red">{{attributesVal}}</option>-->
<!--                                                    </select>-->
                                                </div>
                                            </div>
                                            <div class="form-group mT10 col-sm-4 pd0">
                                                <span class="col-sm-3 pd0"><strong class="red">*</strong>卡的类型</span>
                                                <!--                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >-->
                                                <div class="col-sm-8 pd0">
                                                    <select ng-model="$parent.cardType" class="form-control cp" style="width:180px;" >
                                                        <option value="">请选择类型</option>
                                                        <option value="1">瑜伽</option>
                                                        <option value="2">健身</option>
                                                        <option value="3">舞蹈</option>
                                                        <option value="4">综合</option>
                                                        <!--                                                    <option value="5">VIP</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 pd0 mrt20">
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span class="red">*</span>卡的名称</label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="text" autocomplete="off" placeholder="请输入卡名称" ng-model="cardName" ng-blur="setCardName()" ng-change="setCardName()" class="form-control numCardInput" id="exampleInputName3">
                                                </div>
                                            </div>
                                            <div class="form-group mT10 pd0 col-sm-4" >
                                                <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" >卡别名</label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="text" autocomplete="off" placeholder="英文名" ng-model="anotherName" class="form-control numCardInput" id="exampleInputName3">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span class="red">*</span>次数</label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="number" autocomplete="off" inputnum min="0" placeholder="0次"  ng-model="cardTimes" ng-keyup="calculation(cardTimes,sellPrice)" class="form-control numCardInput" id="exampleInputName3" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 pd0 mT20" >
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" >单数</label>
                                                <div class="col-sm-8 pd0">
                                                    <input id="Singular" type="number"  ng-model="Singular" min="0" placeholder="请输入单数" class="form-control cp w180">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName2"  class="numCardLabel col-sm-3 pd0"><span class="red">*</span>扣次方式</label>
                                                <div class="col-sm-8 pd0">
                                                    <select ng-model="timesMethod" class="form-control w180">
                                                        <option value="">请选择扣次方式</option>
                                                        <option value="1">按时效扣次</option>
                                                        <option value="2">按次数扣次</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span class="red">*</span>激活期限</label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="number" autocomplete="off" inputnum min="0" placeholder="多少天" ng-model="activationTime" class="form-control width100 pT4 disIb" id="exampleInputName3" >
                                                    <select ng-model="activationType" class="form-control mL10 pT4 w66" >
                                                        <option value="1" selected>天</option>
                                                        <option value="7">周</option>
                                                        <option value="30">月</option>
                                                        <option value="90">季</option>
                                                        <option value="365">年</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 pd0 mT10" >
                                                <label for="exampleInputName3"  class="numCardLabel col-sm-3 pd0" ><span class="red">*</span>有效天数<span class="op0">0</span></label>
                                                <div class="col-sm-8 pd0">
                                                    <input type="number" autocomplete="off" inputnum min="0" ng-model="validTime" class="form-control numCardInput width100" id="exampleInputName3"  placeholder="0天">
                                                    <select  class="form-control cp w66 mL10" ng-model="validTimeType" >
                                                        <option value="1" selected >天</option>
                                                        <option value="7">周</option>
                                                        <option value="30">月</option>
                                                        <option value="90">季</option>
                                                        <option value="365">年</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="w100 cp">
                                                <div class="col-sm-8 clearfix">
                                                    <span class="fl mT5" style="margin-top: 35px;margin-left: -12px">&nbsp;卡种照片&emsp;</span>
                                                    <div class="form-group">
                                                        <img ng-src="{{pic}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 25px;margin-left: 44px">
                                                    </div>
                                                    <div class="input-file"
                                                         style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -100px;margin-left: 282px"
                                                         ngf-drop="setCover($file)"
                                                         ladda="uploading"
                                                         ngf-select="setCover($file);"
                                                         ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                                         ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                                        <p style="margin-left: 9px;width: 100%;height: 100%;line-height: 75px;font-size: 50px;" class="text-center">+</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pd0 mT40">
                                                <p class="titleP">2.定价和售卖&nbsp;&nbsp;<span class="f12 color999" ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;一口价和区域定价二选一</span></p>
                                            </div>
                                            <div class="col-sm-12 pd0">
                                                <div class="form-group mT10" >
                                                    <label for="exampleInputName3"  class="numCardLabel" ><span class="red">*</span>一口价&nbsp;&nbsp;&nbsp;</label>
                                                    <input type="number" autocomplete="off"  min="0" ng-model="originalPrice" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" class="form-control mL20 pT4 w140 disIb" id="areaMinPrice1"  placeholder="一口原价0元">
                                                    <input type="number" autocomplete="off"  min="0" ng-model="sellPrice" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" ng-keyup="calculation(cardTimes,sellPrice)" class="form-control mL10 pT4 w140 disIb" id="areaMinPrice2"  placeholder="一口售价0元">
                                                    <span class="f13 color999" > × {{cardTimes}}次 = ￥<i class="f14 fontNormal" >{{totalPrice}}</i> 售价金额</span>
                                                </div>
                                                <div class="form-group disBlock mT30">
                                                    <label for="exampleInputName3" class="oneStepPrice"><span style="color: red;">*</span>区域定价</label>
                                                    <input type="number" autocomplete="off"  min="0" ng-model="regionOriginalPrice" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control" id="areaMinPrice1s" style="margin-left: 18px;padding-top: 4px; width: 140px;display: inline-block;" placeholder="最低价0元">
                                                    <input type="number" autocomplete="off"  min="0" ng-model="regionSellPrice" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control" id="areaMinPrice2s" style="margin-left: 10px;padding-top: 4px; width: 140px;display: inline-block;" placeholder="最高价0元">
                                                </div>
<!--                                                <div class="form-group" style="display: block;margin-top: 30px;">-->
<!--                                                    <label for="exampleInputName3" class="oneStepPrice">单次续费价</label>-->
<!--                                                    <input type="number" autocomplete="off" inputnum min="0" ng-model="onceRenew" class="form-control" id="exampleInputName3" style="margin-left: 10px;padding-top: 4px; width: 140px;display: inline-block;" placeholder="单次续费0元">-->
<!--                                                    <select ng-model="renewUnit" class="form-control" style="margin-left: 10px;padding-top: 4px; width: 66px;">-->
<!--                                                        <option value="30" selected>月</option>-->
<!--                                                        <option value="90">季</option>-->
<!--                                                        <option value="365">年</option>-->
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                                <div class="form-group oneStepActive">-->
<!--                                                    <label for="exampleInputName3" class="oneStepPrice">优惠价&emsp;&emsp;</label>-->
<!--                                                    <input type="number" autocomplete="off" inputnum min="0" ng-model="offerPrice" class="form-control" id="exampleInputName3" style="margin-left: 10px;padding-top: 4px; width: 140px;display: inline-block;" placeholder="">-->
<!--                                                </div>-->
                                                <div class="w100 cp">
                                                    <span >优惠价&emsp;&emsp;</span>
                                                    <input style="margin-left: 0;" type="number" min="0" ng-model="offerPrice" placeholder="0元" class="form-control w125">
                                                </div>
                                                <div class="w100 cp" style="margin-bottom: 10px;">
                                                    <span >移动端售价&emsp;</span>
                                                    <input style="margin-left: 0;" type="number" min="0" ng-model="appSellPrice" placeholder="0元" class="form-control w125">
                                                </div>
                                                <div style="width: 100%;border-top: solid 1px #999;">
                                                    <!--<div class="  cp" style="width: 100%; display: flex;margin-top: 15px;">
                                                        <span style="width: 80px;margin-top: 5px;"><span class="red">*</span>普通续费</span>
                                                        <input style="width: 120px;"  type="number"  id="OrdinaryRenewal" min="0" placeholder="0元" class="form-control "ng-model="OrdinaryRenewal"  >
                                                    </div>
                                                    <div class="" style="width: 100%; display: flex;margin-top: 6px;">
                                                        <div style="margin-left: 95px;color: #999;"><i class="glyphicon glyphicon-info-sign"></i>当其它卡到期时选择此卡的续费</div>
                                                    </div>-->
                                                </div>
                                                <div style="width: 100%;" class="cardValidity123">
                                                    <div style="width: 100%;" class="cardValidityBox">
                                                        <div style="width: 100%; display: flex;margin-top: 15px;">
                                                            <span class="" style="width: 80px;margin-top: 5px;">有效期续费&emsp;</span>
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
                                            </div>
                                            <div class="col-sm-12 pd0">
                                                <p class="titleP mT40" style="">3.售卖场馆</p>
                                                <div id="sellVenue">
                                                    <div class="inputBox1 col-sm-12 pd0">
                                                        <div class="form-group col-sm-4 pd0">
                                                            <label for="exampleInputName2" class="oneChoicePrice col-sm-3 pd0"><span class="red">*</span>选择场馆</label>
                                                            <div class="col-sm-8 pd0">
                                                                <select ng-if="venueStatus == true" ng-change="selectVenue(venueId)" ng-model="$parent.venueId" class="form-control" style="padding-top: 4px; width: 180px;">
                                                                    <option value="">请选择售卖场馆</option>
                                                                    <option value="{{venue.id}}"  ng-repeat="venue in optionVenue"  ng-disabled="venue.id | attrVenue:venueHttp">{{venue.name}}</option>
                                                                </select>
                                                                <select ng-if="venueStatus == false" class="form-control oneStepSell">
                                                                    <option value="">请选择售卖场馆</option>
                                                                    <option value="" disabled class="red">{{optionVenue}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4 pd0">
                                                            <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block" class="col-sm-3 pd0"><span style="color: red;">*</span>售卖张数</label>
                                                            <div class="col-sm-7 pd0 clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                                                                <input style="width: 130px!important;border: none;margin-left: 0;" type="number" inputnum name="sheetsNum" min="0" value="" placeholder="0张" class="fl form-control">
                                                                <div class="checkbox i-checks checkbox-inline" style="top: 4px;width:58px;position: absolute;right: 4px;">
                                                                    <label>
                                                                        <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4 pd0">
                                                            <label for="exampleInputName3" class="oneStepPrice col-sm-3 pd0"><span class="red">*</span>售卖日期</label>
                                                            <div class="input-daterange col-sm-8 pd0 input-group cp" id="container" style="display: inline-block;">
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text"  id="datetimeStart" class="input-sm form-control datetimeStart oneStepTimeStar oneStepStar" name="sellStartTime" style="text-align:left;font-size: 13px;cursor: pointer;width: 100%!important;" autocomplete="off" placeholder="起始日期">

                                                                </div>
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text" id="datetimeEnd" class="input-sm form-control datetimeEnd oneStepTime col-sm-6" name="sellEndTime" autocomplete="off" placeholder="结束日期" style="text-align: left;font-size: 13px;cursor: pointer;width: 100%!important;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 pd0 discountLists mT10">
                                                            <div class="col-sm-12 pd0  discountBox" style="width: 100%;">
                                                                <div class="form-group col-sm-4 pd0 mT10" >
                                                                    <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span style="opacity: 0;">*</span>折扣</label>
                                                                    <div class="col-sm-8 pd0">
                                                                        <input type="number" autocomplete="off"  name="discount" min="0" placeholder="几折" value=""   class="form-control numCardInput" >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-4 pd0 mT10">
                                                                    <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block" class="col-sm-3 pd0"><span style="opacity: 0;">*</span>折扣售卖数</label>
                                                                    <div class="col-sm-7 pd0 clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                                                                        <input style="width: 130px!important;border: none;margin-left: 0;" type="number"  inputnum name="discountNum" min="0" value="" placeholder="0张" class="fl form-control">
                                                                        <div class="checkbox i-checks checkbox-inline" style="top: 4px;width:58px;position: absolute;right: 4px;">
                                                                            <label>
                                                                                <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div  class="col-sm-12 pd0 discountBtnBox" style="margin-top: 10px;margin-left: 96px;">
                                                            <div id="addDiscount123" class="cardAddBtn btn btn-default " ng-click="addDiscountHtml()" venuehtml="" >&nbsp;&nbsp;添加折扣&nbsp;&nbsp;</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <button id="addSellVenue" class="btn btn-white addBtn1" style="margin-top: 10px;margin-left: 96px;" ng-click="addVenueHtml()" venuehtml="">&nbsp;&nbsp;添加场馆&nbsp;&nbsp;</button>
                                                </div>
                                            </div>
                                        <div class="col-sm-12 pd0">
                                            <p class="titleP mT40">4.通用场馆限制<span class="f12 color999" ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;本场馆通店次数需要单独设置, <span >信息不填写完整不会保存</span></span></p>
                                            <div id="venue">
                                            <div class=" inputBox2">
                                            <div class="form-group divs1" style="margin-top: 20px;">
                                                <label for="exampleInputName2" class="oneChoicePrice"><span class="red">*</span>选择场馆</label>
                                                <select ng-if="applyStauts == true" ng-change="selectApply(applyId)" ng-model="$parent.applyId" class="form-control oneStepSell" style="">
                                                    <option value="">请选择场馆</option>
                                                    <option
                                                        value="{{venue.id}}"
                                                        ng-repeat="venue in optionApply"
                                                        ng-disabled="venue.id | attrVenue:applyHttp"
                                                    >{{venue.name}}</option>
                                                </select>
                                                <select ng-if="applyStauts == false" class="form-control oneStepSell">
                                                    <option value="">请选择场馆</option>
                                                    <option value="" disabled style="color:red;">{{optionApply}}</option>
                                                </select>
                                            </div>
                                                <div class="form-group divs2 oneStepXianZhi" style="margin-left: 111px;">
                                                    <div class="input-group clockpicker fl cp w90" style="margin-top: 5px;"><span>进馆时间</span></div>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                                        <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="起始时间">
                                                    </div>
                                                    <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
                                                        <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="结束时间">
                                                    </div>
                                                </div>
                                                <div class="form-group inputUnlimited currencyTime month" style="margin-top: 20px;margin-left: 60px;position: relative;border: none;">
                                                    <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;"><span class="red">*</span>通店限制</label>
                                                    <input type="number" inputnum min="0" class="form-control" name="currencyTimes" id="exampleInputName3" style="padding-top: 4px; width: 166px;display: inline-block;padding-right: 70px;border: 1px solid #ccc!important;" placeholder="通店次数">
                                                    <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 0;left: 200px;">
                                                        <label style="margin-left: -30px;"><input style="width: 2px;" type="checkbox" value="-1">不限</label>
                                                        <select  class="form-control cp w70 mL16 " name="weeks">
                                                            <option value="w">周</option>
                                                            <option value="m">月</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group divs2 oneStepXianZhi" style="margin-left: 111px;">
                                                    <label for="exampleInputName3" class="oneStepPrice"><span class="red">*</span>卡的等级</label>
                                                    <select class="form-control cp"   name='times1' style="margin-left: 20px;">
                                                        <option value="1">普通卡</option>
                                                        <option value="2">VIP卡</option>
                                                    </select>
                                                </div>
                                                <div class="form-group divs2 oneStepXianZhi about" style="margin-left: 75px;">
                                                    <div class="checkbox i-checks checkbox-inline t4">
                                                        <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
                                                    </div>
                                                </div>
<!--                                                <div class="form-group oneStepXianZhi currencyTimes" >-->
<!--                                                    <label for="exampleInputName3" class="oneStepPrice">每周通店限制</label>-->
<!--                                                    <input type="number" autocomplete="off" inputnum min="0" class="form-control" name="currencyTimesr" id="exampleInputName3" style="padding-top: 4px; width: 166px;display: inline-block;padding-right: 70px;" placeholder="通店次数">-->
<!--                                                    <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">-->
<!--                                                        <label><input type="checkbox" value="-1">不限</label>-->
<!--                                                    </div>-->
<!--                                                </div>-->

                                            </div>
                                            </div>
                                            <button id="addVenue" ng-click="addApplyHtml()" venuehtml="" class="btn btn-white addBtn2" style="margin-left: 96px;margin-top: 10px;">&nbsp;&nbsp;添加场馆&nbsp;&nbsp;</button>
                                        </div>
                                        <div style="margin: 750px 0 60px 0;/*position: relative;*/">
                                            <form>
                                            <p class="titleP mT40" style="">5.进馆时间设置&nbsp;&nbsp;<span class="oneStepMonth"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;每月固定日和特定星期二选择一</span></p>
                                            <div class="clearfix">
                                                <div style="" class="fl oneStepDay">
                                                    <p class="mB10">每月固定日(选填)</p>
                                                    <div class="oneStepMonthDay">
                                                        <div class=" w32 clearfix oneStepSellTime">
                                                            <span class="fl">特定时间段</span>
                                                            <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">
                                                                <input type="text" ng-model="dayStartTime" name="dayStart" ng-change="setDayTime()" class="input-sm form-control text-center"  placeholder="起始时间" style="width: 100%;border-radius: 3px;">
                                                            </div>
                                                            <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">
                                                                <input type="text" ng-model="dayEndTime" name="dayEnd" ng-change="setDayTime()" class="input-sm form-control text-center"  placeholder="结束时间" style="width: 100%;border-radius: 3px;">
                                                            </div>
                                                        </div>
                                                        <table id="day" class="cp">
                                                            <tr>
                                                                <td colspan="2" style="opacity: 0;"   class="tdActive"></td>
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
                                                <div id="week" style="float:right;margin: 15px 0 0 30px;width: 620px;">
                                                    <p>特定星期选择</p>
                                                    <div class="checkbox i-checks checkbox-inline checkBoxClick" style="margin-top: 4px;margin-left: 0px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox1" class=" checkBigBox1" value="1">
                                                        <label for="inlineCheckbox1" style="padding-left: 2px;" class="checkBigBox1">周一</label>
                                                        <span class="timeSpan" style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;margin-left: 10px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox2" class=" checkBigBox2" value="2">
                                                        <label for="inlineCheckbox2" style="padding-left: 2px;" class="checkBigBox2">周二</label>
                                                        <span class="timeSpan" style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox3" class=" checkBigBox3" value="3">
                                                        <label for="inlineCheckbox3" class="checkBigBox3" style="padding-left: 2px;">周三</label>
                                                        <span class="timeSpan" style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox4" class=" checkBigBox4" value="4">
                                                        <label class="checkBigBox4" for="inlineCheckbox4" style="padding-left: 2px;">周四</label>
                                                        <span class="timeSpan" style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox5" class=" checkBigBox5" value="5">
                                                        <label for="inlineCheckbox5" style="padding-left: 2px;" class="checkBigBox5">周五</label>
                                                        <span class="timeSpan" style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox6" class=" checkBigBox6" value="6">
                                                        <label for="inlineCheckbox6" style="padding-left: 2px;" class="checkBigBox6">周六</label>
                                                        <span class="timeSpan"  style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>

                                                    <div class="checkbox i-checks checkbox-success checkbox-inline checkBoxClick" style="margin-top: 4px;width: 70px;height: 50px;">
                                                        <input name="weeksTime" type="checkbox" id="inlineCheckbox7" class=" checkBigBox7" value="7">
                                                        <label for="inlineCheckbox7" style="padding-left: 2px;" class="checkBigBox7">周日</label>
                                                        <span class="timeSpan"  style="font-size: 12px;display: none;">18:00-21:00</span>
                                                        <button style="position: absolute;top: 50px;left: 0;display: none;" class="btn btn-sm btn-white btnCheck" data-toggle="modal" data-target="#myModals8">添加时间</button>
                                                    </div>
<!--                                                    <div style="margin-top:60px;height: 50px;">-->
<!--                                                        <p>填写卡的特定时间</p>-->
<!--                                                        <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 10px;">-->
<!--                                                            <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                                <input type="text" ng-model="cardStartTime" class="input-sm form-control text-center"  placeholder="起始时间" style="width: 100%;border-radius: 3px;">-->
<!--                                                            </div>-->
<!--                                                            <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
<!--                                                                <input type="text" ng-model="cardEndTime" class="input-sm form-control text-center"  placeholder="结束时间" style="width: 100%;border-radius: 3px;margin-left: 15px;">-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    </div>

                    <h1>第二步 绑定套餐</h1>
                        <div class="step-content two">
                            <div class="two">
                                <form class="form-inline formBox1 twoStep">
                                    <p class="titleP" style="">1.绑定团课课程</p>
                                    <div class="col-sm-12 pd0" id="course">
                                        <div class="inputBox3">
                                            <div class="form-group mT10" style="">
                                                <label for="exampleInputName2" class="oneChoicePrice">课程名称</label>
                                                <select multiple="multiple" name="leagueCourseList" id="chooseClass" style="width: 180px;" ng-if="classStatus == true" ng-change="selectClass(classKey)" ng-model="$parent.classKey" class="form-control twoStepClass leagueCourseList">
<!--                                                    <option value="">请选择课程</option>-->
                                                    <option
                                                        value="{{venue.id}}"
                                                        ng-repeat="venue in optionClass"
                                                        ng-disabled="venue.id | attrVenue:classHttp"
                                                    >{{venue.name}}</option>
                                                </select>
                                                <select  style="width: 180px;" ng-if="classStatus == false" class="form-control twoStepClass">
                                                    <option value="">请选择课程</option>
                                                    <option value="" disabled style="color:red;">{{optionClass}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group twoStepDay inputUnlimited " style="border: none;margin-left: 60px;">
                                                <label for="exampleInputName3 " class="oneStepPrice">每日节数</label>
                                                <input type="number" autocomplete="off" inputnum min="0" name="leagueTimes" class="form-control" id="exampleInputName3" style="border: solid 1px #ccc!important;margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;padding-right: 70px;" placeholder="0节">
                                                <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">
                                                    <label><input type="checkbox" value="-1">不限</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="addCourse" ng-click="addClassHtml()" class="btn btn-white addBtn3" venuehtml="" style="margin-top: 10px;margin-left: 88px;">&nbsp;&nbsp;添加课程&nbsp;&nbsp;</button>
                                    <div ng-show="serverShow">
                                        <p class="titleP" style="margin-top: 80px;">2.绑定服务</p>
                                        <div class="serve" id="server">
                                            <div class="inputBox4">
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">服务名称</label>
                                                    <select ng-if="serverStatus == true" ng-change="selectServer(serverKey)" ng-model="$parent.serverKey" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
                                                        <option value="">请选择服务</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionServer"
                                                            ng-disabled="venue.id | attrVenue:serverHttp"
                                                        >{{venue.name}}</option>
                                                    </select>
                                                    <select ng-if="serverStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
                                                        <option value="">请选择服务</option>
                                                        <option value="" disabled style="color:red;">{{optionServer}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group " style="margin-top: 10px;margin-left: 60px;position: relative;">
                                                    <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">每日数量</label>
                                                    <input type="number" autocomplete="off" inputnum min="0" name="serviceTimes" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;padding-right: 70px;"placeholder="0">
                                                    <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">
                                                        <label><input type="checkbox" value="-1">不限</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="addServer" ng-click="addServerHtml()" class="btn btn-white addBtn4" venuehtml="" style="margin-top:10px;margin-left: 88px;">&nbsp;&nbsp;添加商品&nbsp;&nbsp;</button>
                                    </div>
                                    <div >
                                        <p class="titleP" style="margin-top: 80px;">2.赠送私教课程</p>
                                        <div class="course" id="pTcourse">
                                            <div class="">
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">HS课程&emsp;&emsp;</label>
                                                    <select ng-if="GiveCourseFlag == true"  style="margin-left: 20px;width: 180px;" id="HSClass" class="form-control cp "  ng-change="selectHsPTClass()" ng-model="HSClass">
                                                        <option value=""  >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select ng-if="GiveCourseFlag == false" style="margin-left: 20px;width: 180px;" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="form-group clear" style="margin-top: 10px;margin-left: 60px;position: relative;">
                                                    <label class="fl" for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block;margin-top: 4px;">HS节数</label>
                                                    <input type="number" style="margin-left: 20px;width: 180px;" inputnum min="0" name="HSNum" ng-model="HSClassNum"  placeholder="0节" class="fl form-control pT0   mL0 mT0">
                                                </div>
                                            </div>
                                            <div class="flag1">
                                                <div class="form-group clearfix" style="margin-top: 10px;">
                                                    <label class="fl" for="" style="opacity:0;font-size: 13px;font-weight: normal;color: #333;">HS课程</label>
                                                    <div class="fl" style="color: #999;margin-left: 30px;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">PT课程&emsp;&emsp;</label>
                                                    <select style="margin-left: 20px;width: 180px;"  ng-if="GiveCourseFlag == true"  id="PTClass" class="form-control cp "  ng-change="selectHsPTClass()" ng-model="PTClass">
                                                        <option value="" >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select style="margin-left: 20px;width: 180px;" ng-if="GiveCourseFlag == false" class="form-control cp">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="form-group clear" style="margin-top: 10px;margin-left: 60px;position: relative;">
                                                    <label class="fl" for="" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block;margin-top: 4px;">PT节数</label>
                                                    <input style="margin-left: 20px;width: 180px;" type="number" inputnum min="0" name="PTNum" ng-model="PTClassNum"  placeholder="0节" class="fl form-control pT0   mL0 mT0">
                                                </div>
                                            </div>
                                            <div class="flag1">
                                                <div class="form-group clearfix" style="margin-top: 10px;">
                                                    <label class="fl" for="" style="opacity:0;font-size: 13px;font-weight: normal;color: #333;">PT课程</label>
                                                    <div class="fl" style="color: #999;margin-left: 30px;"><i class="glyphicon glyphicon-info-sign">有效期和会员卡保持同步</i></div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group" style="margin-top: 10px;">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">生日课&emsp;&emsp;</label>
                                                    <select ng-if="GiveCourseFlag == true"  style="width: 180px;" class="form-control cp " id="BirthdayClass"  ng-change="BirthdayClassSelect()" ng-model="BirthdayClass">
                                                        <option value="" >请选择课程</option>
                                                        <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                                                    </select>
                                                    <select ng-if="GiveCourseFlag == false" class="form-control cp" style="width: 180px;">
                                                        <option value="">请选择课程</option>
                                                        <option value="" disabled class="red">暂无数据</option>
                                                    </select>
                                                </div>
                                                <div class="form-group clear" style="margin-top: 10px;margin-left: 60px;position: relative;">
                                                    <label class="fl" for="" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block;margin-top: 4px;">生日课节数</label>
                                                    <input style="width: 180px;" type="number" inputnum min="0" name="birthClass" id="birthClassNum" ng-model="birthClassNum"  placeholder="0节" class="fl form-control pT0   mL0 mT0">
                                                </div>
                                            </div>
                                            <div class="flag1">
                                                <div class="form-group clearfix" style="margin-top: 10px;">
                                                    <label class="fl" for="" style="opacity:0;font-size: 13px;font-weight: normal;color: #333;">生日课程</label>
                                                    <div class="fl" style="color: #999;margin-left: 20px;"><i class="glyphicon glyphicon-info-sign">每年生日都会赠送，仅生日当月有效</i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-show="shopShow">
                                        <p class="titleP" style="margin-top: 80px;">3.扣次项目</p>
                                        <div class="shopping" id="shopping">
                                            <div class="inputBox5">
                                                <div class="form-group" style="margin-top: 10px;display: inline-block;">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">商品名称</label>
                                                    <select ng-if="shopStatus == true" ng-change="selectShop(shopKey)" ng-model="$parent.shopKey" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
                                                        <option value="">请选择商品</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionShop"
                                                            ng-disabled="venue.id | attrVenue:shopHttp"
                                                        >{{venue.goods_name}}</option>
                                                    </select>
                                                    <select ng-if="shopStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
                                                        <option value="">请选择商品</option>
                                                        <option value="" disabled style="color:red;">{{optionShop}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group inputUnlimited" style="border: none;margin-top: 10px;margin-left: 60px;position: relative;display: inline-block;">
                                                    <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">扣次数量</label>
                                                    <input type="number" autocomplete="off" inputnum min="0" name="goodsNum" class="form-control" id="exampleInputName3" style="border: solid 1px #ccc !important;margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;" placeholder="0个">
                                                </div>
                                            </div>
                                        </div>
                                        <button id="addShop" ng-click="addShopHtml()" class="btn btn-white addBtn5" venuehtml="" style="margin-top: 10px;margin-left: 88px;display: block;">&nbsp;&nbsp;添加商品&nbsp;&nbsp;</button>
                                    </div>
                                    <div>
                                        <p class="titleP" style="margin-top: 80px;">4.赠品</p>
                                        <div class="gift" id="gift">
                                            <div class="form-group" style="margin-top: 10px;display: inline-block;">
                                                <div class="inputBox6">
                                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">赠品名称</label>
                                                    <select ng-if="donationStatus == true" ng-change="selectDonation(donationKey)" ng-model="$parent.donationKey" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
                                                        <option value="">请选择赠品</option>
                                                        <option
                                                            value="{{venue.id}}"
                                                            ng-repeat="venue in optionDonation"
                                                            ng-disabled="venue.id | attrVenue:DonationHttp"
                                                        >{{venue.goods_name}}</option>
                                                    </select>
                                                    <select ng-if="donationStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
                                                        <option value="">请选择赠品</option>
                                                        <option value="" disabled style="color:red;">{{optionDonation}}</option>
                                                    </select>
                                                    <div class="form-group inputUnlimited" style="margin-left: 60px;position: relative;border: none;display: inline-block;">
                                                        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">赠品数量</label>
                                                        <input type="number" autocomplete="off" inputnum min="0" name="giftNum" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px; border: solid 1px #ccc !important;display: inline-block;" placeholder="0个">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="addDonation" ng-click="addDonationHtml()" class="btn btn-white addBtn6" venuehtml="" style="margin-top: 10px;margin-left: 88px;display: block;">&nbsp;&nbsp;添加商品&nbsp;&nbsp;</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <h1>第三步 转让请假设置</h1>
                    <div class="step-content" style="background: #fff;">
                        <div style="background: #fff;">
                            <form class="form-inline formBox1" style="padding: 30px 80px 30px 80px">
                                <p class="titleP">1.转让设置</p>
                                <div class="col-sm-12 pd0">
                                    <div class="form-group" style="margin-top: 10px;">
                                        <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">转让次数</label>
                                        <input type="number" autocomplete="off" checknum min="0" ng-model="transferTimes" class="form-control" id="exampleInputName2" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;" placeholder="0次">
                                    </div>
                                    <div class="form-group" style="margin-top: 10px;margin-left: 60px;position: relative;">
                                        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">转让金额</label>
                                        <input type="number" autocomplete="off"  min="0" ng-model="transferPrice" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;" placeholder="0元">
                                    </div>
                                </div>
                                <p class="titleP" style="margin-top: 160px;">2.请假设置</p>
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">请假总天数</label>
                                    <input type="number" autocomplete="off" checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled1(totalLeaveDays)" min="0" ng-model="totalLeaveDays" id="totalLeaveDays" class="form-control" id="exampleInputName2" style="margin-left: 4px;padding-top: 4px; width: 180px;display: inline-block;" placeholder="多少天">

                                </div>
                                <div class="form-group" style="margin-top: 10px;margin-left: 60px;">
                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">每次最低天数</label>
                                    <input type="number" autocomplete="off" checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled1(minLeaveDays)" min="0" ng-model="minLeaveDays" id="minLeaveDays" class="form-control" id="exampleInputName2" style="margin-left: 0;padding-top: 4px; width: 170px;display: inline-block;" placeholder="多少天">
                                </div>
                                <div class="center-block" style="border: 1px solid #eee;margin-top: 40px;margin-bottom: 40px;"></div>
                                <div class="leaveDay" id="leaveDay">
                                <div class="inputBox7">
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">请假次数</label>
                                    <input type="number" checknum min="0"  ng-disabled="leaveNumsFlag" ng-model="leaveNums" ng-change="setLeaveDaysDisabled1(leaveNums)" name="leaveTimes" class="form-control" id="exampleInputName2" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;" placeholder="几次">
                                </div>
                                <div class="form-group" style="margin-top: 10px;margin-left: 60px;">
                                    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">每次请假天数</label>
                                    <input type="number" checknum min="0" ng-disabled="leaveNumsFlag" ng-model="everyLeaveDays" ng-change="setLeaveDaysDisabled1(everyLeaveDays)" name="leaveDays" class="form-control" id="exampleInputName2" style="margin-left: 0;padding-top: 4px; width: 170px;display: inline-block;" placeholder="多少天">
                                </div>
                                </div>
                                </div>
                                <button id="addLeave" ng-click="addLeaveHtml()"  ng-disabled="leaveNumsFlag" class="btn btn-white addBtn7" venuehtml="" style="margin-top: 10px;margin-left: 88px;display: block;">&nbsp;&nbsp;添加请假&nbsp;&nbsp;</button>
                        </div>
                        </form>
                    </div>

                        <h1>第四步 合同</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md">
                                <form class="formBox1">
                                <section id="form5" >
                                    <div >
                                        <div><span class="fl mL20 mB5"><strong class="red">*</strong>选择合同</span><br></div>
                                        <div>
                                            <select  ng-model="$parent.dealId" ng-change="getDealId(dealId)" class=" fl form-control cp" style="border-color: rgb(207,218,221);width: 200px;margin-left: calc(50% - 100px);margin-top: 10px; ">
                                                <option value="" >请选择合同</option>
                                                <option
                                                    value="{{deal.id}}"
                                                    ng-repeat="deal in dealData track by $index"
                                                >{{deal.name}}</option>
                                            </select>
                                        </div>
                                    </div>
<!--                                    <select ng-if="dealStauts == false" class=" fl form-control cp" style="border-color: rgb(207,218,221);width: 200px; ">-->
<!--                                        <option value="" >请选择合同</option>-->
<!--                                        <option value="" disabled style="color:red;">{{dealData}}</option>-->
<!--                                    </select>-->
                                    <div class="center-block" style="width: 1000px;">
                                        <ul id="bargainContent" style="width: 100%;margin: 30px auto;min-height: 100px">
                                            <li class="contract1">
                                                <h3 style="text-align: center;margin-bottom: 15px;">{{dataDeal.name}}</h3>
                                                <span style="display:block;height: 500px;overflow-y: scroll;" ng-bind-html="dataDeal.intro | to_Html"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div style="margin-top: 20px;z-index: 1!important;" class="modal fade" id="myModals8" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 20%;">
        <div style="padding-bottom: 20px;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>

                <h5 style="margin-left:10px;text-align: center;font-size: 20px;">时间修改</h5>
                <form>
                    <div style="margin-top: 10px;" class="form-group group1" id="weekTime">
                        <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 20px;">
                            <div class="input-group clockpicker" data-autoclose="true" style="width: 130px;">
                                <input ng-model="weekStartTime" id="timeValueStart" type="text" class="input-sm form-control text-center" placeholder="起始时间" style="width: 100%;border-radius: 3px;">
                            </div>
                            <div class="input-group clockpicker" data-autoclose="true" style="width: 130px;">
                                <input ng-model="weekEndTime" id="timeValueEnd" type="text" class="input-sm form-control text-center" placeholder="结束时间" style="width: 100%;border-radius: 3px;margin-left: 15px;">
                            </div>
                        </div>
                    </div>
                    <button style="margin-top: 0px;margin-left: 20px;" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="margin-top: 0px;margin-right: 20px" class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>