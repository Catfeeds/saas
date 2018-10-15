<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/17 0017
 * Time: 19:33
 */
-->
<!--动作详情-->
<div class="modal fade" tabindex="-1" role="dialog" id="updateTypeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改分类</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" ng-repeat="w in modalMenuList">
                        <div class="col-md-6 col-md-offset-3 mB10">
                            <div class="col-md-4 pd0 text-right pL20 LH30">{{w.title}}</div>
                            <div class="col-md-8 pd0 selectModal">
                                <select class="form-control selectStyle chooseSelect updateSelect">
                                    <option value="">请选择类型</option>
                                    <option value="{{c.id}}" ng-repeat="c in w.children">{{c.title}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
                <button type="button" class="btn btn-success" style="width: 100px;" ng-click="updateSuccessBtn()">完成</button>
            </div>
        </div>
    </div>
</div>