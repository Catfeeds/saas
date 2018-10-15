<?php
use backend\assets\FinanceAsset;

FinanceAsset::register($this);
$this->title = '财务管理 - 卖课收入';
?>
<div ng-controller="sellCtrl" ng-cloak>
    <div class="col-sm-12 pd0">
        <div class="col-sm-12 navBox">
            <form>
                <div class="form-group col-sm-4 col-sm-offset-4 pd0">
                    <input type="text" class="form-control searchInput" placeholder="输入会员姓名、手机号、卡号、私教、课程名称" ng-model="searchAll" ng-keyup="enterSearch($event)"/>
                </div>
                <button type="button" class="btn btn-success btnPd" ng-click="searchOp()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <div class="col-sm-12 conditionBox">
            <form class="form-inline">
                <div class="form-group col-md-2">
                    <select class="form-control venueSelect" ng-change="changeVenue();" ng-model="venueCheck" style="width: 100% !important;">
                        <option value="">场馆选择</option>
                        <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                    </select>
                </div>
                <div class="input-daterange input-group col-lg-3 col-md-6 col-sm-6 float" id="container" >
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="sellDateSelect" class="form-control text-center userSelectTime"/>
                </div>
                <div class="form-group">
                    <select class="form-control venueSelect" ng-model="channelCheck">
                        <option value="">销售渠道</option>
                        <option ng-repeat="s in saleChannelList" value="{{s.value}}">{{s.value}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="moneyNum" placeholder="元" ng-model="startMoney"/>
                    <span>-</span>
                    <input type="number" class="moneyNum" placeholder="元" ng-model="endMoney"/>
                </div>
                <div class="form-group">
                    <select class="form-control productTypeSelect" ng-model="productType">
                        <option value="">请选择产品类型</option>
                        <option value="1">常规pt</option>
                        <option value="2">特色课</option>
                        <option value="3">游泳课</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control productTypeSelect" ng-model="courseType">
                        <option value="">请选择课程类型</option>
                        <option value="1">已上过的课程</option>
                        <option value="2">未上过的课程</option>
                        <option value="3">已过期的课程</option>
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
                                style="width: 222px;">场馆</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">会员姓名</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('card_number',sort)"
                                style="width: 222px;">卡号</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 212px;">销售渠道</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 212px;">课程名称</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 222px;">课程类型</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 212px;">产品类型</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('course_amount',sort)"
                                style="width: 212px;">节数</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('unit_price',sort)"
                                style="width: 140px;">课时费</th>
                            <th class="bgw"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                style="width: 140px;">私教</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('pay_money_time',sort)"
                                style="width: 300px;">缴费日期</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('total_price',sort)"
                                style="width: 222px;">总金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="s in sellClassList">
                            <td ng-click="sellTableClick(s.id)">{{8*(nowPage-1)+$index+1}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.venue_name|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.member_name|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.card_number|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.business_remarks| removeWords }}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.product_name|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.course_type == '1'">PT</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.course_type == '2'">HS</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.course_type == '3'">生日课</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.course_type == '4'">购课赠课</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.course_type == null">暂无数据</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.productType == '1' || s.productType == 1">PT常规课</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.productType == '2' || s.productType == 2">特色课</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.productType == '3' || s.productType == 3">游泳课</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.productType == null || s.productType == undefined || s.productType == ''">暂无数据</td>
                            <td ng-click="sellTableClick(s.id)">{{s.course_amount|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.unit_price|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)">{{s.private_name|noData:''}}</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.order_time != null">{{s.order_time*1000|date:'yyyy-MM-dd'}}</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.order_time == null">暂无数据</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.orderMoney != null">{{s.orderMoney}}元</td>
                            <td ng-click="sellTableClick(s.id)" ng-if="s.orderMoney == null">0元</td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'sellNoDataShow','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bgw footerBox">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="col-sm-10 text-right">
                    <span>总计:<span class="orangeSpan">{{allClass}}节</span></span>
                    <span>剩余节数:<span class="orangeSpan">{{overageNum}}节</span></span>
                    <span>总金额:<span class="orangeSpan">{{allMoney}}元</span></span>
                </div>
                <div class="col-sm-2  pd0">
                    <?php if (\backend\models\AuthRole::canRoleByAuth('sell', 'DOWNLOAD')) { ?>
<!--                        href="/finance/export-sell-excel">-->
                        <a class="btn btn-success printer" ng-click="searchOp(true)">
                            打印统计报表
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 卖课详情模态框 -->
    <?= $this->render('@app/views/finance/getSellClassDetailModal.php'); ?>
</div>
