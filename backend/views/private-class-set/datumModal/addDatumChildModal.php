<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/29 0029
 * Time: 15:08
 */
-->
<!--体侧数据添加子级模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="addDatumChildModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">添加子内容</h4>
            </div>
            <div class="modal-body pd50">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 pd0 mB10">
                        <div class="col-lg-2 text-left pd0 lH30">
                            <span class="red">*</span>项目
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" ng-model="datumPro" placeholder="请输入名称，最多6个字">
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1 pd0 mB10">
                        <div class="col-lg-2 text-left pd0 lH30">
                            <span class="white">*</span>单位
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" ng-model="datumUnit" placeholder="请输入单位">
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1 pd0 mB10">
                        <div class="col-lg-2 text-left pd0 lH30">
                            <span class="white">*</span>正常范围
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control fl" style="width: 45%" ng-model="startInput" placeholder="范围">
                            <span class="fl lH30" style="width:10%;text-align: center ">至</span>
                            <input type="text" class="form-control fr" style="width: 45%" ng-model="endInput" placeholder="范围">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="addDatumChildSuccess()">完成</button>
            </div>
        </div>
    </div>
</div>
