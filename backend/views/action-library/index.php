<?php
use backend\assets\ActionLibraryAsset;
ActionLibraryAsset::register($this);
$this->title = '动作库';
/**
 * 私教管理 - 动作库 -添加动作
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="actionLibraryContent" ng-controller="actionLibraryCtrl" ng-cloak>
    <div class="row" style="height: 100%">
        <div class="col-lg-2 col-md-4 pR0" style="height: 100%;">
            <div class="col-md-12 pR0 mT10">
                <p>更新时间</p>
                <div class="col-md-12" style="padding-left: 0">
                    <div class="input-group" style="width: 100%">
                        <input type="text" readonly name="actionDate" id="actionDate" class="form-control text-center h34" style="width: 100%;height: 30px;">
                    </div>
                </div>
            </div>
            <div class="col-md-12 pR0 mT10">
                <p>类型</p>
                <ul class="list typeList">
                    <li class="text-center sp" value="1">有氧训练</li>
                    <li class="text-center sp" value="2">重量训练</li>
                    <li class="text-center sp" value="0">其他</li>
                </ul>
            </div>
            <div class="col-md-12 pR0 mT10 clickDiv" ng-repeat="($index,i) in leftMenuList">
                <p>{{i.title}}</p>
                <ul class="list fixationList">
                    <li class="text-center sp liDiv" value="{{w.id}}" ng-repeat="w in i.children" ng-click="ccc($index,$event)">{{w.title}}</li>
                </ul>
            </div>
            <div class="col-md-12 pR0 mT10">
                <button class="btn btn-success fL" style="margin-right: 8px;width: 100px"  ng-click="sureFilterBtn()">确认</button>
                <button class="btn btn-default fR" style="margin-right: 18px;width: 100px"  ng-click="clearFilterBtn()">清空</button>
            </div>
        </div>
        <div class="col-lg-10 col-md-8" style="border-left: 1px solid #cccccc;height: 100%;padding-left: 0">
            <div class="panel panel-default">
                <div class="panel-heading text-right">
                    <a class="btn btn-info" href="/action-library/create">生成动作</a>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-2">
                        <div class="input-group">
                            <input type="text" class="form-control h34" placeholder="请输入动作名称..." ng-model="searchKeywords" ng-keydown="enterSearch()">
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
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-default" ng-click="batchDeleteBtn()">批量删除</button>
                </div>

            </div>
            <div class="row mr0">
                <table class="table table-hover" style="border-top: 1px solid #ddd">
                    <thead>
                    <tr style="background-color: #f5f5f5">
                       <th>
                           <input type="checkbox" class="chooseOnePage" style="vertical-align: text-bottom;">
                           <span>选择本页</span>
                       </th>
                       <th>动作名称</th>
                       <th>更新时间</th>
                       <th>类型</th>
                       <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="list in actionList">
                        <td class="memberChooseTransfer">
                            <input type="checkbox" data-choose="{{list.id}}">
                        </td>
                        <td>{{list.title}}</td>
                        <td>{{list.updated_at * 1000 | date:'yyyy-MM-dd'}}</td>
                        <td>
                            <span ng-if="list.type == 0">其他</span>
                            <span ng-if="list.type == 1">有氧训练</span>
                            <span ng-if="list.type == 2">重量训练</span>
                        </td>
                        <td>
                            <a href="" class="tabA mR10" ng-click="detailBtn(list.id)">详情</a>
                            <a href="" class="tabA mR10" ng-click="updateBtn(list.id)">编辑</a>
                            <a href="" class="tabA mR10" ng-click="updateTypeBtn(list.id,list)">修改分类</a>
                            <a href="" class="tabA mR10" ng-click="deleteActionBtn(list.id)">删除</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?=$this->render('@app/views/common/nodata.php',['name'=>'actionNoData','text'=>'暂无数据','href'=>true]);?>
                <?=$this->render('@app/views/common/pagination.php',['page'=>'actionPage']);?>
            </div>

        </div>
    </div>

    <!--详情模态框-->
    <?=$this->render('@app/views/action-library/actionDetailModal.php');?>
    <!--修改分类模态框-->
    <?=$this->render('@app/views/action-library/updateTypeModal.php');?>
</div>
