<?php
use backend\assets\NewCabinetAsset;
NewCabinetAsset::register($this);
$this->title = '更柜管理';
?>
<div class="container-fluid " ng-controller="newCabinetCtrl" ng-cloak id="isBind" style="background: #f5f7fa;">
<!--    <div class="wrapper wrapper-content animated fadeIn panelBgColor" >-->
        <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">

        <div class="row panel panel-default ">
            <div class="panel-heading contentBetween" >
                <span style="display: inline-block;line-height: 30px;"><b class="spanSmall">更柜管理</b></span>
                <select name="" id="" class="venueChoose" style="margin: 0 auto;min-width: 200px;" ng-model="venueChoose" ng-change="venueSelectChange(venueChoose)" ng-if="cabinetDetailOpen">
                    <option value="">请选择场馆</option>
                    <option ng-repeat="venues in venueLists" value="{{venues.id}}">{{venues.name}}</option>
                </select>
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETREMIND')) { ?>
                    <button class="btn btn-sm btn-default" ng-click="getMemberCabinetData()" style="position: absolute;right: 250px;">到期提醒</button>
                <?php }?>
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETSET')) { ?>
                <button class="btn btn-sm btn-default" ng-click="showQuitCabinetSetting(1)" style="position: absolute;right: 150px;">退柜设置</button>
                <?php }?>
            </div>
            <div class="panel-body">
                <!--        场馆柜子类型列表-->
                <div class="col-sm-12 contentBox pd0">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-3 box pd0 mT10 cp" ng-model="allCabinetData" ng-repeat="cabinet in  allCabinet" ng-click="cabinetBox(cabinet.id,cabinet.type_name)">
                            <div class="col-sm-12 cabinetBox ">
                                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETAREADEL')) { ?>
                                <button class="text-center pull-right" ng-click="deleteContentBoxButton(cabinet.id,cabinet.is_rent)">&times;</button>
                                <?php } ?>
                                <h3>{{cabinet.type_name}}</h3>
                                <p>总数量:{{cabinet.cabinetNum}}个</p>
                                <p>已租柜:{{cabinet.is_rent}}个</p>
                            </div>
                        </div>
                        <div class="col-sm-3 box cp">
                            <div class="col-sm-12 addBox pd0 mT10" ng-click="addArea()">
                                <img ng-src="/plugins/newCabinet/images/picadd.png">
                                <p>点击添加新的区域</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--        柜子详情列表-->
                <div class="col-sm-12 listBox pd0 disNone" >
                    <div class="col-sm-5 col-xs-10 header1 col-sm-offset-3 col-xs-offset-1">
                        <div class="input-group">
                            <input type="text" style="height: 34px;" class="form-control search" ng-model="keyword" ng-keyup="enterSearchs($event)" placeholder="  请输入柜号、用户名、手机号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" ng-click="searchCabinet()">搜索</button>
                                </span>
                        </div>
                    </div>
                   <div class="col-sm-12 heightCenter mT10" style="padding: 4px 0;border: solid 1px #F5f5f5;">
                            <div class="col-sm-4  text-left" >
                                <span ng-click="backPre()" class= "cp glyphicon glyphicon-chevron-left backHistory f20"></span>
                            </div>
                            <div class="col-sm-4  contentCenter text-center f16" style="font-weight: 600;">
                                {{cabinetTypeName}}
                            </div>
                            <div class="col-sm-4   text-right">
                                <button type="button" class="btn btn-default" id="show-list-id" ng-click ="searchClass()" >列表</button>
                                <button type="button" class="btn btn-default" id="show-matrix-id" ng-click="searchClass(60)">矩阵</button>
                                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETTYPEMANAGE')) { ?>
                                    <button type="button" ng-click="getCabinetTypeLister()" class="btn btn-default type-management">类型管理</button>
                                <?php } ?>
                                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'ADDGENERALCABINET')) { ?>
                                    <button class="btn btn-success"  data-toggle="modal" ng-click="addCabinetModal()" data-target="#addCabinet">新增普通衣柜</button>
                                <?php } ?>
                            </div>
                    </div>
                    <div class="col-sm-12 pd0">
                        <div class="ibox float-e-margins borderNone" >
                            <div class="ibox-content pd0" >
                                <div  id="DataTables_Table_0_wrapper" class="pB0 dataTables_wrapper form-inline" role="grid" style="position:relative;">
<!--                                    列表展示-->
                                    <div class="show-list" ng-show="isList">
                                         <div  id="DataTables_Table_0_wrapper" class="pB0 dataTables_wrapper form-inline" role="grid">
                                        <table class="table table-bordered table-hover dataTables-example dataTable">
                                        <thead>
                                        <tr role="row">
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" ng-click="" rowspan="1" colspan="1" style="width: 70px;background-color: #FFF;">序号</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetNum',sort)" rowspan="1" colspan="1" style="width: 260px;">柜号</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetModel',sort)" rowspan="1" colspan="1" style="width: 110px;">型号</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetType',sort)" rowspan="1" colspan="1" style="width: 110px;">类别</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1" style="width: 120px;">绑定用户</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1" style="width: 120px;">会员卡号</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetEndRent',sort)" rowspan="1" colspan="1" style="width: 120px;">剩余天数</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 255px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="oneCabinet in allCabinetLists">
                                                <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >{{8*(nowPages-1)+ $index +1}}</td>
                                                <td ng-click="tdClick(oneCabinet.status,oneCabinet.id,'list', oneCabinet.cabinetType)" >
                                                    <div  class="col-sm-row">
                                                        <div class="col-sm-6 text-left " style="padding-right: 0;" ><span>{{oneCabinet.cabinet_number}}</span></div>
                                                        <div class="col-sm-6 text-right" style="padding-left: 0;" >
                                                            <small class="label label-primary" ng-if="oneCabinet.status==2 && oneCabinet.end_rent > cabinetCurrentTime/1000" >已租用</small>
                                                            <small class="label label-warning" ng-if="oneCabinet.status==1" >未租用</small>
                                                            <small class="label label-danger"  ng-if="oneCabinet.status==3">维修中</small>
                                                            <small class="label label-danger"  ng-if="oneCabinet.status==4">已冻结</small>
                                                            <small class="label label-danger"  ng-if="oneCabinet.end_rent != null && oneCabinet.end_rent !='' && oneCabinet.end_rent*1 <= cabinetCurrentTime/1000">已过期</small>
                                                        </div>
                                                    </div>
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
                                                <td class="tdBtn">
                                                    <!--                                            退柜的触发按钮-->
                                                    <button ng-if="oneCabinet.status == 2" class="btn btn-sm btn-white" ng-click="quitCabinet(oneCabinet.id,oneCabinet.memberCabinetId,oneCabinet)" data-toggle="modal" data-target="#backCabinet">退柜</button>
                                                    <!--                                            续柜的触发按钮-->
                                                    <button ng-if="oneCabinet.status == 2" class="btn btn-sm btn-warning mL6" ng-click="renewCabinet(oneCabinet)" data-toggle="modal" data-target="#renewCabinet">续柜</button>
                                                    <!--                                            冻结的触发按钮-->
                                                    <button ng-if="oneCabinet.status == 2 && oneCabinet.end_rent > cabinetCurrentTime/1000 "  class="btn btn-sm btn-danger mL6" ng-click="freezeCabinet(oneCabinet.id)">冻结</button>
                                                    <button ng-if="oneCabinet.status != 1 && oneCabinet.status == 4" class="btn btn-sm btn-danger mL6" ng-click="cancelFreezeCabinet(oneCabinet.id)">取消冻结</button>
                                                    <!--                                            绑定用户的触发按钮-->
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETBINDUSER')) { ?>
                                                        <button ng-if="oneCabinet.status == 1" ng-disabled="oneCabinet.cabinetType == 1" class="btn btn-sm btn-success" ng-click="bindingMember(oneCabinet, oneCabinet.id)">绑定用户</button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'DELETECABINET')) { ?>
                                                        <button ng-if="oneCabinet.status == 1"  class="btn btn-sm btn-danger" ng-click="CabinetDelete(oneCabinet.id)">删除</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
<!--                                    矩阵展示-->
                                    <div class="show-matrix row" ng-show="isMatrix">
                                        <div class="matrix-block col-md-1" ng-repeat="oneCabinet in allCabinetLists" ng-click="tdClick(oneCabinet.status,oneCabinet.id,'matrix', oneCabinet.cabinetType)">
                                               <h2 class="matrix-p-h">
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
                                               <p class="matrix-p-con">
                                                   <span ng-if="oneCabinet.cabinetModel == 1">大柜</span>
                                                   <span ng-if="oneCabinet.cabinetModel == 2">中柜</span>
                                                   <span ng-if="oneCabinet.cabinetModel == 3">小柜</span>
                                                   <span>/{{oneCabinet.cabinetType == 1 ?"临时":"正式"}}</span>
                                               </p>
                                           </div>
                                       </div>
<!--                                        <div class="col-md-2"></div>-->
                                        
                                    </div>
<!--                                    <div class="page-jump" style="position: absolute;right: 180px;z-index:999999;">-->
<!--                                        第&nbsp;<input style="width: 50px;" id="judgePage"  type="number" placeholder="几"/>&nbsp;页-->
<!--                                        <button class="btn btn-sm btn-white" ng-click="judgePage()">跳转</button>-->
<!--                                    </div>-->
                                    <?=$this->render('@app/views/common/nodata.php');?>
                                    <?=$this->render('@app/views/common/pagination.php');?>
                                </div>
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
<!--    </div>-->
    <!-- 柜子修改模态框-->
    <?= $this->render('@app/views/new-cabinet/typeClass.php'); ?>
        <!-- 柜子到期短信提醒模态框-->
        <?= $this->render('@app/views/new-cabinet/expirationReminding.php'); ?>
        <!--  更柜区添加新的区域  -->
        <?= $this->render('@app/views/new-cabinet/addNewArea.php'); ?>
        <!--  更柜绑定会员  -->
        <?= $this->render('@app/views/new-cabinet/bindMember.php'); ?>
        <!--  绑定更衣柜  -->
        <?= $this->render('@app/views/new-cabinet/bindLockerCabinet.php'); ?>
        <!--  新增更衣柜  -->
        <?= $this->render('@app/views/new-cabinet/addLockerCabinet.php'); ?>
        <!--  已绑定详情  -->
        <?= $this->render('@app/views/new-cabinet/bindingsDetails.php'); ?>
        <!--  调柜  -->
        <?= $this->render('@app/views/new-cabinet/changeLocker.php'); ?>
        <!--  退租  -->
        <?= $this->render('@app/views/new-cabinet/throwALease.php'); ?>
        <!--  续柜  -->
        <?= $this->render('@app/views/new-cabinet/continuedCabinet.php'); ?>
        <!--  未绑定详情  -->
        <?= $this->render('@app/views/new-cabinet/unbindDetails.php'); ?>
        <!--  未绑定会员修改  -->
        <?= $this->render('@app/views/new-cabinet/unbindMember.php'); ?>
        <!--  调柜完成  -->
        <?= $this->render('@app/views/new-cabinet/changeLockerFinished.php'); ?>
        <!--管理类型详情-->
        <?= $this->render('@app/views/new-cabinet/manageDetail.php'); ?>
        <!-- 退柜设置模态框 -->
        <?= $this->render('@app/views/new-cabinet/quitCabinetSetting.php'); ?>
</div>
