<?php

use backend\rbac\assets\MainAsset;

MainAsset::register($this);
$this->title = '开发者配置';
?>
<div class="panel panel-default" ng-controller='developMainCtrl' ng-cloak>
    <div class="panel-heading h">
        <div class="col-md-12 col-lg-12 mp">
            <div class="text-left col-md-6 col-lg-6 mp">
                <b class="plugin">开发者配置</b>
            </div>
            <div class="text-right col-md-6 col-lg-6 mp">
                <button type="button" ng-click="initModal()" class="btn btn-sm btn-success" data-toggle="modal"
                        data-target="#developModal">新增模块
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12 col-lg-12" style="height: 780px; overflow: auto;">
            <table class="table" style="border-bottom: 1px solid #e7eaec;">
                <tr>
                    <th style="text-align: left; line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-th"
                                                                                         aria-hidden="true"></span><b>&nbsp;模块</b>
                    </th>
                    <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                class="glyphicon glyphicon-screenshot" aria-hidden="true"></span><b>&nbsp;描述</b></th>
                    <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                class="glyphicon glyphicon-tag" aria-hidden="true"></span><b>&nbsp;图标</b></th>
                    <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-transfer"
                                                                       aria-hidden="true"></span><b>&nbsp;响应</b></th>
                    <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                class="glyphicon glyphicon-random" aria-hidden="true"></span><b>&nbsp;路由</b></th>
                    <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-stats"
                                                                       aria-hidden="true"></span><b>&nbsp;状态</b></th>
                    <th style="line-height: 2px; padding: 10px; width: 300px;"><span
                                class="glyphicon glyphicon-hourglass" aria-hidden="true"></span><b>&nbsp;操作</b></th>
                </tr>
                <tr class="wrap-tr" ng-repeat="x in all_modules">
                    <td style="text-align: left; line-height: 2px; padding: 10px; color: #245580;">
                        <span ng-if="x.pid == 0" style="font-weight: bold;">
                            <span class="prefix" ng-bind-html="x.prefix | html_filter"></span>
                            {{x.name}}
                        </span>
                        <span ng-if="x.pid != 0">
                            <span class="prefix" ng-bind-html="x.prefix | html_filter"></span>
                            {{x.name}}
                        </span>
                    </td>
                    <td style="text-align: left; line-height: 2px; padding: 10px;">{{x.desc}}</td>
                    <td style="text-align: left; line-height: 2px; padding: 10px;">{{x.icon ? x.icon : '空'}}</td>
                    <td style="line-height: 2px; padding: 10px; color: purple;">{{x.response_type == 1 ? 'HTML' : 'JSON'
                        }}
                    </td>
                    <td style="text-align: left; line-height: 2px; padding: 10px;">
                        <span class="label label-default">{{x.route}}</span>
                    </td>
                    <td ng-if="x.status == 2" style="line-height: 2px; padding: 10px;"><span class="label"
                                                                                             style="color: rgb(51, 122, 183);">未添加权限</span>
                    </td>
                    <td ng-if="x.status == 1" style="line-height: 2px; padding: 10px;"><span class="label"
                                                                                             style="color: rgb(92, 184, 92);">已添加权限</span>
                    </td>
                    <td ng-if="x.status == 2" style="line-height: 2px; padding: 10px; color: rgb(51, 122, 183);">
                    <span class="btn-group">
                        <button class="btn btn-sm btn-warning basic-role" ng-click="modifyModule(x.id)">修改模块</button>
                        <button class="btn btn-sm btn-default basic-role" ng-click="basicRole(x.name)">添加权限</button>
                    </span>
                    </td>
                    <td ng-if="x.status == 1" style="line-height: 2px; padding: 10px; color: rgb(92, 184, 92);">
                    <span class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary basic-role" data-toggle="modal"
                                data-target="#basicDetail"
                                ng-click="check_basic_role(x.name)">点击查看</button>
                        <button type="button" class="btn btn-sm btn-danger basic-role" ng-if="x.is_two"
                                data-toggle="modal"
                                data-target="#move_menu"
                                ng-click="remove_menu(x.name, x.id)">调换菜单</button>
                        <button type="button" class="btn btn-sm btn-warning basic-role" data-toggle="modal"
                                data-target="#modify_per_module" ng-click="modify_per_module_click(x.id)">修改模块</button>
                    </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?= $this->render('@backend/rbac/views/main/add_menu.php') ?> <!--新增菜单-->
    <?= $this->render('@backend/rbac/views/main/modify_menu.php') ?> <!--未添加权限:修改模块-->
    <?= $this->render('@backend/rbac/views/main/basic_detail.php') ?> <!--查看基础角色-->
    <?= $this->render('@backend/rbac/views/main/move_menu.php') ?> <!--调换菜单-->
    <?= $this->render('@backend/rbac/views/main/modify_per.php') ?> <!--已添加权限:修改模块-->
</div>
<?= $this->render('@backend/rbac/views/loading.php') ?> <!--加载遮罩框-->

