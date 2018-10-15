<!--    绑定更衣柜模态框-->
<div class="modal fade" id="bindingCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog w720" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">绑定更衣柜</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-5 iconBox">
                        <img class="imgHeaderW100" ng-src="{{memberDetail.pic}}" ng-if="memberDetail.pic != null">
                        <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" ng-if="memberDetail.pic == null">
                        <section class="col-sm-12">
                            <div class="col-sm-6 text-right fw" style="padding-right: 0;font-size: 18px;">姓名:</div>
                            <div class="col-sm-6 text-left fw" style="padding-left: 0; font-size: 18px;">{{memberDetail.name}}</div>
                        </section>
                        <section class="col-sm-12" style="margin-top: 10px;">
                            <div class="col-sm-6 text-right" style="padding-right: 0;">手机号:</div>
                            <div class="col-sm-6 text-left" style="padding-left: 0;"> <span>{{memberDetail.mobile}}</span></div>
                        </section>
                        <!--                            <p class="userId">会员编号：<span>{{memberDetail.member_id}}</span></p>-->
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-8 col-sm-offset-3 infoBox bindingCabinetModelContent" >
                            <form class="form-horizontal">
                                <p class="cabinetName text-center">{{containerNumber}}
                                    <span ng-if="cabinetIsType == 1">大柜</span>
                                    <span ng-if="cabinetIsType == 2">中柜</span>
                                    <span ng-if="cabinetIsType == 3">小柜</span>
                                </p>
                                <br />
                                <!--<div class="form-group  pRelative" ng-if="giveBindMonthCounts != 0">
                                    <div class="col-sm-12 ">
                                        <span class="f12 colorD9">温馨提示: 租柜每满一年赠送{{giveBindMonthCounts}}个月</span>
                                    </div>
                                </div>-->
                                <div class="form-group mT10 pRelative" >
                                    <label class="col-sm-4 pd0 control-label pr20 fontNormal"  ><span class="red">*</span>租柜日期</label>
                                    <div class="col-sm-8 mlF20" >
                                        <div class="input-append date" id="dataCabinet"  data-date-format="yyyy-mm-dd">
                                            <input class="cabientSpan form-control h30"  type="text"  ng-change="rentCabinet(startRentCabinet)" placeholder="请选择购买日期" ng-model="startRentCabinet"  />
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mT10 pRelative" >
                                    <label for="inputdate" class="col-sm-4 pd0 control-label pr20 fontNormal" ><span class="red">*</span>租柜月数</label>
                                    <div class="col-sm-8 mlF20" >
                                        <input type="number" id="inputdate" ng-model="cabinetDays" inputnum ng-change="rentCabinetDays(cabinetDays)" class="form-control" placeholder="请输入月数如:12">
                                    </div>
                                </div>
                                <div class="form-group mT10 pRelative" ng-if="giveMonthBingCabinet != null && giveMonthBingCabinet != undefined && giveMonthBingCabinet != ''">
                                    <label class="col-sm-4 pd0 control-label textLeft  fontNormal"><span>&emsp;</span>赠送<span>{{buyTimeType == 'd' ? '天' : '月'}}</span>数</label>
                                    <div class="col-sm-8 mlF20 mT7" >
                                        <input type="number" name="" id="" class="form-control giveMonthBingCabinet11" placeholder="请输入赠送数" ng-model="giveMonthBingCabinet" ng-change="giveDayNumChange(giveMonthBingCabinet)">
                                    </div>
                                    <span class="glyphicon glyphicon-question-sign" style="padding-left: 15px;display: inline-block;margin-top: 15px;">赠送<span>{{buyTimeType == 'd' ? '天' : '月'}}</span>数不能大于{{giveMonthBingCabinet1}}<span>{{buyTimeType == 'd' ? '天' : '月'}}</span></span>
                                </div>
                                <div class="form-group mT10 pRelative" >
                                    <label class="col-sm-4 pd0 control-label textLeft  fontNormal"><span>&emsp;</span>到期日期</label>
                                    <div class="col-sm-8 mlF20 mT7" >
                                        <span>{{ cabinetEnd }}</span>
                                    </div>
                                </div>
                                <div class="form-group mT10 pRelative" ng-if="display == 1">
                                    <label class="col-sm-4 pd0 control-label pr20 fontNormal"><span>&nbsp;&nbsp;</span>折&emsp;&emsp;扣</label>
                                    <div class="col-sm-8 mlF20" >
                                        <div class="input-append date">
                                            <select class="cabientSpan form-control h30" ng-model="selectedDis" ng-change="getCurrentRootMoney(selectedDis)" style="font-size: 13px;">
                                                <option value="1" selected="selected">请选择折扣</option>
                                                <option value="{{x}}" ng-repeat="x in dises">{{x}}</option>
                                            </select>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        备注：
                                    </div>
                                    <div class="col-sm-8 pd0">
                                        <textarea rows="5" ng-model="bindCabinetNote" style="resize: none;"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="f14 mR20">应收金额：<span class="moneyCss">{{theAmountPayable ? theAmountPayable : 0 }}<small class="f14">元</small></span></span>
                <button type="button" ladda="bindingCabinetCompleteFlag" ng-click="bindingCabinetComplete(containerId)" class="btn btn-success w100">完成</button>
            </div>
        </div>
    </div>
</div>