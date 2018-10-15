<?php
use backend\assets\WcheckCardAsset;
WcheckCardAsset::register($this);
$this->title = '验卡系统';
?>
<div ng-controller="CheckCardCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li class="orderMenu">进馆验卡</li>-->
<!--                    <li><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li ><a href="/foreign-field-management/index">场地管理</a></li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <?php if(\backend\rbac\Config::isShow('weiluyou/yankaxiangqing')): ?>
                        <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">进馆验卡</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/huiyuanxiangqing')): ?>
                        <li role="presentation"><a>会员详情</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/huiyuanka')): ?>
                        <li role="presentation"><a>会员卡</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/sijiao')): ?>
                        <li role="presentation"><a>私教</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/tuanjiao')): ?>
                        <li role="presentation"><a>团教</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/changdi')): ?>
                        <li role="presentation"><a>场地</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/gengyigui')): ?>
                        <li role="presentation"><a>更衣柜</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/xinxijilu')): ?>
                        <li role="presentation"><a>信息记录</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/qingjia')): ?>
                        <li role="presentation"><a>请假</a></li>
                    <?php endif; ?>
                    <?php if(\backend\rbac\Config::isShow('weiluyou/xiaofei')): ?>
                        <li role="presentation"><a>消费</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0">
            <div class="panel-body detialS">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div style="padding: 6px;float: left;"><span>进馆验卡:</span></div>
                                <div class="input-group" style="width: 500px">
                                    <input type="text" class="form-control" ng-keyup="enterSearch($event)" ng-model="cardNumber1" placeholder="请刷卡或输入卡号、手机号、身份证号..." style="height: 30px;line-height: 7px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-success" ng-click="checkCardNumberMember('search')">搜索</button>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--选择会员card模态框-->
    <div class="modal fade" id="selectCardModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">选择会员卡</h4>
                </div>
                <div class="modal-body">
                    <section class="row" style="display: flex;justify-content: center;margin-top: 20px;margin-bottom: 20px;">
                        <div class="col-sm-6">
                            <select class="form-control" style="padding: 4px 12px;" ng-change="selectedMemberCard()"ng-model="selectCardId" >
                                <option value="">请选择会员卡</option>
                                <option value="{{card.id}}" ng-repeat="card in allMemberCard">{{card.card_name}}</option>
                            </select>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success" ng-click="dd(selectCardId)">验卡</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>