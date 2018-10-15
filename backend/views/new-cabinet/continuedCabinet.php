<!--    续柜模态框-->
<div class="modal fade" id="renewCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog w720" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" >续柜</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-5 iconBox">
                        <img class="imgHeaderW100" ng-src="{{cabinetDetail.pic}}" ng-if="cabinetDetail.pic != null">
                        <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" ng-if="cabinetDetail.pic == null">
                        <ul class="row">
                            <li class="col-sm-12 mT10">
                                <div class="col-sm-6 text-right pR0 f18 fw">姓名:</div>
                                <div class="col-sm-6 text-left pL0  f18 fw">{{cabinetDetail.consumerName}}</div>
                            </li>
                            <li class="col-sm-12 mT10">
                                <div class="col-sm-6 text-right pR0 ">手机号:</div>
                                <div class="col-sm-6 text-left pL0  ">{{cabinetDetail.mobile}}</div>
                            </li>
                            <li class="col-sm-12 mT10">
                                <div class="col-sm-6 text-right pR0 ">会员编号:</div>
                                <div class="col-sm-6 text-left pL0  ">{{cabinetDetail.member_id}}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-8 col-sm-offset-3 infoBox pT40 f14 pL0" >
                            <form class="form-horizontal">
                                <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                    <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                    <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                    <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                </p>
                                <br />
                                <div class="form-group mT10 pRelative" >
                                    <label for="inputdate" class="col-sm-4 textLeft pd0 control-label fontNormal pR20"><span class="red">*</span>续柜月数:</label>
                                    <div class="col-sm-8 mlF20" >
                                        <input type="number" class="form-control" ng-model="reletMonth" inputnum ng-change="reletMonthChange(reletMonth)" placeholder="请输入月数如:12">
                                    </div>
                                </div>

                                <div class="form-group mT10 pRelative mLF22" ng-if="giveReletMonthNum != null && giveReletMonthNum != undefined && giveReletMonthNum != ''">
                                    <label class="col-sm-4 textLeft pd0 control-label fontNormal pR20">
                                        <span class="red" style="opacity: 0;">*</span>赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数:
                                    </label>
                                    <div class="col-sm-8 mL20 mlF20" style="margin-bottom: 10px;">
                                        <input type="number" checknum class="form-control giveReletMonthNum11" ng-model="giveReletMonthNum" ng-change="giveTimenNumChange(giveReletMonthNum)">
                                    </div>
                                    <span class="glyphicon glyphicon-info-sign" style="margin-top: 5px;margin-left: 6px;display: inline-block;color: #999;">赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数不得大于{{giveReletMonthNum1}}<span>{{giveTimeType == 'd' ? '天' : '月'}}</span></span>
                                </div>

                                <div class="form-group  mT10 pRelative mLF22" >
                                    <label class="col-sm-4 textLeft pd0 control-label fontNormal pR20 " ><span class="red" style="opacity: 0;">*</span>到期日期:</label>
                                    <div class="col-sm-7 mL20 mT7" >
                                        <span >{{cabinetreletEndDate | noData:''}}</span>
                                    </div>
                                </div>

                                <div class="form-group mT10 pRelative" ng-if="redisplay == 1">
                                    <label for="inputdate" class="col-sm-4 textLeft pd0 control-label fontNormal pR20"><span>&nbsp; </span>折&emsp;&emsp;扣:</label>
                                    <div class="col-sm-8 mlF20" >
                                        <select class="form-control" ng-model="reDis" ng-change="getReDis(reDis)" style="font-size: 13px;">
                                            <option value="1" selected="selected">请选择折扣</option>
                                            <option value="{{d}}" ng-repeat="d in redises">{{ d }}</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="mR20 f14" >应收金额：<span class="moneyCss">{{reletPrice| number:2}}<small class="f14">元</small></span></span>
                <button type="button" ladda="renewCabinetCompleteFlag" ng-click="renewCabinetComplete()" class="btn btn-success w100" >完成</button>
            </div>
        </div>
    </div>
</div>