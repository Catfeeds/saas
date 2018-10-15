<!-- 会员卡详情-->
<div  class="modal fade" id="approvalDetailModel"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div  class="modal-dialog mT30 " style="width: 80%;min-width: 720px;">
        <div  class="modal-content borderNone" >
            <div  class="modal-header borderNone clearfix">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="panel blank-panel col-sm-12">
                    <div class="panel-heading">
                        <div class="panel-title m-b-md">
                            <h3 class="text-center">会员卡详情</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12" style="display: flex;align-items: center;">
                            <div class="col-sm-12">
                                <div class="col-sm-12 " >
                                    <section  class="col-sm-12 ">
                                        <div style="width: 100%; " class="text-center">
                                            <img src="/plugins/img/card111.png" class="w250 " >
                                            <!--                                                <div class="pAbsolute mL6 pT10">{{theData.card_name}}</div>-->
                                        </div>
                                    </section>
                                </div>
                                <div class="col-sm-12">
                                    <div><b>基本属性</b></div>
                                    <div class="col-sm-4 lH30 mT10">卡的属性:
                                        <span ng-if="theData.attributes == 1">个人</span>
                                        <span ng-if="theData.attributes == 2">家庭</span>
                                        <span ng-if="theData.attributes == 3">公司</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">卡的类型:
                                        <span ng-if="theData.card_type == 1">瑜伽</span>
                                        <span ng-if="theData.card_type == 2">健身</span>
                                        <span ng-if="theData.card_type == 3">舞蹈</span>
                                        <span ng-if="theData.card_type == 4">综合</span>
                                        <span ng-if="theData.card_type == 5">VIP</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10" title="{{theData.card_name}}">卡的名称:{{theData.card_name |cut:true:6:'...'}}</div>
                                    <div class="col-sm-4 lH30 mT10">卡的别名:{{theData.another_name | noData:''}}</div>
                                    <div class="col-sm-4 lH30 mT10">激活期限:{{theData.active_time | noData:''}}天</div>
                                    <div class="col-sm-4 lH30 mT10">有效天数:{{theData.duration | stringToArr}}</div>
                                    <div class="col-sm-4 lH30 mT10">卡的单数:{{theData.single | noData:''}}</div>
                                    <div class="col-sm-4 lH30 mT10">是否带人:
                                        <span ng-if="theData.bring == 0 ||theData.bring == ''">不带人</span>
                                        <span ng-if="theData.bring != 0 && theData.bring >0">带{{theData.bring}}人</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 mT20"><b>定价和售卖</b></div>
                                <div class="col-sm-12">
                                    <div class="col-sm-4 lH30 mT10">
                                        <span ng-if="theData.sell_price == null">卡的售价:{{theData.min_price}}-{{ theData.max_price}}元</span>
                                        <span ng-if="theData.sell_price != null">卡的售价:{{theData.sell_price}}元</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">优惠价&emsp;:{{theData.offer_price  | noData:'元'}}</div>
                                    <div class="col-sm-4 lH30 mT10">普通续费:{{theData.ordinary_renewal | noData:'元'}}</div>
                                    <div class="col-sm-4 lH30 mT10" ng-if="validLists.length > 0">有效期续费:<span ng-repeat="valid in  validLists">{{valid.day}}
                                                <span ng-if="valid.type == 'd'">天</span>
                                                <span ng-if="valid.type == 'm'">月</span>
                                                <span ng-if="valid.type == 'q'">季</span>
                                                <span ng-if="valid.type == 'y'">年</span>{{valid.price}}元,</span></div>
                                </div>
                                <div class="col-sm-12 mT20"><b>售卖场馆</b></div>
                                <div class="col-sm-12" ng-repeat="(key123,value123) in theData.sellVenue">
                                    <div class="col-sm-4 lH30 mT10" title="{{value123.name}}">售卖场馆: <span>{{value123.name | cut:true:6:'...'}}</span></div>
                                    <div class="col-sm-4 lH30 mT10">售卖张数: <span>{{value123.limit == -1 ?'不限':value123.limit}}</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">售卖日期: <span>{{value123.sell_start_time*1000 | date:'yyyy-MM-dd'}}至{{value123.sell_end_time*1000 | date:'yyyy-MM-dd'}}</span></div>
                                    <div class="col-sm-12 pdLR0" ng-if="value123.cardDiscount.length > 0"  ng-repeat="dis in value123.cardDiscount">
                                        <div class="col-sm-4 lH30 mT10">折扣&emsp;&emsp;:{{dis.discount}}折</div>
                                        <div class="col-sm-4 lH30 mT10">折扣张数:{{dis.surplus == -1 ? '不限':dis.surplus}}</div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mT20" ng-if="theData.goVenue.length > 0"><b>通用场馆限制</b></div>
                                <div class="col-sm-12" ng-repeat="(keys132,Venue123) in theData.goVenue">
                                    <div class="col-sm-4 lH30 mT10" title="{{Venue123.name}}">通用场馆:
<!--                                        <span>{{Venue123.name |cut:true:6:'...'}}</span>-->
                                        <span ng-if="Venue123.name == null || Venue123.name == ''">
                                            <span ng-repeat="ven in  Venue123.organization">
                                                <span title="{{ven.name}}">{{ven.name |cut:true:4:'...'}} <span ng-if="$index != Venue123.organization.length-1">,</span>  </span>
                                            </span>
                                        </span>
                                        <span ng-if="Venue123.name != null && Venue123.name != ''">
                                            <span >{{Venue123.name}}</span>
                                        </span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">通店限制:
                                        <span ng-if="Venue123.week_times != null && Venue123.week_times != ''">{{Venue123.week_times == -1 ? '不限': Venue123.week_times}}/周</span>
                                        <span ng-if="Venue123.times != null && Venue123.times != ''">{{Venue123.times == -1 ? '不限': Venue123.times}}/月</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">
                                        卡的等级: <span>{{Venue123.level == 1 ? '普通卡':'VIP卡'}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 mT20" ng-if="theData.cardTime.day.day.length > 0 || theData.cardTime.week.weeks.length > 0"><b>进馆时间设置</b></div>
                                <div class="col-sm-12">
                                    <div class="col-sm-4 lH30 mT10" ng-if="theData.cardTime.day.day.length > 0">每月固定日: <span ng-repeat="day in  theData.cardTime.day.day">{{day}},</span></div>
                                    <div class="col-sm-4 lH30 mT10" ng-if="theData.cardTime.day.start != ''&& theData.cardTime.day.start != null && theData.cardTime.day.start!=undefined">特定时间段:{{theData.cardTime.day.start}} 至 {{theData.cardTime.day.end}}</div>
                                    <div class="col-sm-4 lH30 mT10" ng-if="theData.cardTime.week.weeks.length > 0">特定星期: <span ng-repeat="week123 in  weekStartTimeListsArr ">{{theData.cardTime.week.weeks[week123] | week}},</span></div>
                                    <div class="col-sm-8 lH30 mT10" ng-if="theData.cardTime.week.startTime.length > 0 && theData.cardTime.week.endTime.length > 0">特定时间段: <span ng-repeat="weekTime in weekStartTimeListsArr " >{{theData.cardTime.week.startTime[weekTime] == null? '全天': theData.cardTime.week.startTime[weekTime]}}<span ng-if="theData.cardTime.week.endTime[weekTime] != null">-</span>{{theData.cardTime.week.endTime[weekTime] == null? '': theData.cardTime.week.endTime[weekTime]}},</span></div>
                                </div>
                                <div class="col-sm-12 mT20" ng-if="theData.serverClass.length > 0"><b>团课套餐</b></div>
                                <div class="col-sm-12" ng-repeat="league in theData.serverClass">
                                    <div class="col-sm-4 col-xs-6 lH30">课程名称:
                                        <span ng-if="league.name== null" ng-repeat="($k,lea) in  league.course" title="{{lea.name}}">{{lea.name |cut:true:4:'...'}} <span ng-if="$k != league.course.length-1">,</span></span>
                                        <span ng-if="league.name != null">{{league.name}}</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">每日节数:{{league.number == -1?'不限':league.number}}</div>
                                </div>
                                <div class="col-sm-12 mT20"><b>绑定私课</b></div>
                                <div class="col-sm-12" ng-repeat="charge in theData.serverCharge">
                                    <div class="col-sm-4 lH30 mT10">私课类型:
                                        <span ng-if="charge.polymorphic_type =='hs'">HS</span>
                                        <span ng-if="charge.polymorphic_type =='pt'">PT</span>
                                        <span ng-if="charge.polymorphic_type =='birth'">生日课</span>
                                    </div>
                                    <div class="col-sm-4 lH30 mT10">私课名称:{{charge.chargeClassName | noData:''}}</div>
                                    <div class="col-sm-4 lH30 mT10">私课节数:{{charge.number  | noData:''}}</div>
                                </div>
                                <div class="col-sm-12 mT20" ng-if="theData.transfer_number != '' && theData.transfer_number != undefined && theData.transfer_number != undefined"><b>转让</b></div>
                                <div class="col-sm-12" ng-if="theData.transfer_number != '' && theData.transfer_number != undefined && theData.transfer_number != undefined">
                                    <div class="col-sm-4 lH30 mT10">转让次数:{{theData.transfer_number | noData:''}}</div>
                                    <div class="col-sm-4 lH30 mT10">转让金额:{{theData.transfer_price | noData:''}}元</div>
                                </div>
                                <div class="col-sm-12 mT20" ng-if="theData.leave_total_days != null  && theData.leave_least_Days != null"><b>请假</b></div>
                                <div class="col-sm-12" ng-if="theData.leave_total_days != null  && theData.leave_least_Days != null">
                                    <div class="col-sm-4 lH30 mT10">请假总天数:{{theData.leave_total_days}}</div>
                                    <div class="col-sm-4 lH30 mT10">每日最低天数:{{theData.leave_least_Days}}</div>
                                </div>
                                <div class="col-sm-12" ng-if="theData.leave_total_days == null && theData.leave_least_Days == null">
                                    <section class="col-sm-12 pdLR0" ng-repeat="w in leaveLongIimit">
                                        <section class="col-sm-4 mT10">请假次数:<strong >{{w[1]}}</strong></section>
                                        <section class="col-sm-4 mT10">每次请假天数:<strong>{{w[0]}}</strong></section>
                                    </section>
                                </div>
                                <div class="col-sm-12 mT20"><b>合同</b></div>
                                <section class="col-sm-12">
                                    <div  class="col-sm-12 mT10">
                                        卡的合同:<strong ><span ng-if="theData.deal != null">《</span>{{theData.deal.name | noData:''}} <span ng-if="theData.deal != null">》</span>   </strong>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center" ng-if="myLaunchApprovalFlag123 == 1 && approvalTypeFlag">
                        <button type="button" class="btn btn-success"
                                style="width: 100px" ng-click="approvalDetailAgreeClick()">同意
                        </button>
                        <button type="button" class="btn btn-default"
                                style="width: 100px" ng-click="approvalDetailRefuseClick()">拒绝
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--    审批详情-->
<!--<div class="modal fade" id="approvalDetailModel" style="overflow: auto"  role="dialog"-->
<!--     aria-labelledby="myModalLabel">-->
<!--    <div class="modal-dialog" role="document" style="min-width: 1000px;">-->
<!--        <div class="modal-content" >-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                        aria-hidden="true">&times;</span></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="row">-->
<!--                    <div class="col-sm-12 privateModalBody">-->
<!--                        <div class="col-sm-12 text-center">-->
<!--                            <img src="/plugins/img/card111.png" style="width: 230px;height: 150px">-->
<!--                        </div>-->
<!--                        <b><p class="titleP">1.基本属性</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv">-->
<!--                            <div class="col-sm-3">卡的属性:-->
<!--                                <span class="contentSpan" ng-if="cardDetails.attributes == 1">个人</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.attributes == 2">公司</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.attributes == 3">家庭</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">卡的名称:<span class="contentSpan">{{cardDetails.card_name}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">激活期限:<span class="contentSpan">{{cardDetails.active_time | noData:'天'}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">有效天数:<span class="contentSpan">{{cardDetails.duration | noData:'天'}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">2.定价和售卖</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv"-->
<!--                             style="padding-left: 5px;padding-right: 5px;margin-top: 10px;">-->
<!--                            <div class="col-sm-3">售价:-->
<!--                                <span class="contentSpan" ng-if="cardDetails.sell_price == null">{{cardDetails.min_price - cardDetails.max_price}}元</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.sell_price != null">{{cardDetails.sell_price}}元</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">续费价:<span class="contentSpan">{{cardDetails.renew_price | noData:'元'}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">优惠价:<span class="contentSpan">{{cardDetails.offer_price | noData:'元'}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">3.售卖场馆</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" ng-repeat="a in cardDetails.limitCardNumberAll">-->
<!--                            <div class="col-sm-3">售卖场馆:<span class="contentSpan">{{a.organization.name | noData:''}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">售卖张数:-->
<!--                                <span class="contentSpan" ng-if="a.limit == -1">不限</span>-->
<!--                                <span class="contentSpan" ng-if="a.limit != -1">{{a.limit | noData:'张'}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">售卖日期:<span class="contentSpan">{{a.sell_start_time *1000 | date:'yyyy-MM-hh '}}至{{a.sell_end_time *1000 | date:'yyyy-MM-hh '}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">4.通用场馆限制</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" ng-repeat="a in cardDetails.limitCardNumberAll">-->
<!--                            <div class="col-sm-3">适用场馆:<span class="contentSpan">{{a.organization.name | noData:''}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">每月通店限制:-->
<!--                                <span class="contentSpan" ng-if="a.times < 0 || a.times == null">不限</span>-->
<!--                                <span class="contentSpan" ng-if="a.times > 0">{{a.times | noData:''}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">是否可以带人:-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bring != null && cardDetails.bring != 0">{{cardDetails.bring | noData:'人'}}</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bring == null || cardDetails.bring == 0">否</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">5.进馆时间设置</p></b>-->
<!--                        <div ng-if="cardTimeDay.day == null && cardTimeDay1.weeks == null">-->
<!--                            <strong>暂无数据</strong>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12" style="margin-left: 16px" ng-if="cardTimeDay.day != null">-->
<!--                            每月固定日:<span class="contentSpan" ng-repeat="w in cardTimeDay.day">{{w | noData:'号'}}</span>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" style="margin-left: 16px">-->
<!--                            特定时间段<span class="contentSpan">{{cardTimeDay.start}} 至 {{cardTimeDay.end}}</span>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" style="margin-left: 16px" ng-if="cardTimeDay1.weeks != null">-->
<!--                            <ul class="weekSelect">-->
<!--                                <li class="ml30" ng-repeat="(index,w) in cardTimeDay1.weeks">-->
<!--                                    <div class="checkbox i-checks checkbox-inline week">-->
<!--                                        <label id="weeksTime1">星期{{w | week}}</label>-->
<!--                                    </div>-->
<!--                                    <div class="weekTime">{{cardTimeDay1.startTime[index]}} 到 {{cardTimeDay1.endTime[index]}}</div>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">6.团课套餐</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" ng-repeat='(index,w) in cardDetails.class'>-->
<!--                            <div class="col-sm-3">课程名称:<span class="contentSpan">{{w.name}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">每日节数:-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bindPack[index].number > 0">{{cardDetails.bindPack[index].number}}</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bindPack[index].number < 0">不限</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">7.服务套餐</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv" ng-repeat='(index,w) in cardDetails.sever'>-->
<!--                            <div class="col-sm-3">服务名称:<span class="contentSpan">{{w.name}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">每日数量:-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bindPack[index].number > 0">{{cardDetails.bindPack[index].number}}</span>-->
<!--                                <span class="contentSpan" ng-if="cardDetails.bindPack[index].number < 0">不限</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">8.转让</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv">-->
<!--                            <div class="col-sm-3">转让次数:<span class="contentSpan">{{cardDetails.transfer_number | noData:'次'}}</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3">转让金额:<span class="contentSpan">{{cardDetails.transfer_price | noData:'元'}}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">9.请假</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv">-->
<!--                            <div ng-if="cardDetails.leave_total_days == null &&  cardDetails.leave_long_limit == 'null' && cardDetails.leave_least_Days == null">-->
<!--                                <span>暂无数据</span>-->
<!--                            </div>-->
<!--                            <div ng-if="cardDetails.leave_total_days != null  && cardDetails.leave_least_Days != null">-->
<!--                                <div class="col-sm-3">请假总天数:-->
<!--                                    <span class="contentSpan">{{cardDetails.leave_total_days | noData:'天'}}</span>-->
<!--                                </div>-->
<!--                                <div class="col-sm-3">每日最低天数:-->
<!--                                    <span class="contentSpan">{{cardDetails.leave_least_Days | noData:'天'}}</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div ng-if="cardDetails.leave_total_days == null && cardDetails.leave_least_Days == null">-->
<!--                                <div ng-repeat="w in leaveLongIimit">-->
<!--                                    <div class="col-sm-3">请假次数:-->
<!--                                        <span class="contentSpan">{{w[0] | noData:'次'}}</span>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-3">每次请假天数:-->
<!--                                        <span class="contentSpan">{{w[1] | noData:'天'}}</span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <b><p class="titleP" style="margin-top: 30px">10.合同</p></b>-->
<!--                        <div class="col-sm-12 privateModalBodyDiv">-->
<!--                            <div class="col-sm-8">合同:<span class="contentSpan" >《{{cardDetails.deal.name}}》</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal-footer" style="text-align: center" ng-if="myLaunchApprovalFlag123 != 3 && approvalTypeFlag">-->
<!--                <button type="button" class="btn btn-success"-->
<!--                        style="width: 100px" ng-click="approvalDetailAgreeClick()">同意-->
<!--                </button>-->
<!--                <button type="button" class="btn btn-default"-->
<!--                        style="width: 100px" ng-click="approvalDetailRefuseClick()">拒绝-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
