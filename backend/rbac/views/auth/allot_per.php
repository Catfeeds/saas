<div id="detail" class="col-md-12 col-lg-12 detail"
     style="padding-left: 0; height: 780px; overflow: auto; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; border-left: 1px solid #ddd;">
    <table class="table" style="border-bottom: 1px solid #e7eaec;">
        <tr>
            <th style="text-align: left; line-height: 2px; padding: 8px;"><span
                        class="glyphicon glyphicon-th"></span><b>&nbsp;模块</b></th>
            <th class="allot-per" ng-init="is_bool = false" ng-click="is_check(is_bool)"
                style="line-height: 2px; padding: 8px;">
                <span class="glyphicon glyphicon-ok-sign"></span><b>&nbsp;全选/反选</b>&nbsp;
            </th>
        </tr>
        <tr class="CP-parent" style="cursor: pointer" ng-click="check_one(per.id, per.is_checked)"
            ng-repeat="per in permissions">
            <td style="text-align: left;line-height: 2px; padding: 8px;">
                <span ng-if="per.pid == 0" style="font-weight: bold;">
                    <span class="prefix" ng-bind-html="per.prefix | html_filter"></span>
                    {{per.name}}
                </span>
                <span ng-if="per.pid != 0">
                    <span class="prefix" ng-bind-html="per.prefix | html_filter"></span>
                    {{per.name}}
                </span>
            </td>
            <td style="line-height: 2px; padding: 8px;">
                <input title="请选择模块" type="checkbox" ng-checked="per.is_checked"/>
            </td>
        </tr>
    </table>
</div>