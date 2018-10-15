<?php
use backend\assets\ClassTemplateAsset;
ClassTemplateAsset::register($this);
$this->title = '课程模板';
/**
 * 私教管理 - 课程模板 - 课程模板列表
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="classTemplateMain" ng-controller="classTemplateCtrl" ng-cloak>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>课程模板</h4>
        </div>
        <div class="panel-body">
            <div class="row mr0 mB10 text-right">
                <a href="/class-template/add-template" class="btn btn-info">新增模板</a>
                <a href="/class-template/custom-template" class="btn btn-default">自定义模板</a>
            </div>
            <div class="row mr0">
                <div class="col-md-2">
                    <select class="form-control" id="searchType" ng-model="searchType">
                        <option value="">请选择模板分类</option>
                        <option value="{{w.id}}" ng-repeat="w in classifyList">{{w.title}}</option>
                    </select>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <div class="input-group">
                        <input type="text" class="form-control h34" placeholder="请输入模板名称..." ng-model="searchKeywords" ng-keydown="enterSearch()">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" ng-click="searchBtn()">搜索</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-default" ng-click="clearBtn()">清空</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><h4>模板列表</h4></div>
        <!-- Table -->
        <table class="table">
            <thead>
            <tr>
                <th>模板名称</th>
                <th>模板描述</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="i in templateList">
                <td>{{i.title}}</td>
                <td>{{i.describe | noData:''}}</td>
                <td>
                    <a href="" class="aHover mR10" ng-click="detailBtn(i.id)">详情</a>
                    <a href="" class="aHover mR10" ng-click="updateTemplate(i.id)">编辑</a>
                    <a href="" class="aHover mR10" ng-click="copyBtn(i.id,i.title)">复制</a>
                    <a href="" class="aHover" ng-click="deleteOne(i.id)">删除</a>
                </td>
            </tr>
            </tbody>
        </table>
        <?=$this->render('@app/views/common/nodata.php',['name'=>'templateNoData','text'=>'暂无数据','href'=>true]);?>
        <?=$this->render('@app/views/common/pagination.php',['page'=>'templatePage']);?>
    </div>
    <!--复制模板模态框-->
    <?=$this->render('@app/views/class-template/copyModal.php');?>
    <!--模板详情模态框-->
    <?=$this->render('@app/views/class-template/detailModal.php');?>
</div>

