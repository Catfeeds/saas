<!--    退租模态框-->
<div class="modal fade" id="backCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB50" role="document" style="width: 800px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" >退柜</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-5 iconBox">
                        <img class="imgHeaderW100" ng-src="{{cabinetDetail.pic}}" ng-if="cabinetDetail.pic != null">
                        <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" ng-if="cabinetDetail.pic == null">
                        <ul class="row">
                            <li class="col-sm-12 mT10">
                                <div class="col-sm-6 text-right pR0 f18 fw">姓名:</div>
                                <div class="col-sm-6 text-left pL0  f18 fw">{{cabinetDetail.name}}</div>
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
                        <div class="col-sm-9 col-sm-offset-2 infoBox pT40 f14" >
                            <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                            </p>
                            <p>总共金额:<span>{{cabinetDetail.price | number:2 }}</span>元</p>
                            <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                            <p>剩余天数:<span>{{cabinetDetail.surplusDay > 0 ? cabinetDetail.surplusDay+ '天':'已到期'}}</span></p>
                            <p>到期时间:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="mR20 f14" >退还押金：<span class="moneyCss">{{depositRefund | number:2}}<small class="f14">元</small></span></span>
                <button type="button"  ladda="quitCabinetCompleteFlag" class="btn btn-success w100" ng-click="quitCabinetComplete(cabinetDetail.end_rent*1000)" >完成</button>
            </div>
        </div>
    </div>
</div>