<div id="check_per" class="col-md-12 col-lg-12 detail"
     style="padding-left: 0; height: 780px; overflow: auto; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; border-left: 1px solid #ddd;">
    <table class="table" style="border-bottom: 1px solid #e7eaec;">
        <tr>
            <th style="text-align: left; line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-lock"
                                                                                 aria-hidden="true"></span><b>&nbsp;权限</b>
            </th>
            <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-hourglass"
                                                               aria-hidden="true"></span><b>&nbsp;操作</b></th>
        </tr>
        <tr class="CP-parent" style="cursor: pointer" ng-repeat="check_per in check_per_data">
            <td style="text-align: left; line-height: 2px; padding: 10px; color: #245580;">
                <span ng-if="check_per.pid == 0" style="font-weight: bold;">
                    <span class="prefix" ng-bind-html="check_per.prefix | html_filter"></span>
                    {{check_per.name}}
                </span>
                <span ng-if="check_per.pid != 0">
                    <span class="prefix" ng-bind-html="check_per.prefix | html_filter"></span>
                    {{check_per.name}}
                </span>
            </td>
            <td style="line-height: 2px; padding: 10px;">
                <span class="label label-default CP"
                      ng-click="del_role_per(check_per.name, check_per_role, check_role_name)">删除</span>
            </td>
        </tr>
    </table>
</div>