<!--卖课详情模态框-->
<div class="modal fade" id="getSellClassDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">卖课详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-5 pd0 text-center infoBox">
                            <img class="img-circle" ng-src="/plugins/checkCard/img/11.png" width="150" ng-if="memberCourseDetails.pic == null">
                            <img class="img-circle" ng-src="{{memberCourseDetails.pic}}" width="150" ng-if="memberCourseDetails.pic != null">
                            <div class="col-sm-10 col-sm-offset-1">
                                <p class="text-center infoName">会员姓名：{{memberCourseDetails.name|noData:''}}</p>
                                <p class="text-center infoOther">会员编号：{{memberCourseDetails.memberId|noData:''}}</p>
                                <p class="text-center infoOther">会员性别：
                                    <span ng-if="memberCourseDetails.sex == 1">男</span>
                                    <span ng-if="memberCourseDetails.sex == 2">女</span>
                                    <span ng-if="memberCourseDetails.sex == null">暂无数据</span>
                                </p>
                                <p class="text-center infoOther">手机号码：{{memberCourseDetails.mobile|noData:''}}</p>
                            </div>
                        </div>
                        <div class="col-sm-7 pd0 text-center rightContentBox">
                            <p class="infoName infoName2">{{memberCourseDetails.product_name|noData:''}}</p>
                            <p class="infoOther infoOther2">销售渠道：{{memberCourseDetails.business_remarks|noData:''}}</p>
                            <p class="infoOther infoOther2" ng-if="memberCourseDetails.type == 1">类型：PT</p>
                            <p class="infoOther infoOther2" ng-if="memberCourseDetails.type == 2">类型：HS</p>
                            <p class="infoOther infoOther2" ng-if="memberCourseDetails.type == null">类型：暂无数据</p>
                            <p class="infoOther infoOther2">节数：{{memberCourseDetails.course_amount|noData:''}}</p>
                            <p class="infoOther infoOther2">私教：{{memberCourseDetails.personalName|noData:''}}</p>
                            <p class="infoOther infoOther2">缴费日期：{{memberCourseDetails.create_at*1000|date:'yyyy-MM-dd'}}</p>
                            <p class="infoOther infoOther2">付款途径：
                                    <span ng-if="memberCourseDetails.many_pay_mode == null || memberCourseDetails.pay_money_mode != null">
                                        <span ng-if="memberCourseDetails.pay_money_mode == '1'">现金</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '2'">支付宝</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '3'">微信</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '4'">pos刷卡</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '5'">建设分期</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '6'">广发分期</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '7'">招行分期</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '8'">借记卡</span>
                                        <span ng-if="memberCourseDetails.pay_money_mode == '9'">贷记卡</span>
                                        <span>{{memberCourseDetails.money_amount|noData:''}}元</span>
                                    </span>
                                    <span ng-if="memberCourseDetails.pay_money_mode == null || memberCourseDetails.many_pay_mode != null">
                                        <span ng-repeat="ww in manyPayMode">
                                            <span ng-if="ww.type == '1'">现金</span>
                                            <span ng-if="ww.type == '2'">支付宝</span>
                                            <span ng-if="ww.type == '3'">微信</span>
                                            <span ng-if="ww.type == '4'">pos刷卡</span>
                                            <span ng-if="ww.type == '5'">建设分期</span>
                                            <span ng-if="ww.type == '6'">广发分期</span>
                                            <span ng-if="ww.type == '7'">招行分期</span>
                                            <span ng-if="ww.type == '8'">借记卡</span>
                                            <span ng-if="ww.type == '9'">贷记卡</span>
                                            <span>{{ww.price}}</span>元 /
                                        </span>
                                    </span>
                            </p>
                            <p class="infoOther infoOther2">总金额：{{memberCourseDetails.money_amount|noData:''}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>