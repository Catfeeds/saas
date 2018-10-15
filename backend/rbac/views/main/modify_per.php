<div id="modify_per_module" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">修改模块</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="c"><b style="color: red;">*</b>模块名:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="modify_per_module" ng-model="modify_per_module" class="form-control"
                                   autocomplete="off" placeholder="请输入模块名"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modify_per_route" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>路&emsp;由:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="modify_per_route" ng-model="modify_per_route" class="form-control"
                                   autocomplete="off" placeholder="请输入路由"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="modify_per_icon">图&emsp;标:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="modify_per_icon" ng-model="modify_per_icon" class="form-control"
                                   autocomplete="off" placeholder="请输入图标"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="modify_per_desc"><b style="color: red;">*</b>描&emsp;述:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="modify_per_desc" ng-model="modify_per_desc" class="form-control"
                                   autocomplete="off" placeholder="请输入描述"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="modify_per_response"><b style="color: red;">*</b>响&emsp;应:</label>
                        <div class="col-md-10 col-lg-10">
                            <select id="modify_per_response">
                                <option value="" selected="selected" disabled="disabled">请选择数据类型</option>
                                <option value="1">HTML</option>
                                <option value="2">JSON</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" ng-click="modify_per_module_submit()">确认</button>
            </div>
        </div>
    </div>
</div>