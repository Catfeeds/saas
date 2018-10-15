<?php
use backend\assets\AddAreaAsset;
AddAreaAsset::register($this);
$this->title = '更柜管理';
?>
<div ng-controller="addAreaCtrl" class="group" ng-cloak>
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
        <div class="col-sm-12 content-center panel panel-default" style="height: 100%;">
            <div class="panel-body detialS" style="min-height: 600px;">
                <div class="row vv" style="overflow-y: auto;">
                    <div class="col-sm-12" style="padding: 15px;color: #676a6cd6;">
                        <span>< 更衣柜管理 < 添加区域</span>
                    </div>
                    <div class="col-sm-12" style="padding: 15px;border-top: 1px solid #eee">
                        <span style="display: inline-block" class="red">*</span>区域名称
                        <input type="text" style="width: 200px;display: inline-block" ng-model="areaName"  class="form-control" id="inputText" placeholder="请输入区域名称">
                    </div>
                    <div class="col-sm-12" style="padding: 15px;">
                        <button class="btn btn-sm btn-success" ng-click="addNewArea()" style="padding: 5px 35px">确定</button>
                        <button class="btn btn-sm btn-default" ng-click="cancel()">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>