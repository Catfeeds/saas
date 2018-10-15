<?php
use backend\assets\ClassTemplateAsset;
ClassTemplateAsset::register($this);
$this->title = '课程模板';
/**
 * 私教管理 - 课程模板 - 新增课程模板
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="addTemplateMain" ng-controller="addTemplateCtrl" ng-cloak>
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="/class-template/index" class="mR10"><span><</span>返回</a>
            <span>新增模板</span>
        </div>
    </div>
    <div class="row mr0">
        <div class="col-md-12 mB10">
            <div class="col-md-1 text-right pd0">
                <span class="red lH30">*</span>模板名称
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" ng-model="fileName" placeholder="请输入名称，最多10位">
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-md-1 text-right pd0 lH30">
               模板描述
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="请输入描述，最多30位" ng-model="describe">
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-1 text-right pd0">
                <span class="red">*</span>训练计划
            </div>
            <div class="templateBig col-lg-7 col-md-11 mB10">
                <div class="col-md-12 templateDiv fl mB10 pd0">
                    <div class="col-lg-2 col-md-2 mT10">
                        <span class="red lH30">*</span>训练阶段
                    </div>
                    <div class="col-lg-8 col-md-10 pd0">
                        <div class="col-md-12 pd0 mB10 mT10 stageNameDiv">
                            <div class="col-md-1 pd0 w60">
                                <span class="red lH30">*</span>阶段名称
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control stageName" placeholder="请输入阶段名称">
                            </div>
                        </div>
                        <div class="col-md-12 pd0 mB10 stageTimeDiv">
                            <div class="col-md-1 pd0 lH30 w60">
                                <span class="white lH30">*</span>训练时长
                            </div>
                            <div class="col-md-5">
                                <input type="number" inputnum min="1" class="form-control stageTime" placeholder="分钟">
                            </div>
                        </div>
                        <div class="col-md-12 pd0 mB10">
                            <div class="col-md-1 pd0 w60">
                                <span class="white">*</span>训练内容
                            </div>
                            <div class="col-lg-8 col-md-8 mL15 pd0 drillDiv" style="border:1px solid #c0bfc4">
                                <div class="row mr0 oneDrill">
                                    <div class="col-md-12 mB10 mT10">
                                        <div class="fl lH30 w60 text-right"><span class="red lH30">*</span>动作</div>
                                        <div class="fl mL15">
                                            <select class="form-control selectStyle w178 chooseSelect">
                                                <option value="">请选择动作</option>
                                                <option value="{{i.id}}" ng-repeat="i in actionListData">{{i.title}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mB10">
                                        <div class="fl lH30 w60 text-right">数量</div>
                                        <div class="fl mL15">
                                            <input type="number" inputnum min="1" class="form-control setNum" placeholder="组数或分钟">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mT10 btnDiv">
                                <div class="col-md-1 pd0 w60"></div>
                                <button class="btn btn-default w100" venuehtml ng-click="addDrill()" id="addDrillBtn">添加</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 addTemplateBtnDiv">
                <div class="col-md-1 pd0" style="height: 30px;"></div>
                <button class="btn btn-info w100" venuehtml ng-click="addTemplateDiv()" id="addTemplateBtn">添加</button>
                <span>说明：至少设置一项内容</span>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-md-3 pd0">
                <div class="col-md-4 text-right pd0 lH30">
                    模板分类
                </div>
                <div class="col-md-8">
                    <select class="form-control" id="chooseType" ng-model="chooseType">
                        <option value="">请选择</option>
                        <option value="{{w.id}}" ng-repeat="w in classifyList">{{w.title}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 lH30">
                <a href="" class="aHover" ng-click="addClassifyBtn()">添加</a>
                <span>|</span>
                <a href="" class="aHover" ng-click="deleteClassifyBtn(chooseType)">删除选中</a>
            </div>
        </div>
    </div>
    <div class="row mr0 mT10">
        <div class="col-md-12 mB10">
            <div class="col-md-3 pd0">
                <div class="col-md-4 text-right pd0 lH30" style="height: 30px;"></div>
                <div class="col-md-8">
                    <button class="btn btn-success w100" ng-click="submitBtn()">保存</button>
                    <button class="btn btn-default w100" ng-click="cancelBtn()">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!--添加模板分类模态框-->
    <?=$this->render('@app/views/class-template/addClassifyModal.php');?>
</div>

