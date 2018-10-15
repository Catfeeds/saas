<?php
use backend\assets\CabinetDataAsset;
CabinetDataAsset::register($this);
$this->title = '更柜管理';
?>
<div ng-controller="CabinetDataCtrl" class="group" ng-cloak>
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
            <div class="panel-body detialS" style="min-height: 600px;">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div ng-show="!isAdd && !isThrow && !isRenew && !isBindUser" class="row vv" style="overflow-y: auto;">
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
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" ng-click="" rowspan="1" colspan="1" style="width: 70px;">序号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetNum',sort)" style="width: 260px;">柜号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetModel',sort)" style="width: 110px;">型号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetType',sort)" style="width: 110px;">类别</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">绑定用户</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">会员卡号</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">剩余天数</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">状态</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 255px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="oneCabinet in allCabinetLists">
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >{{8*(nowPages-1)+ $index +1}}</td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >
                                            <div style="padding-right: 0;" ><span>{{oneCabinet.cabinet_number}}</span></div>
                                        </td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >
                                            <span ng-if="oneCabinet.cabinetModel == 1">大柜</span>
                                            <span ng-if="oneCabinet.cabinetModel == 2">中柜</span>
                                            <span ng-if="oneCabinet.cabinetModel == 3">小柜</span>
                                        </td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >{{oneCabinet.cabinetType == 1 ?"临时":"正式"}}</td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >{{oneCabinet.consumerName | noData:'' }}</td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >{{oneCabinet.memCabinet.memberCard['0'].card_number | noData:'' }}</td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >
                                            <span ng-if="oneCabinet.surplusDay !== false">{{oneCabinet.surplusDay+"天"}}</span>
                                            <span ng-if="oneCabinet.surplusDay === false">暂无数据</span>
                                        </td>
                                        <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >
                                            <small class="label label-primary" ng-if="oneCabinet.status==2 && oneCabinet.end_rent > cabinetCurrentTime/1000" >已租用</small>
                                            <small class="label label-warning" ng-if="oneCabinet.status==1" >未租用</small>
                                            <small class="label label-danger"  ng-if="oneCabinet.status==3">维修中</small>
                                            <small class="label label-danger"  ng-if="oneCabinet.status==4">已冻结</small>
                                            <small class="label label-danger"  ng-if="oneCabinet.end_rent != null && oneCabinet.end_rent !='' && oneCabinet.end_rent*1 <= cabinetCurrentTime/1000">已过期</small>
                                        </td>
                                        <td class="bind">
                                            <!--                                            退柜的触发按钮-->
                                            <span ng-if="oneCabinet.status == 2" style="color: #00b0e8" ng-click="quitCabinet(oneCabinet.id,oneCabinet.memberCabinetId,oneCabinet)">退柜</span>
                                            <!--                                            续柜的触发按钮-->
                                            <span ng-if="oneCabinet.status == 2" style="color: #00b0e8">|</span>
                                            <span ng-if="oneCabinet.status == 2" style="color: #00b0e8" ng-click="renewCabinet(oneCabinet)">续柜</span>
                                            <span ng-if="oneCabinet.status == 2 && oneCabinet.end_rent > cabinetCurrentTime/1000" style="color: #00b0e8">|</span>
                                            <!--                                            冻结的触发按钮-->
                                            <span ng-if="oneCabinet.status == 2 && oneCabinet.end_rent > cabinetCurrentTime/1000" style="color: #00b0e8" ng-click="freezeCabinet(oneCabinet.id)">冻结</span>
                                            <span ng-if="oneCabinet.status != 1 && oneCabinet.status == 4" style="color: #00b0e8" ng-click="cancelFreezeCabinet(oneCabinet.id)">取消冻结</span>
                                            <!--                                            绑定用户的触发按钮-->
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETBINDUSER')) { ?>
                                                <span ng-if="oneCabinet.status == 1" ng-disabled="oneCabinet.cabinetType == 1" style="color: #00b0e8" ng-click="bindingMember(oneCabinet, oneCabinet.id)">绑定用户</span>
                                            <?php } ?>
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'DELETECABINET')) { ?>
                                                <span ng-if="oneCabinet.status == 1" style="color: #00b0e8">|</span>
                                                <span ng-if="oneCabinet.status == 1"  style="color: #00b0e8" ng-click="CabinetDelete(oneCabinet.id)">删除</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php');?>
                                <?=$this->render('@app/views/common/pagination.php');?>
                            </div>
                        </div>
<!--                        添加更衣柜-->
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
                                    <button ng-click="cancel()" ladda="CabinetDetailFlag" type="button" class="btn btn-sm btn-default">取消</button>
                                </div>
                            </form>
                        </div>
<!--                        退柜-->
                        <div ng-show="isThrow" class="row">
                            <div class="col-sm-12" style="border-bottom: 1px solid #ddd;">
                                <div style="padding: 0 0 10px 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}} < 退柜</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 infoBox f14" >
                                    <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                        <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                        <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                        <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                    </p>
                                    <p>总共金额:<span>{{cabinetDetail.price | number:2 }}</span>元</p>
                                    <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                    <p>剩余天数:<span>{{cabinetDetail.surplusDay > 0 ? cabinetDetail.surplusDay+ '天':'已到期'}}</span></p>
                                    <p>到期时间:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                </div>
                                <div class="col-sm-12" style="border-top: 1px solid #eee;padding: 15px;">
                                    <span class="mR20 f14" >退还押金：<span class="moneyCss">{{depositRefund | number:2}}<small class="f14">元</small></span></span>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" style="padding: 5px 50px" ladda="quitCabinetCompleteFlag" class="btn btn-sm btn-success" ng-click="quitCabinetComplete(cabinetDetail.end_rent*1000)">完成</button>
                                    <button type="button" class="btn btn-sm btn-default" ng-click="cancel()">取消</button>
                                </div>
                            </div>
                        </div>
<!--                        续柜-->
                        <div ng-show="isRenew" class="row">
                            <div class="col-sm-12" style="border-bottom: 1px solid #ddd;">
                                <div style="padding: 0 0 10px 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}} < 续柜</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 infoBox f14" >
                                    <div class="col-sm-12 infoBox f14" >
                                        <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                            <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                        </p>
                                        <p>总共金额:<span>{{cabinetDetail.price | number:2 }}</span>元</p>
                                        <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                        <p>剩余天数:<span>{{cabinetDetail.surplusDay > 0 ? cabinetDetail.surplusDay+ '天':'已到期'}}</span></p>
                                        <p>到期时间:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14"  style="border-top: 1px solid #eee;padding: 15px;">
                                        <label for="inputdate" style="display: inline-block" class="textLeft pd0 control-label fontNormal pR20"><span class="red">*</span>续柜月数:</label>
                                        <div style="display: inline-block">
                                            <input type="number" class="form-control" style="width: 200px" ng-model="reletMonth" inputnum ng-change="reletMonthChange(reletMonth)" placeholder="请输入月数如:12">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" ng-if="giveReletMonthNum != null && giveReletMonthNum != undefined && giveReletMonthNum != ''">
                                        <label class="col-sm-2 textLeft control-label fontNormal pR20">
                                            <span class="red" style="opacity: 0;">*</span>赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数:
                                        </label>
                                        <div class="col-sm-4 mL20 mlF20" style="margin-bottom: 10px;">
                                            <input type="number" checknum class="form-control giveReletMonthNum11" ng-model="giveReletMonthNum" ng-change="giveTimenNumChange(giveReletMonthNum)">
                                        </div>
                                        <span class="glyphicon glyphicon-info-sign" style="margin-top: 5px;margin-left: 6px;display: inline-block;color: #999;">赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数不得大于{{giveReletMonthNum1}}<span>{{giveTimeType == 'd' ? '天' : '月'}}</span></span>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" >
                                        <p>到期日期:<span >{{cabinetreletEndDate | noData:''}}</span>元</p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" ng-if="redisplay == 1">
                                        <label for="inputdate" class="col-sm-4 textLeft pd0 control-label fontNormal pR20"><span>&nbsp; </span>折&emsp;&emsp;扣:</label>
                                        <div class="col-sm-8 mlF20" >
                                            <select class="form-control" ng-model="reDis" ng-change="getReDis(reDis)" style="font-size: 13px;">
                                                <option value="1" selected="selected">请选择折扣</option>
                                                <option value="{{d}}" ng-repeat="d in redises">{{ d }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 infoBox f14">
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-bottom: 20px">
                                                <span class="mR20 f14" >应收金额：<span class="moneyCss">{{reletPrice| number:2}}<small class="f14">元</small></span></span>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" style="padding: 5px 50px" ladda="renewCabinetCompleteFlag" ng-click="renewCabinetComplete()" class="btn btn-sm btn-success" >完成</button>
                                                <button type="button" class="btn btn-sm btn-default" ng-click="cancel()">取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        绑定用户-->
                        <div ng-show="isBindUser" class="row">
                            <div class="col-sm-8 col-xs-8" style="margin-bottom: 20px">
                                <div class="input-group" style="width: 400px">
                                    <input type="text" class="form-control" ng-keyup="enterSearch($event)" ng-model="keywords" placeholder="请输入卡号,手机号,身份证号..." style="height: 30px;line-height: 7px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-success" ng-click="searchMember()">搜索</button>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-12 nn" style="border-bottom: 1px solid #ddd;">
                                <div class="row">
                                    <div class="col-sm-3" style="padding-top: 10px">
                                        <div class="input-file ladda-button btn uploader pd0"
                                             id="imgFlagClass"
                                             ngf-drop="uploadCover($file,'update')"
                                             ladda="uploading"
                                             ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                             ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                             ngf-select="uploadCover($file,'update')"
                                             style="padding: 0;width: 100%;">
                                            <img ng-src="{{memberDetail.pic}}" style="width: 100%;height: 100%" ng-if="memberDetail.pic">
                                            <img ng-src="/plugins/user/images/noPic.png" ng-if="!memberDetail.pic" style="float: left;margin:0;width: 100%;">
                                        </div>
                                        <div class="form-group size20" style="margin-top: 30px;">姓名:{{memberDetail.name | noData:''}}</div>
                                        <div class="form-group size13" ng-if="memberDetail.sex == 1">会员性别:男</div>
                                        <div class="form-group size13" ng-if="memberDetail.sex == 2">会员性别:女</div>
                                        <div class="form-group size13" ng-if='memberDetail.mobile !=0'>手机号码:{{memberDetail.mobile|noData:''}}</div>
                                        <div class="form-group size13">会员类型:{{memberDetail.member_type=='1' ? '正式会员': memberDetail.member_type=='2'?'潜在会员' : '失效会员'|noData:''}}</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="col-sm-8 infoBox bindingCabinetModelContent" style="padding-top: 0">
                                            <form class="form-horizontal">
                                                <div class="from-group mT10 pRelative">
                                                    <p class="col-sm-12 cabinetName">
                                                        <span style="margin-left: -30px;">{{containerNumber}}</span>
                                                        <span ng-if="cabinetIsType == 1">大柜</span>
                                                        <span ng-if="cabinetIsType == 2">中柜</span>
                                                        <span ng-if="cabinetIsType == 3">小柜</span>
                                                    </p>
                                                </div>
                                                <div class="form-group mT10 pRelative" >
                                                    <label class="pd0 control-label pr20 fontNormal"><span class="red">*</span>租柜日期</label>
                                                    <div style="display: inline-block;">
                                                        <div class="input-append date" id="dataCabinet"  data-date-format="yyyy-mm-dd">
                                                            <input class="cabientSpan form-control h30"  type="text"  ng-change="rentCabinet(startRentCabinet)" placeholder="请选择购买日期" ng-model="startRentCabinet"  />
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mT10 pRelative" >
                                                    <label for="inputdate" class="pd0 control-label pr20 fontNormal" ><span class="red">*</span>租柜月数</label>
                                                    <div style="display: inline-block;">
                                                        <input type="number" id="inputdate" ng-model="cabinetDays" inputnum ng-change="rentCabinetDays(cabinetDays)" class="form-control" placeholder="请输入月数如:12">
                                                    </div>
                                                </div>
                                                <div class="form-group mT10 pRelative" ng-if="giveMonthBingCabinet != null && giveMonthBingCabinet != undefined && giveMonthBingCabinet != ''">
                                                    <label class="pd0 control-label textLeft  fontNormal"><span>&emsp;</span>赠送<span>{{buyTimeType == 'd' ? '天' : '月'}}</span>数</label>
                                                    <div style="display: inline-block;">
                                                        <input type="number" name="" id="" class="form-control giveMonthBingCabinet11" placeholder="请输入赠送数" ng-model="giveMonthBingCabinet" ng-change="giveDayNumChange(giveMonthBingCabinet)">
                                                    </div>
                                                    <span class="glyphicon glyphicon-question-sign" style="padding-left: 15px;display: inline-block;margin-top: 15px;">赠送<span>{{buyTimeType == 'd' ? '天' : '月'}}</span>数不能大于{{giveMonthBingCabinet1}}<span>{{buyTimeType == 'd' ? '天' : '月'}}</span></span>
                                                </div>
                                                <div class="form-group mT10 pRelative" ng-if="display == 1">
                                                    <label class="pd0 control-label pr20 fontNormal"><span>&nbsp;&nbsp;</span>折&emsp;&emsp;扣</label>
                                                    <div style="display: inline-block">
                                                        <div class="input-append date">
                                                            <select class="cabientSpan form-control h30" ng-model="selectedDis" ng-change="getCurrentRootMoney(selectedDis)" style="font-size: 13px;">
                                                                <option value="1" selected="selected">请选择折扣</option>
                                                                <option value="{{x}}" ng-repeat="x in dises">{{x}}</option>
                                                            </select>
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label style="vertical-align: top;" class="pd0 control-label pr20 fontNormal"><span style="opacity: 0">*</span>备&emsp;&emsp;注</label>
                                                    <div style="display: inline-block">
                                                        <textarea rows="5" ng-model="bindCabinetNote" style="resize: none;width: 183px;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group mT10 pRelative">
                                                    <label class="pd0 control-label textLeft pr20 fontNormal"><span style="opacity: 0">*</span>到期日期</label>
                                                    <div style="display: inline-block;">
                                                        <span>{{ cabinetEnd }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-4 pd0 control-label fontNormal" style="text-align: center">
                                                        <span class="moneyCss" style="padding-left: 20px">{{theAmountPayable ? theAmountPayable : 0 | number:2}}元</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-8 pd0 control-label textLeft fontNormal">
                                                        <button type="button" ladda="bindingCabinetCompleteFlag" ng-click="bindingCabinetComplete(containerId)" class="btn btn-success w100">完成</button>
                                                        <button type="button" class="btn btn-default" ng-click="cancel()">取消</button>
                                                    </div>
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
        </div>
    </div>
</div>