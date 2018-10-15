<!--带人卡部分-->

<!--带人卡绑定-->
<div class="modal hade" id="memberTogetherModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 65%;min-width: 720px;max-width: 1200px;">
        <div class="modal-content clearfix">
            <div class="modal-header text-center positionRelative">
                <div class="form-group togetherCardSelectbox">
                    <select class="form-control" id="bind" ng-change="getMemberBingInfo(memberBindCardId)" ng-model="memberBindCardId">
                        <option value="{{item.id}}" ng-repeat="item in memberBindCard">{{item.card_name}}</option>
                    </select>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">带人卡绑定</h4>
            </div>
            <div class="modal-body pd0">
                <div class="row">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-4 borderRightGreyBox" style="height: 480px;overflow-y: auto;">
                            <div class="col-sm-12 memberTogetherCardBox" ng-repeat="viceCard in viceCards" ng-click="getMemberById(viceCard.member_id,viceCard.create_at,viceCard.id)">
                                <p class="memberTogetherCardNumber">卡号:{{viceCard.card_number}}</p>
                                <p class="memberTogetherCardStatus">状态：
                                    <span>已绑定</span>
                                </p>
                            </div>
                            <div ng-if="addBindShow" class="col-sm-12 memberTogetherCardBox" ng-click="setShowBind()">
                                <p class="memberTogetherCardNumber"></p>
                                <p class="memberTogetherCardStatus">
                                    <span>添加绑定</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-8 memberTogetherCardContentBox">
                            <div class="col-sm-12 col-xs-12 col-md-12 memberTogetherCardContentInfo"
                                 ng-if="bindShowDetail">
                                <p class="memberTogetherCardContentBoxInfo">会员姓名：{{bindData.name}}</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindData.sex != null">会员性别：{{bindData.sex == 1 ? '男' : '女'}}</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindData.sex == null && bindTime == undefined">会员性别：</p>
                                <p class="memberTogetherCardContentBoxInfo">证件号：{{bindData.id_card}}</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindData.mobile != 0">手机号码：{{bindData.mobile}}</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindData.mobile == 0 || bindData.mobile == '' || bindData.mobile == null || bindData.mobile == undefined">手机号码：暂无数据</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindTime != null">绑定时间：{{(bindTime)*1000 | date:"yyyy/MM/dd"}}</p>
                                <p class="memberTogetherCardContentBoxInfo" ng-if="bindTime == null && bindTime == undefined">绑定时间：</p>
                                <div class="col-sm-12 col-xs-12 pd0">
                                    <button type="button"
                                            class="btn btn-warning w100 mt20"
                                            ng-click="delBindMemberById()">
                                        解绑</button>
                                </div>
                            </div>

                            <div style="padding: 40px 0;" class="col-sm-12 col-xs-12 col-md-12 togetherFormBox"
                                 ng-if="bindShow">
                                <!--如果未绑定显示这个-->
                                <form class="form-horizontal col-xs-12 col-sm-10 col-md-8 col-md-offset-2 col-sm-offset-1">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label togetherLabel"><span class="red">*</span>会员姓名</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text"
                                                   ng-model="bindUsername"
                                                   class="form-control"
                                                   placeholder="输入会员姓名"/>
                                        </div>
                                    </div>
                                    <div class="form-group mt30">
                                        <label class="col-sm-4 col-md-4 control-label togetherLabel"><span class="red">*</span>会员性别</label>
                                        <div class="col-sm-8 col-md-8">
                                            <select class="form-control pdt4"  ng-model="bindSex">
                                                <option value="">请选择</option>
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt30">
                                        <label class="col-sm-4 col-md-4 control-label togetherLabel"><span class="red"></span>证件号</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text"
                                                   ng-model="bindIdCard"
                                                   inputnum
                                                   class="form-control"
                                                   placeholder="输入证件号"/>
                                        </div>
                                    </div>
                                    <div class="form-group mt30">
                                        <label class="col-sm-4 col-md-4 control-label togetherLabel"><span class="red">*</span>手机号码</label>
                                        <div class="col-sm-5 col-md-5 pdr0">
                                            <input type="text"
                                                   inputnum
                                                   ng-model="bindMobile"
                                                   class="form-control"
                                                   placeholder="输入手机号"/>
                                        </div>
                                        <div class="col-sm-3 col-md-3 pdl0">
                                            <button class="btn btn-info btn-block btn-sm"
                                                    ng-click="getBindMemberCode(bindMobile)"
                                                    ng-bind="paracont"
                                                    ng-disabled="disabled">验证码</button>
                                        </div>
                                    </div>
                                    <div class="form-group mt30">
                                        <label class="col-sm-4 col-md-4 control-label togetherLabel"><span class="red">*</span>验证数字</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text"
                                                   ng-model="bindCode"
                                                   inputnum
                                                   class="form-control"
                                                   placeholder="输入验证码"/>
                                        </div>
                                    </div>
                                    <div class="form-group mt30">
                                        <div class="col-sm-12 col-md-12">
                                            <button class="btn btn-success" style="width: 100%" ng-click="bindMember(bindUsername,bindSex,bindMobile,bindIdCard,bindCode)">绑定</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default width100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>