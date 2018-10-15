<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4 0004
 * Time: 9:33
 */
 -->
<!--模板模态框-->
<div class="modal" id="maintainEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title text-center" id="myModalLabel" style="font-weight: 600">模板</h2>
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-success" data-toggle="modal" ng-click="addFitness()">新增健身目标</button>
                        <button type="button" class="btn btn-success" data-toggle="modal" ng-click="addDiet()">新增饮食计划</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-sm-2">类型</th>
                            <th class="col-sm-2">名称</th>
                            <th class="col-sm-6">内容</th>
                            <th class="col-sm-2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="i in templates">
                            <td ng-if="i.type == '1' || i.type == 1">健身目标</td>
                            <td ng-if="i.type == '2' || i.type == 2">饮食计划</td>
                            <td>{{i.name}}</td>
                            <td class="tdHh">{{i.content}}</td>
                            <td>
                                <button type="button" class="btn btn-danger" ng-click="removeTem(i.id)">删除</button>
                                <button type="button" class="btn btn-warning" ng-click="tap(i.type,i.id,i.name,i.content)">修改</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?=$this->render('@app/views/common/nodata.php',['name'=>'templateNoData','text'=>'暂无数据','href'=>true]);?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
            </div>
        </div>
    </div>
</div>