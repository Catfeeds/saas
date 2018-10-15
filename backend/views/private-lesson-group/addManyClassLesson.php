<?php
/**
 * author:张亚鑫<zhangyaxin@itsports.club>
 * date:2017-12-28
 * 描述：新增多人私教课程分页
 */
use backend\assets\PrivateLessonGroupAsset;
PrivateLessonGroupAsset::register($this);
$this->title = '新增多人单课种产品';
?>
<header class="reservation_header clearfix fw">
    <div class="w20  fl"><a href="/private-lesson-group" style="color: #ffffff">小团体课产品</a></div>
    <div class="fl">新增多人单课种产品</div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<div id="private" class="container-fluid" style=" background: #f5f5f5" ng-controller="addManyClassLessonCtrl">
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
    <main class="main">
        <h4>1.基本属性</h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div class="row">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class="red">*</strong>产品名称&emsp;&emsp;</span>
                        <input type="text" ng-model="name" placeholder="产品的名称" class="form-control fl">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5"><strong class="red">*</strong>每月上课数量</span>
                        <input type="text" inputnum ng-model="monthUpNum" min="0" placeholder="每月上课数量" class="form-control fl">
                    </div>
                    <div class="col-sm-4 clearfix" style="position: relative;">
                        <span class="fl"><strong class="red">*</strong>课程类型&emsp;&emsp;</span>
                        <select style="border: solid 1px gainsboro;font-size: 14px;" ng-model="courseType">
                            <option value="">请选择类型</option>
                            <option value="1">购买</option>
                            <option value="2">赠送</option>
                        </select>
                    </div>
                    <div class="col-sm-4 clearfix" id="unLimit">
                        <span class="fl"><strong class="red">*</strong>售卖总数量&emsp;</span>
                        <div class="fl clearfix addUnlimited h32 inputSellNum" style="border: solid 1px #cfdadd;border-radius: 3px;margin-left: 8px">
                            <input style="width:136px;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;margin-right: 0;" type="text" name="sellNum" inputnum min="0" placeholder="0套" class="fl form-control">
                            <div class="checkbox i-checks checkbox-inline " style="top: 4px;margin-left: 2px;">
                                <label>
                                    <input type="checkbox"   value="-1"> <i></i> 不限
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 clearfix cp" style="position: relative;">
                        <span class="fl"><strong class=" red">*</strong>售卖日期&emsp;&emsp;</span>
                        <input type="text" ng-model="saleStart" class="input-sm form-control fl datetimeStart" placeholder="起始日期"  style="width: 100px;text-align:left;font-size: 14px;cursor: pointer;">
                        <input type="text" ng-model="saleEnd" class="input-sm form-control fl datetimeEnd" placeholder="结束日期" style="width: 100px;text-align: left;font-size: 14px;cursor: pointer;">
                    </div>
                </div>
            </form>
        </div>
        <h4>2.课种选择</h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div id="course">
                    <div class="row xxxx">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"><strong class=" red">*</strong>选择课种&emsp;&emsp;</span>
                            <select class="form-control fl" style="padding: 4px 12px;" ng-model="classId">
                                <option value="">请选择课种</option>
                                <option value="{{venue.id}}"  ng-repeat="venue in optionClass">{{venue.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"><strong class="red">*</strong>课程时长&emsp;&emsp;</span>
                            <input type="text" inputnum name="classTime" ng-model="classTime"  min="0" placeholder="0分钟" class="form-control fl">
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5"><strong class="red">*</strong>单节原价&emsp;&emsp;</span>
                            <input type="text" inputnum name="onePrice" ng-model="onePrice" placeholder="0元" class="form-control fl" style="margin-left: 10px">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <h4>3.多人阶梯价格</h4>
        <div style="margin-top: 10px;">
<!--            <form action="">-->
            <div id="numLimit">
                <div class="row  clearfix" style="margin-left: -1px">
                    <div class="row">
                        <div class="col-sm-4 clearfix" style="margin-left: -1px">
                            <span class="fl mT5"><strong class=" red">*</strong>课程节数设置&nbsp;</span>
                            <input type="text" inputnum name="intervalEnd" placeholder="0节" class="form-control cp fl" style="width: 95px;">
                        </div>
                    </div>
                    <div class="row personLimit" id="">
                        <div class="clearfix">
                            <div class="col-sm-4 clearfix">
                                <span class="fl mT5"><strong class=" red">*</strong>人数设置&emsp;&emsp;&nbsp;</span>
                                <input type="text" inputnum name="classPersonRight" placeholder="0人" class="form-control cp fl" style="width: 95px;">
                            </div>
                            <div class="col-sm-4 clearfix">
                                <span class="fl mT5"><strong class=" red">*</strong>单节优惠价&emsp;&emsp;&nbsp;</span>
                                <input style="margin-left: -10px;" type="text" inputnum name="unitPrice" placeholder="0元" class="form-control cp fl">
                            </div>
                            <div class="col-sm-4 clearfix">
                                <span class="fl mT5"><strong class=" red">*</strong>单节POS价&emsp;&emsp;&emsp;&nbsp;</span>
                                <input style="margin-left: -26px;" type="text" inputnum name="posPrice" placeholder="0元" class="form-control cp fl">
                            </div>
                            <div class="col-sm-4 clearfix">
                                <span class="fl mT5"><strong class=" red">*</strong>最低开课人数&nbsp;</span>
                                <input type="text" inputnum name="lowNum" placeholder="0人" class="form-control cp fl">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--            </form>-->
            <div class="row addPersonLimit1" >
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button class="btn btn-default fl" id="addPersonLimit" venuehtml  ng-click="addPersonLimitHtml()" style="margin-left: 4px;">添加人数区间</button>
                </div>
            </div>
            <hr>
            <div class="row addNumLimit">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button class="btn btn-default fl" id="addNumLimit" venuehtml  ng-click="addNumLimitHtml()" style="margin-left: 4px;">添加节数区间</button>
                </div>
            </div>
        </div>
        <h4>4.售卖场馆 </h4>
        <div style="margin-top: 10px;margin-left: 0px">
                <div id="privateVenue">
                <div class="row" >
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;<strong class=" red">*</strong>售卖场馆&emsp;&emsp;</span>
                        <select  class="form-control cp fl"  ng-if="venueStatus == true"  style="padding: 4px 12px;" >
                            <option value="">请选择场馆</option>
                            <option
                                value="{{venue.id}}"
                                ng-repeat="venue in optionVenue"
                                >{{venue.name}}</option>
                        </select>
                        <select class="form-control cp fl" ng-if="venueStatus == false"   style="padding: 4px 12px;" >
                            <option value="">请选择场馆</option>
                            <option value="" disabled style="color:red;">{{optionVenue}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;<strong class=" red">*</strong>单馆售卖数量</span>
                        <input type="text" inputnum name="venueSaleNum" min="0" placeholder="0套" class="form-control cp fl">
                    </div>
                </div>
                </div>

            <div class="row addGroupPrivateVenue">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addGroupPrivateVenue" class="btn btn-default fl" venuehtml ng-click="addGroupSaleVenueHtml()" style="margin-left: 4px;">添加场馆</button>
                </div>
            </div>
        </div>
        <h4>5.赠品 </h4>
        <div style="margin-top: 10px;">
                <div id="productGift">
                    <div class="row">
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;商品名称&emsp;&emsp;</span>
                            <select ng-if="donationStatus == true" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择商品</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionDonation">{{venue.goods_name}}</option>
                            </select>
                            <select ng-if="donationStatus == false" class="form-control cp fl" style="padding: 4px 12px;" >
                                <option value="">请选择商品</option>
                                <option value="" disabled style="color:red;">{{optionDonation}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 clearfix">
                            <span class="fl mT5">&nbsp;商品数量&emsp;&emsp;</span>
                            <input type="text" inputnum min="0" name="giftNum" placeholder="0" class="form-control cp fl">
                        </div>
                    </div>
                </div>
            <div class="row addGroupPrivateGiftBox">
                <div class="col-sm-4 clearfix">
                    <span class="fl">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>
                    <button id="addGroupPrivateGift" class="btn btn-default fl" venuehtml ng-click="addDonationHtml()">添加商品</button>
                </div>
            </div>
        </div>
        <h4>6.转让设置</h4>
        <div style="margin-top: 10px;">
            <form action="">
                <div class="row">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;转让次数&emsp;</span>
                        <input type="text" inputnum ng-model="transferNum" min="0" placeholder="几次" class="form-control cp fl" style="margin-left: 21px">
                    </div>
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;转让金额&emsp;&emsp;</span>
                        <input type="text" inputnum ng-model="transferPrice" min="0" placeholder="0" class="form-control cp fl">
                    </div>
                </div>
            </form>
        </div>
        <h4>7.课程详情</h4>
        <div style="margin-top: 10px;">
            <form action="" >
                <div class="row">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5"><strong class=" red">*</strong>&nbsp;课程介绍&emsp;</span>
                        <textarea ng-model="desc" style="width: 500px;height: 100px;margin-left: 21px;resize: none;" placeholder="请输入课程介绍..."></textarea>
                    </div><br>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5"><strong class=" red">*</strong>&nbsp;添加照片&emsp;</span>
                        <div class="input-file btn "
                             style="margin-left: 21px;width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;"
                             ngf-drop="setCover($file)"
                             ngf-select="setCover($file)">
                            <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;" class="text-center">+</p>
                        </div>
                        <div class="form-group" style="margin-left: 300px;margin-top: -100px;">
                            <img ng-src="{{pic}}" width="100px" height="100px">
                        </div>
                    </div><br>
                </div>
            </form>
        </div>
        <h4>8.合同</h4>
        <div style="margin-top: 10px;">
            <div class="row">
                <form class="form-horizontal">
                    <div class="col-sm-4 clearfix">
                        <span class="fl mT5">&nbsp;合同名称&emsp;</span>
                        <select ng-model="contactAdd" class="form-control cp fl" ng-change="contactAddChange(contactAdd)" style="margin-left: 22px">
                            <option value="">请选择合同</option>
                            <option value="{{contact.id}}" ng-repeat="contact in contactList">
                                {{contact.name}}
                            </option>
                        </select>
                        <!--<select ng-click="" ng-modal="contactAdd" ng-show="contactStatus == false" class="form-control cp fl"  style="margin-left: 22px">
                            <option value="">请选择合同</option>
                            <option value="" disabled style="color:red;">
                                {{contactList}}
                            </option>
                        </select>-->
                    </div>
                    <div class="col-sm-12" style="margin: 20px 0;">
                        <ul style="border: 1px solid #999;border-radius: 4px;">
                            <!--<li style="height: 300px;overflow-y: auto">
                                <span></span>
                            </li>-->
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
                <button type="submit" class="btn btn-success" style="margin-left:10px ;margin-right: 30px;" ng-click="setHttp()">完成</button>
            </div>
        </div>
    </main>
</div>