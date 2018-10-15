<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 15:48
 */
-->
<!--新增顶级分类-->
<div class="modal fade" tabindex="-1" role="dialog" id="addParentModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">新增顶级分类</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 text-right">
                        <span class="red LH30">*</span>分类名称
                    </div>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" placeholder="请输入分类名称" ng-model="parentClassifyName" id="parentClassifyName">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="addParentSuccess()">确定</button>
            </div>
        </div>
    </div>
</div>