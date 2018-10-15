<?php
use backend\assets\FinanceAsset;

FinanceAsset::register($this);
$this->title = '财务管理 - 卡种收入';
?>
<div ng-controller="cardCtrl" ng-cloak>
    <div class="col-sm-12 pd0">
        <div class="col-sm-12 navBox">
            <form>
                <div class="form-group col-sm-4 col-sm-offset-4 pd0">
                    <input type="text" class="form-control searchInput" placeholder="输入会员姓名、手机号、卡号、会籍顾问、卡种进行搜索" ng-model="searchAll" ng-keyup="enterSearch($event)"/>
                </div>
                <button type="button" class="btn btn-success btnPd" ng-click="search()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <div class="col-sm-12 conditionBox">
            <form class="form-inline">
                <div class="form-group col-lg-2 col-md-3">
                    <select class="form-control venueSelect" ng-model="venueCheck" style="width: 100% !important;padding-left: 6px;padding-right: 6px;">
                        <option value="">场馆选择</option>
                        <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                    </select>
                </div>
                <div class="input-daterange input-group col-md-4 float" id="container">
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="cardDateSelect" class="form-control text-center userSelectTime"/>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect" ng-model="behavior">
                        <option value="">缴费行为</option>
                        <option value="办卡">办卡</option>
                        <option value="续费">续费</option>
                        <option value="升级">升级</option>
                        <option value="回款">回款</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect" ng-model="payMode">
                        <option value="">缴费方式</option>
                        <option value="1">现金</option>
                        <option value="2">支付宝</option>
                        <option value="3">微信</option>
<!--                        <option value="4">pos机</option>-->
                        <option value="5">分期</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect" ng-model="payStatus">
                        <option value="">开票状态</option>
                        <option value="1">已开票</option>
                        <option value="0">未开票</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="moneyNum" placeholder="元" ng-model="startMoney"/>
                    <span>-</span>
                    <input type="number" class="moneyNum" placeholder="元" ng-model="endMoney"/>
                </div>
                <button type="submit" class="btn btn-default btn-sm" ng-click="initSearch()">清空</button>
                <button type="submit" class="btn btn-info btn-sm" ng-click="search()">搜索</button>
            </form>
        </div>
        <div class="col-sm-12 contentBox pd0">
            <div class="ibox float-e-margins tableBox">
                <div class="ibox-content"
                     style="padding: 0">
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                           id="DataTables_Table_0"
                           aria-describedby="DataTables_Table_0_info" style="margin-bottom: 0;">
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
                                style="width: 260px;">场馆</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">会员姓名</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">缴费行为</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">卡种</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('total_money',sort)"
                                style="width: 222px;">总金额</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">会籍顾问</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('single',sort)"
                                style="width: 140px;">单数</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('pay_money_time',sort)"
                                style="width: 300px;">缴费日期</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="card in cardIncomeList">
                                <td ng-click="lookDetails(card.id)">{{8*(nowPage-1)+$index+1}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.venue_name}}</td>
                                <td ng-click="lookDetails(card.id)">
                                    <span ng-if="card.member_name != null">{{card.member_name}}</span>
                                    <span ng-if="card.member_name == null">{{card.username}}</span>
                                </td>
                                <td ng-click="lookDetails(card.id)">{{card.note}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.card_category_name}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.total_price | noData:''}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.sell_people_name | noData:''}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.single|noData:''}}</td>
                                <td ng-click="lookDetails(card.id)">{{card.pay_money_time*1000|date:'yyyy-MM-dd'}}</td>
                                <td class="pd0">
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'CARDBILLING')) { ?>
                                        <button class="btn btn-sm btn-success w100"
                                                ng-if="card.is_receipt == '0'"
                                                ng-click="cardReceipt(card.id)">开票</button>
                                        <span ng-if="card.is_receipt == '1'">已开票</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'groupNoDataShow','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bgw footerBox">
            <div class="col-sm-12">
                <div class="col-md-10 col-sm-9 text-right">
                    <span>总单数:&nbsp;<span class="orangeSpan">{{receipt}}单</span></span>
                    <span>总金额:&nbsp;<span class="orangeSpan">{{totalMoney}}元</span></span>
                    <span>已开票:&nbsp;<span class="orangeSpan">{{receiptNum}}</span></span>
                    <span>开票金额:&nbsp;<span class="orangeSpan">{{receiptMoney}}元</span></span>
                </div>
                <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'DOWNLOAD')) { ?>
                    <div class="col-md-2 col-sm-2 text-right pd0">
<!--                        href="/finance/export-card-excel" 链接配合SEESION使用-->
                        <button class="btn btn-success printer" ng-click="search(true)">
                            打印统计报表
                        </button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- 卡种收入详情模态框 -->
    <?= $this->render('@app/views/finance/detailsCradModal.php'); ?>
</div>
