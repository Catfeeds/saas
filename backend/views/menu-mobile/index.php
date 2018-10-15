<?php
use backend\assets\MenuMobileAsset;
MenuMobileAsset::register($this);
$this->title = '菜单管理';
?>
<div class="container-fluid pd0" ng-controller="menuCtrl" ng-cloak>
    <?=$this->render('@app/views/common/csrf.php')?>
    <!--菜单列表-->
    <div class="col-sm-12 menuBox pd0">
        <div class="panel panel-default ">
            <div class="panel-heading">
                <span style="display: inline-block"><b class="spanSmall">菜单管理</b></span>
            </div>
            <div class="title col-sm-12" style="background: #fff;padding: 5px 20px 5px 0;">
                <button class="btn btn-success pull-right ml_20px" data-toggle="modal" data-target="#addTopMenu" ng-click="addtopMenu()">新增顶级菜单</button>
                <button type="button" class="btn btn-default pull-right  " data-toggle="modal" data-target="#mainMenuSorting" ng-click="mainMenuSorting()">排序</button>
            </div>
            <div class="panel-body">
                <div class="col-sm-12 pd0">
                    <div class="ibox float-e-margins borderNone">
                        <div class="ibox-content" style="padding: 10px">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pdm0" role="grid">
                                <table class="table table-bordered table-hover dataTables-example dataTable">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('menuName',sort)" rowspan="1" colspan="1">菜单名</th>
                                        <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('englishMenuName',sort)" rowspan="1" colspan="1">英文名</th>
                                        <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('secondMenuName',sort)" rowspan="1" colspan="1">所含子菜单</th>
                                        <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('addTime',sort)" rowspan="1" colspan="1">创建时间</th>
                                        <th class="sorting w200" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="top in topMenuList">
                                        <td>
                                            <span ng-if="top.name != null">{{top.name}}</span>
                                            <span ng-if="top.name == null">暂无数据</span>
                                        </td>
                                        <td>
                                            <span ng-if="top.e_name != null">{{top.e_name}}</span>
                                            <span ng-if="top.e_name == null">暂无数据</span>
                                        </td>
                                        <td class="pdlr30">
                                    <span ng-repeat="inn in top.module">
                                        <span class="noDataNameInn">{{inn.name}}</span>
                                    </span>
                                        </td>
                                        <td>
                                            <span ng-if="top.create_at != null">{{top.create_at*1000|date:'yyyy-MM-dd'}}</span>
                                            <span ng-if="top.create_at == null">暂无数据</span>
                                        </td>
                                        <td>
                                            <!--                                            修改顶级菜单的触发按钮-->
                                            <button class="btn btn-sm btn-warning w80" data-toggle="modal" data-target="#amendTopMenu" ng-click="amendTopMenu(top.id)">修改顶菜单</button>
                                            <!--                                            修改顶级菜单的触发按钮-->
                                            <button class="btn btn-sm btn-primary w80" data-toggle="modal" data-target="#lookSecondMenu" ng-click="lookSecondMenu(top.id,top.name)">查看子菜单</button>
                                            <!--                                            删除菜单的触发按钮-->
                                            <button class="btn btn-sm btn-danger w80" data-toggle="modal" data-target="#deleteMenu" ng-click="deleteMenu(top.id,top.name)">删除菜单</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <span class="pull-right spanTable">共{{allNumTopMenu}}条</span>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'noTopMenuShow','text'=>'暂无数据','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--新增顶级菜单的模态框、顶级菜单排序、修改顶级菜单的模态框-->
    <?= $this->render('@app/views/menu/topMenuFunc.php'); ?>


    <!--查看子菜单的模态框、子菜单排序、子菜单移动、新增子菜单的模态框、子菜单功能的模态框、修改子菜单的模态框-->
    <?= $this->render('@app/views/menu/submenuunction.php'); ?>
    
</div>
