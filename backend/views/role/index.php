<?php
use backend\assets\RoleAsset;
RoleAsset::register($this);
$this->title = '角色管理';
?>

<div ng-controller="roleCtrl" ng-cloak>
    <header>
<!--        <div class="wrapper wrapper-content  animated fadeIn">-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default " >
                        <div class="panel-heading">
                            <span style="display: inline-block"><b class="spanSmall">角色管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6" style="">
                                    <div class="panelDefaultLeft">
                                        <center>
                                            <span>选择公司</span>
                                            <label for="id_label_single">
                                                <select style="width: 200px;"  class="js-example-basic-single js-states form-control w110 pdb3" ng-change="selectCompanyChange(selectCompanyDataId)" ng-model="selectCompanyDataId" id="id_label_single">
                                                    <option value="">不限</option>
                                                    <option  value="{{w.id}}" ng-repeat="w in selectCompanyDatas">{{w.name}}</option>
                                                </select>
                                            </label>
                                        </center>
                                    </div>
                                <div class="input-group" style="left: 30%">
                                    <input type="text" class="form-control" id="keyword" ng-model="roleKeywords" placeholder="请输入角色名进行搜索..." style="height: 34px;" ng-keyup="enterSearchRoles($event)">
                                    <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" ng-click="searchWords()">搜索</button>
                                    </span>
                                    <span class="input-group-btn" style="left: 10px;">
                                            <button class="btn btn-default" type="button" ng-click="clearSearch()">清空</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6" style="width: 200px;position: relative;right: -300px;top: -5px">
                                <div class="input-group panelDefaultButton">
                                    <button type="button" class="btn btn-success"
                                             ng-click="addShowModel()">新增角色</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pd0" >
                        <div class="ibox float-e-margins">
                            <div class="ibox-content pd0">

                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row displayNone">
                                        <div class="col-sm-6">
                                            <div id="DataTables_Table_0_filter" class="dataTables_filter">

                                            </div>
                                        </div>
                                    </div>
                                    <table
                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)"><span
                                                    class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;角色名
                                            </th>
                                            <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)"><span class="glyphicon glyphicon-king" aria-hidden="true"></span>&nbsp;所属公司
                                            </th>
                                            <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)"><span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>&nbsp;操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="gradeA odd" ng-repeat="w in listDatas">
                                            <td >{{w.name}}</td>
                                            <td >{{w.organization.name}}</td>
                                            <td class="tdBtn mrr6">
                                                    <button ng-click="assignEmployees(w.id,w.company_id)"
                                                            class="btn btn-success btn-sm tdBtn" data-toggle="modal" data-target="#assignEmployees">分配员工
                                                    </button>
                                                    <button class="btn btn-default btn-sm mrr6 tdBtn"
                                                            ng-click="delete(w.id,w.name)">
                                                        删除角色
                                                    </button>
                                                <button class="btn btn-default btn-sm mrr6 tdBtn" ng-click="viewDetails(w.id,w.name)">
                                                    查看详情
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/nodata.php'); ?>
                                    <?=$this->render('@app/views/common/page.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </header>

    <!--新增角色和分配员工-->
    <?= $this->render('@app/views/role/addAndAllot.php'); ?>
    <!--详情-->
    <div class="modal fade" id="viewDetails" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">角色详情</h4>
                </div>
                <div class="row" style="margin: 10px 0">
                    <div class="col-md-2"></div>
                    <div class="input-group col-md-6" style="float: left">
                        <input type="text" class="form-control" ng-keyup="enterSearch($event)" ng-model="keywords" placeholder="输入姓名、手机号搜索..." style="height: 34px;">
                        <span class="input-group-btn"  >
                            <button class="btn btn-primary" type="button" ng-click="searchRole()">搜索</button>
                        </span>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <button class="btn btn-info" type="button" ng-click="clearDetailKeywords()">清空</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body viewDetailsBody" style="padding-top: 0;">
                    <div class="col-sm-12 boxConTent435">
                        <table
                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1"
                                    colspan="1" aria-label="浏览器：激活排序列升序"
                                    ng-click="changeSort('employee_name',sort)">&nbsp;姓名
                                </th>
                                <th class="w260"  tabindex="0" aria-controls="DataTables_Table_0"
                                     rowspan="1"
                                     colspan="1" aria-label="浏览器：激活排序列升序"
                                     ng-click="changeSort('employee_name',sort)">&nbsp;性别
                                </th>
                                <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                     rowspan="1"
                                     colspan="1" aria-label="浏览器：激活排序列升序"
                                     ng-click="changeSort('employee_name',sort)">&nbsp;手机号
                                </th>
                                <th class="w260" tabindex="0" aria-controls="DataTables_Table_0"
                                     rowspan="1"
                                     colspan="1" aria-label="浏览器：激活排序列升序"
                                     ng-click="changeSort('employee_name',sort)">&nbsp;所属部门
                                </th>
                                <th class="w290" tabindex="0" aria-controls="DataTables_Table_0"
                                     rowspan="1"
                                     colspan="1" aria-label="浏览器：激活排序列升序"
                                     ng-click="changeSort('employee_name',sort)">&nbsp;入职时间
                                </th>
                                <th class="w290" tabindex="0" aria-controls="DataTables_Table_0"
                                     rowspan="1"
                                     colspan="1" aria-label="浏览器：激活排序列升序"
                                     ng-click="changeSort('employee_name',sort)">&nbsp;操作
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="gradeA odd tdBtnTr" ng-repeat="w in viewDetailsData" ng-if="w.admin.level != null">
                                <td >{{w.name}}</td>
                                <td >{{w.sex == 1 ? "男":"女"}}</td>
                                <td >{{w.mobile}}</td>
                                <td >{{w.organization.name}}</td>
                                <td>{{w.entry_date | noData:''}}</td>
                                <td class="tdBtns">
                                    <button class="btn btn-default btn-sm"
                                            style="margin-right: 6px;"
                                            ng-click="removeRoles(w.admin.id,w.name)">
                                        移除角色
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoMoneyDataShow','text'=>'无记录','href'=>true]);?>
                    </div>
                    <div class="font18 col-sm-12 text-right" >
                        共{{viewDetailsData.length}}人
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>