<?php
use backend\assets\ClassTemplateAsset;
ClassTemplateAsset::register($this);
$this->title = '自定义课程模板';
/**
 * 私教管理 - 课程模板 - 自定义课程模板
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="customTemplateMain" ng-controller="customTemplateCtrl" ng-cloak>
    <div class="panel panel-default" style="border:none">
        <div class="panel-body">
            <a href="/class-template/index" class="mR10"><span><</span>返回</a>
            <span>自定义模板</span>
        </div>
    </div>
    <div class="row mr0">
        <div class="col-md-12">
            <div class="templateBig col-lg-7 col-md-11 pd0 ">
                <!--没有设置自定义模板-->
                <div class="col-md-12 templateDiv fl mB10 pd0 pd20" ng-if="customList.length == 0">
                    <div class="col-lg-2 col-md-2">
                        <span class="red lH30">*</span>训练阶段
                    </div>
                    <div class="col-lg-8 col-md-10 pd0">
                        <div class="col-md-12 pd0 mB10 stageNameDiv">
                            <div class="col-md-1 pd0 w60">
                                <span class="red lH30">*</span>阶段名称
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control stageName" placeholder="请输入阶段名称">
                            </div>
                        </div>
                        <div class="col-md-12 pd0 stageTimeDiv">
                            <div class="col-md-1 pd0 lH30 w60">
                                <span class="white lH30">*</span>建议时长
                            </div>
                            <div class="col-md-5">
                                <input type="number" inputnum min="1" class="form-control stageTime" placeholder="分钟">
                            </div>
                        </div>
                    </div>
                </div>
                <!--已经设置过自定义模板-->
                <div class="col-md-12 templateDiv fl mB10 pd0 pd20 removeCustom" ng-if="customList.length > 0" ng-repeat="($index,i) in customList">
                    <div class="col-lg-2 col-md-2">
                        <span class="red lH30">*</span>训练阶段
                    </div>
                    <div class="col-lg-8 col-md-10 pd0">
                        <div class="col-md-12 pd0 mB10 stageNameDiv">
                            <div class="col-md-1 pd0 w60">
                                <span class="red lH30">*</span>阶段名称
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control stageName" placeholder="请输入阶段名称" value="{{i.title}}">
                            </div>
                        </div>
                        <div class="col-md-12 pd0 stageTimeDiv">
                            <div class="col-md-1 pd0 lH30 w60">
                                <span class="white lH30">*</span>建议时长
                            </div>
                            <div class="col-md-5">
                                <input type="text" inputnum min="1" class="form-control stageTime" placeholder="分钟" value="{{i.length_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-right" ng-if="$index != 0">
                        <button class="btn btn-default w100 removeHtml" data-remove="removeCustom">删除</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 addCustomBtnDiv pd0">
                <button class="btn btn-info w100" venuehtml ng-click="addCustomDiv()" id="addCustomBtn">添加</button>
                <span>说明：至少设置一项内容</span>
            </div>
        </div>
    </div>
    <div class="row mr0 mT20">
        <div class="col-md-3 col-md-offset-2 pd0">
            <button class="btn btn-success w100 midA" ng-click="submitBtn()">保存</button>
            <button class="btn btn-default w100" ng-click="cancelBtn()">取消</button>
        </div>
    </div>
</div>
