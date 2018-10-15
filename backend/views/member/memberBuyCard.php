<!--    二次购卡及送人卡部分-->
<!-- 购卡模态框 -->
<div class="modal fade" id="buyCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 55%;min-width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">购卡</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 pdt20Box">
                        <div class="col-sm-5 ">
                            <img ng-if="MemberData.pic == null" ng-src="/plugins/checkCard/img/11.png" width="180"
                                 height="180" alt="">
                            <div ng-if="MemberData.pic != null"
                                 style="width:180px; height:180px;border-radius: 50%;overflow: hidden;">
                                <img ng-src="{{MemberData.pic}}" width="180" height="180" alt="">
                            </div>
                            <p class="buyCardWords font-blod">会员姓名：{{MemberData.name}}</p>
                            <p class="buyCardWords">会员生日：{{MemberData.birth_date| noData:''}}</p>
                            <p class="buyCardWords">证件号：{{MemberData.id_card}}</p>
                            <p class="buyCardWords" ng-if="MemberData.mobile != 0">手机号码：{{MemberData.mobile}}</p>
                            <p class="buyCardWords"
                               ng-if="MemberData.mobile == 0 || MemberData.mobile == null || MemberData.mobile == undefined || MemberData.mobile == ''">
                                手机号码：暂无数据</p>
                        </div>
                        <div class="col-sm-7" style="border-left: solid 1px #E5E5E5;">
                            <form style="padding-left: 0;" class="form-horizontal pdl30Form">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        选择卡种
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control pdt4"  ng-model="cardType" ng-change="cardChange(cardType)">
                                            <option value="">请选择</option>
                                            <option ng-repeat="x in getCardList"
                                                    value="{{x.id}}">{{x.card_name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt20" style="margin-bottom: 0;">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        应付金额
                                    </label>
                                    <div class="col-sm-6">
                                        <input class="form-control amountMoneyInput1"
                                               id="amountMoneyInputVal2"
                                               placeholder="请输入应付金额"
                                               ng-change="mathAllAmountMoneyLast()"
                                               ng-disabled="amount != null && amount != ''"
                                               ng-model="buyMoney">
                                               <span style="font-size: 12px;color: #999;"
                                               ng-if="buyCardMaxPrice != '' && buyCardMaxPrice != undefined">区间价格为：{{buyCardMinPrice}}至{{buyCardMaxPrice}}元</span>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 15px;">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        付款方式
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control pdt4"
                                                ng-model="pay"   ng-change="paymentTypeChange(pay)">
                                            <option value="">请选择</option>
                                            <option value="1">全款</option>
                                            <option value="2">定金</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                       定金金额
                                    </label>
                                    <div class="col-sm-6" style="margin-left: 16px">
                                        <select class="form-control select2 buyCardDepositSelect2" multiple="multiple" ng-change="buyCardDepositSelectChange()"ng-model="buyCardDepositSelect">
                                            <option ng-repeat="zzz in buyCardDepositSelectData" value="{{zzz.id}}" data-price="{{zzz.price}}">定金：{{zzz.price}}元</option>
                                        </select>
                                        <br>
                                        <br>
                                        <span>剩余购卡定金{{surplusPrice}}元</span>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        选择销售
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control pdt4"
                                                ng-model="saleMan">
                                            <option value="">请选择</option>
                                            <option ng-repeat="ss in saleInfo"
                                                    value="{{ss.id}}">
                                                {{ss.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        会员卡号
                                    </label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text"
                                               placeholder="请输入会员卡号"
                                               ng-model="userCardNumber"/>
                                    </div>
                                </div>
                                <!--                                    <div class="form-group mt20">-->
                                <!--                                        <label class="col-sm-4 control-label label-words">-->
                                <!--                                            <span class="text-danger">*</span>收款方式-->
                                <!--                                        </label>-->
                                <!--                                        <div class="col-sm-6">-->
                                <!--                                            <select class="form-control pdt4" ng-model="paymentMethod">-->
                                <!--                                                <option value="">请选择</option>-->
                                <!--                                                <option value="1">现金</option>-->
                                <!--                                                <option value="3">微信</option>-->
                                <!--                                                <option value="2">支付宝</option>-->
                                <!--                                                <option value="4" >pos机</option>-->
                                <!--                                                <option value="5" >建设分期</option>-->
                                <!--                                                <option value="6" >广发分期</option>-->
                                <!--                                                <option value="7" >招行分期</option>-->
                                <!--                                                <option value="8" >借记卡</option>-->
                                <!--                                                <option value="9" >贷记卡</option>-->
                                <!--                                            </select>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <div class="form-group mt20 buyCardMethodBox">
                                    <div class="col-sm-12 addBuyCardElement removeDiv" style="padding: 10px 0;">
                                        <label class="col-sm-4 control-label label-words" style="padding-top: 5px;">
                                            <span class="red">*</span>付款途径
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="buyCardMethodSelect">
                                                <option value="">请选择</option>
                                                <option value="1">现金</option>
                                                <option value="3">微信</option>
                                                <option value="2">支付宝</option>
                                                <!--                                        <option value="4" >pos机</option> -->
                                                <option value="5">建设分期</option>
                                                <option value="6">广发分期</option>
                                                <option value="7">招行分期</option>
                                                <option value="8">借记卡</option>
                                                <option value="9">贷记卡</option>
                                            </select>
                                            <input type="text" class="buyCardPrice" ng-change="buyCardInputChange()"
                                                   ng-model="buyCardInput" style="border-color: #0a0a0a;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt20 buyCardMethodBtnBox text-center">
                                    <button class="btn btn-default buyCardMethodButton" id="buyCardMethod" venuehtml
                                            ng-click="addBuyCardMethod()">新增付款途径
                                    </button>
                                    总金额：<span>{{allBuyCardPrice}}</span>元
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        使用方式
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control pdt4" ng-model="use">
                                            <option value="1">自用</option>
                                            <option value="2">送人</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        购卡备注
                                    </label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" ng-model="buyCardNote"
                                                  style="overflow-y: auto;height: 100px;resize: none;border-color: #0a0a0a;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <div style="text-align: right;">
                                        <p class="ppp">
                                            <span style="font-size: 18px;color: #ff9900;font-weight: bold;">应付:{{allMathMoney}}元</span>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="text-align: center;">
                <button type="button"
                        class="btn btn-success width100"
                        ng-click="buyTwoCardSuccess()"
                        ladda="checkButton">完成
                </button>
            </div>
        </div>
    </div>
</div>

<!--  绑定会员模态框 -->
<div class="modal fade" id="bindingUserSelectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 35%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <h2 class="text-center h2BindingTitle" style="margin-top: 4px">绑定会员
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 btnBindingBox">
                        <div class="btnBoxBinding">
                            <button class="btn btn-success center-block btn-block"
                                    ng-click="newUserBinding()">新会员绑定
                            </button>
                        </div>
                        <div class="btnBoxBinding2">
                            <button class="btn btn-default center-block btn-block"
                                    ng-click="oldUserBinding()">老会员绑定
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!--送人卡修改模态框-->

<div class="modal fade" id="changeMemberTimeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="myModalLabel">修改时间</h3>
            </div>
            <div class="modal-body">
                <div class="row pd15">
                    <div class="col-sm-12 m20">
                        <div class="col-sm-4 lh32 text-right">
                            <label for=""><span class="red">*</span>激活时间：</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="delayActiveCard lh32 inputStyle" ng-model="delayActiveCardChange">
                        </div>
                    </div>
                    <div class="col-sm-12 m20">
                        <div class="col-sm-4 lh32 text-right">
                            <label for=""><span class="red">*</span>到期时间：</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="expiryTime lh32 inputStyle" ng-model="expiryTimeChange">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-padding" ng-click="changePresentCardTime()">修改</button>
                <button type="button" class="btn btn-default btn-padding" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>

<!-- 绑定老会员模态框 -->
<div class="modal fade" id="bindingUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h2 class="text-center h2BindingTitle">搜索会员</h2>
                    <div class="col-sm-8 col-sm-offset-2 inputBindingBox">
                        <form>
                            <div class="form-group">
                                <input type="text"
                                       class="form-control uglyInput"
                                       placeholder="&nbsp;输入手机号或会员卡号或会员名称进行搜索"
                                       ng-model="keywordsTel"/>
                                <button type="submit"
                                        class="btn btn-success w40Btn"
                                        ng-click="searchBindingUser()"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- 新会员绑定模态框 -->
<div class="modal fade" id="bindingNewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">绑定新会员</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img ng-src="/plugins/checkCard/img/11.png" width="180" style="margin-bottom: 20px;">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4 control-label label-words">
                                    <span class="text-danger">*</span>
                                    姓名
                                </label>
                                <div class="col-sm-5">
                                    <input class="form-control"
                                           placeholder="请输入姓名"
                                           ng-model="newBindingName"/>
                                </div>
                            </div>
                            <div class="form-group mt20">
                                <label class="col-sm-4 control-label label-words">
                                    <span class="text-danger">*</span>
                                    证件号
                                </label>
                                <div class="col-sm-5">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="请输入证件号"
                                           ng-model="newBindingIdCard"/>
                                </div>
                            </div>
                            <div class="form-group mt20">
                                <label class="col-sm-4 control-label label-words">
                                    <span class="text-danger">*</span>
                                    性别
                                </label>
                                <div class="col-sm-5">
                                    <select class="form-control pdt4" ng-model="newBindingSex">
                                        <option value="">请选择性别</option>
                                        <option value="1">男</option>
                                        <option value="2">女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt20">
                                <label class="col-sm-4 control-label label-words">
                                    <span class="text-danger">*</span>
                                    手机号
                                </label>
                                <div class="col-sm-3 pdr0">
                                    <input type="number"
                                           inputnum
                                           class="form-control"
                                           placeholder="请输入手机号"
                                           ng-model="newBindingMobile"/>
                                </div>
                                <div class="col-sm-2 pdl0">
                                    <button class="btn btn-info btn-block codeBtn"
                                            ng-click="getCode()"
                                            ng-bind="paracont"
                                            ng-disabled="disabled"
                                            value="获取验证码"></button>
                                </div>
                            </div>
                            <div class="form-group mt20">
                                <label class="col-sm-4 control-label label-words">
                                    <span class="text-danger">*</span>
                                    验证码
                                </label>
                                <div class="col-sm-5">
                                    <input type="number"
                                           class="form-control"
                                           placeholder="请输入验证码"
                                           ng-model="newBindingCode"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success center-block w100"
                        ng-click="newBindingSuccess()"
                        ladda="checkButton">完成
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 绑定老会员详情的模态框 -->
<div class="modal fade" id="bindingUserDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">绑定会员</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 text-center">
                            <img class="" ng-src="/plugins/checkCard/img/11.png" width="180">
                        </div>
                        <div class="col-sm-6">
                            <p class="bindingUserName nameU">姓名:
                                <span>{{userInfoNews.name| noData:''}}</span>
                            </p>
                            <p class="bindingUserTel">性别:
                                <span ng-if="userInfoNews.memberDetails.sex == 1">男</span>
                                <span ng-if="userInfoNews.memberDetails.sex == 2">女</span>
                                <span ng-if="userInfoNews.memberDetails.sex == null">暂无数据</span>
                                <span ng-if="userInfoNews.memberDetails.sex == 0">暂无数据</span>
                            </p>
                            <p class="bindingUserTel">生日:
                                <span>{{userInfoNews.memberDetails.birth_date| noData:''}}</span>
                            </p>
                            <p class="bindingUserTel">证件号:
                                <span>{{userInfoNews.memberDetails.id_card| noData:''}}</span>
                            </p>
                            <p class="bindingUserTel">手机号:
                                <span ng-if="userInfoNews.mobile != 0">{{userInfoNews.mobile| noData:''}}</span>
                                <span
                                    ng-if="userInfoNews.mobile == 0 || userInfoNews.mobile == '' || userInfoNews.mobile == null || userInfoNews.mobile == undefined">暂无数据</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success center-block w100"
                        ng-click="bindingOldUserSendCard()"
                        ladda="checkButton">绑定会员
                </button>
            </div>
        </div>
    </div>
</div>