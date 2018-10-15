<!-- 修改私教课程模态框 -->
<!-- 私教课程-修改基本属性模态框 -->
<div class="modal fade" id="changeBasicTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 75%;min-width: 930px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">基本属性修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">1.基本属性</p>
                    </div>
                    <div class="col-sm-12 pd0 changeBasicAttrAllDiv">
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品名称：</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="name" type="text" class="w100Percent">
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品类型：</div>
                            <div class="col-sm-8 pd0">
                                <select ng-model="privateClassDetails.product_type" name="" id="" class="w100Percent">
                                    <option value="">请选择产品类型</option>
                                    <option ng-repeat="productType in productType" value="{{productType.id}}">{{productType.type}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>每月上课数量：</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="monthNum" inputnum min="0" class="w100Percent">
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品激活期限：</div>
                            <div class="col-sm-8 pd0">
                                <div class="col-sm-7 pd0">
                                    <input ng-model="activatedTime" inputnum class="w100Percent">
                                </div>
                                <div class="col-sm-4 col-sm-offset-1 pd0">
                                    <select ng-model="activatedUnit" name="" id="" class="w100Percent">
                                        <option value="1" ng-selected="unit">天</option>
                                        <option value="7">周</option>
                                        <option value="30">月</option>
                                        <option value="90">季</option>
                                        <option value="365">年</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0" style="margin-top: 15px;">
                            <div class="col-sm-4 pd0">售卖总数量：</div>
                            <div class="col-sm-8 pd0">
                                <div class="changeSellAllNumDiv" id="unLimit">
                                    <input name="sellNum" ng-model="sellNum" inputnum min="0" style="margin-top: -1px;margin-left: -1px;">
                                    <div class="checkbox i-checks checkbox-inline t4" style="margin-top: 0px ;margin-right: 0;">
                                        <label style="padding-left: 0;"><input type="checkbox" value="-1" name="checkbox" class="changeSellAllNumCheckBox" style="margin-top: 0;height: 22px;"> <i></i> 不限</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0" style="padding-bottom: 1px;">
                            <div class="col-sm-4 pd0"><span class="red">*</span>售卖日期：</div>
                            <div class="col-sm-8 pd0">
                                <div class="col-sm-6 pd0">
                                    <input id ="datetimeStart" ng-model="sellStart" type="text" class="w100Percent">
                                </div>
                                <div class="col-sm-5 col-sm-offset-1 pd0">
                                    <input id="datetimeEnd" ng-model="sellEnd" type="text" class="w100Percent">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>课程类型：</div>
                            <div class="col-sm-8 pd0">
                                <select ng-model="privateClassDetails.course_type" name="" id="" class="w100Percent">
                                    <option value="">请选择类型</option>
                                    <option ng-repeat="courseType in courseType" value="{{courseType.id}}">{{courseType.type}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>所属场馆：</div>
                            <div class="col-sm-8 pd0">
                                <select style="border: solid 1px gainsboro;font-size: 14px;" ng-model="venueTypeId" class="w100Percent">
                                    <option value="">请选择场馆</option>
                                    <option value="{{i.id}}" ng-repeat="i in venueLists">{{i.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="basicTypeUpdateLoad" ng-click="basicTypeUpdateData()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 私教课程-修改课种选择模态框 -->
<div class="modal fade" id="changeClassChooseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">课种选择修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">2.课种选择</p>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv">
                        <div class="col-sm-4 mt20">
                            <div class="col-sm-4 pd0"><span class="red">*</span>选择课种：</div>
                            <div class="col-sm-8 pd0">
                                <select ng-model="courseId" name="" id="" class="form-control selectPadding">
                                    <option value="">请选择</option>
                                    <option ng-repeat="course in allCourseData"
                                            ng-selected="course.id == privateClassDetails.course[0].course_id"
                                            value="{{course.id}}">{{course.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20">
                            <div class="col-sm-4 pd0"><span class="red">*</span>课程时长：</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="courseLength" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4 mt20">
                            <div class="col-sm-4 pd0"><span class="red">*</span>单节原价：</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="originalPrice" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4 mt20">
                            <div class="col-sm-4 pd0">移动端单节原价：</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="appOriginalPrice" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="courseUpdateLoad" ng-click="courseUpdateData()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 私教课程-修改产品价格模态框 -->
<div class="modal fade" id="changeProductPriceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" id="courseSection" style="min-width: 870px;max-width: 1200px;width: 80%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">产品价格修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">3.产品价格&nbsp;&nbsp;&nbsp;&nbsp;
                            <span style="color: #ccc;font-weight: 700;font-size: 12px;">
<!--                                <span class="glyphicon glyphicon-info-sign"></span>-->
<!--                                如果需要添加多个课程区间，请先点击添加区间后再填区间数-->
                            </span>
                        </p>
                    </div>
                    <div class="col-sm-12  col-md-12 col-xs-12 pdLr0" id="courseSectionNumBox">
                        <div class="col-sm-12 col-md-12  col-xs-12 pdLr0 removeDivBox courseSectionNum" ng-if="privateClassDetails.price.length == 0"  >
                            <div class="col-sm-6 col-md-4 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>课程节数区间:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <div class="col-sm-5 col-md-5 col-xs-5 pdLr0 heightCenter">
                                        <input  type="number" name="startSec" inputnum class="form-control " placeholder="节">
                                    </div>
                                    <span class="col-sm-2 col-md-2 col-xs-2 pdLr0 text-center" style="padding-top: 4px;">至</span>
                                    <div class="col-sm-5 col-md-5 col-xs-5 pdLr0">
                                        <input ng-blur="endSectionBlur($event)"  type="number" name="endSec" inputnum class="form-control " placeholder="节">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>优惠单价:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <input type="number" name="discountPrice" class="form-control" placeholder="元">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>POS价:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <input type="number" name="posPrice" class="form-control" placeholder="元">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>移动端折扣:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0" style="margin-left: 50px">
                                    <input type="number" name="appDiscount" class="form-control" placeholder="请输入折扣">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-xs-6 mT20 heightCenter">
                                <button class="btn btn-default btn-sm removeHtml" data-remove="removeDivBox">删除</button>
                            </div>
                        </div>
<!--                        有之前产品价格区间-->
                        <div class="col-sm-12 col-md-12  col-xs-12 pdLr0 removeDivBox courseSectionNum" ng-if="privateClassDetails.price.length >0"  ng-repeat="($secIndex,secPrice) in privateClassDetails.price">
                            <div class="col-sm-6 col-md-4 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>课程节数区间:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <div class="col-sm-5 col-md-5 col-xs-5 pdLr0 heightCenter">
                                        <input ng-if="$secIndex == 0"  type="number" name="startSec" inputnum class="form-control " placeholder="节">
                                        <input ng-if="$secIndex != 0"  type="number" name="startSec" inputnum class="form-control " placeholder="节">
                                    </div>
                                    <span class="col-sm-2 col-md-2 col-xs-2 pdLr0 text-center" style="padding-top: 4px;">至</span>
                                    <div class="col-sm-5 col-md-5 col-xs-5 pdLr0">
                                        <input  ng-blur="endSectionBlur($event)" type="number" name="endSec" inputnum class="form-control " placeholder="节">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>优惠单价:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <input type="number" name="discountPrice" class="form-control" placeholder="元">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>POS价:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0">
                                    <input type="number" name="posPrice" class="form-control" placeholder="元">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
                                <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>移动端折扣:</div>
                                <div class="col-sm-8 col-md-8 col-xs-7 pd0" style="margin-left: 50px">
                                    <input type="number" name="appDiscount" class="form-control" placeholder="请输入折扣">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-xs-6 mT20 heightCenter" ng-if="$secIndex != 0">
                                <button class="btn btn-default btn-sm removeHtml" data-remove="removeDivBox">删除</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12 mT20" id="addCourseSectionBtnBox">
                        <div class="col-sm-6 col-md-4 col-xs-6">
                            <button id="addCourseSectionBtn" venuehtml="" class="btn btn-default" ng-click="addCourseSectionHtml()">添加区间</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="courseSectionEditFlag" ng-click="courseSectionEdit()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改售卖场馆模态框 -->
<div class="modal fade" id="changeSellVenueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="min-width: 720px;max-width: 900px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">售卖场馆修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">4.售卖场馆
                            <span style="color: #ccc;font-weight: 700;font-size: 12px;">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                如售卖场馆不选择则视为不限
                            </span>
                        </p>
                    </div>
                    <div class="ptServeSellVenueBox col-sm-12 col-xs-12 pdLr0">
                        <div class="col-sm-12 col-xs-12 mT20 ptServeSellVenue pdLr0" ng-if="privateClassDetails.venue.length == 0" >
                            <div class="col-sm-5 col-xs-5 mt20">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>售卖场馆:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <select class="form-control selectPadding " name="sellVenue">
                                        <option value="">请选择</option>
                                        <option title="{{sellVenue.name}}" value="{{sellVenue.id}}" ng-repeat="sellVenue in optionVenue">{{sellVenue.name |cut:true:8:'...'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-5 mt20">
                                <div class="col-sm-5 col-xs-5 pd0"><span class="red">*</span>单馆售卖数量:</div>
                                <div class="col-sm-7 col-xs-7 pd0">
                                    <input type="number" name="num" placeholder="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 mT20 ptServeSellVenue pdLr0 removeDivBox" ng-if="privateClassDetails.venue.length > 0" ng-repeat="($oldIndex,oldVenue) in privateClassDetails.venue">
                            <div class="col-sm-5 col-xs-5 ">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>售卖场馆:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <select class="form-control selectPadding " name="sellVenue" ng-click="selectSellVenue123()" >
                                        <option value="">请选择</option>
                                        <option ng-selected="oldVenue.venue_id == sellVenue.id" ng-disabled="sellVenue.id | attrVenue:sellVenueArr123" title="{{sellVenue.name}}" value="{{sellVenue.id}}" ng-repeat="sellVenue in optionVenue">{{sellVenue.name |cut:true:8:'...'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-5 ">
                                <div class="col-sm-5 col-xs-5 pd0"><span class="red">*</span>单馆售卖数量:</div>
                                <div class="col-sm-7 col-xs-7 pd0">
                                    <input type="number" name="num" placeholder="0" class="form-control">
                                </div>
                            </div>
                            <div  class="col-sm-2 col-xs-2 " ng-if="$oldIndex != 0">
                                <button class="btn btn-default btn-sm removeHtml" data-remove="removeDivBox">删除</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12  changeAddButtonMT" id="addPTSellVenueBtnBox">
                        <button id="addPTSellVenueBtn" class="btn btn-default" ng-click="addPTSellVenueBtnHtml()" venuehtml="">添加场馆</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="ptSellVenueEditFlag" ng-click="ptSellVenueEditComplete()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改赠品模态框 -->
<div class="modal fade" id="changeFreeGiftsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="min-width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">赠品修改</h4>
            </div>
            <div class="modal-body" id="productGift">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">5.赠品</p>
                    </div>
                    <div class="col-sm-12 col-xs-12 pd0 "id="giftShopEdit123123Box">
                        <div class="col-sm-12 col-xs-12 changeBasicAttrAllDiv giftShopBox123 " ng-if="privateClassDetails.gift.length == 0" >
                            <div class="col-sm-5 col-xs-5 mT20">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品名称:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <select name="giftShopEdit"  class="form-control selectPadding"  >
                                        <option value="">请选择</option>
                                        <option ng-repeat="giftData in allGiftData"
                                                value="{{giftData.id}}">{{giftData.goods_name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-5 mT20">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品数量:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <input type="number" inputnum min="0" placeholder="0" name="giftNum" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 changeBasicAttrAllDiv giftShopBox123 removeDivBox" ng-if="privateClassDetails.gift.length > 0" ng-repeat="($oldIndex,oldGift) in privateClassDetails.gift">
                            <div class="col-sm-5 col-xs-5 mT20">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品名称:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <select name="giftShopEdit" ng-click="shopGiftSelectClick()" class="form-control selectPadding"  >
                                        <option value="">请选择</option>
                                        <option ng-repeat="giftData in allGiftData"
                                                ng-selected="oldGift.gift_id == giftData.id"
                                                ng-disabled=" giftData.id | attrVenue:giftId"
                                                value="{{giftData.id}}">{{giftData.goods_name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-5 mT20">
                                <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品数量:</div>
                                <div class="col-sm-8 col-xs-7 pd0">
                                    <input type="number" inputnum min="0" placeholder="0" name="giftNum" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-2 mT20">
                                <button class="btn btn-default btn-sm removeHtml" data-remove="removeDivBox">删除</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 changeAddButtonMT" id="addShopGiftEditBox" ng-if="$oldIndex != 0">
                        <button id="addShopGiftEdit" venuehtml="" class="btn btn-default" ng-click="addGiftShopHtml1321()">添加赠品</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="giftUpdateLoad" ng-click="giftUpdate()">完成</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改转让设置模态框 -->
<div class="modal fade" id="changeTransferSettingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id="myModalLabel">转让设置修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">6.转让设置</p>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv">
                        <div class="col-sm-6 mt20">
                            <div class="col-sm-4 pd0">转让次数：</div>
                            <div class="col-sm-8 pd0">
                                <input type="text" ng-model="transferNum" class="w100Percent">
                            </div>
                        </div>
                        <div class="col-sm-6 mt20">
                            <div class="col-sm-4 pd0">转让金额：</div>
                            <div class="col-sm-8 pd0">
                                <input type="text" ng-model="transferPrice" class="w100Percent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="transferUpdateLoad" ng-click="changeTransferUpdate()">完成</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改预约设置模态框 -->
<!--<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title text-center" id="myModalLabel">预约设置</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!---->
<!--            </div>-->
<!--            <div class="modal-footer modalFooterButtonCenter">-->
<!--                <button type="button" class="btn btn-success">修改</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- 修改课程详情模态框 -->
<div class="modal fade" id="changeClassDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">课程详情修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 beCenterMiddle">
                        <p class="titleP">7.课程详情</p>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv">
                        <div class="col-sm-8 mt20 beCenterMiddle">
                            <div class="col-sm-3 pd0">课程介绍：</div>
                            <div class="col-sm-9 pd0">
                                <textarea ng-model="note" placeholder="请输入课程介绍..." style="width: 100%;height: 200px;margin-bottom: 30px;resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-8 mt20 beCenterMiddle changeBasicAttrAllDiv">
                            <div class="col-sm-3 pd0">添加照片：</div>
                            <div class="form-group">
                                <img ng-if="photo != null" ng-src="{{photo}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: 76px">
                                <img ng-if="photo == null" ng-src="{{}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: 76px">
                            </div>
                            <div class="input-file"
                                 style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 394px"
                                 ngf-drop="setCover($file)"
                                 ladda="uploading"
                                 ngf-select="setCover($file);"
                                 ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                 ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                <p style="margin-left: 20px;width: 100%;height: 100%;line-height: 85px;font-size: 50px;" class="text-center">+</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="classDetailUpdateLoad" ng-click="classDetailUpdate()">完成</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改合同模态框 -->
<div class="modal fade" id="changeContractDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">合同修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">8.合同</p>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv">
                        <div class="col-sm-6 mt20 beCenterMiddle">
                            <div class="col-sm-5 pd0">请选择合同：</div>
                            <div class="col-sm-7 pd0">
                                <select name="" id="" class="w100Percent" ng-model="dealId" ng-change="getDealId(dealId)">
                                    <option value="">请选择</option>
                                    <option ng-selected="deal.id == privateClassDetails.deal_id"
                                            value="{{deal.id}}" ng-repeat="deal in dealData track by $index">{{deal.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv">
                        <main class="col-sm-12 pdLR0 mT20" style="min-height:200px;max-height: 400px;overflow-y: scroll;border: solid 1px #5E5E5E;">
                            <ul id="bargainContent" style="padding: 20px;">
                                <li class="contract1">
                                    <span class="contractCss" ng-bind-html="dataDeal.intro | to_Html"></span>
                                </li>
                            </ul>
                        </main>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="contractUpdateLoad" ng-click="contractDetailUpdate()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 绑定服务修改的模态框 -->
<!-- 目前没有找到对应按钮，暂时注释 -->
<!--<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title text-center" id="myModalLabel">绑定服务修改</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!---->
<!--            </div>-->
<!--            <div class="modal-footer modalFooterButtonCenter">-->
<!--                <button type="button" class="btn btn-success">修改</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- 私教服务-修改基本属性模态框 -->
<div class="modal fade" id="changeBasicTypeModalS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 75%;min-width: 930px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">基本属性修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">1.基本属性</p>
                    </div>
                    <div class="col-sm-12 pd0 changeBasicAttrAllDiv">
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品名称:</div>
                            <div class="col-sm-8 pd0">
                                <input ng-model="name" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品类型:</div>
                            <div class="col-sm-8 pd0">
                                <select ng-model="privateClassDetails.product_type" name="" id="" class="form-control selectPadding">
                                    <option value="">请选择产品类型</option>
                                    <option ng-repeat="productType in productType" value="{{productType.id}}">{{productType.type}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pdLr0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品有效期限:</div>
                            <div class="col-sm-8 pd0">
                                <div class="col-sm-7 pd0">
                                <input ng-model="validTime" inputnum min="0" class="form-control">
                                </div>
                                <div class="col-sm-4 col-sm-offset-1 pd0">
                                    <select ng-model="validUnit" name="" id="" class="form-control selectPadding">
                                        <option value="1" ng-selected="unit">天</option>
                                        <option value="7">周</option>
                                        <option value="30">月</option>
                                        <option value="90">季</option>
                                        <option value="365">年</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pdLr0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>产品激活期限:</div>
                            <div class="col-sm-8 pd0">
                                <div class="col-sm-7 pd0">
                                    <input ng-model="activatedTime" inputnum class="form-control">
                                </div>
                                <div class="col-sm-4 col-sm-offset-1 pd0">
                                    <select ng-model="activatedUnit" name="" id="" class="form-control selectPadding">
                                        <option value="1" ng-selected="unit">天</option>
                                        <option value="7">周</option>
                                        <option value="30">月</option>
                                        <option value="90">季</option>
                                        <option value="365">年</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0" style="margin-top: 15px;">
                            <div class="col-sm-4 pd0">售卖总数量：</div>
                            <div class="col-sm-8 pd0">
                                <div class="changeSellAllNumDiv" id="unLimit2">
                                    <input name="sellNum" ng-model="sellNum" inputnum min="0" style="margin-top: -1px;margin-left: -1px;">
                                    <div class="checkbox i-checks checkbox-inline t4" style="margin-top: 0px ;margin-right: 0;">
                                        <label style="padding-left: 0;"><input type="checkbox" value="-1" name="checkbox" class="changeSellAllNumCheckBox" style="margin-top: 0;height: 22px;"> <i></i> 不限</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>售卖日期：</div>
                            <div class="col-sm-8 pd0">
                                <div class="col-sm-6 pd0">
                                    <input id ="datetimeStartServe" ng-model="sellStart" type="text" class="form-control">
                                </div>
                                <div class="col-sm-6 " style="padding-right: 0;padding-left: 4px;">
                                    <input id="datetimeEndServe" ng-model="sellEnd" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>课程类型：</div>
                            <div class="col-sm-8 pd0">
                                <select ng-model="privateClassDetails.course_type" name="" id="" class="form-control selectPadding">
                                    <option value="">请选择类型</option>
                                    <option ng-repeat="courseType in courseType" value="{{courseType.id}}">{{courseType.type}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt20 pd0">
                            <div class="col-sm-4 pd0"><span class="red">*</span>所属场馆：</div>
                            <div class="col-sm-8 pd0">
                                <select style="border: solid 1px gainsboro;font-size: 14px;" ng-model="venueTypeId" class="form-control selectPadding">
                                    <option value="">请选择场馆</option>
                                    <option value="{{i.id}}" ng-repeat="i in venueLists">{{i.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="basicTypeUpdateLoad" ng-click="basicTypeUpdateData()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 私教服务-修改课种选择模态框 -->
<div class="modal fade" id="changeClassChooseModalS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 800px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">课种选择修改</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="courseDiv">
                    <div class="col-sm-12 col-xs-12">
                        <p class="titleP">2.课种选择</p>
                    </div>
                    <div id="ptServeClassBox" class=" col-sm-12 col-xs-12 pdLr0">
                        <div class="col-sm-12 changeBasicAttrAllDiv allCourse ptServerBoxEdit removeDivBox" ng-repeat="($keyIndex,servePtCourse) in privateClassDetails.course">
                            <div class="col-sm-4 col-xs-6 mt20">
                                <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>选择课种：</div>
                                <div class="col-sm-8 col-xs-8 pd0">
                                    <select  name="courseId" id="" class="form-control selectPadding" ng-click="oldCourseIdArrClick()">
                                        <option value="">请选择</option>
                                        <option title="{{course.name}}" ng-repeat="course in allCourseData"
                                                ng-disabled="course.id | attrVenue:oldCourseIdArr123"
                                                ng-selected="course.id == servePtCourse.course_id"
                                                value="{{course.id}}">{{course.name |cut:true:8:'...'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 mt20">
                                <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>课程时长：</div>
                                <div class="col-sm-8 col-xs-8 pd0">
                                    <input  name="courseLength" placeholder="分钟" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 mt20">
                                <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>课程节数：</div>
                                <div class="col-sm-8 col-xs-8 pd0">
                                    <input  name="courseNum"  placeholder="节" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 mt20">
                                <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>单节原价：</div>
                                <div class="col-sm-8 col-xs-8 pd0">
                                    <input  name="originalPrice" placeholder="元"  type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 mt20">
                                <div class="col-sm-4 col-xs-4 pd0">移动端单节原价：</div>
                                <div class="col-sm-8 col-xs-8 pd0">
                                    <input  name="appOriginalPrice" placeholder="元"  type="number" class="form-control">
                                </div>
                            </div>
                            <div  class="col-sm-4 col-xs-6 mt20 " ng-if="$keyIndex != 0">
                                <button class="btn btn-default btn-sm removeHtml" data-remove="removeDivBox">删除</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 changeAddButtonMT" id="addServeClassEditBox">
                        <button id="addServeClassEdit" class="btn btn-default" venuehtml="" ng-click="addServerClassHtml123()">添加课种</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="courseUpdateLoad" ng-click="courseUpdateData()">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- 私教服务-修改产品价格模态框 -->
<div class="modal fade" id="changeProductPriceModalS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">产品价格修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="titleP">3.产品价格&nbsp;&nbsp;&nbsp;&nbsp;
<!--                            <span style="color: #ccc;font-weight: 700;font-size: 12px;">-->
<!--                                <span class="glyphicon glyphicon-info-sign"></span>-->
<!--                                该课程总原价￥/金额-->
<!--                            </span>-->
                        </p>
                    </div>
                    <div class="col-sm-12 changeBasicAttrAllDiv" id="totalPirce123">
                        <div class="col-sm-6 mt20">
                            <div class="col-sm-4 pd0"><span class="red"></span>总售价：</div>
                            <div class="col-sm-8 pd0">
                                <input type="number" name="serveTotalPirce123"   placeholder="元" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6 mt20">
                            <div class="col-sm-4 pd0"><span class="red"></span>总POS价：</div>
                            <div class="col-sm-8 pd0">
                                <input type="number" name="servePosPirce123"    placeholder="元" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6 mt20">
                            <div class="col-sm-4 pd0">移动端总售价：</div>
                            <div class="col-sm-8 pd0">
                                <input type="number" name="appTotalPrice123" placeholder="元" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modalFooterButtonCenter">
                <button type="button" class="btn btn-success" ladda="servePriceLoadFlag" ng-click="servePriceEdit()">修改</button>
            </div>
        </div>
    </div>
</div>

<!--私教产品增加折扣设置-->
<div class="modal fade" id="setPrivateClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">设置折扣</h4>
            </div>
            <div class="modal-body discountSettingAllBox">
                <div class="row discountSettingBox">
                    <div class="setDiscountSmallBox" ng-if="getDiscountList.length === 0">
                        <div class="col-sm-12 mt20">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>设置折扣：
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control chooseDiscount" style="border: 1px solid #aaa;border-radius: 4px;height: 32px;">
                                <span class="glyphicon glyphicon-info-sign" style="line-height: 30px;">多个折扣用"/"分开,例如: 8.5/7.0</span>
                            </div>
                        </div>
                        <div class="col-sm-12 mt20" style="margin-bottom: 30px;">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>使用角色：
                            </div>
                            <div class="col-sm-8">
                                <select class="chooseRoleSelect" multiple>
                                    <option ng-repeat="roles in roleListChoose" value="{{roles.id}}">{{roles.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="setDiscountSmallBox" ng-repeat="getDiscount in getDiscountList">
                        <div class="col-sm-12 mt20">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>设置折扣：
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control chooseDiscount" style="border: 1px solid #aaa;border-radius: 4px;height: 32px;">
                                <span class="glyphicon glyphicon-info-sign" style="line-height: 30px;">多个折扣用"/"分开,例如: 8.5/7.0</span>
                            </div>
                        </div>
                        <div class="col-sm-12 mt20" style="margin-bottom: 30px;">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>使用角色：
                            </div>
                            <div class="col-sm-8">
                                <select class="chooseRoleSelect" multiple>
                                    <option ng-repeat="roles in roleListChoose" value="{{roles.id}}">{{roles.name}}</option>
                                </select>
                                <button class="btn btn-default mt20 removeHtml removeDiscountBtn" ng-if="$index !== 0" data-remove="removeDiv" data-zhangyaxin-id="{{getDiscount.id}}" data-remove-index="{{$index}}" ng-click="removeDiscountHtml($index)">删除</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-default" id="setDiscount" venuehtml ng-click="addNewDiscountHtml()">新增折扣设置</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-click="setPrivateClass()">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>