<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 17:33
 */
-->
<!--修改病史模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="updateHistoryModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改</h4>
            </div>
            <div class="modal-body pd50">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2  pd0">
                        <div class="col-lg-2 text-right pd0 lH30">
                            <span class="red">*</span>项目名称
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" ng-model="updateHistoryName" placeholder="请输入名称，最多6个字">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="updateHistorySuccess()">完成</button>
            </div>
        </div>
    </div>
</div>
