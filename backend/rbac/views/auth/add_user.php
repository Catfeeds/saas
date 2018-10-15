<div id="user_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">分配用户</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="high_role_label"><b
                                    style="color: red;">*</b>高级角色:</label>
                        <div class="col-md-8 col-lg-8">
                            <input type="hidden" value="{{high_role_id}}">
                            <input type="text" id="high_role_label" ng-disabled="is_disabled_role" ng-model="high_role_name"
                                   class="form-control"/>
                        </div>
                        <button type="button" ng-show="is_show_modify" ng-click="modifyRoleName()" class="btn btn-default btn-sm">修改</button>
                        <button type="button" ng-show="is_show_save" ng-click="saveRoleName(high_role_id, high_role_name)" class="btn btn-info btn-sm">保存</button>
                    </div>
                    <div class="form-group">
                        <label for="user_company_label" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>选择公司:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="user_company_label">
                                <option value="" selected disabled="disabled">请选择公司</option>
                                <option value="{{company.id}}" ng-repeat="company in companies">{{company.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_label" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>选择用户:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" multiple id="user_label">
                                <option value="{{user.id}}" ng-repeat="user in users">{{user.username}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="assign_user()">确认</button>
            </div>
        </div>
    </div>
</div>
