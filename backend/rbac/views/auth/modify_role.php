<div id="modify-role" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">修改角色</h4>
            </div>
            <div class="modal-body MTPT0">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="modify_name_label"><b style="color: red;">*</b>角色名:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="modify_name_label" ng-model="modify_role_name" class="form-control"
                                   autocomplete="off" placeholder="请输入角色名"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modify_company_label" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>公&emsp;司:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="modify_company_label">
                                <option value="" selected disabled="disabled">请选择公司</option>
                                <option value="{{company.id}}" ng-repeat="company in companies">{{company.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="modify_roles_label"><b
                                    style="color: red;">*</b>派&emsp;生:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="modify_roles_label" ng-disabled="is_derive_disabled">
                                <option value="" selected disabled="disabled">请选择角色</option>
                                <option value="0">顶级角色</option>
                                <option ng-if="modify_role_id !== item.id" value="{{item.id}}" ng-repeat="item in optionItems">
                                    {{item.prefix + item.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="saveModifyRole(modify_role_id)">保存</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>