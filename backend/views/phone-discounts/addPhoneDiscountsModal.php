<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/24 0024
 * Time: 9:29
 */
 -->
<!-- 新增折扣模态框 -->
<div class="modal fade" id="addNewPhoneDiscountsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新增移动端折扣&emsp;</h4>
            </div>
            <div class="modal-body">
                <div class="row MT20 text-center">
                    <span class="f10 colorCCC"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;每个场馆只能有一个折扣</span>
                </div>
                <div class="row MT20">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-2 pd0 text-right">
                            <span class="red">*</span><span>场馆：&emsp;</span>
                        </div>
                        <div class="col-sm-4 pd0">
                            <label for="">
                                <select name="" id="addDiscountVenue" ng-model="addDiscountVenue" ng-change="venueChange(addDiscountVenue)">
                                    <option value="">选择场馆</option>
                                    <option ng-repeat="venue in venueList" value="{{venue.id}}">{{venue.name}}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row MT20">
                    <div class="col-sm-6 pd0">
                        <div class="col-sm-4 pd0 text-right">
                            <span class="red">*</span><span>移动端卡种折扣：&emsp;</span>
                        </div>
                        <div class="col-sm-8 pd0">
                            <label for="">
                                <input class="inputStyle" type="text" placeholder="请输入折扣,如:8.0" ng-model="addDiscountDiscount" style="width: 130px;">
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 pd0">
                        <div class="col-sm-4 pd0 text-right">
                            <span>折扣售卖期限：&emsp;</span>
                        </div>
                        <div class="col-sm-8 pd0">
                            <label for="">
                                <input class="inputStyle startTime" type="text" placeholder="起始日期" ng-model="addDiscountStartTime" readonly style="width: 100px;">
                            </label>
                            <label for="">
                                <input class="inputStyle endTime" type="text" placeholder="结束日期" ng-model="addDiscountEndTime" readonly style="width: 100px;margin-left: 15px;">
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row MT20">
                    <div class="col-sm-6 pd0">
                        <div class="col-sm-4 pd0 text-right">
                            <span>不打折卡种：&emsp;</span>
                        </div>
                        <ul class="col-sm-8 pd0">
                            <li class="col-sm-8 mL20" style="margin-left: 0">
                                <select class="js-example-basic-single payMoneyType form-control" id="discountCardSelect" multiple="multiple" ng-model="noDiscountCardType" ng-change="noDiscountChange(noDiscountCardType) ">
                                    <option ng-repeat="i in venueCardList" value="{{i.id}}" data-name="{{i.card_name}}">{{i.card_name}}</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-success btn-padding" ng-click="addDiscount()">提交审核</button>
            </div>
        </div>
    </div>
</div>