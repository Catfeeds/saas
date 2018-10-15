<div id="move_menu" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">调换菜单</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="move_two_module">二级菜单:</label>
                        <div class="col-md-8 col-lg-8">
                            <input type="text" id="move_two_module" class="form-control" ng-disabled="true"
                                   ng-model="move_module">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="move_one_module" class="col-md-2 col-lg-2 control-label"><b
                                    style="color: red;">*</b>一级菜单:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="move_one_module">
                                <option value="" selected="selected" disabled="disabled">请选择移动的菜单</option>
                                <option value="{{menu.id}}" ng-repeat="menu in top_menus">{{menu.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="submit_change()">确认调换</button>
            </div>
        </div>
    </div>
</div>
