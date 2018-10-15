<?php
use backend\assets\CabinetDatalAsset;
CabinetDatalAsset::register($this);
$this->title = '更柜管理';
?>
<div ng-controller="CabinetData2Ctrl" class="group" ng-cloak>
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
                        <div ng-show="!isAdd" class="row">
                            <!--柜子详情列表-->
                            <div class="col-sm-12" style="margin-bottom: 20px;">
                                <div class="row">
                                    <div class="col-sm-2" style="padding: 5px 0 0 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}}</div>
                                    <div class="col-sm-6 text-center">
                                        <div class="input-group" style="width: 400px;margin: 0 auto">
                                            <input type="text" class="form-control" ng-model="keyword" ng-keyup="enterSearchs($event)" placeholder="请输入柜号、用户名、手机号进行搜索..." style="height: 30px;line-height: 7px;">
                                        <span class="input-group-btn">
                                           <button type="button" class="btn btn-sm btn-primary" ng-click="searchCabinet()">搜索</button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button type="button" class="btn btn-sm btn-default" id="show-list-id" ng-click ="searchClass()" >列表</button>
                                        <button type="button" class="btn btn-sm btn-default" id="show-matrix-id" ng-click="searchClass(60)">矩阵</button>
                                        <button type="button" ng-click="getCabinetTypeLister()" class="btn btn-sm btn-default type-management">类型管理</button>
                                        <button class="btn btn-sm btn-success"  data-toggle="modal" ng-click="addCabinetModal()" data-target="#addCabinet">添加更衣柜</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 vv">
                                <div class="ibox float-e-margins borderNone" >
                                    <div class="ibox-content pd0" >
                                        <div class="show-matrix row">
                                            <div class="matrix-block col-md-1" ng-repeat="oneCabinet in allCabinetLists" ng-click="tdClick(oneCabinet.status,oneCabinet.id,'matrix', oneCabinet.cabinetType)">
                                                <h2 class="matrix-p-h" style="padding: 0;">
                                                    {{oneCabinet.cabinet_number}}
                                                </h2>
                                                <div>
                                                    <small class="label label-primary" ng-if="oneCabinet.status==2 && oneCabinet.end_rent > cabinetCurrentTime/1000" >已租用</small>
                                                    <small class="label label-warning" ng-if="oneCabinet.status==1" >未租用</small>
                                                    <small class="label label-danger"  ng-if="oneCabinet.status==3">维修中</small>
                                                    <small class="label label-danger"  ng-if="oneCabinet.status==4">已冻结</small>
                                                    <small class="label label-danger"  ng-if="oneCabinet.end_rent != null && oneCabinet.end_rent !='' && oneCabinet.end_rent*1 <= cabinetCurrentTime/1000">已过期</small>
                                                    <!--<small class="label label-danger"  ng-if="oneCabinet.end_rent != null && oneCabinet.end_rent !='' && oneCabinet.end_rent*1 <= cabinetCurrentTime/1000 &&  cabinetCurrentTime/1000 <= (oneCabinet.end_rent*1 + 7*24*60*60*1)  ">已过期</small>-->
                                                </div>
                                                <div>
                                                    <p class="matrix-p-con" style="font-size: 12px">
                                                        <span ng-if="oneCabinet.cabinetModel == 1">大柜</span>
                                                        <span ng-if="oneCabinet.cabinetModel == 2">中柜</span>
                                                        <span ng-if="oneCabinet.cabinetModel == 3">小柜</span>
                                                        <span>/{{oneCabinet.cabinetType == 1 ?"临时":"正式"}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <!--                                        <div class="col-md-2"></div>-->

                                        </div>
                                        <?=$this->render('@app/views/common/nodata.php');?>
                                        <?=$this->render('@app/views/common/pagination.php');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div ng-show="isAdd" class="row">
                            <form class="form form-inline">
                                <div class="formBox row pLR120" style="height: 200px;">
                                    <p class="addTitle">
                                        1.基本属性
                                    </p>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                        <label><span class="red">*</span>柜子型号</label>
                                        <select ng-model="cabinetSize" class="cp">
                                            <option value="">请选择柜子尺寸</option>
                                            <option value="1">大柜</option>
                                            <option value="2">中柜</option>
                                            <option value="3">小柜</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                        <label><span class="red">*</span>柜子类别</label>
                                        <select ng-model="cabinetType" class="cp">
                                            <option value="">请选择类别</option>
                                            <option value="1">临时</option>
                                            <option value="2">正式</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput2"><span class="red">*</span>柜号&emsp; &emsp;</label>
                                        <div class="input-group">
                                            <input type="text" ng-model="cabinetPrefix" onkeyup="this.value = this.value.replace(/\d/,'')" id="exampleInput2" class="form-control cp" style="width: 100px;" placeholder="编号" autocomplete="off">
                                            <input type="text" ng-model="cabinetNumStart" checknum class="form-control cp" style="width: 100px;" placeholder="柜号" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40" style="position: absolute; left: 105px; top: 135px;">
                                        <label for="exampleInput1"><span class="red">*</span>柜子数量</label>
                                        <input id="exampleInput1" class="form-control cp w200" checknum ng-model="addCabinetNum" placeholder="请输入数量" autocomplete="off"/>
                                    </div>
                                </div>
                                <!--选择正式柜子触发显示的模块-->
                                <div class="formBox row pLR120 " ng-if="cabinetType == 2">
                                    <p class="addTitle">
                                        2.价格设置
                                    </p>
                                    <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput3"><span class="red">*</span>单月金额</label>
                                        <input type="number" checknum ng-model = "halfMonthMoney" placeholder="请输入单月金额" class="form-control moneyInput cp halfMonthMoney" id="exampleInput3" autocomplete="off"/>
                                        <span class="label label-info" ng-bind = "halfMonthMoney|currency:'￥':2"></span>
                                    </div>
                                    <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput111"><span class="red">*</span>柜子押金</label>
                                        <input  type="text" checknum class="form-control cp w200 moneyInput cabinetDeposit" id="exampleInput111" ng-model="cabinetDeposit" placeholder="0元" autocomplete="off"/>
                                        <span class="label label-info" ng-bind = "cabinetDeposit | currency:'￥':2"></span>
                                    </div>
                                    <hr style="background: #eee;margin-top: 80px;">
                                    <!--新增多月设置容器--start-->
                                    <div id="addMuchPlugins" class="addCabinetMonth">
                                        <div class="clearfix">
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                                <label for="exampleInput112">多月设置</label>
                                                <div class="input-group">
                                                    <input type="text" name="cabinet_month"  id="exampleInput112" ng-model="muchMonth" class="form-control cp" checknum style="width: 100px;" placeholder="月数" autocomplete="off"/>
                                                    <input type="number" name="cabinet_money" ng-model="cabinetMoney" class="form-control cp moneyInput" style="width: 100px;" placeholder="金额" autocomplete="off"/>
                                                </div>
                                                <span class="label label-info" ng-bind = "cabinetMoney|currency:'￥':0"></span>
                                            </div>
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40" >
                                                <label for="exampleInput113"><span style="visibility: hidden">*</span>&emsp;&emsp;赠送</label>
                                                <select class="form-control" style="width: 25%;padding: 0 0 0 5px;">
                                                    <option value="d">天数</option>
                                                    <option value="m">月数</option>
                                                </select>
                                                <input type="text" name="give_month" id="exampleInput113" ng-model="giveMonth" class="form-control cp" checknum autocomplete="off" placeholder="请输入赠送数" style="width: 35%;"/>
                                            </div>
                                            <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                                <label for="exampleInput114"><span style="visibility: hidden">*</span>&emsp;&emsp;折扣</label>
                                                <input type="text" name="cabinet_dis" id="exampleInput114" ng-model="dis" class="form-control cp w200" placeholder="请输入折扣" autocomplete="off"/>
                                                <p class="help-block">
                                                    <i class="glyphicon glyphicon-info-sign"></i>多个折扣用<span class="text-info">"/"</span>分开,例如<span class="text-info"> (八折,七折,六折)</span>: <span class="text-success">0.8/0.7/0.6</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--新增多月设置容器 --end-->
                                    <span class="help-block">
                                        <button id="addCabinetMonth" class="btn btn-default btn-sm" venuehtml ng-click="btnAddMuchMonth()">
                                            <span class="glyphicon glyphicon-arrow-up"></span>
                                          新增多月设置
                                        </button>
                                    </span>
                                </div>
                                <div class="col-sm-12" style="padding: 10px 105px; height: 100px;" >
                                    <button ng-click="addComplete()" ladda="CabinetDetailFlag" style="padding: 5px 50px;" type="button" class="btn btn-sm btn-success">完成</button>
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