<div id="add_permission" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">新增权限</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="old_role" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>角&emsp;&emsp;色</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" class="form-control" disabled="disabled" value="{{add_role_name}}"
                                   id="old_role" placeholder="角色">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="option_menu" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>选择菜单</label>
                        <div class="col-md-10 col-lg-10">
                            <select id="option_menu">
                                <option value="" selected="selected" disabled="disabled">请选择菜单</option>
                                <option value="{{item.id}}" ng-repeat="item in add_per_data">{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="new_add_per(add_role_id)">确认</button>
            </div>
        </div>
    </div>
</div>