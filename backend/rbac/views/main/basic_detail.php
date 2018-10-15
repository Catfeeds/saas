<div id="basicDetail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: white;">
                        <b>角色</b>
                        <br/>
                        <i class="glyphicon glyphicon-info-sign" style="color: #245580; font-size: 8px;">拥有此权限的角色</i>
                    </div>
                    <div class="panel-body" style="height: 255px; overflow-y: auto;">
                        <table class="table" style="border-bottom: 1px solid #e7eaec;">
                            <tr>
                                <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-user"
                                                                                   aria-hidden="true"></span><b>&nbsp;角色</b>
                                </th>
                                <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-apple"
                                                                                   aria-hidden="true"></span><b>&nbsp;公司</b>
                                </th>
                            </tr>
                            <tr class="CP-parent" ng-repeat="role_item in role_data">
                                <td style="line-height: 2px; padding: 15px;">{{role_item.role_name}}</td>
                                <td style="line-height: 2px; padding: 15px;">{{role_item.company_name}}</td>
                            </tr>
                        </table>
                        <?= $this->render('@backend/rbac/views/no_data.php', ['name' => 'role_no_data']); ?>
                    </div>
                </div>
                <div class="panel panel-default" style="margin-bottom: -15px;">
                    <div class="panel-heading" style="background-color: white;">
                        <b>用户</b>
                        <br/>
                        <i class="glyphicon glyphicon-info-sign" style="color: #245580; font-size: 8px;">拥有此权限的用户</i>
                    </div>
                    <div class="panel-body" style="height: 255px; overflow-y: auto;">
                        <table class="table" style="border-bottom: 1px solid #e7eaec;">
                            <tr>
                                <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-user"
                                                                                   aria-hidden="true"></span><b>&nbsp;用户</b>
                                </th>
                                <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-apple"
                                                                                   aria-hidden="true"></span><b>&nbsp;公司</b>
                                </th>
                            </tr>
                            <tr class="CP-parent" ng-repeat="user_item in user_data">
                                <td style="line-height: 2px; padding: 15px;">{{user_item.username}}</td>
                                <td style="line-height: 2px; padding: 15px;">{{user_item.company_name}}</td>
                            </tr>
                        </table>
                        <?= $this->render('@backend/rbac/views/no_data.php', ['name' => 'user_no_data']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>