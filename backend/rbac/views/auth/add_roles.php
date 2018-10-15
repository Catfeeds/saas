<div id="rolesModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">新增高级角色</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="name_label"><b style="color: red;">*</b>角色名:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="name_label" ng-model="role_name" class="form-control"
                                   autocomplete="off" placeholder="请输入角色名"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_label" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>公&emsp;司:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="company_label">
                                <option value="" selected disabled="disabled">请选择公司</option>
                                <option value="{{company.id}}" ng-repeat="company in companies">{{company.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="roles_label"><b
                                    style="color: red;">*</b>派&emsp;生:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="roles_label">
                                <option value="" selected disabled="disabled">请选择角色</option>
                                <option value="0">顶级角色</option>
                                <option value="{{item.id}}" ng-repeat="item in optionItems">
                                    {{item.prefix + item.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="venue_label" class="col-lg-2 col-md-2 control-label"><b
                                    style="color: red;">*</b>场&emsp;馆:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" multiple id="venue_label">
                                <option value="{{venue.id}}" ng-repeat="venue in venues">{{venue.name}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="submit()">确认</button>
            </div>
        </div>
    </div>
</div>
