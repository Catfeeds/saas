<?php
use backend\assets\DepartmentAsset;
DepartmentAsset::register($this);
$this->title = '场地管理';
?>

<div  ng-controller = 'departmentMainCtrl' style="min-width: 620px;" ng-cloak>
    <header>
<!--        <div class="wrapper wrapper-content  animated fadeIn"  >-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <span style="display: inline-block"><b>组织架构管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pd0 " >
                                <div class="col-sm-6 col-xs-8 col-sm-offset-2" >
                                    <div class="input-group">
                                        <input type="text" class="form-control" ng-model="topSearch" placeholder="请输入所属场馆，部门名称搜索..."
                                               style="height: 34px;line-height: 7px;" ng-keydown="enterSearch()">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="search()" class="btn btn-primary">搜索</button>
                                                </span>
                                    </div>
                                </div>
                                <div class="col-sm-offset-1 col-xs-4 col-sm-2 text-left">
                                    <li class="nav_add" style="padding-top: 0;">
                                        <div class="dropdown " style="border: none;left: 0;cursor:pointer " >
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','ADD')){ ?>
                                                <div style="border: none;background-color: transparent !important;padding-bottom: 5px:  " class=" dropdown-toggle f14 " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <span class="btn btn-success btn header2" style="font-size: 15px;color: green;">选择添加项目</span>
                                                </div>
                                            <?php } ?>
                                            <ul  class="dropdown-menu f16 " aria-labelledby="dropdownMenu1" style="margin-top: 10px;border: none !important;box-shadow: 0 0 2px #5e5e5e;font-size: 13px;">
                                                <li><a href="/main/add-brand" >公司品称添加</a></li>
                                                <li><a href="/main/add-venue" >场馆添加</a></li>
                                                <li><a href="/main/add-site" >场地添加</a></li>
    <!--                                            <li><a href="/main/add-facility?mid=21&c=20" >设备添加</a></li>-->
                                                <li><a href="/main/add-department" >部门添加</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                                <div class=" fl" style="display: flex;justify-content: space-between">
                                    <span class="" style="position: relative;margin-top: 5px;width: 100px;   ">选择场馆:</span>
                                    <label for="id_label_single" >
                                        <select class="js-example-basic-single1 js-states form-control"  style="width: 130px;padding-bottom: 3px;" ng-model="venueId" id="id_label_single">
                                            <option id="" value="" selected>所有场馆</option>
                                            <option ng-repeat ="venue in venues" value="{{venue.id}}">{{venue.name}}</option>
                                        </select>
                                    </label>
                                </div>
                                <button class="btn btn-success btn-sm" ng-click="search()" tape="submit" style="margin-left: 40px;">确定</button>
                                <button class="btn btn-info btn-sm" ng-click="searchClear()" tape="submit" style="margin-left: 20px;">清除</button>
                            </div>
                        </div>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                <div class="tabBox clearfix" style="border: solid 1px #e5e5e5;min-width: 620px;">
                    <div class="list_tab fl " style="">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/index"><span class="yG">场馆</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;z-index: 10;">
                        <img src="/plugins/main/imgs/u109.png"/><a href="/main/site"><span >场地</span></a>
                    </div>
<!--                    <div class="list_tab fl" style="margin-left: -50px;">-->
<!--                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/facility?mid=21&c=20"><span >设备</span></a>-->
<!--                    </div>-->
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/company"><span >公司</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u113.png" alt="" /><a href="/main/department"><span >部门</span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>部门信息列表</h5>
                        <div class="ibox-tools">

                        </div>
                    </div>
                    <div class="ibox-content">

                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <div class="row">
                                <div class="col-sm-6"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('name',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="fa fa-home" aria-hidden="true"></span>&nbsp;所属公司
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('name',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;所属场馆
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('name',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="fa fa-group" aria-hidden="true"></span>&nbsp;部门名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('code',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="fa fa-barcode" aria-hidden="true"></span>&nbsp;识别码
                                    </th>

                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 500px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="item in items">
                                    <td>{{item.beCompanyName}}</td>
                                    <td>{{item.beVenueName}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.code}}</td>
                                    <td class="tdBtn">
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('organization','UPDATE')){ ?>
                                            <a href="" data-toggle="modal" data-target="#editSite" style="margin-top: 5px;color:#fff">
                                            <span class="btn btn-success btn-sm"   ng-click="update(item.id,item.name,item.code)" type="submit">修改</span></a>
                                            &nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('organization','DELETE')){ ?>
                                            <button class="btn btn-danger btn-sm" ng-click="del(item.id,item.name)"  type="submit">删除</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php'); ?>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <div class="dataTables_paginate paging_simple_numbers"
                                         id="DataTables_Table_0_paginate">
                                        <?= $this->render('@app/views/common/pagination.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--        </div>-->
    </header>
    <!--场地修改页面-->
    <div class="modal fade" id="editSite" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                        修改部门信息
                    </h3>
                </div>
                <div class="modal-body">
                    <div style="display: flex;justify-content: center;">
                        <div  ng-model="dep"  class="form-group" style="color: rgb(153,153,153);width: 300px;"><strong style="color:red">*</strong>部门名称</div>
                    </div>
                    <input  id="_csrf" type="hidden"
                            name="<?= \Yii::$app->request->csrfParam; ?>"
                            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    <div class="form-group text-center">
                        <input type="hidden" id="departId" value="{{DepartmentId}}">
                        <center>
                            <input type="text" ng-model="name"   class="form-control actions" id="" value="销售">
                        </center>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <div class="form-group" style="color: rgb(153,153,153);width: 300px;"><strong style="color:red">*</strong>识别码</div>
                    </div>
                    <div class="form-group text-center">
                        <center>
                            <input type="text" ng-model="code"    class="form-control actions" id="" value="xiaoshou">
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <center><button type="button" class="btn btn-success " ng-click="depUpdate()"  style="width: 100px;">提交</button></center>
                </div>
            </div>
        </div>
    </div>
</div>