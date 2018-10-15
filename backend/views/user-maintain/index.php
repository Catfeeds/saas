<?php
use backend\assets\UserMaintainAsset;
UserMaintainAsset::register($this);
$this->title = '会员维护';
?>
<main  ng-controller="maintainCtrl"  ng-cloak>
    <input ng-model="res._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
<header>
    <div class="panel panel-default ">
        <div class="panel-heading"><span class="displayInlineBlock"><b class="spanSmall">会员维护</b></span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-7  col-lg-offset-2 text-center header-input" >
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="input-group">
                            <input type="text" id="inputSearch" class="form-control "  placeholder="请输入姓名、手机号" ng-model="inputSearch" ng-keydown="enterSearch()">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" ng-click="search()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 text-right text-right-btn">
                    <button type="button" class="btn  btn-default" data-toggle="modal" ng-click="maintainEditBtn()">
                        模板
                    </button>
                    <button type="button" class="btn btn-success" ng-click="sendGoal()">发送健身目标</button>
                    <button type="button" class="btn btn-success" ng-click="sendPlan()">发送饮食计划</button>
                    <div>
                        <span class="f12 colorCCC" style="margin-right: 12px;"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;群发速度较慢，请勿重复点击！</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <select name="" id="" ng-model="venueIdData" class="form-control" style="padding:4px;">
                        <option value="" >选择场馆</option>
                        <option value="{{venue.id}}" ng-repeat="venue in maintainVenue">{{venue.name}}</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-3">
                    <select name="" id="" ng-model="planGoal" class="form-control" style="padding:4px;">
                        <option value="">计划目标</option>
                        <option value="1">未添加</option>
                        <option value="2">已添加</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-2  col-sm-3" style="padding:0;">
                    <select name="" id="" ng-model="sendMessageType" class="form-control" style="padding:4px;">
                        <option value="">未发送</option>
                        <option value="d">本日未发送的</option>
                        <option value="w">本周未发送的</option>
                        <option value="m">本月未发送的</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>目标列表</h5>
                <div class="ibox-tools"></div>
            </div>
            <div class="ibox-content pd0" >
                <div id="DataTables_Table_0_wrapper"  class="dataTables_wrapper form-inline pd0" role="grid">
                    <div class="row disNone" >
                        <div class="col-sm-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                        </div>
                    </div>
                    <table
                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('pic',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                    class="glyphicon glyphicon-camera" aria-hidden="true"></span>&nbsp;姓名
                            </th>
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('class_type',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                    class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;手机号
                            </th>
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('category',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                    class="glyphicon glyphicon-list-alt" aria-hidden="true" ></span>&nbsp;教练
                            </th>
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('name',sort)"    colspan="1" aria-label="平台：激活排序列升序" ><span
                                    class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;计划目标
                            </th>
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('created_at',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" ><span
                                    class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;发送时间
                            </th>
                            <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS等级：激活排序列升序"><span
                                    class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;操作
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="w in maintainVenueMemberList">
                            <td>{{w.memberName}}</td>
                            <td>{{w.mobile}}</td>
                            <td>{{w.privateName}}</td>
                            <td ng-if="w.programId == null">未添加</td>
                            <td ng-if="w.programId != null">已添加</td>
                            <td ng-if="w.send_time == null">暂无数据</td>
                            <td ng-if="w.send_time != null">{{w.send_time * 1000 | date:'yyyy-MM-dd'}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" ng-click="infoList(w.id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'maintainVenueFlag','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'navList']);?>
                </div>
            </div>
        </div>
    </div>
    <!--模板模态框-->
    <?= $this->render('@app/views/user-maintain/maintainEditModal.php'); ?>
    <!--新增和修改健身目标模态框-->
    <?= $this->render('@app/views/user-maintain/maintainEditSportModal.php'); ?>
    <!--新增和修改饮食计划模态框-->
    <?= $this->render('@app/views/user-maintain/maintainEditSportFoodModal.php'); ?>
    <!--会员维护查看详情模态框-->
    <?= $this->render('@app/views/user-maintain/maintainDetailsModal.php'); ?>
</header>
</main>


