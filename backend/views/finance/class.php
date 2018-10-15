<?php
use backend\assets\FinanceAsset;

FinanceAsset::register($this);
$this->title = '财务管理 - 上课收入';
?>
<div ng-controller="classCtrl" ng-cloak>
    <div class="col-sm-12 pd0">
        <div class="col-sm-12 navBox">
            <form>
                <div class="form-group col-sm-4 col-sm-offset-4 pd0">
                    <input type="text" class="form-control searchInput" placeholder="输入私教进行搜索" ng-model="searchAll" ng-keyup="enterSearch($event)"/>
                </div>
                <button type="button" class="btn btn-success btnPd" ng-click="searchOpClick()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </form>
            <?php if (\backend\models\AuthRole::canRoleByAuth('class', 'DOWNLOAD')) { ?>
            <div class="" style="position: absolute;right: 150px;top: 30px; ">
<!--                href="/finance/get-class-excel"-->
                <a class="ladda-button btn btn-success dim" ng-click="searchOpClick(true)">
                    导出文件
                </a>
            </div>
            <?php } ?>
        </div>
        <div class="col-sm-12 conditionBox">
            <form class="form-inline">
                <div class="form-group  col-md-2">
                    <select class="form-control venueSelect " ng-model="venueCheck" style="width: 100% !important;">
                        <option value="">场馆选择</option>
                        <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                    </select>
                </div>
                <div class="input-daterange input-group col-lg-3 col-md-6 col-sm-6 float" id="container" >
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="classDateSelect" class="form-control text-center userSelectTime"/>
                </div>
                <div class="form-group">
                    <select class="form-control classTypeSelect" ng-model="classTypeSelect">
                        <option value="">课程分类</option>
                        <option value="1">PT</option>
                        <option value="2">HS</option>
                        <option value="3">生日课</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="moneyNum" placeholder="节" ng-model="startMoney"/>
                    <span>-</span>
                    <input type="number" class="moneyNum" placeholder="节" ng-model="endMoney"/>
                </div>
                <button type="submit" class="btn btn-default btn-sm" ng-click="initSearch()">清空</button>
                <button type="submit" class="btn btn-info btn-sm" ng-click="searchOpClick()">搜索</button>
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
                                style="width: 222px;">私教</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('token_num',sort)"
                                style="width: 222px;">上课节数</th>
                            <th class="sorting"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                aria-label="浏览器：激活排序列升序"
                                ng-click="changeSort('token_money',sort)"
                                style="width: 222px;">上课金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="c in classList">
                            <td data-toggle="modal"
                                data-target="#classDetailsModal"
                                ng-click="showCouserList(c.id)">{{8*(nowPage-1)+$index+1}}</td>
                            <td data-toggle="modal"
                                data-target="#classDetailsModal"
                                ng-click="showCouserList(c.id)">{{c.venue_name}}</td>
                            <td data-toggle="modal"
                                data-target="#classDetailsModal"
                                ng-click="showCouserList(c.id)">{{c.name}}</td>
                            <td data-toggle="modal"
                                data-target="#classDetailsModal"
                                ng-click="showCouserList(c.id)">{{c.token_num}}</td>
                            <td data-toggle="modal"
                                data-target="#classDetailsModal"
                                ng-click="showCouserList(c.id)">{{c.token_money}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'classNoDataShow','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bgw footerBox">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="col-sm-10 text-right">
                    <span>节数:<span class="orangeSpan">{{allClass}}节</span></span>
                    <span>上课金额:<span class="orangeSpan">{{classMoney}}元</span></span>
                    <span>剩余金额:<span class="orangeSpan">{{classSurplusMoney}}元</span></span>
                </div>
                <div class="col-sm-2 pd0" ng-if="">
                    <button class="btn btn-success btn-block">打印统计报表</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 上课收入详情模态框 -->
    <?= $this->render('@app/views/finance/classDetailsModal.php'); ?>
</div>