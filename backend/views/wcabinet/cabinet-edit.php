<?php
use backend\assets\CabinetEditAsset;
CabinetEditAsset::register($this);
$this->title = '修改';
?>
<div ng-controller="CabinetEditCtrl" class="group" ng-cloak>
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
                        <div class="row">
                            <!--柜子详情列表-->
                            <div class="col-sm-12" style="margin-bottom: 20px;">
                                <div class="row">
                                    <div style="padding: 5px 0 0 10px;color: #676a6cd6">< 更衣柜管理 < 男更衣柜 < 会员详情 < 修改</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <form class="form-horizontal pd0 pR40">
                                    <div class="form-group">
                                        <div class="selectBox mT20 col-sm-6">
                                            <label for="inputEmail1" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子型号</label>
                                            <div class="col-sm-8">
                                                <select class="form-control pT4 colorGrey" ng-model="editCabinetSize" id="inputEmail1" ng-disabled="isCabinetBindMember">
                                                    <option value="">请选择柜子尺寸</option>
                                                    <option value="1">大柜</option>
                                                    <option value="2">中柜</option>
                                                    <option value="3">小柜</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="selectBox mT20 col-sm-6">
                                            <label for="inputEmail2" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子类别</label>
                                            <div class="col-sm-8">
                                                <select class="form-control colorGrey" style="padding: 4px 12px;" id="inputEmail2" ng-model="editCabinetType" ng-disabled="isCabinetBindMember">
                                                    <option value="">请选择类别</option>
                                                    <option value="1">临时</option>
                                                    <option value="2">正式</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="selectBox mT20 col-sm-6" ng-show="editCabinetType == '2'">
                                            <label for="editCabinetDeposit555" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子押金</label>
                                            <div class="col-sm-8">
                                                <input type="number" checknum ng-model="editCabinetDeposit" id="editCabinetDeposit555" class="form-control"  placeholder="请输入柜子押金"/>
                                            </div>
                                        </div>
                                        <div class="selectBox mT20 col-sm-6">
                                            <label for="inputEmail4" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>单月金额</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" checknum ng-model="editOneMonthPrice" id="inputEmail4" type="text" placeholder="请输入价格：如10000"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!--多月设置修改-->
                                    <div class="form-group">
                                        <div id="modify" class="modify" style="margin-top: 20px;" ng-show="editCabinetType == '2'"></div>
                                        <div class="selectBox huiLeiAdd pull-right" >
                                            <label for="inputEmail4" class="control-label">
                                                <button id="modifyPlugins" ng-show="editCabinetType == '2'" class="btn btn-default" venuehtml ng-click="addPlugins()" style="margin-right: 55px;">新增多月设置</button>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" ladda="editCompleteFlag" ng-disabled="!isClick"  ng-click="editComplete()" class="btn btn-success center-block w100" >完成</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>