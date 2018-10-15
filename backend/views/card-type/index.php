<?php
use backend\assets\CardTypeAsset;
CardTypeAsset::register($this);
$this->title = '属性匹配';
/**
 * 公共管理 - 属性匹配 - 会员卡属性匹配
 * @author zhujunzhe@itsports.club
 * @create 2018/1/31 am
 */
?>
<div class="cardTypeContent" ng-controller="cardTypeCtrl" ng-cloak>
    <input ng-model="res._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
    <div class="panel panel-default cardTypeTop">
        <div class="panel-heading panelTitle">条件筛选</div>
        <div class="panel-body">
            <div class="col-md-3 col-sm-2 col-sm-1"></div>
            <div class="input-group col-md-5" style="padding-left: 8%">
                <input type="text" style="height: 34px;" class="form-control" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder="请输入卡种名称进行搜索">
                <span class="input-group-btn">
                     <button class="btn btn-success" type="button" ng-click="searchCard()">搜索</button>
                </span>
            </div>
            <div class="col-md-12" style="margin-top: 10px;">
                <div class="col-md-2 col-sm-3">
                    <select name="" id="" ng-model="venueId">
                        <option value="">请选择场馆</option>
                        <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>
                        <option ng-if="VenueStautsLength" value="" ><span style="color:red;">暂无数据</span></option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-2">
                    <select name="" id="" ng-model="type">
                        <option value="">卡类别</option>
                        <option value="1">时间卡</option>
                        <option value="2">次卡</option>
                        <option value="3">充值卡</option>
                        <option value="4">混合卡</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-2">
                    <select name="" id="" ng-model="attributes">
                        <option value="">卡类型</option>
                        <option value="1">瑜伽</option>
                        <option value="2">健身</option>
                        <option value="3">舞蹈</option>
                        <option value="4">综合</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-2">
                    <select name="" id="" ng-model="status">
                        <option value="">不限</option>
                        <option value="1">正常</option>
                        <option value="2">冻结</option>
                        <option value="3">过期</option>
                        <option value="4">审核中</option>
                        <option value="5">拒绝</option>
                        <option value="6">撤销</option>
                    </select>
                </div>
                <div class="mR6" style="display: inline-block;vertical-align: middle;"><input type="checkbox" value="1" ng-model="isCheck" style="width: 20px;height: 20px"><span style="width: 20px;height: 20px;position: relative;top:-5px">全部卡种</span></div>
                <button  class="btn btn-info" type="button" style="padding-top: 4px;padding-bottom: 4px;" ng-click="searchCard()">确定</button>
                <button  class="btn btn-warning" type="button" style="padding-top: 4px;padding-bottom: 4px;" ng-click="searchClear()">清空</button>
            </div>
        </div>
    </div>
    <div class="row cardTypeMain" style="margin-left: 0;margin-right: 0">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading panelTitle">卡种管理</div>
            <!-- Table -->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>卡类型</th>
                    <th>卡名称</th>
                    <th>售价</th>
                    <th>有效天数</th>
                    <th>次数</th>
                    <th>激活期限</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="data in datas">
                    <td ng-click="getCardDetail(data.id)">{{data.cardCategoryType.type_name | noData:'' }}</td>
                    <td ng-click="getCardDetail(data.id)">{{data.card_name | noData:''}}</td>
                    <td ng-click="getCardDetail(data.id)">{{data|cardPrice}}</td>
                    <td ng-click="getCardDetail(data.id)">{{data.duration|stringToArr}}</td>
                    <td ng-click="getCardDetail(data.id)">{{data.times | noData:'次':'num'}}</td>
                    <td ng-click="getCardDetail(data.id)">{{data.active_time | noData:'天'}}</td>
                    <td ng-click="getCardDetail(data.id)">
                        <span class="label label-danger"  ng-if="data.status == 2">冻结</span>
                        <span class="label label-warning" ng-if="data.status == 3">过期</span>
                        <span class="label label-info"    ng-if="data.status == 4">审核中</span>
                        <span class="label label-success" ng-if="data.status == 1">正常</span>
                        <span class="label label-danger"  ng-if="data.status == 5">已拒绝</span>
                        <span class="label label-default" ng-if="data.status == 6">已撤销</span>
                    </td>
                    <td>
                        <button  class="btn btn-info" type="button" data-toggle="modal" ng-click="matching(data.id)">属性匹配</button>
                        <button  class="btn btn-primary" type="button" data-toggle="modal" ng-click="record(data.id)">匹配记录</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <?= $this->render('@app/views/common/nodata.php'); ?>
        <?=$this->render('@app/views/common/page.php');?>
    </div>
    <!--卡种详情模态框-->
    <?= $this->render('@app/views/card-type/cardTypeModal.php'); ?>
    <!--属性匹配模态框-->
    <?= $this->render('@app/views/card-type/matchingModal.php'); ?>
    <!--匹配记录模态框-->
    <?= $this->render('@app/views/card-type/recordModal.php'); ?>
</div>
