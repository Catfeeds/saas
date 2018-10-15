<!--
/**
 * 公共管理 - 属性匹配 - 会员卡属性匹配
 * @author zhujunzhe@itsports.club
 * @create 2018/1/31 am
 */
 -->
<!--卡种属性详情模态框-->
<div style="margin-left: 100px;" class="modal fade" id="cardTypeModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div style="margin-top: 40px;width: 90%;" class="modal-dialog">
        <div style="border: none;" class="modal-content clearfix">
            <div class="membershipCardDetailsBox">
                <div  class="modal-header border1none">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="text-center" style="font-size: 18px;border-width: 0 0 1px 0;">卡种详情</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12 col-xs-12" style="display: flex;align-items: center;">
                        <div class="col-sm-12 col-xs-12">
                            <div class="col-sm-12  col-xs-12" >
                                <section  class="col-sm-12 col-xs-12">
                                    <div style="width: 100%; " class="text-center">
                                        <img ng-if="theData.pic == null || theData.pic == ''" ng-src="/plugins/cardType/image/card.png" style="height: 150px" class="w250">
                                        <img ng-if="theData.pic != null && theData.pic != ''" ng-src="{{theData.pic}}" style="width: 200px;height: 150px" class="w250">
                                    </div>
                                </section>
                            </div>
                            <div class="col-sm-12 col-xs-12 contentBetween" >
                                <b>1.基本属性</b>
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
                                <div class="col-sm-4 col-xs-6 lH30">激活期限:{{theData.active_time | noData:''}}天</div>
                                <div class="col-sm-4 col-xs-6 lH30">有效天数:{{theData.duration | stringToArr}}</div>
                                <div class="col-sm-4 col-xs-6 lH30" >卡的单数:{{theData.single | noData:''}}</div>
                                <div class="col-sm-4 col-xs-6 lH30" ng-if="theData.category_type_id == '2'">卡的次数:{{theData.times | noData:''}}</div>
                                <div class="col-sm-4 col-xs-6 lH30" ng-if="theData.category_type_id == '2'">扣次方式:
                                    <span ng-if="theData.count_method == '1'">按时效扣次</span>
                                    <span ng-if="theData.count_method == '2'">按次数扣次</span>
                                </div>
                                <div class="col-sm-4 col-xs-6 lH30" ng-if="theData.category_type_id == '1'">是否带人:
                                    <span ng-if="theData.bring == 0 ||theData.bring == ''|| theData.bring == null">不带人</span>
                                    <span ng-if="theData.bring != 0 && theData.bring >0">带{{theData.bring}}人</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                <b>2.定价和售卖</b>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="col-sm-4 col-xs-6 lH30">
                                    <span ng-if="theData.sell_price == null">卡的售价:{{theData.min_price}}-{{ theData.max_price}}元</span>
                                    <span ng-if="theData.sell_price != null">卡的售价:{{theData.sell_price}}元</span>
                                </div>
                                <div class="col-sm-4 col-xs-6 lH30">优惠价&emsp;:{{theData.offer_price  | noData:'元'}}</div>
                                <div class="col-sm-4 col-xs-6 lH30">普通续费:{{theData.ordinary_renewal | noData:'元'}}</div>
                                <div class="col-sm-4 col-xs-6 lH30" ng-if="validLists.length > 0">有效期续费:<span ng-repeat="valid in  validLists">{{valid.day}}
                                                <span ng-if="valid.type == 'd'">天</span>
                                                <span ng-if="valid.type == 'm'">月</span>
                                                <span ng-if="valid.type == 'q'">季</span>
                                                <span ng-if="valid.type == 'y'">年</span>{{valid.price}}元,</span></div>
                                <div class="col-sm-4 col-xs-6 lH30">移动端售价:{{theData.app_sell_price | noData:'元'}}</div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                <b>3.售卖场馆</b>
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
                                <b>4.通用场馆限制</b>
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
                                <b>5.进馆时间设置</b>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="col-sm-4  lH30" ng-if="theData.cardTime.day.day.length > 0">每月固定日: <span ng-repeat="day in  theData.cardTime.day.day">{{day}},</span></div>
                                <div class="col-sm-4  lH30" ng-if="theData.cardTime.day.start != ''&& theData.cardTime.day.start != null && theData.cardTime.day.start!=undefined">特定时间段:{{theData.cardTime.day.start}} 至 {{theData.cardTime.day.end}}</div>
                                <div class="col-sm-4  lH30" ng-if="theData.cardTime.week.weeks.length > 0">特定星期: <span ng-repeat="week123 in  weekStartTimeListsArr ">{{theData.cardTime.week.weeks[week123] | week}},</span></div>
                                <div class="col-sm-8 lH30" ng-if="theData.cardTime.week.startTime.length > 0 && theData.cardTime.week.endTime.length > 0">特定时间段: <span ng-repeat="weekTime in weekStartTimeListsArr " >{{theData.cardTime.week.startTime[weekTime] == null || theData.cardTime.week.startTime[weekTime] == ''? '全天': theData.cardTime.week.startTime[weekTime]}}<span ng-if="theData.cardTime.week.endTime[weekTime] != null && theData.cardTime.week.endTime[weekTime] != ''">-</span>{{theData.cardTime.week.endTime[weekTime] == null? '': theData.cardTime.week.endTime[weekTime]}},</span></div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                <b>6.团课套餐</b>
                            </div>
                            <div class="col-sm-12 col-xs-12" ng-repeat="league in theData.serverClass">
                                <div class="col-sm-4 col-xs-6 lH30" >课程名称:
                                    <span ng-if="league.name== null "  ng-repeat="($k,lea) in  league.course" title="{{lea.name}}">{{lea.name |cut:true:4:'...'}} <span ng-if="$k != league.course.length-1">,</span></span>
                                    <span ng-if="league.name != null">{{league.name}}</span>
                                </div>
                                <div class="col-sm-4 col-xs-6 lH30">每日节数:{{league.number == -1?'不限':league.number}}</div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween">
                                <b>7.绑定私课</b>
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
                                <b>8.赠品</b>
                            </div>
                            <div class="col-sm-12 col-xs-12" ng-if="theData.gift.length != 0" ng-repeat="giftOne in  theData.gift">
                                <div class="col-sm-4 col-xs-6 lH30">商品:
                                    <span >{{giftOne.goods_name}}</span>
                                </div>
                                <div class="col-sm-4 col-xs-6 lH30">数量:{{giftOne.number == -1 ?'不限': giftOne.number}}</div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                <b>9.转让</b>
                            </div>
                            <div class="col-sm-12 col-xs-12" ng-if="theData.transfer_number != '' && theData.transfer_number != undefined && theData.transfer_number != undefined">
                                <div class="col-sm-4 col-xs-6 lH30">转让次数:{{theData.transfer_number | noData:''}}</div>
                                <div class="col-sm-4 col-xs-6 lH30">转让金额:{{theData.transfer_price | noData:''}}元</div>
                            </div>
                            <div class="col-sm-12 col-xs-12 mT20 contentBetween" >
                                <b>10.请假</b>
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
                                <b>11.合同</b>
                            </div>
                            <section class="col-sm-12 col-xs-12">
                                <div  class="col-sm-12 col-xs-12">
                                    卡的合同:<strong ><span ng-if="theData.deal != null">《</span>{{theData.deal.name | noData:''}} <span ng-if="theData.deal != null">》</span>   </strong>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>