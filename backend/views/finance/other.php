<?php
use backend\assets\FinanceAsset;

FinanceAsset::register($this);
$this->title = '财务管理 - 其他收入';
?>
<div ng-controller="otherCtrl" ng-cloak>
    <div class="col-sm-12 pd0">
        <div class="col-sm-12 navBox">
            <form>
                <div class="form-group col-sm-4 col-sm-offset-4 pd0">
                    <input type="text" class="form-control searchInput" placeholder="输入购买人、手机号、卡号、售卖人、订单号进行搜索" ng-model="searchAll" ng-keyup="enterSearch($event)"/>
                </div>
                <button type="button" class="btn btn-success btnPd" ng-click="searchOp()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <div class="col-sm-12 conditionBox">
            <form class="form-inline">
                <div class="form-group  col-md-2">
                    <select class="form-control venueSelect" ng-model="venueSelect" style="width: 100% !important;">
                        <option value="">场馆选择</option>
                        <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                    </select>
                </div>
                <div class="input-daterange input-group col-lg-3 col-md-6 col-sm-6 float" id="container" >
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="otherDateSelect" class="form-control text-center userSelectTime"/>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect"
                            ng-model="sellBehavior">
                        <option value="">业务行为</option>
                        <option value="租柜">租柜</option>
                        <option value="续柜">续柜</option>
                        <option value="柜子押金">柜子押金</option>
                        <option value="定金">定金</option>
                        <option value="会员卡转卡">转卡</option>
                        <option value="手环工本费">手环工本费</option>
                        <option value="私课转课">转课</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect"
                            ng-model="sellType">
                        <option value="">缴费方式</option>
                        <option value="1">现金</option>
                        <option value="2">微信</option>
                        <option value="3">支付宝</option>
<!--                        <option value="4">pos机</option>-->
                        <option value="5">建设分期</option>
                        <option value="6">广发分期</option>
                        <option value="7">招行分期</option>
                        <option value="8">借记卡</option>
                        <option value="9">贷记卡</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-default btn-sm" ng-click="initSearch()">清空</button>
                <button type="submit" class="btn btn-info btn-sm" ng-click="searchOp()">搜索</button>
            </form>
        </div>
        <div class="col-sm-12 contentBox pd0">
            <div class="ibox float-e-margins tableBox">
                <div class="ibox-content" style="padding: 0">
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                           id="DataTables_Table_0"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 140px;">序号</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">场馆</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('order_number',sort)"
                                style="width: 222px;">订单编号</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">购买人</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">业务行为</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('total_price',sort)"
                                style="width: 222px;">价格</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">缴费方式</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 140px;">售卖人</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('pay_money_time',sort)"
                                style="width: 300px;">缴费日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="o in otherList">
                            <td>{{8*(nowPage-1)+$index+1}}</td>
                            <td>{{o.venue_name|noData:''}}</td>
                            <td>{{o.order_number|noData:''}}</td>
                            <td>{{o.pay_people_name|noData:''}}</td>
                            <td>{{o.note|noData:''}}</td>
                            <td>{{o.total_price|noData:''}}</td>
                            <td>
                                <span ng-if="o.pay_money_mode == 1">现金</span>
                                <span ng-if="o.pay_money_mode == 2">微信</span>
                                <span ng-if="o.pay_money_mode == 3">支付宝</span>
                                <span ng-if="o.pay_money_mode == 4">pos机</span>
                                <span ng-if="o.pay_money_mode == 5">建设分期</span>
                                <span ng-if="o.pay_money_mode == 6">广发分期</span>
                                <span ng-if="o.pay_money_mode == 7">招行分期</span>
                                <span ng-if="o.pay_money_mode == 8">借记卡</span>
                                <span ng-if="o.pay_money_mode == 9">贷记卡</span>
                                <span ng-if="o.pay_money_mode == null">暂无数据</span>
                            </td>
                            <td ng-if="o.consumption_type != 'cabinet'">{{o.sell_people_name|noData:''}}</td>
                            <td ng-if="o.consumption_type == 'cabinet'">暂无数据</td>
                            <td ng-if="o.pay_money_time != null">{{o.pay_money_time*1000|date:'yyyy-MM-dd'}}</td>
                            <td ng-if="o.pay_money_time == null">暂无数据</td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'otherNoDataShow','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bgw footerBox">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="col-sm-10 text-right">
                    <span>金额:<span class="orangeSpan">{{allOther}}元</span></span>
                </div>
                <div class="col-sm-2  pd0" ng-if="">
                    <button class="btn btn-success btn-block">打印统计报表</button>
                </div>
            </div>
        </div>
    </div>
</div>
