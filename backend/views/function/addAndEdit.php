<!--
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/12/1
 * Time: 10:59
 *Content:
 */-->
<!--    新增功能-->
<div class="modal fade" id="addFunctionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel mColor">
                    新增功能
                </h3>
            </div>
            <div class="modal-body mrb193">
                <div class="col-sm-12 heightCenter">
                    <div class="col-sm-4 form-group text-right c153"><span class="red">*</span><b>功能名称</b></div>
                    <div class="col-sm-8 form-group text-center" style="">
                        <input type="text" value="" ng-model="addFunctionName" class="form-control actions" id=""
                               placeholder="请输入功能名称">
                    </div>
                </div>
                <div class="col-sm-12 heightCenter">
                    <div class="col-sm-4 form-group text-right c153"><b>英文名称</b></div>
                    <div class="col-sm-8 form-group text-center">
                        <input   type="text" value="" ng-model="addFunctionEnName" class="form-control actions" id=""
                                 placeholder="请输入英文功能名称">
                    </div>
                </div>
                <div class="col-sm-12 ">
                    <div class="col-sm-4 form-group text-right c153"><span class="red">*</span><b>功能描述</b></div>
                    <div class="col-sm-8 form-group text-center" style="">
                            <textarea placeholder="请输入功能描述,最多十五个字" style="resize: none;" maxlength="15" ng-model="addFunctionNote" class="form-control actions mrl0">
                </textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" ng-click="cancelAddFunction()" >取消
                </button>
                <button type="button" class="btn btn-success" ng-click="completeAddFunction()" >完成
                </button>
            </div>
        </div>
    </div>
</div>
<!--    修改功能-->
<div class="modal fade" id="updateFunctionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel c3517368">
                    修改功能
                </h3>
            </div>
            <div class="modal-body mrb193">
                <div class="col-sm-12 heightCenter">
                    <div class="col-sm-4 form-group text-right c153"><span class="red">*</span><b>功能名称</b></div>
                    <div class="col-sm-8 form-group text-center">
                        <input type="text" value="" ng-model="editFunctionName" class="form-control actions" id=""
                               placeholder="请输入功能名称">
                    </div>
                </div>
                <div class="col-sm-12 heightCenter">
                    <div class="col-sm-4 form-group text-right c153"><b>英文名称</b></div>
                    <div class="col-sm-8 form-group text-center" style="">
                        <input type="text" value="" ng-model="editFunctionEnName" class="form-control actions" id=""
                               placeholder="请输入英文功能名称">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-4 form-group text-right c153"><span class="red">*</span><b>功能描述</b></div>
                    <div class="col-sm-8 form-group">
                            <textarea placeholder="请输入功能描述,最多十五个字" style="resize: none;" maxlength="15" ng-model="editFunctionNote" class="form-control actions c153">
                            </textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning w15b" ng-click="cancelEditFunction()">取消
                </button>
                <button type="button" class="btn btn-success w15b" ng-click="completeEditFunction()">完成
                </button>
            </div>
        </div>
    </div>
</div>

