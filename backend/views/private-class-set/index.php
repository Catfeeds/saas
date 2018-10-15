<?php
use backend\assets\PrivateClassSetAsset;
PrivateClassSetAsset::register($this);
$this->title = '设置';
/**
 * 私教管理 - 设置
 * @author zhujunzhe@itsports.club
 * @create 2018/5/28 am
 */
?>
<div class="setUpContent" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="headTab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs headUl" role="tablist">
            <li role="presentation" class="active">
                <a href="#classSet" aria-controls="classSet" role="tab" data-toggle="tab">课程内容</a>
            </li>
            <li role="presentation">
                <a href="#fileSet" aria-controls="fileSet" role="tab" data-toggle="tab">客户资料</a>
            </li>
            <li role="presentation">
                <a href="#followStatus" aria-controls="followStatus" role="tab" data-toggle="tab">跟进状态</a>
            </li>
            <li role="presentation">
                <a href="#followWay" aria-controls="followWay" role="tab" data-toggle="tab">跟进方式</a>
            </li>
            <li role="presentation">
                <a href="#source" aria-controls="source" role="tab" data-toggle="tab">私教来源</a>
            </li>
            <!--<li role="presentation">
                <a href="#client" aria-controls="client" role="tab" data-toggle="tab">客户分类</a>
            </li>-->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!--课程内容-->
            <div role="tabpanel" class="tab-pane active" id="classSet" ng-controller="classSetCtrl">
                <div class="panel panel-default mT20">
                    <div class="panel-heading">课前询问</div>
                    <div class="panel-body">
                        <div class="row">
                           <!-- <div class="col-md-1">
                                <input type="checkbox" class="fl w16">
                                <span class="fl" style="font-size: 16px">启用</span>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="fl w16">
                                <span class="fl" style="font-size: 16px">不启用</span>
                            </div>-->
                            <div class="col-md-2 col-md-offset-10">
                                <button class="btn btn-info" ng-click="addClassSet()">添加内容</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-3">
                                <div class="input-group">
                                    <input type="text" class="form-control h34" placeholder="请输入课种进行搜索..." ng-model="classKeywords" ng-keydown="classEnterSearch()">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button" ng-click="classSearchBtn()">搜索</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-default" ng-click="classClearBtn()">清空</button>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead class="classThead">
                        <tr>
                            <th>课种</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in classSetList">
                            <td>{{i.name}}</td>
                            <td>
                                <a href="" class="aHover" ng-click="detailBtn(i.id)">详情</a>
                                <a href="" class="aHover midA" ng-click="updateBtn(i.id)">修改</a>
                                <a href="" class="aHover" ng-click="deleteOneBtn(i.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'classSetNoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'classSetPage']);?>
                </div>
                <!--添加模态框-->
                <?=$this->render('@app/views/private-class-set/addClassSetModal.php');?>
                <!--详情模态框-->
                <?=$this->render('@app/views/private-class-set/classDetailModal.php');?>
                <!--修改模态框-->
                <?=$this->render('@app/views/private-class-set/updateClassSetModal.php');?>
            </div>
            <!--客户资料-->
            <div role="tabpanel" class="tab-pane" id="fileSet">
                <div class="fileTab mT20">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#qaContent" aria-controls="qaContent" role="tab" data-toggle="tab">健康问答</a>
                        </li>
                        <li role="presentation">
                            <a href="#goal" aria-controls="goal" role="tab" data-toggle="tab">健身目的</a>
                        </li>
                        <li role="presentation">
                            <a href="#assess" aria-controls="assess" role="tab" data-toggle="tab">体适能评估</a>
                        </li>
                        <li role="presentation">
                            <a href="#datum" aria-controls="datum" role="tab" data-toggle="tab">体测数据</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="qaContent" ng-controller="qaCtrl">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row mr0">
                                        <div class="col-md-2 lH30">病史</div>
                                        <div class="col-md-10 text-right">
                                            <button class="btn btn-info" ng-click="addHistory()">添加项目</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 50%">项目</th>
                                        <th style="width: 50%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="h in historyList">
                                        <td>
                                            <span>{{h.title}}</span>
                                        </td>
                                        <td>
                                            <a class="aHover" ng-click="updateHistory(h.id,h.title)">修改</a>
                                            <a class="aHover mL10" ng-click="deleteHistory(h.id)">删除</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'historyNoData','text'=>'暂无数据','href'=>true]);?>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row mr0">
                                        <div class="col-md-2 lH30">其他问题</div>
                                        <div class="col-md-10 text-right">
                                            <button class="btn btn-info" ng-click="addOther()">添加项目</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 50%">项目</th>
                                        <th style="width: 50%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="o in otherList">
                                        <td>
                                            <span>{{o.title}}</span>
                                        </td>
                                        <td>
                                            <a class="aHover" ng-click="updateOther(o.id,o.title)">修改</a>
                                            <a class="aHover mL10" ng-click="deleteOther(o.id)">删除</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'otherNoData','text'=>'暂无数据','href'=>true]);?>
                            </div>
                            <!--添加病史模态框-->
                            <?=$this->render('@app/views/private-class-set/qaModal/addHistoryModal.php');?>
                            <!--修改病史模态框-->
                            <?=$this->render('@app/views/private-class-set/qaModal/updateHistoryModal.php');?>
                            <!--添加其他问题模态框-->
                            <?=$this->render('@app/views/private-class-set/qaModal/addOtherModal.php');?>
                            <!--修改其他问题模态框-->
                            <?=$this->render('@app/views/private-class-set/qaModal/updateOtherModal.php');?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="goal" ng-controller="goalCtrl">
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="row mr0 text-right">
                                        <button class="btn btn-info" ng-click="addGoalBtn()">添加内容</button>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>目的</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="g in goalList">
                                        <td>
                                            <span>{{g.title}}</span>
                                        </td>
                                        <td>
                                            <a class="aHover" ng-click="updateGoal(g.id,g.title)">修改</a>
                                            <a class="aHover mL10" ng-click="deleteGoal(g.id)">删除</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'goalNoData','text'=>'暂无数据','href'=>true]);?>
                            </div>
                            <!--添加模态框-->
                            <?=$this->render('@app/views/private-class-set/goalModal/addGoalModal.php');?>
                            <!--修改模态框-->
                            <?=$this->render('@app/views/private-class-set/goalModal/updateGoalModal.php');?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="assess" ng-controller="assessCtrl">
                            <!--体能评估-->
                            <div class="panel panel-default mT20">
                                <div class="panel-heading">
                                    <!--<div class="row">
                                        <div class="col-md-1" style="padding-top: 6px;">
                                            <input type="checkbox" class="fl w16">
                                            <span class="fl" style="font-size: 16px">启用</span>
                                        </div>
                                        <div class="col-md-1" style="padding-top: 6px;">
                                            <input type="checkbox" class="fl w16">
                                            <span class="fl" style="font-size: 16px">不启用</span>
                                        </div>
                                    </div>-->
                                    <div class="row homePageSearch">
                                        <div class="col-md-2 mT10">
                                            <select class="form-control fileSelect" id="assessSelect" ng-model="assessSelect" ng-change="assessSelectChange(assessSelect)">
                                                <option value="" ng-if="assessTypeList.length == 0">暂无数据</option>
                                                <option value="{{i.id}}" ng-repeat="i in assessTypeList">{{i.title}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-10 mT10 lH30 pd0">
                                            <a  class="aHover" ng-click="addAssessBtn()">添加项目组</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" ng-if="assessTypeList.length != 0">
                                    <div class="row">
                                        <h4 class="col-md-9">
                                            {{assessParentList.title}}
                                            <span class="mL8" ng-click="updateAssessBtn(assessParentList.id,assessParentList.title)">
                                                <img src="/plugins/privateClassSet/img/update.png">
                                            </span>
                                            <span class="mL8" ng-click="deleteAssessBtn(assessParentList.id)">
                                                <img src="/plugins/privateClassSet/img/delete.png">
                                            </span>
                                        </h4>
                                        <div class="col-md-3">
                                            <a  class="aHover" ng-click="addAssessChildBtn(assessParentList.id)" ng-if="!showAssessSort">添加项目</a>
                                            <a  class="aHover mL10" ng-click="assessSortStart()" ng-if="!showAssessSort">修改排序</a>
                                            <a  class="aHover mL10" ng-click="cancelAssessSort()" ng-if="showAssessSort">取消排序</a>
                                            <a  class="aHover mL10" ng-click="assessSortEnd()" ng-if="showAssessSort">保存</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mr0">
                                    <ul class="list-group" style="margin-bottom: 0">
                                        <li class="list-group-item row mr0 fileLi firstLi">
                                            <span class="col-md-3 text-center">项目</span>
                                            <span class="col-md-2 text-center">单位</span>
                                            <span class="col-md-2 text-center">正常范围</span>
                                            <span class="col-md-2 text-center" ng-if="showAssessSort">排序</span>
                                            <span class="col-md-3 text-center">操作</span>
                                        </li>
                                    </ul>
                                    <ul  class="list-group" id="sortable{{assessParentList.id}}">
                                        <li ng-repeat="($index,w) in assessChildList" class="list-group-item row mr0 pd0" name="{{$index}}" value="{{w.id}}">
                                            <span class="col-md-3 text-center">{{w.title}}</span>
                                            <span class="col-md-2 text-center">{{w.unit | noData :''}}</span>
                                            <span class="col-md-2 text-center">{{w.normal_range | noData : ''}}</span>
                                            <span class="col-md-2 text-center" ng-if="showAssessSort">
                                                <img src="/plugins/privateClassSet/img/sort-3.png">
                                            </span>
                                            <span class="col-md-3 text-center">
                                                <a class="aHover" ng-click="assessChildDetail(w.id)">详情</a>
                                                <a class="mL10 aHover" ng-click="updateAssessChild(w.id)">修改</a>
                                                <a class="mL10 aHover" ng-click="deleteAssessChild(w.id)">删除</a>
                                            </span>
                                        </li>
                                    </ul>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'assessNoData','text'=>'暂无数据','href'=>true]);?>
                                </div>
                            </div>
                            <!--添加父级分类模态框-->
                            <?=$this->render('@app/views/private-class-set/assessModal/addAssessModal.php');?>
                            <!--添加子级分类模态框-->
                            <?=$this->render('@app/views/private-class-set/assessModal/addAssessChildModal.php');?>
                            <!--修改名称模态框-->
                            <?=$this->render('@app/views/private-class-set/assessModal/updateAssessModal.php');?>
                            <!--修改子类模态框-->
                            <?=$this->render('@app/views/private-class-set/assessModal/updateAssessChildModal.php');?>
                            <!--子类详情模态框-->
                            <?=$this->render('@app/views/private-class-set/assessModal/assessChildDetailModal.php');?>
                        </div>
                        <!--体侧数据-->
                        <div role="tabpanel" class="tab-pane" id="datum" ng-controller="fileSetCtrl">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h4>默认内容</h4></div>
                                <ul class="list-group" style="margin-bottom: 0">
                                    <li class="list-group-item row mr0 topLi">
                                        <span class="col-md-3 text-center">项目</span>
                                        <span class="col-md-2 text-center">单位</span>
                                        <span class="col-md-2 text-center">正常范围</span>
                                    </li>
                                    <li class="list-group-item row mr0 pd0">
                                        <span class="col-md-3 text-center">健康评估</span>
                                        <span class="col-md-2 text-center">分</span>
                                        <span class="col-md-2 text-center">0 ~ 100</span>
                                    </li>
                                    <li class="list-group-item row mr0 pd0">
                                        <span class="col-md-3 text-center">内脏脂肪等级</span>
                                        <span class="col-md-2 text-center">级</span>
                                        <span class="col-md-2 text-center">1 ~ 10</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel panel-default mT20">
                                <div class="panel-heading">
                                    <!--<div class="row">
                                        <div class="col-md-1" style="padding-top: 6px;">
                                            <input type="checkbox" class="fl w16">
                                            <span class="fl" style="font-size: 16px">启用</span>
                                        </div>
                                        <div class="col-md-1" style="padding-top: 6px;">
                                            <input type="checkbox" class="fl w16">
                                            <span class="fl" style="font-size: 16px">不启用</span>
                                        </div>
                                    </div>-->
                                    <div class="row homePageSearch">
                                        <div class="col-md-2 mT10">
                                            <select class="form-control fileSelect" id="datumSelect" ng-model="datumSelect" ng-change="datumSelectChange(datumSelect)">
                                                <option value="" ng-if="datumTypeList.length == 0">暂无数据</option>
                                                <option value="{{i.id}}" ng-repeat="i in datumTypeList">{{i.title}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-10 mT10 lH30 pd0">
                                            <a  class="aHover" ng-click="addDatumBtn()">添加项目组</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" ng-if="datumTypeList.length != 0">
                                    <div class="row">
                                        <h4 class="col-md-9">
                                            {{datumParentList.title}}
                                            <span class="mL8" ng-click="updateDatumBtn(datumParentList.id,datumParentList.title)">
                                                <img src="/plugins/privateClassSet/img/update.png">
                                            </span>
                                            <span class="mL8" ng-click="deleteDatumBtn(datumParentList.id)">
                                                <img src="/plugins/privateClassSet/img/delete.png">
                                            </span>
                                        </h4>
                                        <div class="col-md-3">
                                            <a  class="aHover" ng-click="addDatumChildBtn(datumParentList.id)" ng-if="!showSortEnd">添加项目</a>
                                            <a  class="aHover mL10" ng-click="fileSortStart()" ng-if="!showSortEnd">修改排序</a>
                                            <a  class="aHover mL10" ng-click="cancelFileSort()" ng-if="showSortEnd">取消排序</a>
                                            <a  class="aHover mL10" ng-click="fileSortEnd()" ng-if="showSortEnd">保存</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mr0">
                                    <ul class="list-group" style="margin-bottom: 0">
                                        <li class="list-group-item row mr0 fileLi firstLi">
                                            <span class="col-md-3 text-center">项目</span>
                                            <span class="col-md-2 text-center">单位</span>
                                            <span class="col-md-2 text-center">正常范围</span>
                                            <span class="col-md-2 text-center" ng-if="showSortEnd">排序</span>
                                            <span class="col-md-3 text-center">操作</span>
                                        </li>
                                    </ul>
                                    <ul  class="list-group" id="fileSort{{datumParentList.id}}">
                                        <li ng-repeat="($index,w) in datumChildList" class="list-group-item row mr0 pd0" name="{{$index}}" value="{{w.id}}">
                                            <span class="col-md-3 text-center">{{w.title}}</span>
                                            <span class="col-md-2 text-center">{{w.unit | noData :''}}</span>
                                            <span class="col-md-2 text-center">{{w.normal_range | noData : ''}}</span>
                                            <span class="col-md-2 text-center" ng-if="showSortEnd">
                                                <img src="/plugins/privateClassSet/img/sort-3.png">
                                            </span>
                                            <span class="col-md-3 text-center">
                                                <a class="aHover" ng-click="datumChildDetail(w.id)">详情</a>
                                                <a class="mL10 aHover" ng-click="updateDatumChild(w.id)">修改</a>
                                                <a class="mL10 aHover" ng-click="deleteDatumChild(w.id)">删除</a>
                                            </span>
                                        </li>
                                    </ul>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'datumNoData','text'=>'暂无数据','href'=>true]);?>
                                </div>
                            </div>
                            <!--添加父级分类模态框-->
                            <?=$this->render('@app/views/private-class-set/datumModal/addDatumModal.php');?>
                            <!--添加子级分类模态框-->
                            <?=$this->render('@app/views/private-class-set/datumModal/addDatumChildModal.php');?>
                            <!--修改名称模态框-->
                            <?=$this->render('@app/views/private-class-set/datumModal/updateDatumModal.php');?>
                            <!--修改子类模态框-->
                            <?=$this->render('@app/views/private-class-set/datumModal/updateDatumChildModal.php');?>
                            <!--子类详情模态框-->
                            <?=$this->render('@app/views/private-class-set/datumModal/datumChildDetailModal.php');?>
                        </div>
                    </div>
                </div>


            </div>
            <!--跟进状态-->
            <div role="tabpanel" class="tab-pane" id="followStatus" ng-controller="followStatusCtrl">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row mr0">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-info w100" ng-click="keepBtn()" ng-disabled="initClick">保存修改</button>
                                <button class="btn btn-default mL10 w100" ng-click="resetBtn()">重置</button>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>状态名称</th>
                            <th>启用</th>
                            <th>提醒私教</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="s in statusList">
                            <td>{{s.title}}</td>
                            <td>
                                <input type="checkbox" class="w16 chooseDay" value="{{s.id}}" ng-if="s.state == 0" checked="checked" ng-click="changeInit()">
                                <input type="checkbox" class="w16 chooseDay" value="{{s.id}}" ng-if="s.state == 1" ng-click="changeInit()">
                            </td>
                            <td>
                                <input type="checkbox" class="w16 chooseRemind" value="{{s.id}}" ng-if="s.is_remind == 0" checked="checked" ng-click="changeInit()">
                                <input type="checkbox" class="w16 chooseRemind" value="{{s.id}}" ng-if="s.is_remind == 1" ng-click="changeInit()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--跟进方式-->
            <div role="tabpanel" class="tab-pane" id="followWay" ng-controller="followWayCtrl">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading text-right">
                        <button class="btn btn-info w100" ng-click="addFollowWayBtn()">新增</button>
                    </div>
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr>
                            <th>跟进方式</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="f in followWayList">
                            <td>{{f.title}}</td>
                            <td>
                                <a class="aHover" ng-click="updateFollowWayBtn(f.id,f.title)">修改</a>
                                <a class="aHover mL10" ng-click="deleteWay(f.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'followWayNoData','text'=>'暂无数据','href'=>true]);?>
                </div>
                <!--添加跟进方式模态框-->
                <?=$this->render('@app/views/private-class-set/followModal/addFollowWay.php');?>
                <!--修改跟进方式模态框-->
                <?=$this->render('@app/views/private-class-set/followModal/updateFollowWay.php');?>
            </div>
            <!--私教来源-->
            <div role="tabpanel" class="tab-pane" id="source" ng-controller="sourceCtrl">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading text-right">
                        <button class="btn btn-info w100" ng-click="addSourceBtn()">新增</button>
                    </div>
                    <!-- Table -->
                    <table class="table">
                        <thead>
                        <tr>
                            <th>私教来源</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="s in sourceList">
                            <td>{{s.title}}</td>
                            <td>
                                <a class="aHover" ng-click="updateSourceBtn(s.id,s.title)">修改</a>
                                <a class="aHover mL10" ng-click="deleteSource(s.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'sourceNoData','text'=>'暂无数据','href'=>true]);?>
                </div>
                <!--添加私教来源模态框-->
                <?=$this->render('@app/views/private-class-set/followModal/addSource.php');?>
                <!--修改私教来源模态框-->
                <?=$this->render('@app/views/private-class-set/followModal/updateSource.php');?>
            </div>
            <!--客户分类-->
            <!--<div role="tabpanel" class="tab-pane" id="client" ng-controller="clientCtrl">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn btn-info w100" ng-click="addClientBtn()">新增</button>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>客户分类</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>XXXXXXXX</td>
                            <td>
                                <a class="aHover" ng-click="updateClientBtn(c.id,c.title)">修改</a>
                                <a class="aHover mL10" ng-click="deleteClient(c.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>-->
        </div>

    </div>
</div>