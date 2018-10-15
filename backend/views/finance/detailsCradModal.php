<!-- 卡种收入详情模态框 -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog"
         role="document"
         style="width: 60%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"
                    id="myModalLabel">卡种收入详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4 pd0 text-center infoBox">
                            <img class="img-circle" ng-src="/plugins/checkCard/img/11.png" width="150" ng-if="cardDetailsList.pic == null">
                            <img class="img-circle" ng-src="{{cardDetailsList.pic}}" width="150" ng-if="cardDetailsList.pic != null">
                            <p class="infoName">会员姓名：{{cardDetailsList.member_name|noData:''}}</p>
                            <p class="infoOther">会员编号：{{cardDetailsList.mem_id|noData:''}}</p>
                            <p class="infoOther">会员性别：
                                <span ng-if="cardDetailsList.sex == 1">男</span>
                                <span ng-if="cardDetailsList.sex == 2">女</span>
                                <span ng-if="cardDetailsList.sex == null">暂无数据</span>
                            </p>
                            <p class="infoOther">会员年龄：
                                <span ng-if="cardDetailsList.birth_date == null || cardDetailsList.birth_date == '' ">暂无数据</span>
                                <span ng-if="cardDetailsList.birth_date != null && cardDetailsList.birth_date != '' ">{{cardDetailsList.birth_date | birth}}</span>
                            </p>
                            <p class="infoOther">手机号码：{{cardDetailsList.mobile|noData:''}}</p>
                            <p class="infoOther">会员备注：{{cardDetailsList.mdNote | noData:''}}</p>
                        </div>
                        <div class="col-sm-8 pd0 text-center rightContentBox">
                            <div class="col-md-12">
                                <img class="cardImg" src="/plugins/img/card111.png" ng-src="/plugins/img/card111.png" width="280">
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <p class="infoName infoName2">卡种名称：{{cardDetailsList.card_name|noData:''}}</p>
                                <p class="infoOther infoOther2">总计天数：{{duration}}</p>
                                <p class="infoOther infoOther2">卡种卡号：{{cardDetailsList.card_number|noData:''}}</p>
                                <p class="infoOther infoOther2">缴费日期：{{cardDetailsList.pay_money_time * 1000|date:'yyyy-MM-dd'}}</p>
                                <p class="infoOther infoOther2">激活日期：
                                    <span ng-if="cardDetailsList.active_time != null && cardDetailsList.active_time != ''">{{cardDetailsList.active_time * 1000|date:'yyyy-MM-dd'}}</span>
                                    <span ng-if="cardDetailsList.active_time == null || cardDetailsList.active_time == ''">暂无数据</span>
                                </p>
                                <p class="infoOther infoOther2">截止日期：{{cardDetailsList.invalid_time * 1000|date:'yyyy-MM-dd'}}</p>
                                <p class="infoOther infoOther2">缴费方式：
                                    <span ng-if="cardDetailsList.many_pay_mode == null || cardDetailsList.pay_money_mode != null">
                                        <span ng-if="cardDetailsList.pay_money_mode == '1'">现金</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '2'">支付宝</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '3'">微信</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '4'">pos刷卡</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '5'">建设分期</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '6'">广发分期</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '7'">招行分期</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '8'">借记卡</span>
                                        <span ng-if="cardDetailsList.pay_money_mode == '9'">贷记卡</span>
                                        <span>{{cardDetailsList.total_price|noData:''}}元</span>
                                    </span>
                                    <span ng-if="cardDetailsList.pay_money_mode == null || cardDetailsList.many_pay_mode != null">
                                        <span ng-repeat="yy in manyMode">
                                            <span ng-if="yy.type == '1'">现金</span>
                                            <span ng-if="yy.type == '2'">支付宝</span>
                                            <span ng-if="yy.type == '3'">微信</span>
                                            <span ng-if="yy.type == '4'">pos刷卡</span>
                                            <span ng-if="yy.type == '5'">建设分期</span>
                                            <span ng-if="yy.type == '6'">广发分期</span>
                                            <span ng-if="yy.type == '7'">招行分期</span>
                                            <span ng-if="yy.type == '8'">借记卡</span>
                                            <span ng-if="yy.type == '9'">贷记卡</span>
                                            <span>{{yy.price}}</span>元 /
                                        </span>
                                    </span>
                                </p>
                                <p class="infoOther infoOther2">总计金额：{{cardDetailsList.total_price|noData:''}}</p>
                                <p class="infoOther infoOther2">缴费单数：{{cardDetailsList.single|noData:''}}</p>
                                <p class="infoOther infoOther2">缴费备注：{{cardDetailsList.mcNote|noData:''}}</p>
                                <p class="infoOther infoOther2">售卖场馆：{{cardDetailsList.vName|noData:''}}</p>
                                <p class="infoOther infoOther2">所属场馆：{{cardDetailsList.ccName|noData:''}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="width: 100px;" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>