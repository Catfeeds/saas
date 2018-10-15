<?php

use backend\rbac\assets\AuthAsset;

AuthAsset::register($this);
$this->title = "用户配置";
?>
<div class="panel panel-default" ng-controller="vipRoleCtrl" ng-cloak>
    <div class="panel-heading h">
        <div class="col-md-12 col-lg-12 mp">
            <div class="col-md-8 col-lg-8 text-left mp">
                <div class="col-md-5 col-lg-5 mp">
                    <b class="panel-title">用户配置</b>
                </div>
                <div class="col-md-7 col-lg-7 text-right mp">
                    <button class="btn btn-sm btn-success" type="button" ng-click="insert_roles()">新增角色</button>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 text-right mp">
                <button id="save_per" ng-click="save_permission()" class="btn btn-sm btn-success detail" type="button">
                    保存权限
                </button>
                <button id="add_per" class="btn btn-sm btn-success detail" data-toggle="modal"
                        data-target="#add_permission" ng-click="add_per(check_per_role, check_role_name)" type="button">
                    增加权限
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12 col-lg-12" style="padding: 0;">
            <div class="col-md-8 col-lg-8"
                 style="padding-left: 0; height: 780px; overflow: auto; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                <table class="table" style="border-bottom: 1px solid #e7eaec;">
                    <tr>
                        <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                    class="glyphicon glyphicon-user" aria-hidden="true"></span><b>&nbsp;角色</b></th>
                        <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                    class="glyphicon glyphicon-apple" aria-hidden="true"></span><b>&nbsp;公司</b></th>
                        <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-stats"
                                                                           aria-hidden="true"></span><b>&nbsp;状态</b>
                        </th>
                        <th style="line-height: 2px; padding: 10px; width: 330px;"><span
                                    class="glyphicon glyphicon-hourglass" aria-hidden="true"></span><b>&nbsp;操作</b></th>
                    </tr>
                    <tr class="senior" ng-repeat="item in items">
                        <td style="text-align: left;line-height: 2px; padding: 10px; color: #245580;">
                            <span ng-if="item.derive_id == 0" style="font-weight: bold;">
                                <span class="prefix" ng-bind-html="item.prefix | html_filter"></span>
                                    {{item.name}}
                            </span>
                            <span ng-if="item.derive_id != 0">
                                <span class="prefix" ng-bind-html="item.prefix | html_filter"></span>
                                {{item.name}}
                            </span>
                        </td>
                        <td style="text-align: left;line-height: 2px; padding: 10px;">{{item.company_name}}</td>
                        <td ng-if="item.status == 2" style="line-height: 2px; padding: 10px;"><span class="label"
                                                                                                    style="color: rgb(51, 122, 183);">未分配权限</span>
                        </td>
                        <td ng-if="item.status == 1" style="line-height: 2px; padding: 10px;"><span class="label"
                                                                                                    style="color: rgb(92, 184, 92);">已分配权限</span>
                        </td>
                        <td ng-if="item.status == 2"
                            style="line-height: 2px; padding: 10px; color: rgb(51, 122, 183);">
                            <span class="btn-group">
                                <button class="btn btn-primary btn-sm senior-role"
                                        ng-click="allot_per(item.id, item.derive_id)" type="button">分配权限</button>
                                <button class="btn btn-sm btn-warning senior-role"
                                        ng-click="view_venue(item.id, true)" type="button" data-toggle="modal"
                                        data-target="#venue-detail">查看场馆</button>
                                <button class="btn btn-sm btn-info senior-role"
                                        ng-click="unModifyRole(item.id)" type="button" data-toggle="modal"
                                        data-target="#modify-role">修改角色</button>
                            </span>
                        </td>
                        <td ng-if="item.status == 1" style="line-height: 2px; padding: 10px; color: rgb(92, 184, 92);">
                            <span class="btn-group">
                                <button class="btn btn-default btn-sm senior-role"
                                        ng-click="look_per(item.id, item.name)" type="button">查看权限</button>
                                <button class="btn btn-success btn-sm senior-role"
                                        ng-click="allot_user(item.id, item.name, false)" type="button">分配用户</button>
                                <button class="btn btn-info btn-sm senior-role"
                                        ng-click="look_assign(item.id, item.name)" type="button">查看用户</button>
                                <button class="btn btn-sm btn-warning senior-role" type="button"
                                        ng-click="view_venue(item.id, true)" data-toggle="modal"
                                        data-target="#venue-detail">查看场馆</button>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4 col-lg-4">
                <?= $this->render('@backend/rbac/views/auth/allot_per.php'); ?> <!--分配权限-->
                <?= $this->render('@backend/rbac/views/auth/check_per.php'); ?> <!--查看权限-->
            </div>
        </div>
    </div>
    <?= $this->render('@backend/rbac/views/auth/add_roles.php'); ?> <!--新增高级角色模态框-->
    <?= $this->render('@backend/rbac/views/auth/add_user.php'); ?> <!--分配用户模态框-->
    <?= $this->render('@backend/rbac/views/auth/check_user.php'); ?> <!--查看用户模态框-->
    <?= $this->render('@backend/rbac/views/auth/add_per.php'); ?> <!--选择模块模态框-->
    <?= $this->render('@backend/rbac/views/auth/new_per.php'); ?> <!--新增权限模态框-->
    <?= $this->render('@backend/rbac/views/auth/venue_detail.php'); ?> <!--场馆详情模态框-->
    <?= $this->render('@backend/rbac/views/auth/check_venue.php'); ?> <!--选择场馆模态框-->
    <?= $this->render('@backend/rbac/views/auth/modify_role.php'); ?> <!--选择场馆模态框-->
</div>
<?= $this->render('@backend/rbac/views/loading.php') ?> <!--加载遮罩框-->

