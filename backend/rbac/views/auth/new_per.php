<div id="new_permission" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">选择权限</h4>
            </div>
            <div class="modal-body">
                <div style="height: 450px; overflow-y: auto;">
                    <table class="table" style="border-bottom: 1px solid #e7eaec;">
                        <tr>
                            <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                        class="glyphicon glyphicon-lock" aria-hidden="true"></span><b>&nbsp;权限</b></th>
                            <th style="line-height: 2px; padding: 10px; cursor: pointer;" ng-init="is_new_bool = false"
                                ng-click="is_select(is_new_bool)">
                                <span class="glyphicon glyphicon-ok-sign"></span><b>&nbsp;全选/反选</b>&nbsp;
                            </th>
                        </tr>
                        <tr style="cursor: pointer" class="CP-parent {{per.is_disabled == true ? 'new-per-box' : ''}}"
                            ng-click="select_one(per.id, per.isSelect)" ng-repeat="per in select_pers">
                            <td style="text-align: left; line-height: 2px; padding: 8px; color: #245580;">
                                <span class="prefix" ng-bind-html="per.prefix | html_filter"></span>
                                {{per.name}}
                            </td>
                            <td style="line-height: 2px; padding: 8px;">
                                <input class="new_per_box" type="checkbox" ng-disabled="per.is_disabled"
                                       ng-checked="per.isSelect" title="请选择模块"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="save_pers(select_per_role)">确认</button>
            </div>
        </div>
    </div>
</div>