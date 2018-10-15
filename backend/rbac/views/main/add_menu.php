<div id="developModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">新增模块</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="module-label"><b
                                    style="color: red;">*</b>模块名:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="module-label" ng-model="module_name" class="form-control"
                                   autocomplete="off" placeholder="请输入模块名"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="route-label" class="col-md-2 col-lg-2 control-label"><b
                                    style="color: red;">*</b>路&emsp;由:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="route-label" ng-model="route_name" class="form-control"
                                   autocomplete="off" placeholder="请输入路由"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="icon-label">图&emsp;标:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="icon-label" ng-model="module_icon" class="form-control" autocomplete="off"
                                   placeholder="请输入图标"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="desc-label"><b
                                    style="color: red;">*</b>描&emsp;述:</label>
                        <div class="col-md-10 col-lg-10">
                            <input type="text" id="desc-label" ng-model="desc" class="form-control" autocomplete="off"
                                   placeholder="请输入描述"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-lg-2 control-label" for="response-label"><b style="color: red;">*</b>响&emsp;应:</label>
                        <div class="col-md-10 col-lg-10">
                            <select id="response-label">
                                <option value="" disabled selected>请选择数据类型</option>
                                <option value="1">HTML</option>
                                <option value="2">JSON</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select-menu" class="col-md-2 col-lg-2 control-label"><b
                                    style="color: red;">*</b>类&emsp;别:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" id="select-menu">
                                <option value="" selected disabled="disabled">请选择模块</option>
                                <option value="0">顶级模块</option>
                                <option value="{{item.id}}" ng-repeat="item in option_modules">
                                    {{item.prefix + item.name}}
                                </option>
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