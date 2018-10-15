<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/4/17
 * Time: 15:46
 * content:新增私教产品页面
 */
use backend\assets\PrivateServeCtrlAsset;
PrivateServeCtrlAsset::register($this);
$this->title = '新增单课种产品';
?>
<header class="reservation_header clearfix fw">
    <div class="w20  fl"><a href="/private-lesson/course" style="color: #ffffff">私教产品</a></div>
    <div class="fl">
        <span class="spanBig">新增单课种产品</span>
    </div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<div id="private" class="container-fluid" ng-controller="addServeCtrl" ng-cloak style=" background: #f5f5f5">
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
    <main class="main">
        <h4>1.基本属性</h4>
        <div style="margin-top: 10px;">
            <form >
                <div class="row">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class="red">*</strong>产品名称&emsp;&emsp;</span>
                        <input type="text" ng-model="name" placeholder="产品的名称" class="form-control cp fl">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class="red">*</strong>产品类型&emsp;&emsp;</span>
                        <select ng-model="productType" class="form-control fl cp">
                            <option value="">请选择产品类型</option>
                            <option value="1">常规pt</option>
                            <option value="2">特色课</option>
                            <option value="3">游泳课</option>
                        </select>
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class=" red">*</strong>每月上课数量</span>
                        <input  style="width:210px;" ng-model="monthUpNum" type="number" inputnum min="0" placeholder="请输入上课数量"  class="form-control fl cp" >
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class=" red">*</strong>产品激活期限</span>
                        <input  style="width:130px;" ng-model="activatedTime" type="number" inputnum min="0" placeholder="多少"  class="form-control fl cp" >
                        <select style="width: 70px;margin-left: 10px;" ng-model="activatedTimeType" class="form-control fl cp"  >
                            <option value="1" selected>天</option>
                            <option value="7">周</option>
                            <option value="30">月</option>
                            <option value="90">季</option>
                            <option value="365">年</option>
                        </select>
                    </div>
                    <div class="col-sm-4 clearfix" id="unLimit">
                        <span class="fl" style="line-height: 30px;">售卖总数量&emsp;</span>
                        <div class="fl clearfix cp addUnlimited h32 inputSellNum" style="border: solid 1px #cfdadd;border-radius: 3px;">
                            <input name="sellNum" style="width:136px;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;margin-right: 0;" type="number" inputnum min="0" placeholder="0套"  class="fl form-control">
                            <div class="checkbox i-checks checkbox-inline " style="top: 4px;margin-left: 2px;">
                                <label>
                                    <input type="checkbox" value="-1" > <i></i> 不限</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 clearfix input-daterange cp" style="position: relative;">
                        <span class="fl" style="line-height: 30px;"><strong class=" red">*</strong>售卖日期&emsp;&emsp;</span>
                        <input type="text" ng-model="saleStart" class="input-sm form-control datetimeStart fl" name="start" placeholder="起始日期"  style="width: 100px;text-align:left;font-size: 14px;cursor: pointer;padding:4px 10px;">
                        <input type="text" ng-model="saleEnd" class="input-sm form-control datetimeEnd fl" name="end" placeholder="结束日期" style="width: 100px;text-align: left;font-size: 14px;cursor: pointer;padding:4px 10px;">
                    </div>
                    <div class="col-sm-4 clearfix input-daterange cp" style="position: relative;">
                        <span class="fl" style="line-height: 30px;"><strong class=" red">*</strong>课程类型&emsp;&emsp;</span>
                        <select style="border: solid 1px gainsboro;font-size: 14px;" ng-model="courseType">
                            <option value="">请选择类型</option>
                            <option value="1">购买</option>
                            <option value="2">赠送</option>
                        </select>
                    </div>
                    <div class="col-sm-4 clearfix input-daterange cp">
                        <span class="fl" style="line-height: 30px;"><strong class=" red">*</strong>所属场馆&emsp;&emsp;</span>
                        <select style="border: solid 1px gainsboro;font-size: 14px;" ng-model="venueTypeId">
                            <option value="">请选择场馆</option>
                            <option value="{{i.id}}" ng-repeat="i in venueLists">{{i.name}}</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <h4>2.课种选择</h4>
        <div style="margin-top: 10px;">
            <form >
                <div id="course">
                    <div class="row">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"  ><strong class=" red">*</strong>选择课种&emsp;&emsp;</span>
                            <select ng-if="classStatus == true" ng-change="selectClass(classKey)" ng-model="$parent.classKey" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择课种</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionClass">
                                    {{venue.name}}
                                </option>
                            </select>
                            <select ng-if="classStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
                                <option value="">请选择课种</option>
                                <option value="" disabled style="color:red;">{{optionClass}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"><strong class="red">*</strong>课程时长&emsp;&emsp;</span>
                            <input type="number" inputnum min="0" ng-model="classTime" placeholder="0分钟" class="form-control cp fl">
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"><strong class="red">*</strong>单节原价&emsp;</span>
<!--                            <input type="number" checknum  ng-model="onePrice" placeholder="0元" class="form-control cp fl">-->
                            <input type="number" inputnum min="0" ng-model="onePrice" placeholder="0元" class="form-control cp fl">
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">移动端单节原价&emsp;</span>
                            <input type="number" inputnum min="0" ng-model="appUnitPrice" ng-change="getAppDiscountPrice(appUnitPrice,appDiscounts)" placeholder="0元" class="form-control cp fl" style="margin-left: -10px;">
                        </div>
                        <!--                        <div class="col-sm-4">-->
                        <!--                            <span class="glyphicon glyphicon-yen"><strong style="font-size: 16px;">{{classTotalPrice}}</strong>元/金额</span>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </form>

        </div>

        <h4>3.产品价格&nbsp;
<!--            <span class="glyphicon glyphicon-info-sign" style="font-weight: 100;font-size: 12px;color:red;"><b style="color: #999;">如果需要添加多个课程区间，请先点击添加区间后再填区间数</b></span>-->
        </h4>
        <div style="margin-top: 10px;">
            <div id="qujian " class="sectionNumber">
                <div class="row xxxx">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">课程节数区间&emsp;&emsp;&emsp;</span>
                        <input type="number"  inputnum min="0" name="intervalStart" placeholder="多少节" class="form-control cp f1 intervalStart sectionInput" style="position: relative;left: -24px;width: 75px">
                        <div style="position: relative;left: 195px;top: -35px">至</div>
                        <input type="number" inputnum min="0" name="intervalEnd" placeholder="多少节" ng-blur="numChangeBlur($event,numClass)"  ng-keyup="numChange($event,numClass)" ng-model="numClass" class="form-control cp fl intervalEnd sectionInput2" style="position: relative;left: 221px;width: 75px;top: -58px">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">优惠单价&emsp;&emsp;</span>
                        <input type="number" inputnum min="0" name="unitPrice" placeholder="0元" class="form-control cp fl unitPrice">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">POS价&emsp;&emsp;</span>
                        <input type="number" inputnum name="posPrice" placeholder="0元" class="form-control cp fl">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">移动端折扣&emsp;</span>
                        <input type="number" inputnum name="appDiscount" ng-model="appDiscounts" placeholder="请输入折扣" class="form-control cp fl" ng-change="getAppDiscountPrice(appUnitPrice,appDiscounts)">
                        <span class="glyphicon glyphicon-info-sign" style="margin-top: 8px;font-weight: 100;font-size: 12px;color: darkgrey;">折扣价格：{{appDiscountPrice}}元</span>
                    </div>
                </div>
            </div>
            <div class="row addPrivatePrice">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addPrivatePrice" ng-click="addPriceHtml()" venuehtml class="btn btn-default fl" style="margin-bottom: 10px;margin-top: -40px;">添加区间</button>
                </div>
            </div>
        </div>

        <h4>4.售卖场馆 <span class="glyphicon glyphicon-info-sign" style="font-weight: 100;font-size: 12px;color: darkgrey;">如售卖场馆不选择则视为不限</span>  </h4>
        <div style="margin-top: 10px;">
            <form >
                <div id="productPrice">
                    <div class="row">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;售卖场馆&emsp;&emsp;</span>
                            <select ng-if="venueStatus == true" ng-change="selectVenue(venueKey)" ng-model="$parent.venueKey" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择场馆</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionVenue"
                                    ng-disabled="venue.id | attrVenue:venueHttp">{{venue.name}}</option>
                            </select>
                            <select ng-if="venueStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
                                <option value="">请选择场馆</option>
                                <option value="" disabled style="color:red;">{{optionVenue}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;单馆售卖数量</span>
                            <input type="number" inputnum min="0" name="venueSaleNum" placeholder="0套" class="form-control cp fl">
                        </div>
<!--                        <div class="col-sm-4 clearfix" id="venueSaleNum">-->
<!--                            <span class="fl mT5">&nbsp;单馆售卖数量</span>-->
<!--                            <div class="fl clearfix cp addUnlimited h32 venueSaleNum" style="border: solid 1px #cfdadd;border-radius: 3px;margin-left: 6px;">-->
<!--                                <input name="venueSaleNum" style="width:136px;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;margin-right: 0;" type="number" inputnum min="0" placeholder="0套"  class="fl form-control cp">-->
<!--                                <div class="checkbox i-checks checkbox-inline " style="top: 4px;margin-left: 2px;">-->
<!--                                    <label>-->
<!--                                        <input type="checkbox" value="-1" > <i></i> 不限</label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </form>
            <div class="row addPrivateVenue">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addPrivateVenue" ng-click="addVenueHtml()" venuehtml class="btn btn-default fl" >添加场馆</button>
                </div>
            </div>
        </div>

        <h4>5.绑定服务 </h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div id="productServe">
                    <div class="row">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;服务名称&emsp;&emsp;</span>
                            <select ng-if="serverStatus == true" ng-change="selectServer(serverKey)" ng-model="$parent.serverKey" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择服务</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionServer"
                                    ng-disabled="venue.id | attrVenue:serverHttp">{{venue.name}}</option>
                            </select>
                            <select ng-if="serverStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
                                <option value="">请选择服务</option>
                                <option value="" disabled style="color:red;">{{optionServer}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;每日数量</span>
                            <input type="number" inputnum min="0" name="serverNum" placeholder="0" class="form-control cp fl">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row addPrivateServe">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addPrivateServe" ng-click="addServerHtml()" venuehtml class="btn btn-default fl" >添加服务</button>
                </div>
            </div>
        </div>

        <h4>6.赠品 </h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div id="productGift">
                    <div class="row">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;商品名称&emsp;</span>
                            <select  ng-change="selectDonation(donationKey)" ng-model="donationKey" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择商品</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in shopLists">{{venue.goods_name}}</option>
                            </select>
<!--                            <select ng-if="donationStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">-->
<!--                                <option value="">请选择赠品</option>-->
<!--                                <option value="" disabled style="color:red;">{{optionDonation}}</option>-->
<!--                            </select>-->
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;商品数量</span>
                            <input type="number" inputnum min="0" name="giftNum" placeholder="0" class="form-control cp fl">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row addPrivateGift">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addPrivateGift" ng-click="addDonationHtml()" venuehtml="" class="btn btn-default fl" >添加商品</button>
                </div>
            </div>
        </div>
        <h4>7.转让设置</h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div class="row">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;转让次数&emsp;</span>
                        <input type="number" inputnum min="0" ng-model="transferNum" placeholder="几次" class="form-control cp fl" style="margin-left: 22px">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;转让金额</span>
                        <input type="number" inputnum min="0" ng-model="transferPrice" placeholder="0元" class="form-control cp fl">
                    </div>
                </div>
            </form>
        </div>

        <h4>8.课程详情</h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div class="row">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5">&nbsp;课程介绍&emsp;</span>
                        <textarea ng-model="desc" style="margin-left: 21px;width: 500px;height: 100px;resize: none;" placeholder="请输入课程介绍"></textarea>
                    </div><br>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5">&nbsp;添加照片&emsp;</span>
                        <div class="input-file ladda-button btn ng-empty uploader"
                             style="margin-left: 21px;width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;"
                             ngf-drop="setCover($file)"
                             ladda="uploading"
                             ngf-select="setCover($file)"
                             ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                             ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                            <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;" class="text-center">+</p>
                        </div>
                        <div class="form-group" style="margin-left: 300px;margin-top: -90px;">
                            <img ng-src="{{pic}}" width="80px" height="80px">
                        </div>
                    </div><br>
                </div>
            </form>
        </div>
        <h4>9.合同</h4>
        <div style="margin-top: 10px;">
            <div class="row">
                <form class="form-horizontal">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class=" red">*</strong>&nbsp;合同名称&emsp;</span>
                        <select ng-model="contactAdd" class="form-control cp fl" style="margin-left: 22px" ng-change="getContact(contactAdd)">
                            <option value="">请选择合同</option>
                            <option value="{{contact.id}}" ng-repeat="contact in contactList">
                                {{contact.name}}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12"  style="margin: 20px 0;">
                        <ul id="bargainContent wB100 mT30 mB30" style="border: 1px solid #999;border-radius: 4px;">
                            <li ng-if="contactAdd != undefined && contactAdd != ''" class="text-center" style="font-size: 24px;color:#000000">合同内容</li>
                            <li class="contract1" style="height: 300px;overflow-y: auto">
                                <span class="contractCss" ng-bind-html="contentTeach | to_Html"></span>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div class="row clearfix" style="margin-top: 20px; border-top: solid 1px #e5e5e5;">
            <div class="fr col-sm-4 clearfix text-right" style="margin-top:10px;margin-bottom: 10px;">
                <button class="btn btn-default btnCancel">取消</button>
                <button type="submit" class="btn btn-success " ladda="setHttpButtonFlag" style="margin-left:10px ;margin-right: 30px;" ng-click="setHttp()">完成</button>
            </div>
        </div>
    </main>

</div>
