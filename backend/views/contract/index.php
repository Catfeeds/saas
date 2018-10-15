<?php
use backend\assets\ContractAsset;
ContractAsset::register($this);
$this->title = '合同管理';
?>
<!--<header>-->
<div class="container-fluid" ng-controller="contractCtrl" ng-cloak>
    <div class="wrapper wrapper-content ">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b class="spanSmall">合同管理</b></span>
                    </div>
                    <div class="panel-body col-sm-12 col-md-12 col-xs-12" style="background-color: #FFF;">
                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <div class="col-md-4 col-sm-5 col-xs-6 col-md-offset-3 col-sm-offset-1 " >
                                <div class="input-group">
                                    <input type="text" class="form-control headerSearch" ng-keyup="enterSearch($event)" ng-model="searchContent"  placeholder="  请输入合同名称或合同编号进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5 col-xs-6 searchAdd">
                                <li class="nav_add">
                                    <ul>
                                        <li id="tmk">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('deal', 'ADD')) { ?>
                                                <a class="glyphicon glyphicon-plus addCabinet searchAddButton" data-toggle="modal" ng-click="getDealTypeInfo()" data-target="#myModals4">新增合同</a>
                                            <?php }?>
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('deal', 'EDIT')) { ?>
                                                <a class="glyphicon glyphicon-pencil getDealType" data-toggle="modal" ng-click="getDealType()" data-target="#myModals10">编辑合同类型</a>
                                            <?php }?>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 header mT20">
                            <label for="id_label_single">
                                <select class="js-example-basic-single js-states form-control headerWidth" ng-change="getVenueOptions(company_id)" ng-model="company_id" id="id_label_single">
                                    <option value="">选择公司</option>
                                    <option value="{{w.id}}" ng-repeat="w in optionCompany" >{{w.name}}</option>
                                </select>
                            </label>
                            <label for="id_label_single">
                                <select class="js-example-basic-single2 js-states form-control headerWidth" ng-model="venue_id" id="id_label_single">
                                    <option value="">选择场馆</option>
                                    <option value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>
                                </select>
                            </label>
                            <button type="button" ladda="searchCarding" ng-click="searchEmployee()"
                                    class="btn btn-sm btn-success ladda-button headerSure" style="position: static">确定
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 bodyList mT20" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>合同列表</h5><span class="bodyList1">点击查看合同详情</span>
                </div>
                <div class="ibox-content bodyHeader">
                    <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('dealTypeName',sort)"     colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;合同类型
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('dealTypeName',sort)"     colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>&nbsp;合同分类
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('dealName',sort)"     colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span>&nbsp;合同名称
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('dealNumber',sort)"    colspan="1" style="width: 100px;"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;合同编号
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('create_at',sort)"    colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;合同日期
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 160px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;编辑
                                </th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr ng-repeat="item in items" ng-click="contractDetail(item.id)">
                                <td class="showBtn" data-toggle="modal" data-target="#myModals3"><span class="center-block" style="display: block;text-align: center;">{{item.type_name}}</span></td>
                                <td class="showBtn" data-toggle="modal" data-target="#myModals3">
                                    <span class="center-block" style="display: block;text-align: center;" ng-if="item.type == '1' || item.type == 1">卡种类</span>
                                    <span class="center-block" style="display: block;text-align: center;" ng-if="item.type == '2' || item.type == 2">私课类</span>
                                    <span class="center-block" style="display: block;text-align: center;" ng-if="item.type == null || item.type == undefined || item.type == ''">暂无数据(请修改)</span>
                                </td>
                                <td class="showBtn" data-toggle="modal" data-target="#myModals3"><span class="center-block" style="display: block;text-align: center;">{{item.name}}</span></td>
                                <td class="showBtn" data-toggle="modal" data-target="#myModals3"><span class="center-block" style="display: block;text-align: center;">{{item.deal_number}}</span></td>
                                <td class="showBtn" data-toggle="modal" data-target="#myModals3"><span class="center-block" style="display: block;text-align: center;">{{item.create_at*1000 | date:'yyyy-MM-dd HH:mm'}}</span></td>
                                <td class="showBtn">
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('deal', 'UPDATE')) { ?>
                                        <button class="tdBtn btn btn-success btn-sm btnClose" ng-click="dealOne(item.id)" data-toggle="modal" data-target="#myModals2">修改</button>
                                    <?php }?>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('deal', 'DELETE')) { ?>
                                        <button class="tdBtn btn btn-danger btn-sm" ng-click="del(item.id,item.name)"   type="submit">删除</button>
                                    <?php }?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php'); ?>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate" style="padding-right: 20px;">
                                    <?=$this->render('@app/views/common/page.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModals2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 72%;">
            <div class="modal-content clearfix updateContract">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="button-success text-center" style="font-size: 24px;">修改合同内容</h3>
                    <div class="col-sm-12 pd0 updateHeader"></div>
                    <h4  class="updateXieYi">{{dataOne.name}}合同协议</h4>
                    <input type="hidden" id="dealId" value="{{dataOne.id}}">
                    <div class="row">
                        <form class="form-inline formBox1 contractFcuntion">
                            <p class="titleP">1.基本属性</p>
                            <div class="col-sm-12 pd0">
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="exampleInputName2" class="contractName font14 fontNormal"><span style="color: red;">*</span>合同名称</label>
                                    <input  type="text" class="form-control"
                                           ng-model="dataOne.name"
                                           id="exampleInputName2"
                                           ng-change="setDealName(dataOne.name)"
                                           style="margin-left: 10px;padding-top: 4px; width: 160px;display: inline-block;"
                                           placeholder="请输入合同名称">
                                </div>
                                <div class="form-group contractTypeHeader"  style="padding-top: 0;">
                                    <label for="exampleInputName2" class="contractTypeBody font14 fontNormal"><span style="color: red;">*</span>合同类型</label>
                                    <select style="width: 160px;margin-left: 10px;"  ng-if="dealTypeNoData == false" class="form-control contractBody" ng-model="dataOne.deal_type_id">
                                        <option value="">请选择合同类型</option>
                                        <option value="{{deals.id}}" ng-repeat="deals in dealTypeData">{{deals.type_name}}</option>
                                    </select>
                                </div>
                                <div class="form-group contractTypeHeader" style="padding-left: 0;padding-top: 0;">
                                    <label class="font14 fontNormal" for=""><span style="color: red;">*</span>合同分类</label>
                                    <select class="form-control contractBody" ng-model="dataOne.type" style="width: 160px;margin-left: 10px;">
                                        <option value="">请选择合同分类</option>
                                        <option value="1">卡种类合同</option>
                                        <option value="2">私课类合同</option>
                                    </select>
                                </div>
                                <p class="titleP" style="margin-top: 40px;">2.合同内容</p>

                            </div>
                        </form>
                        <div class="col-sm-12 contractBody1">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5 class="contractBody2"><span style="color: red;">*</span>合同内容</h5>
                                    <button id="edit" class="btn btn-primary btn-xs m-l-sm" onclick="edit()" type="button">编辑</button>
                                    <button id="save" class="btn btn-primary  btn-xs" onclick="save()" type="button">保存</button>
                                    <div class="ibox-tools">
                                    </div>
                                </div>
                                <textarea config="summernoteConfigs" summernote style="resize: none;" class="summernote" required
                                          ng-model="dataOne.intro">
                                  </textarea>
                            </div>
                        </div>
                    </div>
                    <div style="width: 100%;" class="text-center">
                        <button class="btn btn-success btnClose contractWan width100" ng-click="dealUpdate()">完成</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--    详情-->
    <div class="modal fade contractDetail" id="myModals3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog contractDetailHeader" style="width: 65%;min-width: 720px;">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <select class="form-control"
                            style="width: 210px;padding: 0 12px;"
                            ng-change="contractChange(contractId)"
                            ng-model="contractId">
<!--                        <option value="">选择合同</option>-->
                        <option value="{{index}}" ng-repeat="(index, item) in contractNames">{{item.name}}</option>
                    </select>
                    <h3 class="contractDetails">合同详情</h3>
                </div>
                <div class="modal-body text-center" style="padding-top: 0">
                    <div class="row">
                        <div class="contractDetailType col-sm-12">
                            <span class="col-sm-6 text-right">合同类型:</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px">{{contractMessage.dealType.type_name}}</span>
                        </div>
                        <div class="contractDetailType col-sm-12">
                            <span class="col-sm-6 text-right">合同分类:</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px" ng-if="contractMessage.type == 1 || contractMessage.type == '1'">卡种类合同</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px" ng-if="contractMessage.type == 2 || contractMessage.type == '2'">私课类合同</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px" ng-if="!contractMessage.type">暂无数据(请修改)</span>
                        </div>
                        <div class="contractDetailType col-sm-12">
                            <span class="col-sm-6 text-right">合同名称:</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px">{{contractMessage.name}}</span>
                        </div>
                        <div class="contractDetailType col-sm-12">
                            <span class="col-sm-6 text-right">合同编号:</span>
                            <span class="col-sm-6 text-left" style="margin-left: -20px">{{contractMessage.deal_number}}</span>
                        </div>
                        <div class="col-sm-12">
                            <h2 class="text-center">合同内容</h2>
                            <p id="contractContentDetail" class="text-left">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--新增合同、合同类型和修改合同-->
    <?= $this->render('@app/views/contract/addAndEdit.php'); ?>

    <?=$this->render('@app/views/common/csrf.php');?>
</div>
<!--模态 修改-->
