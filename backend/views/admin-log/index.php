<?php
use backend\assets\AdminLogAsset;

AdminLogAsset::register($this);
$this->title = '操作日志';
?>
<div class="adminLogContent" ng-controller="adminLogCtrl" ng-cloak>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>操作日志</h4></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="input-daterange input-group cp">
                        <span class="add-on input-group-addon"">选择日期</span>
                        <input type="text" readonly name="reservation" placeholder="请选择日期" id="adminLogDate" class="form-control text-center userSelectTime reservationExpire" style="width: 100%">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input type="text" id= "searchData" ng-model="keywords" class="form-control" ng-keydown="enterSearch()" placeholder="请输入路由" style="height: 34px">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" ng-click="searchAbout()">搜索</button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-1 ">
                   <button class="btn btn-default" ng-click="searchClear()">清空</button>
                </div>

            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading "><h4>日志列表</h4></div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>ID</th>
                    <th width="30%">路由</th>
                    <th>操作时间</th>
                    <th>操作人</th>
                    <th>操作IP</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr class="gradeA odd" ng-repeat='(index,item) in items'>
                    <th>{{index+1}}</th>
                    <td>{{item.id | noData:''}}</td>
                    <td>{{item.route | noData:''}}</td>
                    <td>{{item.created_at | noData:''}}</td>
                    <td>{{item.username | noData:''}}</td>
                    <td>{{item.ip | noData:''}}</td>
                    <th>
                        <button class="btn btn-default" data-toggle="modal" data-target="#adminLogModal" ng-click="getLogInfo(item.id)">查看</button>
                    </th>
                </tr>
                </tbody>
            </table>
            <?= $this->render('@app/views/common/pagination.php'); ?>
            <?= $this->render('@app/views/common/nodata.php',['name'=>'adminLogNoData','text'=>'暂无数据','href'=>true]); ?>
        </div>
    </div>
    <!--详情-->
    <?= $this->render('@app/views/admin-log/adminLogModal.php'); ?>
</div>
