
<!--/**
 * Created by PhpStorm.
 * User: 程丽明
 * Date: 2017/10/30
 * Time: 11:37
 *content:卡种详情和修改
 */-->
<!-- 卡种详情-->
<div class="modal fade" id="myModals2" style="overflow: scroll" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog mT30 " style="width: 80%;min-width: 720px;">
        <div class="modal-content clearfix borderNone" >
            <div class="modal-header borderNone">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="panel blank-panel col-sm-12 col-xs-12">
                    <div class="panel-heading">
                        <div class="panel-title m-b-md">
                            <h3 class="text-center">卡种详情</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12 col-xs-12" style="display: flex;align-items: center;">
                            <div class="col-sm-12 col-xs-12">
                                <div class="col-sm-12  col-xs-12" >
                                    <section  class="col-sm-12 col-xs-12">
                                        <div style="width: 100%; " class="text-center">
                                            <img class="w250" ng-if="theData.pic == null || theData.pic == ''" ng-src="/plugins/img/card111.png" style="width: 200px;height: 150px" >
                                            <img class="img-rounded w250" ng-if="theData.pic != null && theData.pic != ''" ng-src="{{theData.pic}}" style="width: 200px;height: 150px">
                                            <!--                                                <div class="pAbsolute mL6 pT10">{{theData.card_name}}</div>-->
                                        </div>
                                    </section>
                                </div>
                                <div class="col-sm-12 col-xs-12 contentBetween" >
                                    <b>基本属性</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'ATTRIBUTESUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="basicAttributesEdit()">基本属性修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 col-xs-6 lH30">所属场馆:
                                        <span >{{theData.organization.name | noData:''}}</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">卡的属性:
                                        <span ng-if="theData.attributes == 1">个人</span>
                                        <span ng-if="theData.attributes == 2">家庭</span>
                                        <span ng-if="theData.attributes == 3">公司</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">卡的类型:
                                        <span ng-if="theData.card_type == 1">瑜伽</span>
                                        <span ng-if="theData.card_type == 2">健身</span>
                                        <span ng-if="theData.card_type == 3">舞蹈</span>
                                        <span ng-if="theData.card_type == 4">综合</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">卡的名称:{{theData.card_name}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30">卡的别名:{{theData.another_name | noData:''}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30" ng-if="categoryTypeId == 2">卡的次数:{{theData.times | noData:''}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30" ng-if="categoryTypeId == 2">扣次方式:
                                        <span ng-if="theData.count_method == '1'">按时效扣次</span>
                                        <span ng-if="theData.count_method == '2'">按次数扣次</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">激活期限:{{theData.active_time | noData:''}}天</div>
                                    <div class="col-sm-4 col-xs-6 lH30">有效天数:{{theData.duration | stringToArr}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30">卡的单数:{{theData.single | noData:''}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30" ng-if="categoryTypeId == 1">是否带人:
                                        <span ng-if="theData.bring == 0 ||theData.bring == ''|| theData.bring == null">不带人</span>
                                        <span ng-if="theData.bring != 0 && theData.bring >0">带{{theData.bring}}人</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                    <b>定价和售卖</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'PRICEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="pricingAndSellingEdit()">定价售价修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 col-xs-6 lH30">
                                        <span ng-if="theData.sell_price == null">卡的售价:{{theData.min_price}}-{{ theData.max_price}}元</span>
                                        <span ng-if="theData.sell_price != null">卡的售价:{{theData.sell_price}}元</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">优惠价&emsp;:{{theData.offer_price  | noData:'元'}}</div>
                                   <!-- <div class="col-sm-4 col-xs-6 lH30">普通续费:{{theData.ordinary_renewal | noData:'元'}}</div>-->
                                    <div class="col-sm-4 col-xs-6 lH30" ng-if="validLists.length > 0">有效期续费:
                                        <span ng-repeat="valid in  validLists">
                                        {{valid.day}}<span ng-if="valid.type == 'd'">天</span>
                                        <span ng-if="valid.type == 'm'">月</span>
                                        <span ng-if="valid.type == 'q'">季</span>
                                        <span ng-if="valid.type == 'y'">年</span>/{{valid.price}}元 ,</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">移动端售价:{{theData.app_sell_price | noData:'元'}}</div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                    <b>售卖场馆</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'SELLVENUEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="sellingVenueEdit()">售卖场馆修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-repeat="(key123,value123) in theData.sellVenue">
                                    <div class="col-sm-4 col-xs-6  lH30">售卖场馆: <span>{{value123.name}}</span></div>
                                    <div class="col-sm-4 col-xs-6 lH30">售卖张数: <span>{{value123.limit == -1 ?'不限':value123.limit}}</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">售卖日期: <span>{{value123.sell_start_time*1000 | date:'yyyy-MM-dd'}}至{{value123.sell_end_time*1000 | date:'yyyy-MM-dd'}}</span></div>
                                    <div class="col-sm-12 pdLR0" ng-if="value123.cardDiscount.length > 0"  ng-repeat="dis in value123.cardDiscount">
                                        <div class="col-sm-4 col-xs-6 lH30" ng-if="dis.discount != '' && dis.discount != undefined">折扣&emsp;&emsp;:{{dis.discount}}折</div>
                                        <div class="col-sm-4 col-xs-6 lH30" ng-if="dis.surplus != '' && dis.surplus != undefined">折扣张数:{{dis.surplus == -1 ? '不限':dis.surplus}}</div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                    <b>通用场馆限制</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'APPLYVENUEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="applyVenueEdit()">通用场馆修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-repeat="(keys132,Venue123) in theData.goVenue">
                                    <div class="col-sm-4 col-xs-6 lH30">通用场馆:
                                        <span ng-if="Venue123.name == null || Venue123.name == ''">
                                            <span ng-repeat="ven in  Venue123.organization">
                                                <span title="{{ven.name}}">{{ven.name |cut:true:4:'...'}} <span ng-if="$index != Venue123.organization.length-1">,</span>  </span>
                                            </span>
                                        </span>
                                        <span ng-if="Venue123.name != null && Venue123.name != ''">
                                            <span >{{Venue123.name}}</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">进馆时间:
                                        <span ng-if="Venue123.apply_start != null && Venue123.apply_start != ''">{{Venue123.apply_start*1000 | date:'HH:mm'}} - {{Venue123.apply_end*1000 | date:'HH:mm'}}</span>
                                        <span ng-if="Venue123.apply_start == null || Venue123.apply_start == ''">{{'暂无数据'}}<span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">通店限制:
                                        <span ng-if="Venue123.week_times != null && Venue123.week_times != ''">{{Venue123.week_times == -1 ? '不限': Venue123.week_times}}/周</span>
                                        <span ng-if="Venue123.times != null && Venue123.times != ''">{{Venue123.times == -1 ? '不限': Venue123.times}}/月</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">
                                        卡的等级: <span>{{Venue123.level == 1 ? '普通卡': Venue123.level == 2 ? 'VIP卡' : '暂无数据'}}</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">
                                        预约团课时，不受团课预约设置限制：<span>{{Venue123.about_limit == -1 ? '启用': Venue123.about_limit == 1 ? '不启用' : '暂无数据'}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                    <b>进馆时间设置</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'TIMEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="entranceTimeSettingEdit()">进馆时间修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4  lH30" ng-if="theData.cardTime.day.day.length > 0">每月固定日: <span ng-repeat="day in  theData.cardTime.day.day">{{day}},</span></div>
                                    <div class="col-sm-4  lH30" ng-if="theData.cardTime.day.start != ''&& theData.cardTime.day.start != null && theData.cardTime.day.start!=undefined">特定时间段:{{theData.cardTime.day.start}} 至 {{theData.cardTime.day.end}}</div>
                                    <div class="col-sm-4  lH30" ng-if="theData.cardTime.week.weeks.length > 0">特定星期: <span ng-repeat="week123 in  weekStartTimeListsArr ">{{theData.cardTime.week.weeks[week123] | week}},</span></div>
                                    <div class="col-sm-8 lH30" ng-if="theData.cardTime.week.startTime.length > 0 && theData.cardTime.week.endTime.length > 0">特定时间段: <span ng-repeat="weekTime in weekStartTimeListsArr " >{{theData.cardTime.week.startTime[weekTime] == null || theData.cardTime.week.startTime[weekTime] == ''? '全天': theData.cardTime.week.startTime[weekTime]}}<span ng-if="theData.cardTime.week.endTime[weekTime] != null && theData.cardTime.week.endTime[weekTime] != ''">-</span>{{theData.cardTime.week.endTime[weekTime] == null? '': theData.cardTime.week.endTime[weekTime]}},</span></div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                    <b>团课套餐</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'GROUPCLASSUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="classPackageEdit()">卡种团课修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-repeat="league in theData.serverClass">
                                    <div class="col-sm-4 col-xs-6 lH30" >课程名称:
                                        <span ng-if="league.name== null "  ng-repeat="($k,lea) in  league.course" title="{{lea.name}}">{{lea.name |cut:true:4:'...'}} <span ng-if="$k != league.course.length-1">,</span></span>
                                        <span ng-if="league.name != null">{{league.name}}</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">每日节数:{{league.number == -1?'不限':league.number}}</div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                    <b>绑定私课</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'CHARGEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="bindingPrivateLessonsEdit()">卡种私课修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-repeat="charge in theData.serverCharge">
                                    <div class="col-sm-4 col-xs-6 lH30">私课类型:
                                        <span ng-if="charge.polymorphic_type =='hs'">HS</span>
                                        <span ng-if="charge.polymorphic_type =='pt'">PT</span>
                                        <span ng-if="charge.polymorphic_type =='birth'">生日课</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">私课名称:{{charge.chargeClassName | noData:''}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30">私课节数:{{charge.number  | noData:''}}</div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                    <b>赠品</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'GIFTUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="giftEditClick()">卡种赠品修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-if="theData.gift.length != 0" ng-repeat="giftOne in  theData.gift">
                                    <div class="col-sm-4 col-xs-6 lH30">商品:
                                        <span >{{giftOne.goods_name}}</span>
                                    </div>
                                    <div class="col-sm-4 col-xs-6 lH30">数量:{{giftOne.number == -1 ?'不限': giftOne.number}}</div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                    <b>转让</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'TRANSFERUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="assignmentEdit()">卡种转让修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-if="theData.transfer_number != '' && theData.transfer_number != undefined && theData.transfer_number != undefined">
                                    <div class="col-sm-4 col-xs-6 lH30">转让次数:{{theData.transfer_number | noData:''}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30">转让金额:{{theData.transfer_price | noData:''}}元</div>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                    <b>请假</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'LEAVEUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="leaveEditClick()">卡种请假修改</button>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-if="theData.leave_total_days != null  && theData.leave_least_Days != null">
                                    <div class="col-sm-4 col-xs-6 lH30">请假总天数:{{theData.leave_total_days}}</div>
                                    <div class="col-sm-4 col-xs-6 lH30">每次最低天数:{{theData.leave_least_Days}}</div>
                                </div>
                                <div class="col-sm-12 col-xs-12" ng-if="theData.leave_total_days == null && theData.leave_least_Days == null">
                                    <section class="col-sm-12 col-xs-12 pdLR0" ng-repeat="w in leaveLongIimit">
                                        <section class="col-sm-4 col-xs-6">请假次数:<strong >{{w[1]}}</strong>次</section>
                                        <section class="col-sm-4 col-xs-6">每次请假天数:<strong>{{w[0]}}</strong>天</section>
                                    </section>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <section class="col-sm-12 col-xs-12 pdLR0">
                                        <section class="col-sm-4 col-xs-6" ng-if="theData.student_leave_limit != null">暑假天数:<strong>{{summer[0]}}</strong>天</section>
                                        <section class="col-sm-4 col-xs-6" ng-if="theData.student_leave_limit != null">寒假天数:<strong>{{winter[0]}}</strong>天</section>
                                    </section>
                                </div>
                                <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                    <b>合同</b>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'DEALUPDATE')) { ?>
                                        <button class="btn btn-default btn-sm" ng-click="contractEdit()">卡种合同修改</button>
                                    <?php } ?>
                                </div>
                                <div style="margin-top: 10px;">
                                    <div class="row">
                                        <form class="form-horizontal">
                                            <section class="col-sm-12 col-xs-12">
                                                <div style="padding: 0 30px">
                                                    卡的合同:<strong ><span ng-if="theData.deal != null">《</span>{{theData.deal.name | noData:''}} <span ng-if="theData.deal != null">》</span>   </strong>
                                                </div>
                                            </section>
                                            <div ng-if="theData.deal" class="col-sm-12"  style="margin: 20px 0;">
                                                <ul id="bargainContent wB100 mT30 mB30" style="border: 1px solid #999;border-radius: 4px;">
                                                    <li class="text-center" style="font-size: 24px;color:#000000">卡的合同内容</li>
                                                    <li style="height: 300px;overflow-y: auto;padding: 0 10px;line-height: 2;">
                                                        <span class="contractCss" ng-bind-html="theData.deal.intro | to_Html"></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--时间卡基本属性修改模态框-->
<div class="modal fade" id="timeAttributesModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 80%;min-width: 1000px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >卡种属性修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>所属场馆</span>
                    <select  class="form-control cp mL10 selectPd"  ng-change="cardTheVenue(cardTheVenueIdEdit)" ng-model="cardTheVenueIdEdit">
                        <option value="" >请选择场馆</option>
                        <option ng-if="cardTheVenueListsFlag" value="{{venue.id}}"
                                ng-repeat=" venue in cardTheVenueLists"
                        >{{venue.name}}</option>
                        <option ng-if="cardTheVenueListsFlag == false" style="color: red;" disabled>暂无数据</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的属性</span>
                    <select ng-model="cardAttributeEdit" class="form-control cp mL10 selectPd"  >
                        <!--                                                    <option value="{{attr.key}}" ng-repeat="attr in attributesVal">{{attr.val}}</option>-->
                        <option value="1">个人</option>
                        <option value="2">家庭</option>
                        <option value="3">公司</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的类型</span>
                    <!--                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >-->
                    <select ng-model="cardTypeEdit" class="form-control cp mL10 selectPd"  >
                        <option value="1">瑜伽</option>
                        <option value="2">健身</option>
                        <option value="3">舞蹈</option>
                        <option value="4">综合</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的名称</span>
                    <input type="text" placeholder="至尊卡" class="form-control cp mL10"
                           ng-blur="setCardName()" ng-change="setCardName()" ng-model="cardNameEdit">
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right">卡别名</span>
                    <input type="text" placeholder="英文名称" class="form-control cp mL10"
                           ng-model="anotherNameEdit">
                </div>
<!--                <div class="col-sm-4 heightCenter mT20" ng-if="categoryTypeId == 2">-->
<!--                    <span class="width100 text-right"><strong class="red">*</strong>次数</span>-->
<!--                    <input type="number" autocomplete="off" inputnum min="0" placeholder="0次" ng-model="cardTimesEdit" class="mL10 form-control numCardInput" id="exampleInputName3" >-->
<!--                </div>-->
<!--                <div class="col-sm-4 heightCenter mT20" ng-if="categoryTypeId == 2">-->
<!--                    <span class="width100 text-right"><strong class="red">*</strong>扣次方式</span>-->
<!--                    <select ng-model="timesMethodEdit" class="form-control selectPd mL10">-->
<!--                        <option value="1">按时效扣次</option>-->
<!--                        <option value="2">按次数扣次</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right">激活期限</span>
                    <div class="contentBetween wB100 mL10" >
                        <input type="number" inputnum name="num" min="0" placeholder="多少天" class="form-control w115 cp" ng-model="activeTimeEdit">
                        <select class="form-control cp w70 selectPd" id="activeUnitEdit" ng-model="activeUnitEdit" >
                            <option value="1" ng-selected="unit">天</option>
                            <option value="7">周</option>
                            <option value="30">月</option>
                            <option value="90">季</option>
                            <option value="365">年</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>有效天数</span>
                    <div class="contentBetween wB100 mL10" >
                        <input   inputnum type="number" min="0" placeholder="多少天" class="form-control cp w115" ng-model="durationEdit">
                        <select  class="form-control cp w70 selectPd" id="durationUnitEdit" ng-model="durationUnitEdit"  >
                            <option value="1" ng-selected="unit">天</option>
                            <option value="7">周</option>
                            <option value="30">月</option>
                            <option value="90">季</option>
                            <option value="365">年</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span  class="width100 text-right" >单数</span>
                    <input id="Singular" type="number"  ng-model="SingularEdit" inputnum min="0" placeholder="请输入单数" class="form-control cp  mL10">
                </div>
                <div class="col-sm-4 heightCenter mT20" ng-if="categoryTypeId == 1">
                    <span  class="width100 text-right" style="line-height: 1;">带人卡</span>
                    <div  class="contentBetween wB100 " >
                        <input  type="radio" ng-click="withoutHuman()" name="bring" id="bring-false" value="0" style="width: 65px;margin-left: -5px;" />
                        <span style="width: 55px;margin-left: -20px;line-height: 11px;">不带人</span>
                        <input type="radio" ng-click="withPeople()" name="bring" id="bring-true" value="1"  style="width: 65px;margin-left: -35px;"/>
                        <span style="line-height: 11px;margin-left: -17px;">带人</span>
                        <input ng-model="bringEdit" ng-change="withPeopleNum()" inputnum type="number" id="bring-num" name="bring-name"  min="1" max="5" style="width:70px" disabled />
                    </div>
                </div>
                <div class="w100 cp">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5" style="margin-top: 35px;margin-left: 22px">&nbsp;卡种照片&emsp;</span>
                        <div class="form-group">
                            <img ng-if="theData.pic != null" ng-src="{{theData.pic}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: -1px">
                            <img ng-if="theData.pic == null" ng-src="{{}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: -1px">
                        </div>
                        <div class="input-file"
                             style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 362px"
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
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="basicAttributesCompleteFlag" ng-click="basicAttributesComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--次卡卡基本属性修改模态框-->
<div class="modal fade" id="numAttributesModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 80%;min-width: 1000px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >卡种属性修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>所属场馆</span>
                    <select  class="form-control cp mL10 selectPd"  ng-change="cardTheVenue(cardTheVenueIdEdit)" ng-model="cardTheVenueIdEdit">
                        <option value="" >请选择场馆</option>
                        <option ng-if="cardTheVenueListsFlag" value="{{venue.id}}"
                                ng-repeat=" venue in cardTheVenueLists"
                        >{{venue.name}}</option>
                        <option ng-if="cardTheVenueListsFlag == false" style="color: red;" disabled>暂无数据</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的属性</span>
                    <select ng-model="cardAttributeEdit" class="form-control cp mL10 selectPd"  >
                        <!--                                                    <option value="{{attr.key}}" ng-repeat="attr in attributesVal">{{attr.val}}</option>-->
                        <option value="1">个人</option>
                        <option value="2">家庭</option>
                        <option value="3">公司</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的类型</span>
                    <!--                                                <select ng-if="attributesStatus == true" ng-model="$parent.attributes" class="form-control cp"  >-->
                    <select ng-model="cardTypeEdit" class="form-control cp mL10 selectPd"  >
                        <option value="1">瑜伽</option>
                        <option value="2">健身</option>
                        <option value="3">舞蹈</option>
                        <option value="4">综合</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>卡的名称</span>
                    <input type="text" placeholder="至尊卡" class="form-control cp mL10"
                           ng-blur="setCardName()" ng-change="setCardName()" ng-model="cardNameEdit">
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right">卡别名</span>
                    <input type="text" placeholder="英文名称" class="form-control cp mL10"
                           ng-model="anotherNameEdit">
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>次数</span>
                    <input type="number" autocomplete="off" inputnum min="0" placeholder="0次" ng-model="cardTimesEdit" class="mL10 form-control numCardInput" id="exampleInputName3" >
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>扣次方式</span>
                    <select ng-model="timesMethodEdit" class="form-control selectPd mL10">
                        <option value="1">按时效扣次</option>
                        <option value="2">按次数扣次</option>
                    </select>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right">激活期限</span>
                    <div class="contentBetween wB100 mL10" >
                        <input type="number" inputnum name="num" min="0" placeholder="多少天" class="form-control w115 cp" ng-model="activeTimeEdit">
                        <select class="form-control cp w70 selectPd" id="activeUnitEdit" ng-model="activeUnitEdit" >
                            <option value="1" ng-selected="unit">天</option>
                            <option value="7">周</option>
                            <option value="30">月</option>
                            <option value="90">季</option>
                            <option value="365">年</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span class="width100 text-right"><strong class="red">*</strong>有效天数</span>
                    <div class="contentBetween wB100 mL10" >
                        <input   inputnum type="number" min="0" placeholder="多少天" class="form-control cp w115" ng-model="durationEdit">
                        <select  class="form-control cp w70 selectPd" id="durationUnitEdit" ng-model="durationUnitEdit"  >
                            <option value="1" ng-selected="unit">天</option>
                            <option value="7">周</option>
                            <option value="30">月</option>
                            <option value="90">季</option>
                            <option value="365">年</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 heightCenter mT20">
                    <span  class="width100 text-right" >单数</span>
                    <input id="Singular" type="number"  ng-model="SingularEdit" min="0" placeholder="请输入单数" class="form-control cp  mL10">
                </div>
                <div class="col-sm-4 heightCenter mT20" ng-if="categoryTypeId == 1">
                    <span  class="width100 text-right" style="line-height: 1;">带人卡</span>
                    <div  class="contentBetween wB100 " >
                        <input  type="radio" ng-click="withoutHuman()" name="bring" id="bring-false" value="0" style="width: 65px;margin-left: -5px;" />
                        <span style="width: 55px;margin-left: -20px;line-height: 11px;">不带人</span>
                        <input type="radio" ng-click="withPeople()" name="bring" id="bring-true" value="1"  style="width: 65px;margin-left: -35px;"/>
                        <span style="line-height: 11px;margin-left: -17px;">带人</span>
                        <input ng-model="bringEdit" ng-change="withPeopleNum()" inputnum type="number" id="bring-num" name="bring-name"  min="1" max="5" style="width:70px" disabled />
                    </div>
                </div>
                <div class="w100 cp">
                    <div class="col-sm-8 clearfix">
                        <span class="fl mT5" style="margin-top: 35px;margin-left: 22px">&nbsp;卡种照片&emsp;</span>
                        <div class="form-group">
                            <img ng-if="theData.pic != null" ng-src="{{theData.pic}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: -1px">
                            <img ng-if="theData.pic == null" ng-src="{{}}" class='photo mL120W100H100' style="width: 100px;height: 100px;margin-top: 21px;margin-left: -1px">
                        </div>
                        <div class="input-file"
                             style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 362px"
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
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="basicAttributesCompleteFlag" ng-click="basicAttributesComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--定价和售卖修改模态框-->
<div class="modal fade" id="pricingAndSellingModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 720px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >定价和售卖修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12">
                    <div class="col-sm-3 heightCenter ">
                        <span class="width100 text-right"></span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <span class="f12 colorCCC" ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;一口价和区域定价二选一</span>
                    </div>
                </div>
                <div class="col-sm-12 mT20">
                    <div class="col-sm-3  text-right">
                        <span ><strong class="red">*</strong>一口价</span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <input id="areaMinPrice1" type="number"  min="0"  placeholder="原价0元" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" class="form-control w120" ng-model="originalPriceEdit">
                        <input id="areaMinPrice2" type="number"  min="0"  placeholder="售价0元" ng-disabled="disabled" ng-change="setDisabled(disabled,unable)" class="form-control w120 mL10" ng-model="sellPriceEdit" >
                    </div>
                </div>
                <div class="col-sm-12 mT20">
                    <div class="col-sm-3  text-right">
                        <span ><strong class="red">*</strong>区域定价</span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <input id="areaMinPrice1s"  type="number"  inputnum min="0" placeholder="最低价0元" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control w120" ng-model="areaMinPriceEdit" >
                        <input id="areaMinPrice2s"  type="number"  inputnum min="0" placeholder="最高价0元" ng-disabled="unable" ng-change="setUnable(disabled,unable)" class="form-control w120 mL10" ng-model="areaMaxPriceEdit">
                    </div>
                </div>
                <div class="col-sm-12 mT20">
                    <div class="col-sm-3  text-right">
                        <span>优惠价</span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <input type="number" min="0" inputnum placeholder="0元" class="form-control w120"ng-model="offerPriceEdit"  >
                    </div>
                </div>
                <div class="col-sm-12 mT20">
                    <div class="col-sm-3  text-right">
                        <span>移动端售价</span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <input type="number" inputnum min="0" placeholder="0元" class="form-control w120"ng-model="appSellPrice"  >
                    </div>
                </div>
                <div class="border1 col-sm-offset-2 col-sm-8 mT20"></div>
                <div class="col-sm-12 mT20">
                   <!-- <div class="col-sm-3  text-right">
                        <span ><strong class="red">*</strong>普通续费</span>
                    </div>
                    <div class="col-sm-9 heightCenter ">
                        <input style=""  type="number" inputnum min="0" placeholder="0元" class="form-control w120"ng-model="OrdinaryRenewalEdit"  >
                    </div>
                    <div class="col-sm-offset-3 col-sm-9 heightCenter ">
                        <div style="color: #999;"><i class="glyphicon glyphicon-info-sign"></i>当其它卡到期时选择此卡的续费</div>
                    </div>-->
                </div>
                <section class="col-sm-12 pdLR0 " id="validityRenewBoxLists">
                    <div class="col-sm-12 mT20 validityRenewBox" ng-repeat="valid in validityRenewalArr">
                        <div class="col-sm-3  text-right ">
                            <span >有效期续费</span>
                        </div>
                        <div class="col-sm-9 heightCenter ">
                            <input  name="cardValidityNum"  value="{{valid.day}}" inputnum type="text" min="0" placeholder="0" class="form-control cp w120" >
                            <select  class="form-control cp cardValidityCompany w70 mL10 selectPd"  ng-model="valid.type"  >
                                <option value="d"  >天</option>
                                <option value="m">月</option>
                                <option value="q">季</option>
                                <option value="y">年</option>
                            </select>
                            <input style="" name="cardValidityMoney"   type="text" inputnum min="0" placeholder="0元" value="{{valid.price}}" class="form-control cp w120 mL10 " >
                        </div>
                        <div class="col-sm-offset-3 col-sm-9 heightCenter " ng-if="$index == 0">
                            <div style="color: #999;"><i class="glyphicon glyphicon-info-sign"></i>此卡到期时增加此卡有效期的续费</div>
                        </div>
                    </div>
                </section>
                <div class="col-sm-12 mT20 removeBoxBtn">
                    <div class="col-sm-offset-3 col-sm-9 heightCenter ">
                        <button id="addCardValidityEdit" class="btn btn-sm btn-default" ng-click="addCardValidityEdit()" venuehtml="" >添加有效期</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="pricingAndSellingCompleteFlag" ng-click="pricingAndSellingComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--售卖场馆修改模态框-->
<div class="modal fade" id="sellingVenueEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 1080px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >售卖场馆修改</h4>
            </div>
            <div class="modal-body col-sm-12" >
                <div class="col-sm-12 pdLR0" id="sellVenue">
                    <div class="col-sm-12 pdLR0 sellVenueBox removeSellBoxDiv" ng-repeat="($sellIndex,sellVenue) in  theData.sellVenue">
                        <div class="col-sm-4  heightCenter mT20">
                            <span class="width100 text-right"><strong class="red">*</strong>选择场馆</span>
                            <select  class="form-control cp selectPd mL10 w240 sellVenueSelect"  name="sellVenueSelect"  ng-change="selectVenue(venueIdS[$sellIndex][$sellIndex])" ng-model="venueIdS[$sellIndex][$sellIndex]">
                                <option value="" >请选择场馆</option>
                                <option value="{{venue.id}}"
                                        ng-repeat=" venue in optionVenue"
                                        ng-selected="venue.id == sellVenue.venue_id"
                                        ng-disabled="venue.id | attrVenue:venueHttpIdArr"
                                >{{venue.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4  heightCenter mT20">
                            <span class="width100 text-right"><strong class="red">*</strong>售卖张数</span>
                            <div class="clearfix cp h32 inputUnlimited unlimitedDivOne mL10 w240 sellNumBox" >
                                <input  type="number" data-num="{{sellVenue.limit}}" inputnum name="sheets" min="0" value="" placeholder="0张" class="fl form-control pT0 unlimitedInputOne">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label>
                                        <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4  heightCenter input-daterange mT20">
                            <div class="width100 text-right"><strong class="red">*</strong>售卖日期</div>
                            <div class="mL10 heightCenter">
                                <b><input type="text" id = 'datetimeStart' value="{{sellVenue.sell_start_time*1000 | date:'yyyy-MM-dd'}}" class="input-sm form-control datetimeStart dateCss" name="start" placeholder="起始日期"  style="margin-left: 0;width: 110px;" ></b>
                                <b><input type="text" id="datetimeEnd" value="{{sellVenue.sell_end_time*1000 | date:'yyyy-MM-dd'}}"  class="input-sm form-control datetimeEnd dateCss" name="end" placeholder="结束日期" style="width: 110px;"></b>
                            </div>
                        </div>

<!--                        <div class="col-sm-12 pdLR0  discountLists">-->
                            <div class=" col-sm-12 pdLR0 discountList ">
                                <div class=" col-sm-12 pdLR0 discountBox removeDisBox mT20 " ng-if="sellVenue.cardDiscount.length  == 0">
                                    <div class="col-sm-4 heightCenter ">
                                        <span  class="width100 text-right">折扣</span>
                                        <input type="number"  name="discount" inputnum min="0"  placeholder="几折" class="  form-control pT0 mL10 w240">
                                    </div>
                                    <div class="col-sm-4 heightCenter ">
                                        <div  class="width100 text-right">折扣价售卖数</div>
                                        <div class=" cp h32 inputUnlimited unDivBorder mL10 w240" >
                                            <input type="number" data-num="{{dis.surplus}}" inputnum name="discountNum" min="1" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
                                            <div class="checkbox i-checks checkbox-inline t4" >
                                                <label>
                                                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-12 pdLR0 discountBox removeDisBox mT20 " ng-if="sellVenue.cardDiscount.length  > 0 " ng-repeat="($disKey,dis) in sellVenue.cardDiscount">
                                    <div class="col-sm-4 heightCenter ">
                                        <span  class="width100 text-right">折扣</span>
                                        <input type="number"  name="discount" inputnum min="0"  placeholder="几折" class="  form-control pT0 mL10 w240">
                                    </div>
                                    <div class="col-sm-4 heightCenter ">
                                        <div  class="width100 text-right">折扣价售卖数</div>
                                        <div class=" cp h32 inputUnlimited unDivBorder mL10 w240" >
                                            <input type="number" data-num="{{dis.surplus}}" inputnum name="discountNum" min="1" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
                                            <div class="checkbox i-checks checkbox-inline t4" >
                                                <label>
                                                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4  heightCenter " ng-if="$disKey != 0">
                                        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removeDisBox">删除</button>
                                    </div>
                                </div>
                            </div>
                            <div  class="col-sm-12 pdLR0 mT20  discountBtnBox heightCenter" >
                                <div  class="width100 text-right" ></div>
                                <button id="addDiscountEdit" class="cardAddBtn btn btn-default mL10" ng-click="addDiscountEditHtml()" venuehtml="" >添加折扣</button>
                                <button ng-if="$sellIndex !=0"  type="button" class="btn  btn-default  removeHtml mL10"  data-remove="removeSellBoxDiv">删除场馆</button>
                            </div>
<!--                        </div>-->
                    </div>
                </div>
                <div class="col-sm-12 pdLR0 mT20 heightCenter addSellVenueEditBox ">
                    <div  class="width100 text-right" ></div>
                    <div id="addSellVenueEdit" ng-click="addVenueEditHtml()"  class="btn btn-default mL10" venuehtml>添加场馆</div>
                </div>
            </div>

            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="sellingVenueEditCompleteFlag" ng-click="sellingVenueEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--通店场馆修改模态框-->
<div class="modal fade" id="applyVenueEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 1080px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >通店场馆限制修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 text-center"><span class="f12 colorCCC " ><i class="glyphicon glyphicon-info-sign"></i>&nbsp;本场馆通店次数需要单独设置,<span >信息不填写完整不会保存</span></span></div>
                <div class="col-sm-12 pdLR0" id="applyVenue">
                    <div class="col-sm-12 pdLR0 applyVenueBox removeBoxDiv" ng-repeat="($appIndex,appVenue) in theData.goVenue">
                        <div class="col-sm-4  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;"><strong class="red">*</strong>场馆类型</span>
                            <select disabled class="form-control cp selectPd w240 " ng-change="selectApplyVenueType(applyTypeS[$appIndex])"  ng-model="applyTypeS[$appIndex]"  name='applyVenueType'>
                                <option value="">场馆类型</option>
                                <option value="1">普通</option>
                                <option value="2">尊爵</option>
                            </select>
                        </div>
                        <div class="col-sm-4  heightCenter mT20" >
                            <span class="width100 text-right" style="margin-right: 10px;"><strong class="red">*</strong>选择场馆</span>
                            <select   ng-change="selectApply(applyIdS[$appIndex])" name="applySelectVenue"  multiple="multiple" ng-model="$parent.applyIdS[$appIndex]"   class=" form-control cp applySelectVenue js-example-basic-multiple w240" style="height: 60px;overflow-y: scroll;">
                                <option value="{{venue.id}}"
                                        ng-if="appVenue.identity == 1 || appVenue.organization[0].identity == 1"
                                        ng-repeat=" venue in applyTypeVenueLists1"
                                        ng-disabled="venue.id | attrVenue:generalVenuesNoRepeat"
                                >{{venue.name}}</option>
                                <option value="{{venue.id}}"
                                        ng-if="appVenue.identity == 2 || appVenue.organization[0].identity == 2"
                                        ng-repeat=" venue in applyTypeVenueLists2"
                                        ng-disabled="venue.id | attrVenue:extrawellVenuesNoRepeat"
                                >{{venue.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4 heightCenter mT20">
                            <span class="">进馆时间&emsp;&emsp;</span>
                            <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="起始时间">
                            </div>
                            <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
                                <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="结束时间">
                            </div>
                        </div>
                        <div class="col-sm-4  heightCenter mT20">
                            <div class="width100 text-right " style="margin-right: 10px;"><strong class="red">*</strong>通店限制</div>
                            <div class="clearfix cp h32 inputUnlimited">
                                <input ng-if="appVenue.week_times != null && appVenue.times == null" type="number" data-num="{{appVenue.week_times}}" inputnum min="0" value="" placeholder="通店次数" name='times' class="fl form-control pT0">
                                <input ng-if="appVenue.times != null && appVenue.week_times == null" type="number" data-num="{{appVenue.times}}" inputnum min="0" value="" placeholder="通店次数" name='times' class="fl form-control pT0">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label><input style="width: 6px;" type="checkbox" value="" name="limit"> <i></i> 不限</label>
                                </div>
                            </div>
                            <select  class="form-control cp w70 mL10 selectPd" name="weeks">
                                <option ng-selected="appVenue.week_times != null && appVenue.times == null"  value="w">周</option>
                                <option ng-selected="appVenue.times != null && appVenue.week_times == null" value="m">月</option>
                            </select>
                        </div>
                        <div class="col-sm-4 heightCenter mT20">
                            <div class="width100 text-right"><strong class="red">*</strong>卡的等级</div>
                            <select class="form-control cp w240 selectPd mL10" name='times1'>
                                <option value="1">普通卡</option>
                                <option value="2">VIP卡</option>
                            </select>
                        </div>
                        <div class="col-sm-4 heightCenter mT20 about">
                            <div class="checkbox i-checks checkbox-inline t4">
                                <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
                            </div>
                        </div>
                        <div class="col-sm-4  heightCenter mT20" ng-if="$appIndex != 0">
                            <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId()" data-remove="removeBoxDiv">删除</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pdLR0 mT20 heightCenter addApplyVenueEditEditBox">
                    <div  class="width100 text-right" ></div>
                    <div id="addApplyVenueEdit" ng-click="addApplyEditHtml()" class="btn btn-default  mL10" venuehtml>添加场馆</div>
                </div>
            </div>
            <div class="modal-footer contentCenter">
                <button type="button" class="btn btn-success btn-sm width100" ladda="applyVenueEditCompleteFlag" ng-click="applyVenueEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--进馆时间修改模态框-->
<div class="modal fade" id="entranceTimeEditModal" style="overflow: scroll;" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 1080px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >进馆时间限制修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 text-center"><span class="f12 colorCCC"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;每月固定日和特定星期二选择一</span></div>
                <div class="col-sm-12 pdLR0" >
                    <div class="col-sm-12 pdLR0">
                        <div class="col-sm-4 w300 mT15">
                            <p class="mB10 text-center">每月固定日(选填)</p>
                            <div class="borderE5">
                                <div class=" col-sm-12 pdLR0 timeLength" >
                                    <span class="col-sm-3 pdLR0">特定时间段</span>
                                    <div class="input-group clockpicker cp w90" data-autoclose="true" >
                                        <input name="dayStart" ng-change="setDayTime()" ng-model="dayStart" type="text" class="input-sm form-control text-center timeCss"  placeholder="起始时间" >
                                    </div>
                                    <div class="input-group clockpicker cp w90" data-autoclose="true" >
                                        <input name="dayEnd"  ng-change="setDayTime()" ng-model="dayEnd" type="text" class="input-sm form-control text-center timeCss"  placeholder="结束时间" >
                                    </div>
                                </div>
                                <table id="table" class="cp">
                                    <tr>
                                        <td colspan="2" class="tdActive borderNone op0"></td>
                                        <td class="timeTd" data-num="1">1</td>
                                        <td class="timeTd" data-num="2">2</td>
                                        <td class="timeTd" data-num="3">3</td>
                                        <td class="timeTd" data-num="4">4</td>
                                        <td class="timeTd" data-num="5">5</td>
                                    </tr>
                                    <tr>
                                        <td class="timeTd" data-num="6">6</td>
                                        <td class="timeTd" data-num="7">7</td>
                                        <td class="timeTd" data-num="8">8</td>
                                        <td class="timeTd" data-num="9">9</td>
                                        <td class="timeTd" data-num="10">10</td>
                                        <td class="timeTd" data-num="11">11</td>
                                        <td class="timeTd" data-num="12">12</td>
                                    </tr>
                                    <tr>
                                        <td class="timeTd" data-num="13">13</td>
                                        <td class="timeTd" data-num="14">14</td>
                                        <td class="timeTd" data-num="15">15</td>
                                        <td class="timeTd" data-num="16">16</td>
                                        <td class="timeTd" data-num="17">17</td>
                                        <td class="timeTd" data-num="18">18</td>
                                        <td class="timeTd" data-num="19">19</td>
                                    </tr>
                                    <tr>
                                        <td class="timeTd" data-num="20">20</td>
                                        <td class="timeTd" data-num="21">21</td>
                                        <td class="timeTd" data-num="22">22</td>
                                        <td class="timeTd" data-num="23">23</td>
                                        <td class="timeTd" data-num="24">24</td>
                                        <td class="timeTd" data-num="25">25</td>
                                        <td class="timeTd" data-num="26">26</td>
                                    </tr>
                                    <tr>
                                        <td class="timeTd" data-num="27">27</td>
                                        <td class="timeTd" data-num="28">28</td>
                                        <td class="timeTd" data-num="29">29</td>
                                        <td class="timeTd" data-num="30">30</td>
                                        <td class="timeTd" data-num="31">31</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-8 mT15" >
                            <p>特定星期选择</p>
                            <ul class="weekSelect">
                                <li class="text-center">
                                    <div class="checkbox i-checks checkbox-inline week mL0">
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="1"> <i></i> 星期一</label>
                                    </div>
                                    <div class="weekTime "></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()" >添加时间</button>
                                </li>
                                <li class="text-center">
                                    <div class="checkbox i-checks checkbox-inline week mL0">
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="2"> <i></i> 星期二</label>
                                    </div>
                                    <div class="weekTime mL10"></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                                <li class="text-center">
                                    <div class="checkbox i-checks checkbox-inline week mL0">
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="3"> <i></i> 星期三</label>
                                    </div>
                                    <div class="weekTime "></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                                <li class="">
                                    <div class="checkbox i-checks checkbox-inline week mL0" >
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="4"> <i></i> 星期四</label>
                                    </div>
                                    <div class="weekTime mL10"></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                                <li class="text-center">
                                    <div class="checkbox i-checks checkbox-inline week mL0">
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="5"> <i></i> 星期五</label>
                                    </div>
                                    <div class="weekTime "></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                                <li class="text-center">
                                    <div class="checkbox i-checks checkbox-inline week mL0">
                                        <label  class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="6"> <i></i> 星期六</label>
                                    </div>
                                    <div class="weekTime "></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                                <li class="text-center" >
                                    <div class="checkbox i-checks checkbox-inline week ">
                                        <label class="pdL0">
                                            <input name="weeksTime" type="checkbox" value="7" > <i></i> 星期日</label>
                                    </div>
                                    <div class="weekTime "></div>
                                    <div class="height10"></div>
                                    <button class="btn btn-default btn-sm addTime disNone" ng-click="openMyModals8()">添加时间</button>
                                </li>
                            </ul>
                            <!--                                            <div style="margin-top:30px;">-->
                            <!--                                                <p>填写卡的特定时间</p>-->
                            <!--                                                <div class=" input-daterange cp" style="position: relative;display: flex;margin-top: 10px;">-->
                            <!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
                            <!--                                                        <input type="text" class="input-sm form-control text-center" ng-model="start" placeholder="起始时间" style="width: 100%;border-radius: 3px;">-->
                            <!--                                                    </div>-->
                            <!--                                                    <div class="input-group clockpicker fl cp" data-autoclose="true" style="width: 90px; ">-->
                            <!--                                                        <input type="text" class="input-sm form-control text-center" ng-model="end"  placeholder="结束时间" style="width: 100%;border-radius: 3px;margin-left: 15px;">-->
                            <!--                                                    </div>-->
                            <!--                                                </div>-->
                            <!--                                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="timeEditCompleteFlag" ng-click="entranceTimeEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--时间插件模态框-->
<div  class="modal fade mT20 " id="myModals8" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog w360" >
        <div  class="modal-content clearfix">
            <div  class="modal-header borderNone">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title text-center" id="myModalLabel">时间修改</h4>
<!--                <h5  class="text-center f20 mB20 mT20">时间修改</h5>-->
            </div>
            <div class="modal-body">
                <div class="col-sm-12 input-daterange cp timeModalCss contentBetween" >
                    <div  class="input-group  clockpicker  wB45" data-autoclose="true"  >
                        <input type="text" id="weekStart" readonly="readonly" class="input-sm form-control text-center timeCss" placeholder="起始时间">
                    </div>
                    <div class="input-group  clockpicker  wB45" data-autoclose="true" >
                        <input type="text" id="weekEnd" readonly="readonly" class="input-sm form-control text-center timeCss" placeholder="结束时间">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: 20px;">
                <div data-toggle="modal" data-target="#myModals8" class="btn btn-sm width100 mT30 btn-primary pull-left cancelTime">返回</div>
                <div data-toggle="modal" ng-click="weekTimeSelect()" class="btn btn-sm mT30 btn-success pull-right width100 successBtn">完成</div>
            </div>
        </div>
    </div>
</div>

<!--团课课程修改模态框-->
<div class="modal fade" id="leagueClassEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 920px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >团课课程修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 pdLR0 course"   id="course">
                    <div class="col-sm-12 pdLR0 addLeagueCourseBox removePageDiv" ng-if="theData.serverClass == 0">
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">课程名称</span>
                            <select  multiple="multiple" data-tags="true"  name="leagueCourseList" class="form-control leagueCourseList cp js-example-basic-multiple"  ng-change="selectClass()" ng-model="classKey" style="max-height: 60px !important;overflow-y: scroll; width:240px;">
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionClass"
                                    ng-disabled="venue.id | attrVenue:classArr1234"
                                >{{venue.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">每日节数</span>
                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                <input   type="number" inputnum min="0" name="times" placeholder="0节" class=" form-control pT0 unDivBorderInput w200">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label>
                                        <input type="checkbox" value="-1"> <i></i> 不限</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pdLR0 addLeagueCourseBox removePageDiv" ng-if="theData.serverClass != 0" ng-repeat="class in theData.serverClass">
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">课程名称</span>
                            <select  multiple="multiple" data-tags="true"  name="leagueCourseList" class="form-control leagueCourseList cp js-example-basic-multiple"  ng-change="selectClass()" ng-model="$parent.classKey[$index][$index]" style="max-height: 60px !important;overflow-y: scroll; width:240px;">
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionClass"
                                    ng-disabled="venue.id | attrVenue:classArr1234"
                                >{{venue.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">每日节数</span>
                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                <input data-num="{{class.number}}"  type="number" inputnum min="0" name="times" placeholder="0节" class=" form-control pT0 unDivBorderInput w200">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label>
                                        <input type="checkbox" value="-1"> <i></i> 不限</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 heightCenter  mT20" ng-if="$index != 0">
                            <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removePageDiv">删除</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pdLR0 mT20 heightCenter addLeagueCourseEditBox ">
                    <div  class="width100 text-right" ></div>
                    <div id="addLeagueCourseEdit" ng-click="addLeagueClassEditHtml()"  class="btn btn-default addCourse  mL10" venuehtml="">添加课程</div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="leagueClassEditCompleteFlag" ng-click="leagueClassEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--私课课程修改模态框-->
<div class="modal fade" id="privateCourseEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 920px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >私课课程修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 pdLR0 course"   id="PtCourse">
                    <div class="col-sm-12 pdLR0 ">
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">HS课程</span>
                            <select ng-if="GiveCourseFlag"  id="HSClass" class="form-control cp w200 selectPd"  ng-change="selectHsPTClass()" ng-model="HSClass">
                                <option value=""  >请选择课程</option>
                                <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                            </select>
                            <select ng-if="GiveCourseFlag == false"  class="form-control w200 cp selectPd">
                                <option value="">请选择课程</option>
                                <option value="" disabled class="red">暂无数据</option>
                            </select>
                        </div>
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">HS节数</span>
                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                <input type="number"  inputnum min="0" name="HSNum" ng-model="HSClassNum"  placeholder="0节" class="fl form-control pT0 w200  mL0 mT0">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pdLR0 ">
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">PT课程</span>
                            <select ng-if="GiveCourseFlag"   id="PTClass" class="form-control cp w200 selectPd"  ng-change="selectPTClass()" ng-model="PTClass">
                                <option value="" >请选择课程</option>
                                <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                            </select>
                            <select  ng-if="GiveCourseFlag == false" class="form-control cp w200 selectPd">
                                <option value="">请选择课程</option>
                                <option value="" disabled class="red">暂无数据</option>
                            </select>
                        </div>
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">PT节数</span>
                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                <input type="number" inputnum min="0" name="PTNum" ng-model="PTClassNum"  placeholder="0节" class="fl form-control pT0 w200  mL0 mT0">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pdLR0 ">
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">生日课</span>
                            <select ng-if="GiveCourseFlag"  class="form-control cp w200 selectPd" id="BirthdayClass"  ng-change="BirthdayClassSelect()" ng-model="BirthdayClass">
                                <option value="" >请选择课程</option>
                                <option value="{{giveCourse.id}}" ng-repeat="giveCourse in GiveCourseDataLists">{{giveCourse.name}}</option>
                            </select>
                            <select ng-if="GiveCourseFlag == false" class="form-control cp w200 selectPd">
                                <option value="">请选择课程</option>
                                <option value="" disabled class="red">暂无数据</option>
                            </select>
                        </div>
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">生日课节数</span>
                            <div class=" cp h32 inputUnlimited unDivBorder" >
                                <input type="number" inputnum min="0" name="birthClass" id="birthClassNum" ng-model="birthClassNum"  placeholder="0节" class="fl form-control pT0 w200  mL0 mT0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="privateCourseEditCompleteFlag" ng-click="privateCourseEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--赠品修改模态框-->
<div class="modal fade" id="giftEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 920px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >赠品修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 pdLR0 donation"   id="giveShopBox">
                    <div class="col-sm-12 pdLR0 donationBox removeDivBox" ng-if="theData.gift.length == 0">
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">赠品名称</span>
                            <select  class="form-control cp w200 selectPd selectGive123"  ng-change="selectDonation(donationKey)" ng-model="donationKey" >
                                <option value="" >请选择赠品</option>
                                <option value="{{donation.id}}"
                                        ng-repeat="donation in optionDonation"
                                        ng-disabled="donation.id | attrVenue:giveShopArray"
                                >{{donation.goods_name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">商品数量</span>
                            <div class=" cp h32 inputUnlimited  " >
                                <input   type="number"  inputnum min="0" name='times' placeholder="0" class=" form-control w200 pT0">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i> 不限</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pdLR0 donationBox removeDivBox" ng-if="theData.gift.length != 0" ng-repeat="($giftKey,giftEdit) in theData.gift">
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">赠品名称</span>
                            <select  class="form-control cp w200 selectPd selectGive123"  ng-change="selectDonation(donationsKey[$giftKey][$giftKey])" ng-model="donationsKey[$giftKey][$giftKey]" >
                                <option value="" >请选择赠品</option>
                                <option value="{{donation.id}}"
                                        ng-repeat="donation in optionDonation"
                                        ng-disabled="donation.id | attrVenue:giveShopArray"
                                >{{donation.goods_name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">商品数量</span>
                            <div class=" cp h32 inputUnlimited  " >
                                <input   type="number" data-num="{{giftEdit.number}}" inputnum min="0" name='times' placeholder="0" class=" form-control w200 pT0">
                                <div class="checkbox i-checks checkbox-inline t4" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i> 不限</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2  heightCenter mT20" ng-if="$giftKey != 0">
                            <button   type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeGIveClick()"  data-remove="removeDivBox">删除</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pdLR0 mT20 heightCenter addDonationBox ">
                    <div  class="width100 text-right" ></div>
                    <div id="addDonationEdit" ng-click="addDonationEditHtml()"  class="btn btn-default addDonation  mL10" venuehtml="">添加商品</div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="giftEditCompleteFlag" ng-click="giftEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--转让修改模态框-->
<div class="modal fade" id="assignmentEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 720px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >转让修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 pdLR0 donation"   id="donation">
                    <div class="col-sm-12 pdLR0 donationBox">
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">转让次数</span>
                            <input type="number" min="0" ng-model="transferNumberEdit" checknum placeholder="0次" class="form-control w200">
                        </div>
                        <div class="col-sm-6  heightCenter mT20">
                            <span class="width100 text-right" style="margin-right: 10px;">转让金额</span>
                            <input type="number" min="0" checknum ng-model="transferPriceEdit"  placeholder="0元" class="form-control w200">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="assignmentEditCompleteFlag" ng-click="assignmentEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--请假修改模态框-->
<div class="modal fade" id="leaveEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 720px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >请假修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <div class="col-sm-12 pdLR0 donation"   id="donation">
                    <div class="col-sm-12 pdLR0 donationBox">
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width100 text-right " style="margin-right: 10px;">请假总天数</span>
                            <input type="number" min="0"  id="leaveDaysTotalEdit"  checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled(leaveDaysTotalEdit)" ng-model="leaveDaysTotalEdit" placeholder="0次" class="form-control">
                        </div>
                        <div class="col-sm-5  heightCenter mT20">
                            <span class="width140 text-right" style="margin-right: 10px;">每次最低天数</span>
                            <input type="number" min="0"  id="leaveTimesTotalEdit"  checknum ng-disabled="leaveDaysFlag1" ng-change="setLeaveNumDisabled(leaveTimesTotalEdit)" ng-model="leaveTimesTotalEdit" placeholder="0天" class="form-control">
                        </div>
                    </div>
                    <div class="border1  col-sm-12 mT20"></div>
                    <div class="col-sm-12 pdLR0  leaveNumBoxLists" >
                        <div class="col-sm-12 pdLR0  leaveNumBox" ng-repeat="leaveNum in leaveListsArr">
                            <div class="col-sm-5  heightCenter mT20">
                                <span class="width100 text-right " style="margin-right: 10px;">请假次数</span>
                                <input type="text" min="0"  ng-disabled="leaveNumsFlag" ng-blur="seLeaveDaysDisabled()" ng-model="leaveNum.a" ng-change="seLeaveDaysDisabled()" value="{{leaveNum.a}}"   checknum name="times" placeholder="0次" class="form-control">
                            </div>
                            <div class="col-sm-5  heightCenter mT20">
                                <span class="width140 text-right" style="margin-right: 10px;">每次请假天数</span>
                                <input type="text" min="0" ng-disabled="leaveNumsFlag"  ng-blur="seLeaveDaysDisabled()" ng-model="leaveNum.b" ng-change="seLeaveDaysDisabled()" value="{{leaveNum.b}}"  checknum name="days" placeholder="0天" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pdLR0 mT20 heightCenter leaveBtnBox ">
                        <div  class="width100 text-right" ></div>
                        <button   ng-click="addLeaveEditHtml()" ng-disabled="leaveNumsFlag" id="addLeaveEdit"   class="btn btn-default addLeave addBtn"  venuehtml="">添加请假</button>
                    </div>
                    <div class="col-sm-12 mT20">
                        <span class="fa fa-info-circle">请假次数和每次请假天数同时输入才能生效</span>
                    </div>
                    <div class="border1  col-sm-12 mT20"></div>
                    <div class="col-sm-12 pdLR0 studentLeaveDay"  id="studentLeaveDay">
                        <div class="col-sm-12 pdLR0 clearfix">
                             <div class="col-sm-5  heightCenter mT20">
                                <span class="width100 text-right " style="margin-right: 10px;">暑假天数</span>
                                <input type="text" min="0"    ng-model="summerEdit[0]"    checknum name="winterNum" placeholder="天" class="form-control">
                             </div>
                             <div class="col-sm-5  heightCenter mT20">
                                <span class="width140 text-right" style="margin-right: 10px;">寒假天数</span>
                                <input type="text" min="0"    ng-model="winterEdit[0]"    checknum name="winterNum" placeholder="天" class="form-control">
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100"ladda="leaveEditCompleteFlag"  ng-click="leaveEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--合同修改模态框-->
<div class="modal fade" id="contractEditModal" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog" role="document" style="width: 920px">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >合同修改</h4>
            </div>
            <div class="modal-body col-sm-12">
                <section class="col-sm-12 pdLR0">
                    <div class="col-sm-12 pdLR0 contentCenter">
                        <div class=" heightCenter">
                            <span class="width100" >请选择合同</span>
                            <select id="contractSelect"  ng-model="dealId" ng-change="getDealId(dealId)" class="form-control cp w200 selectPd" >
                                <option value="">请选择合同</option>
                                <option
                                    value="{{deal.id}}"
                                    ng-repeat="deal in dealData track by $index"
                                >{{deal.name}}</option>
                            </select>
                        </div>
                    </div>
                    <main class="col-sm-12 pdLR0 mT20" style="min-height:200px;max-height: 400px;overflow-y: scroll;border: solid 1px #5E5E5E;">
                        <ul id="bargainContent" style="padding: 20px;">
                            <li class="contract1">
                                <h3 class="text-center " >{{dataDeal.name}}</h3>
                                <span class="contractCss" ng-bind-html="dataDeal.intro | to_Html"></span>
                            </li>
                        </ul>
                    </main>
                </section>
            </div>
            <div class="modal-footer contentCenter" >
                <button type="button" class="btn btn-success btn-sm width100" ladda="contractEditCompleteFlag" ng-click="contractEditComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
