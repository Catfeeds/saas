<?php
use backend\assets\BehaviorTrajectoryAsset;

BehaviorTrajectoryAsset::register($this);
$this->title = '系统管理 - 行为轨迹';
?>
<div class="container-fluid pd0" ng-controller="behaviorTrajectoryCtrl" ng-cloak>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                            <span style="display: inline-block"><b>系统管理</b></span>  >  <span style="display: inline-block"><b>行为轨迹</b></span>
                    </div>
                    <div class="panel-body">
                        <div class=" col-sm-4">
                            <div class="col-sm-4">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            id="id_label_single" ng-model="initDataModel.behavior" ng-change="allBehaviorChange(initDataModel.behavior)">
                                        <option value="">全部行为</option>
                                        <option value="1">浏览</option>
                                        <option value="2">编辑</option>
                                        <option value="3">修改</option>
                                        <option value="4">查看</option>
                                        <option value="5">删除</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            id="id_label_single" ng-model="initDataModel.modules" ng-change="allModulesChange(initDataModel.modules)">
                                        <option value="">顶级模块</option>
                                        <option value="{{w.id}}" ng-repeat="w in allModulesData">{{w.name}}</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            id="id_label_single" ng-model="subModuleChangeId" ng-change="subModuleChange(subModuleChangeId)">
                                        <option value="">全部模块</option>
                                        <option value="{{w.id}}" ng-repeat="w in subModeleData">{{w.name}}</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class=" col-sm-3">
                            <div class="input-daterange input-group dataInputInput fl cp userTime" id="container">
                                <div class="input-daterange input-group cp userTimeRecord" id="container">
                             <span class="add-on input-group-addon">
                                 日期
                                 </span>
                                    <input type="text" readonly name="reservation" id="reservation" class="form-control text-center userSelectTime" value="" ng-blur="getTimeDate()"  placeholder="选择日期"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 userHeader" style="">
                            <div class="input-group">
                                <input type="text" class="form-control userHeaders" ng-model="initDataModel.keywords"
                                       ng-keyup="enterSearch($event)" placeholder=" 请输入名字进行搜索...">
                                      <span class="input-group-btn">
                                            <button type="button" ng-click="searchName()"
                                                    class="btn btn-primary">搜索</button>
                                      </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('@app/views/common/csrf.php') ?>
        <div class="col-sm-12 boxDivBig">
            <div class="ibox-content">
                <div id="DataTables_Table_0_wrapper"
                     class="dataTables_wrapper form-inline" role="grid">
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                           id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th ng-click="changeSort('employeeName',sort)" class="sorting"
                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;用户
                            </th>
                            <th ng-click="changeSort('employeeBehavior',sort)" class="sorting"
                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;">
                                <span class="glyphicon glyphicon-link" aria-hidden="true"></span>&nbsp;功能
                            </th>
                            <th ng-click="changeSort('behavior_intro',sort)" class="sorting"
                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>&nbsp;行为
                            </th>
                            <th ng-click="changeSort('create_at',sort)" class="sorting"
                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;时间
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="w in listDatas">
                            <td ng-if="w.name != null">{{w.name}}</td>
                            <td ng-if="w.name == null">{{w.username}}</td>
                            <td>{{w.behavior_intro}}</td>
                            <td ng-if="w.behavior == null"></td>
                            <td ng-if="w.behavior == 1">浏览</td>
                            <td ng-if="w.behavior == 2">编辑</td>
                            <td ng-if="w.behavior == 3">修改</td>
                            <td ng-if="w.behavior == 4">查看</td>
                            <td ng-if="w.behavior == 5">删除</td>
                            <td>{{w.create_at *1000|date:"yyyy-MM-dd HH:mm"}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'dataInfo', 'text' => '暂无数据', 'href' => false]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
