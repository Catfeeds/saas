<div id="check_user_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">查看用户</h4>
            </div>
            <div class="modal-body">
                <div style="height: 450px; overflow-y: auto;">
                    <table class="table" style="border-bottom: 1px solid #e7eaec;">
                        <tr>
                            <th style="line-height: 2px; padding: 11px;"><span class="glyphicon glyphicon-user"
                                                                               aria-hidden="true"></span><b>&nbsp;用户</b>
                            </th>
                            <th style="line-height: 2px; padding: 11px;"><span class="glyphicon glyphicon-hourglass"
                                                                               aria-hidden="true"></span><b>&nbsp;操作</b>
                            </th>
                        </tr>
                        <tr class="CP-parent" ng-repeat="item in assign_users">
                            <td style="line-height: 2px; padding: 11px;">
                                {{item.username}}
                            </td>
                            <td style="line-height: 2px; padding: 11px;">
                                <span class="label label-default CP"
                                      ng-click="del_user(item.child_id, item.user_id, role_id)">删除</span>
                            </td>
                        </tr>
                    </table>
                    <?= $this->render('@backend/rbac/views/no_data.php', ['name' => 'user_no_data']); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>