<?php
use backend\assets\CabinetTypeAsset;
CabinetTypeAsset::register($this);
$this->title = '管理类型';
?>
<div ng-controller="CabinetTypeCtrl" class="group" ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li class="orderMenu"><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li>场地管理</li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">更衣柜管理</a></li>
                    <li role="presentation"><a href="/wcabinet/index#profile">到期提醒</a></li>
                    <li role="presentation"><a href="/wcabinet/index#profile1">退柜设置</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0" style="height: 100%;">
            <div class="panel-body detialS" style="overflow-y: auto;min-height: 600px;">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div ng-if="!isShow" class="row">
                            <!--柜子详情列表-->
                            <div class="col-sm-12" style="margin-bottom: 20px;">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 0 0 10px;color: #676a6cd6">< 更衣柜管理 < 男更衣柜 < 类型管理</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetNum',sort)" rowspan="1" colspan="1">柜子型号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetModel',sort)" rowspan="1" colspan="1">柜子类别</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetType',sort)" rowspan="1" colspan="1">柜号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1">柜子数量</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1">单月金额</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetEndRent',sort)" rowspan="1" colspan="1">押金</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-if = "lf > 0">
                                        <td>大柜</td>
                                        <td>正式</td>
                                        <td>{{largeFormNumber}}</td>
                                        <td>{{largeFormCount + '个'}}</td>
                                        <td ng-if="largeFormMoney != null && largeFormMoney != undefined && largeFormMoney != ''">{{largeFormMoney + '元'}}</td>
                                        <td ng-if="largeFormMoney == null || largeFormMoney == undefined || largeFormMoney == ''">暂无数据</td>
                                        <td ng-if="largeFormDeposit != null && largeFormDeposit != undefined && largeFormDeposit != ''">{{largeFormDeposit + '元'}}</td>
                                        <td ng-if="largeFormDeposit == null || largeFormDeposit == undefined || largeFormDeposit == ''">暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="CabinetTypeModify(largeFormId, largeFormCount, largeFirstNumber, '1', '2')">修改</span>
                                            <span style="color: #00b0e8">|</span>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="deleteCabinetType(largeFormId, largeFormCount)" ng-disabled="largeFormStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    <tr ng-if = "lt > 0">
                                        <td>大柜</td>
                                        <td>临时</td>
                                        <td>{{largeTempNumber}}</td>
                                        <td>{{largeTempCount + '个'}}</td>
                                        <td>暂无数据</td>
                                        <td>暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="CabinetTypeModify(largeTempId, largeTempCount, largeScondNumber, '1', '1')">修改</span>
                                            <span style="color: #00b0e8">|</span>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="deleteCabinetType(largeTempId, largeTempCount)" ng-disabled="largeTempStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    <tr ng-if = "mf > 0">
                                        <td>中柜</td>
                                        <td>正式</td>
                                        <td>{{MidFormNumber}}</td>
                                        <td>{{MidFormCount + '个'}}</td>
                                        <td ng-if="MidFormMoney != null && MidFormMoney != undefined && MidFormMoney != ''">{{MidFormMoney + '元'}}</td>
                                        <td ng-if="MidFormMoney == null || MidFormMoney == undefined || MidFormMoney == ''">暂无数据</td>
                                        <td ng-if="MidFormDeposit != null && MidFormDeposit != undefined && MidFormDeposit != ''">{{MidFormDeposit + '元'}}</td>
                                        <td ng-if="MidFormDeposit == null || MidFormDeposit == undefined || MidFormDeposit == ''">暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="CabinetTypeModify(MidFormId, MidFormCount, MidFirstNumber, '2', '2')">修改</span>
                                            <span style="color: #00b0e8;">|</span>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="deleteCabinetType(MidFormId, MidFormCount)" ng-disabled="MidFormStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    <tr ng-if = "mt > 0">
                                        <td>中柜</td>
                                        <td>临时</td>
                                        <td>{{MidTempNumber}}</td>
                                        <td>{{MidTempCount + '个'}}</td>
                                        <td>暂无数据</td>
                                        <td>暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="CabinetTypeModify(MidTempId, MidTempCount, MidScondNumber, '2', '1')">修改</span>
                                            <span style="color: #00b0e8">|</span>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="deleteCabinetType(MidTempId, MidTempCount)" ng-disabled="MidTempStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    <tr ng-if = "sf > 0">
                                        <td>小柜</td>
                                        <td>正式</td>
                                        <td>{{smallFormNumber}}</td>
                                        <td>{{smallFormCount + '个'}}</td>
                                        <td ng-if="smallFormMoney != null && smallFormMoney != undefined && smallFormMoney != ''">{{smallFormMoney + '元'}}</td>
                                        <td ng-if="smallFormMoney == null || smallFormMoney == undefined || smallFormMoney == ''">暂无数据</td>
                                        <td ng-if="smallFormDeposit != null && smallFormDeposit != undefined && smallFormDeposit != ''">{{smallFormDeposit + '元'}}</td>
                                        <td ng-if="smallFormDeposit == null || smallFormDeposit == undefined || smallFormDeposit == ''">暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="CabinetTypeModify(smallFormId, smallFormCount, smallFirstNumber, '3', '2')">修改</span>
                                            <span style="color: #00b0e8">|</span>
                                            <span style="color: #00b0e8;cursor: pointer;" ng-click="deleteCabinetType(smallFormId, smallFormCount)" ng-disabled="smallFormStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    <tr ng-if = "st > 0">
                                        <td>小柜</td>
                                        <td>临时</td>
                                        <td>{{smallTempNumber}}</td>
                                        <td>{{smallTempCount + '个'}}</td>
                                        <td>暂无数据</td>
                                        <td>暂无数据</td>
                                        <td>
                                            <span style="color: #00b0e8" ng-click="CabinetTypeModify(smallTempId, smallTempCount, smallScondNumber, '3', '1')">修改</span>
                                            <span style="color: #00b0e8">|</span>
                                            <span style="color: #00b0e8" ng-click="deleteCabinetType(smallTempId, smallTempCount)" ng-disabled="smallTempStatus == 2">删除</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php');?>
                            </div>
                        </div>
                        <div ng-show="isShow" class="row">
                            <form class="form-inline">
                                <div class="formBox row pLR20" style="padding: 0px 120px; height: 200px;" >
                                    <p class="addTitle">1.基本属性{{modifyCabinetType}}</p>
                                    <div class="col-sm-4 pd0 form-group formSmbox ">
                                        <label for="exampleInput1"><span class="red">*</span>柜子型号</label>
                                        <select disabled style="cursor: not-allowed;" ng-model="modifyCabinetSize" class="cp">
                                            <option value="">请选择柜子尺寸</option>
                                            <option value="1">大柜</option>
                                            <option value="2">中柜</option>
                                            <option value="3">小柜</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 pd0 form-group formSmbox ">
                                        <label ><span class="red">*</span>柜子类别</label>
                                        <select ng-model="modifyCabinetType1" class="cp">
                                            <option value="">请选择类别</option>
                                            <option  value="1">临时</option>
                                            <option  value="2">正式</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox ">
                                        <label >柜号&emsp; &emsp;</label>
                                        <div class="input-group">
                                            <input type="text" ng-model="modifyCabinetPrefix" class="form-control" onkeyup="this.value = this.value.replace(/\d/,'')"  placeholder="编号" style="width: 100px;">
                                            <input type="text" ng-model="modifyCabinetNumStart" checknum class="form-control" style="width: 100px;" placeholder="柜号">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pd0 formSmbox">
                                        <label for="exampleInput1"><span class="red">*</span>柜子数量</label>
                                        <input tyle="number" ng-disabled="true" class="form-control w200" ng-model="modifyCabinetNum" placeholder="请输入数量"/>
                                    </div>
                                </div>
                                <!--选择正式柜子触发显示的模块-->
                                <div class="formBox row pLR120" ng-show="modifyCabinetType1 == '2'">
                                    <p class="addTitle">
                                        2.价格设置
                                    </p>
                                    <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput3"><span class="red">*</span>单月金额</label>
                                        <input type="number" id="exampleInput3" ng-model="modifyHalfMonthMoney" class="form-control moneyInput" placeholder="请输入单月金额" autocomplete="off" checknum/>
                                        <span class="label label-info" ng-bind="modifyHalfMonthMoney|currency:'￥':0"></span>
                                    </div>
                                    <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput111"><span class="red">*</span>柜子押金</label>
                                        <input  type="number" id="exampleInput111" ng-model="modifyCabinetDeposit" class="form-control w200 moneyInput" placeholder="0元" autocomplete="off" checknum/>
                                        <span class="label label-info" ng-bind="modifyCabinetDeposit|currency:'￥':0"></span>
                                    </div>
                                    <hr style="background: #eee;margin-top: 80px;">
                                    <!--新增多月设置容器--start-->
                                    <div id="modifyMuchPlugins" class="addCabinetMonth">
                                        <div class="clearfix">
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                                <label for="exampleInput112">多月设置</label>
                                                <div class="input-group">
                                                    <input type="text" name="cabinet_month"  id="exampleInput112" ng-model="modifyMuchMonth" class="form-control" checknum style="width: 100px;" placeholder="月数" autocomplete="off"/>
                                                    <input type="number" name="cabinet_money" ng-model="modifyCabinetMoney" class="form-control moneyInput" style="width: 100px;" placeholder="金额" autocomplete="off" checknum/>
                                                </div>
                                                <span class="label label-info" ng-bind="modifyCabinetMoney|currency:'￥':0"></span>
                                            </div>
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40" >
                                                <label for="exampleInput113"><span style="visibility: hidden">*</span>&emsp;&emsp;赠送</label>
                                                <select class="form-control" style="width: 25%;padding: 0 0 0 5px;" ng-model="modifyGiveType">
                                                    <option value="d">天数</option>
                                                    <option value="m">月数</option>
                                                </select>
                                                <input type="text" name="give_month" id="exampleInput113" ng-model="modifyGiveMonth" class="form-control" checknum autocomplete="off" placeholder="请输入赠送数" style="width: 35%;"/>
                                            </div>
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                                <label for="exampleInput114"><span style="visibility: hidden">*</span>&emsp;&emsp;折扣</label>
                                                <input  type="text" name="cabinet_dis" id="exampleInput114" ng-model="modifyDis" class="form-control w200" placeholder="请输入折扣" autocomplete="off"/>
                                                <p class="help-block">
                                                    <i class="glyphicon glyphicon-info-sign"></i>多个折扣用<span class="text-info">"/"</span>分开,例如<span class="text-info"> (八折,七折,六折)</span>: <span class="text-success">0.8/0.7/0.6</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--新增多月设置容器 --end-->
                                    <span class="help-blocks">
                                        <button id="addCabMonth" class="btn btn-default btn-sm" venuehtml ng-click="btnAddMoreMonth()">
                                            <span class="glyphicon glyphicon-arrow-up"></span>
                                          新增多月设置
                                        </button>
                                    </span>
                                </div>
                                <div class="col-sm-12" style="padding: 10px 105px; height: 100px;" >
                                    <button ng-click="typeModifyComplete($id, modifyCabinetNum)" ladda="CabinetDetailFlag" style="padding: 5px 50px;" type="button" class="btn btn-sm btn-success">完成</button>
                                    <button ng-click="cancelTypeModify()" ladda="CabinetDetailFlag" type="button" class="btn btn-sm btn-default">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>