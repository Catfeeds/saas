<?php
use backend\assets\FinanceAsset;

FinanceAsset::register($this);
$this->title = '财务管理 - 分摊收入';
?>
<div ng-controller="shareCtrl" ng-cloak>
    <div class="col-sm-12 pd0">
        <div class="col-sm-12 navBox">
            <form>
                <div class="form-group col-sm-4 col-sm-offset-4 pd0">
                    <input type="text" class="form-control searchInput" placeholder="输入会员姓名、卡号、会籍顾问进行搜索" ng-model="searchAll" ng-keyup="enterSearch($event)"/>
                </div>
                <button type="button" class="btn btn-success btnPd" ng-click="searchOp()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
        </div>
        <div class="col-sm-12 conditionBox">
            <form class="form-inline">
                <div class="form-group col-md-2 col-sm-3">
                    <select class="form-control venueSelect" ng-model="venueSelect" style="width: 100% !important;">
                        <option value="">场馆选择</option>
                        <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                    </select>
                </div>
                <div class="input-daterange input-group col-lg-3 col-md-6 col-sm-6 float" id="container" >
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="shareDateSelect" class="form-control text-center userSelectTime"/>
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
                                style="width: 222px;">卡种</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('total_price',sort)"
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
                                ng-click="changeSort('pay_money_time',sort)"
                                style="width: 300px;">缴费日期</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('total_price',sort)"
                                style="width: 222px;">分摊金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="s in shareIncomeList">
                          <td>{{8*(nowPage-1)+$index+1}}</td>
                          <td>{{s.venue_name}}</td>
                          <td>{{s.member_name|noData:''}}</td>
                          <td>{{s.card_number|noData:''}}</td>
                          <td>{{s.card_category_name|noData:''}}</td>
                          <td>{{s.total_price|noData:''}}</td>
                          <td>{{s.sell_people_name|noData:''}}</td>
                          <td>{{s.create_card_time*1000|date:'yyyy-MM-dd'}}</td>
                          <td>
                              <span ng-if="s.share != null && s.share != undefined">{{s.share|number:2}}</span>
                              <span ng-if="s.share == null || s.share == undefined">0.00</span>
                          </td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'shareNoDataShow','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bgw footerBox">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="col-sm-10 text-right">
                    <span>总分摊金额:<span class="orangeSpan">&nbsp;{{allShare|number:2}}元</span></span>
                </div>
                <div class="col-sm-2  pd0" ng-if="">
                    <button class="btn btn-success btn-block">打印统计报表</button>
                </div>
            </div>
        </div>
    </div>
</div>
