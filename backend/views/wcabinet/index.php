<?php
use backend\assets\WcabinetAsset;
WcabinetAsset::register($this);
$this->title = '更柜管理';
?>
<div ng-controller="cabinetCtrl" class="group" ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li class="orderMenu"><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li><a href="/foreign-field-management/index">场地管理</a></li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <ul class="nav nav-tabs" role="tablist">
                        <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">更衣柜管理</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" ng-click="getMemberCabinetData()">到期提醒</a></li>
                        <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab" ng-click="getCardDate()">退柜设置</a></li>
                    </ul>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0" style="height: 100%;">
            <div class="panel-body detialS" style="min-height: 600px;">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="contentBox">
                            <div class="col-sm-8 col-xs-8" style="margin-bottom: 10px">
                                <div class="row">
                                    <select class="venueChoose" style="height: 30px;border: 1px solid #ddd"  ng-model="venueChoose" ng-change="venueSelectChange(venueChoose)" ng-if="cabinetDetailOpen">
                                        <option value="">请选择场馆</option>
                                        <option ng-repeat="venues in venueLists" value="{{venues.id}}">{{venues.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 text-right">
                                <div class="row">
                                    <button class="btn btn-sm btn-success" ng-click="addAreaBtn()" style="color: #fff;">添加区域</button>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-top: 1px solid #ddd;">
                                <div class="row">
                                    <div class="col-sm-3 box pd0 mT10 cp" ng-model="allCabinetData" ng-repeat="(index, cabinet) in  allCabinet" ng-click="cabinetBox(cabinet.id,cabinet.type_name)">
                                        <div class="col-sm-12 cabinetBox" style="position: relative;">
                                            <button ng-if="cabinet.btnShow" class="btn btn-sm btn-default" ng-click="deleteContentBoxButton(cabinet.id,cabinet.is_rent)" style="position: absolute;right: 25px;top: 35px;">删除</button>
                                            <span class="text-center pull-right" ng-click="isShow(index, $event)">...</span>
                                            <h3>{{cabinet.type_name}}</h3>
                                            <p>总数量:{{cabinet.cabinetNum}}个/已租柜:{{cabinet.is_rent}}个</p>
                                            <p>我爱运动大上海店</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 管理类型列表-->
                        <div class="col-sm-12 listBoxType pd0 disNl">
                            <div class="col-sm-12 heightCenter mT10" style="padding: 4px 0;border: solid 1px #F5f5f5;">
                                <div class="col-sm-4  text-left" >
                                    <span ng-click="backShaPage()" class= "cp glyphicon glyphicon-chevron-left backHistory f20"></span>
                                </div>
                                <div class="col-sm-4  contentCenter text-center f16" style="font-weight: 600;">
                                    管理类型
                                </div>
                            </div>
                            <div class="col-sm-12 pd0">
                                <div class="ibox float-e-margins borderNone" >
                                    <div class="ibox-content pd0" >
                                        <div  id="DataTables_Table_0_wrapper" class="pB0 dataTables_wrapper form-inline" role="grid">
                                            <table class="table table-bordered table-hover dataTables-example dataTable">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 260px;">柜子型号</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 110px;">柜子类别</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 110px;">柜号</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 120px;">柜子数量</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 120px;">单月金额</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 120px;">押金</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 255px;">操作</th>
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
                                                        <button type="button" ng-click="showCabinetDetail('大柜','正式', largeFormNumber, largeFormCount,largeFormId, '1', '2',largeFormStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(largeFormId, largeFormCount, largeFirstNumber, '1', '2')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(largeFormId, largeFormCount)" ng-disabled="largeFormStatus == 2" class="btn btn-danger">删除</button>
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
                                                        <button type="button" ng-click="showCabinetDetail('大柜','临时',largeTempNumber, largeTempCount,largeTempId, '1', '1',largeTempStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(largeTempId, largeTempCount, largeScondNumber, '1', '1')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(largeTempId, largeTempCount)" ng-disabled="largeTempStatus == 2" class="btn btn-danger">删除</button>
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
                                                        <button type="button" ng-click="showCabinetDetail('中柜', '正式', MidFormNumber, MidFormCount,MidFormId, '2', '2',MidFormStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(MidFormId, MidFormCount, MidFirstNumber, '2', '2')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(MidFormId, MidFormCount)" ng-disabled="MidFormStatus == 2" class="btn btn-danger">删除</button>
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
                                                        <button type="button" ng-click="showCabinetDetail('中柜', '临时', MidTempNumber, MidTempCount,MidTempId, '2', '1',MidTempStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(MidTempId, MidTempCount, MidScondNumber, '2', '1')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(MidTempId, MidTempCount)" ng-disabled="MidTempStatus == 2" class="btn btn-danger">删除</button>
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
                                                        <button type="button" ng-click="showCabinetDetail('小柜','正式',smallFormNumber,smallFormCount,smallFormId, '3', '2',smallFormStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(smallFormId, smallFormCount, smallFirstNumber, '3', '2')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(smallFormId, smallFormCount)" ng-disabled="smallFormStatus == 2" class="btn btn-danger">删除</button>
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
                                                        <button type="button" ng-click="showCabinetDetail('小柜', '临时', smallTempNumber, smallTempCount,smallTempId, '3', '1',smallTempStatus)" class="btn btn-default">详情</button>
                                                        <button type="button" ng-click="CabinetTypeModify(smallTempId, smallTempCount, smallScondNumber, '3', '1')"  class="btn btn-warning">修改</button>
                                                        <button type="button" ng-click="deleteCabinetType(smallTempId, smallTempCount)" ng-disabled="smallTempStatus == 2" class="btn btn-danger">删除</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/nodata.php');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="row">
                            <div class="col-sm-10" style="margin-bottom: 10px">
                                <div class="disB">
                                    <select class="venueChoose" style="height: 30px;border: 1px solid #ddd"  ng-model="venue" ng-change="venueChange(venue)">
                                        <option value="">请选择场馆</option>
                                        <option ng-repeat="venues in venueLists" value="{{venues.id}}">{{venues.name}}</option>
                                    </select>
                                </div>
                                <div class="disB">
                                    <select class="form-control selectPd" style="width: 120px;" ng-model="cabinetData" ng-change="getCabinet(cabinetData)">
                                        <option value="">全部区域</option>
                                        <option value="{{cabinet.id}}" ng-repeat="cabinet in cabinetType">
                                            {{cabinet.type_name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="disB">
                                    <select class="form-control selectPd" style="width: 140px;"ng-model="cabinetDay" ng-change="getDay()">
                                        <option value="">选择到期时间</option>
                                        <option value="d">当日</option>
                                        <option value="w">当周</option>
                                        <option value="m">当月</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                                <button type="button" class="btn btn-sm btn-success"ng-click="sendCabinet()" ladda="sendBtnStatus">批量发送短信</button>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">序号</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">区域</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">柜号</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">型号</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">会员姓名</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">手机号</th>
                                        <th tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">到期日期</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat='(index, data) in datas'>
                                        <td>{{index +1}}</td>
                                        <td>{{data.type_name | noData:''}}</td>
                                        <td>{{data.cabinet_number | noData:''}}</td>
                                        <td ng-if="data.cabinet_model ==1">大柜</td>
                                        <td ng-if="data.cabinet_model ==2">中柜</td>
                                        <td ng-if="data.cabinet_model ==3">小柜</td>
                                        <td>{{data.name | noData:''}}</td>
                                        <td>{{data.mobile | noData:''}}</td>
                                        <td>{{data.end_rent*1000 | date:'yyyy-MM-dd'| noData:''}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php',['name' => 'cabinetNoDataShow','text' => '无即将到期会员数据', 'href' => true]); ?>
                                <?=$this->render('@app/views/common/pagination.php',['page' =>'cabinet']);?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile1">
                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                        <div class="col-sm-12">
                            <div class="form-group">
                                到期退款
                                <input ng-model="setDays" type="text" inputnum placeholder="请输入天数" style="padding: 5px 10px;height: 28px;width: 200px;margin-left: 20px">
                                <div style="margin-left: 55px;margin-top: 5px;color: rgb(153,153,153);">
                                    <span class="fa fa-info-circle">到期多少天内可进行全额退款</span>
                                </div>
                            </div>
                            <div class="form-group">
                                超期扣费
                                <div style="display: inline-block">
                                    <select id="getDateType"  style="height: 28px;width: 50px;position: relative;left: 20px;">
                                        <option value="everyDay">每日</option>
                                        <option value="everyWeek">每周</option>
                                        <option value="everyMonth">每月</option>
                                    </select>
                                </div>
                                <input ng-model="setCost" type="text" inputnum placeholder="请输入扣除费用" style="padding: 5px 10px;height: 28px;width: 150px;margin-left: 20px">
                                <div style="margin-left: 55px;margin-top: 5px;color: rgb(153,153,153);">
                                    <span class="fa fa-info-circle">超过全额退款天数的扣费</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="button" style="padding: 5px 40px" class="btn btn-sm btn-success" ng-click="setQuitCabinetHttp()">完成</button>
                        </div>
                    </div>
                    <!--                    修改柜子-->
                    <div role="tabpanel" class="tab-pane" id="profilew2">
                        <div class="modal-content clearfix">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel" >修改普通衣柜</h4>
                            </div>
                            <div class="modal-body row mB60">
                                <div class="col-sm-12 pd0">
                                    <form class="form-inline">
                                        <div class="formBox row pLR20" style="padding: 0px 120px; height: 200px;" >
                                            <p class="addTitle">1.基本属性</p>
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
                                                <label for="exampleInput1"><span class="red">*</span>柜子类别</label>
                                                <select ng-model="modifyCabinetType" class="cp">
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
                                            <div class="col-sm-4 pd0 formSmbox" style="position: absolute; left: 105px; top: 135px;">
                                                <label for="exampleInput1"><span class="red">*</span>柜子数量</label>
                                                <input tyle="number" ng-disabled="true" class="form-control w200" ng-model="modifyCabinetNum" placeholder="请输入数量"/>
                                            </div>
                                        </div>
                                        <!--选择正式柜子触发显示的模块-->
                                        <div class="formBox row pLR120" ng-show="modifyCabinetType == 2">
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
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button ng-click="typeModifyComplete($id, modifyCabinetNum)" ladda="CabinetDetailFlag" type="button" class="btn btn-success w100" >完成</button>
                            </div>
                        </div>

                    </div>
                    <!--                    添加柜子-->
                    <div role="tabpanel" class="tab-pane" id="profilew3">
                        <div class="modal-content clearfix">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel" >修改普通衣柜</h4>
                            </div>
                            <div class="modal-body row mB60">
                                <div class="col-sm-12 pd0">
                                    <form class="form-inline">
                                        <div class="formBox row pLR20" style="padding: 0px 120px; height: 200px;" >
                                            <p class="addTitle">1.基本属性</p>
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
                                                <label for="exampleInput1"><span class="red">*</span>柜子类别</label>
                                                <select ng-model="modifyCabinetType" class="cp">
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
                                            <div class="col-sm-4 pd0 formSmbox" style="position: absolute; left: 105px; top: 135px;">
                                                <label for="exampleInput1"><span class="red">*</span>柜子数量</label>
                                                <input tyle="number" ng-disabled="true" class="form-control w200" ng-model="modifyCabinetNum" placeholder="请输入数量"/>
                                            </div>
                                        </div>
                                        <!--选择正式柜子触发显示的模块-->
                                        <div class="formBox row pLR120" ng-show="modifyCabinetType == 2">
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
                                            <!--填充begin-->
                                            <!--                            <div class="col-sm-4 pd0 form-group formSmbox mB40" style="visibility: hidden;">-->
                                            <!--                                <input type="text" class="form-control" />-->
                                            <!--                            </div>-->
                                            <!--填充end-->
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
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button ng-click="typeModifyComplete($id, modifyCabinetNum)" ladda="CabinetDetailFlag" type="button" class="btn btn-success w100" >完成</button>
                            </div>
                        </div>

                    </div>
                    <!--                    详情 会员信息 消费行为-->
                    <div role="tabpanel" class="tab-pane" id="profilew4">
                        <div class="modal-content clearfix">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title col-sm-6 showBoxTitle" ng-class="{false:'activeBox',true:''}[isShowBox]" ng-click="showBoxClick(2)" id="myModalLabel" style="display: inline-block;float: unset;cursor:pointer;">消费记录</h4>
                                <h4 class="modal-title col-sm-5 showBoxTitle" ng-class="{true:'activeBox',false:''}[isShowBox]" ng-click="showBoxClick(1)" id="myModalLabel2" style="display: inline-block;float: left;cursor:pointer;">基本信息</h4>
                            </div>
                            <div ng-show="showBox == 1">
                                <div class="modal-body row" >
                                    <div class="col-sm-12 pd0">
                                        <div class="col-sm-5 iconBox">
                                            <img class="imgHeaderW100" ng-src="{{cabinetDetail.pic}}" ng-if="cabinetDetail.pic != null">
                                            <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" ng-if="cabinetDetail.pic == null">
                                            <p class="iconName col-sm-12"><span class="col-sm-7" style="text-align: right">姓名:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.name}}</span></p>
                                            <p class="mobile  col-sm-12"><span class="col-sm-7" style="text-align: right">手机号:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.mobile}}</span></p>
                                            <p class="userId col-sm-12"><span class="col-sm-7" style="text-align: right">会员编号:</span><span class="col-sm-5" style="text-align: left;margin-left: -22px">{{cabinetDetail.member_id}}</span></p>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="col-sm-9 col-sm-offset-2 infoBox pT40 f14" >
                                                <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                                    <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                                    <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                                    <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                                </p>
                                                <p>总共金额:<span>{{cabinetDetail.price |number:2}}</span>元</p>
                                                <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                                <p>剩余天数:<span>{{cabinetDetail.surplusDay | noData:''}}</span>天</p>
                                                <p>有效期至:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                                <p>备注信息:<span>{{cabinetDetail.remark | noData:''}}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'UPDATE')) { ?>
                                        <button type="button" class="btn btn-info w100" ng-click="editUnBinding(cabinetDetailOne.cabinet_id,'isBind')" data-toggle="modal" data-target="#revise">修改</button>
                                    <?php } ?>
                                    <button type="button" ng-if="cabinetDetailOne.status==2 && cabinetDetailOne.end_rent > cabinetCurrentTime/1000" class="btn btn-success w100"  ng-click="switchCabinet(cabinetDetailOne)">调柜</button>
                                    <button type="button" class="btn btn-warning w100"  ng-click="renewCabinet(cabinetDetailOne)" data-toggle="modal" data-target="#renewCabinet">续柜</button>
                                    <button type="button" class="btn btn-white w100"  ng-click="quitCabinet(cabinetDetailOne.cabinet_id,cabinetDetailOne.memberCabinetId, cabinetDetailOne)" data-toggle="modal" data-target="#backCabinet">退柜</button>
                                    <!--                                            冻结的触发按钮-->
                                    <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==2"   ng-click="freezeCabinet(cabinetDetailOne.cabinet_id)">冻结</button>
                                    <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==4" ng-click="cancelFreezeCabinet(cabinetDetailOne.cabinet_id)" >取消冻结</button>
                                    <button type="button" style="color: #fff;" class="btn w100" data-toggle="modal" data-target="#boundCabinet">关闭</button>
                                </div>
                            </div>
                            <div ng-show="showBox == 2">
                                <div class="ibox-content">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper form-inline a26" role="grid">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                            id="DataTables_Table_0"
                                            aria-describedby="DataTables_Table_0_info"
                                            style="position: relative;">
                                            <thead>
                                            <tr role="row">
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">消费行为
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">消费金额
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">租用日期
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">消费日期
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">赠送时间
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                                </th>
                                                <th class="a28" tabindex="0"
                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="w in memberConsumListData">
                                                <td>{{w.rent_type}}</td>
                                                <td>{{w.price}}</td>
                                                <td>{{w.start_rent *1000 | noData:''| date:'yyyy/MM/dd'}} - {{w.end_rent *1000 | noData:''| date:'yyyy/MM/dd'}}</td>
                                                <td ng-if="w.rent_type == '退租金'">{{w.back_rent *1000 | noData:''|
                                                    date:'yyyy/MM/dd'}}</td>
                                                <td ng-if="w.rent_type != '退租金'">{{w.create_at *1000 | noData:''|
                                                    date:'yyyy/MM/dd'}}
                                                </td>
                                                <td ng-if="w.give_month != null && w.give_month != 0 && w.give_month != ''">{{w.give_month}}
                                        <span ng-if="w.give_type != null">
                                            <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 1">天</span>
                                            <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 2">月</span>
                                        </span><span ng-if="w.give_type == null">月</span></td>
                                                <td ng-if="w.give_month == null || w.give_month == 0 || w.give_month == ''">0</td>
                                                <!--                                    <td>-->
                                                <!--                                        {{w.name | noData}}-->
                                                <!--                                    </td>-->
                                                <td ng-if="w.name != null && w.name != undefined && w.name != ''">{{w.name}}</td>
                                                <td ng-if="w.name == null || w.name == undefined || w.name == ''">暂无数据</td>
                                                <td ng-if="w.remark != null && w.remark != undefined && w.remark != ''">{{w.remark }}</td>
                                                <td ng-if="w.remark == null || w.remark == undefined || w.remark == ''">暂无数据</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/pagination.php',['page'=>'recordPages']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>