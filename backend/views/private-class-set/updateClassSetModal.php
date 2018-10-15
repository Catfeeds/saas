<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/28 0028
 * Time: 10:21
 */
-->
<!--修改课程内容设置模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="updateClassSetModal">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pd0 mB10">
                        <div class="col-lg-2 text-right pd0 lH30">
                           <span class="red">*</span>选择课种
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control" id="updateChooseClass" ng-model="updateChooseClass">
                                <option value="">请选择</option>
                                <option value="{{w.id}}" ng-repeat="w in updateCourseList">{{w.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 pd0 mB10" id="updateModalMain">
                        <div class="col-lg-2 text-right pd0">
                            <span class="red">*</span>内容
                        </div>
                        <div class="col-lg-8 modalMainDiv">
                            <div class="row mr0 modalMain mB10 removeMainDiv" ng-repeat="($index,i) in updateQuestion">
                                <div class="col-md-12 mB10 pd0">
                                    <div class="col-lg-2 text-right pd0 lH30">
                                        <span class="red">*</span>类别
                                    </div>
                                    <div class="col-lg-8">
                                        <select class="form-control selectStyle chooseSelect updateSelect" ng-model="chooseType">
                                            <option value="">请选择</option>
                                            <option value="3">单选</option>
                                            <option value="2">多选</option>
                                            <option value="1">自定义答案</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mB10 pd0">
                                    <div class="col-lg-2 text-right pd0 lH30">
                                        <span class="red">*</span>问题
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control question" placeholder="请输入问题" value="{{i.title}}">
                                    </div>
                                </div>
                                <div class="col-md-12 pd0 choiceDiv" ng-if="chooseType != 1 && i.option != undefined" ng-repeat="($index,w) in i.option">
                                    <div class="row mr0 mB10 choice removeChoiceDiv">
                                        <div class="col-lg-2 text-right pd0 lH30">
                                            <span class="red">*</span>选项
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control choiceInput" placeholder="请输入选项" value="{{w}}">
                                        </div>
                                        <div class="col-lg-2 pd0" ng-if="$index != 0 && $index != 1">
                                            <button class="btn btn-default pd4 removeHtml" data-remove="removeChoiceDiv">删除</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-lg-offset-2 mB10 addChoiceDiv" ng-if="chooseType != 1 && i.option != undefined">
                                    <button class="btn btn-default w100" ng-click="addChoice()" id="addChoiceBtn" venuehtml>添加</button>
                                    <span>说明：至少有2个选项</span>
                                </div>
                                <div class="col-md-12 pd0 choiceDiv" ng-if="chooseType != 1 && i.option == undefined">
                                    <div class="row mr0 mB10 choice">
                                        <div class="col-lg-2 text-right pd0 lH30">
                                            <span class="red">*</span>选项
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control choiceInput" placeholder="请输入选项，最多6个字">
                                        </div>
                                    </div>
                                    <div class="row mr0 mB10 choice">
                                        <div class="col-lg-2 text-right pd0 lH30">
                                            <span class="red">*</span>选项
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control choiceInput" placeholder="请输入选项，最多6个字">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-lg-offset-2 mB10 addChoiceDiv" ng-if="chooseType != 1 && i.option == undefined">
                                    <button class="btn btn-default w100" ng-click="addChoice()" id="addChoiceBtn" venuehtml>添加</button>
                                    <span>说明：至少有2个选项</span>
                                </div>
                                <div class="col-lg-12 pd0 text-right" ng-if="$index != 0">
                                    <button class="btn btn-default w100 removeHtml" data-remove="removeMainDiv">删除</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-lg-offset-2 addMainDiv">
                            <button class="btn btn-info w100" ng-click="addMain()" id="addMainBtn" venuehtml>添加</button>
                            <span>说明：至少有1项内容</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="updateSuccessBtn()">完成</button>
            </div>
        </div>
    </div>
</div>