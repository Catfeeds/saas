<?php
use backend\assets\PhoneDiscountsAsset;
PhoneDiscountsAsset::register($this);
$this->title = '手机折扣';
/**
 * 手机管理 - 手机折扣
 * @author 张亚鑫<zhangyaxin@itsports.club>
 * @date 2018/2/1 pm
 */
?>
<div class="col-sm-12" ng-controller="phoneDiscountCtrl" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">手机折扣</h3>
        </div>
        <div class="panel-body" style="display: flex;justify-content: space-around;">
            <div class="input-group" style="max-width: 450px;">
                <input type="text" class="form-control" ng-model="searchDiscount" style="padding: 18px;" placeholder="请输入场馆名称进行搜索">
                <span class="input-group-addon btn btn-success" ladda="searchDataBtnClickFlag" ng-click="searchPhoneDiscount()" style="min-width: 80px;border: 0;">搜索</span>
            </div>
            <button class="btn btn-success" ng-click="addNewPhoneDiscount()">新增移动端折扣</button>
        </div>
        <hr>
        <div style="padding: 0 30px;">
            <label for="">
                <select name="" id="venueChoose" class="venueChoose" ng-model="venueChooseDiscount" ng-change="venueChangeDiscount(venueChooseDiscount)">
                    <option value="">请选择场馆</option>
                    <option ng-repeat="venue in venueList" value="{{venue.id}}">{{venue.name}}</option>
                </select>
            </label>
            <label for="">
                <select name="" id="statusChoose" class="statusChoose" ng-model="statusChooseDiscount" ng-change="statusChangeDiscount(statusChooseDiscount)">
                    <option value="">所有状态</option>
                    <option value="1">审核中</option>
                    <option value="2">已通过</option>
                    <option value="3">未通过</option>
                </select>
            </label>
            <button class="btn btn-info" ng-click="clearBtn()" style="padding-top: 4px;padding-bottom: 4px;margin-left: 10%">清除</button>
        </div>
        <hr>
        <!-- Table -->
        <table class="table table-hover table-striped table-style" style="cursor: default;">
            <thead>
                <tr>
                    <th>场馆</th>
                    <th>折扣</th>
                    <th>折扣售卖期限</th>
                    <th>操作日期</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="i in discountsList">
                    <td>{{i.name}}</td>
                    <td>{{i.discount}}折</td>
                    <td>{{i.start * 1000 | date:'yyyy-MM-dd'}}到{{i.end * 1000 | date:'yyyy-MM-dd'}}</td>
                    <td>{{i.create_at * 1000 | date:'yyyy-MM-dd' }}</td>
                    <td ng-if="i.frozen == 1">冻结</td>
                    <td ng-if="i.frozen == 2 && i.status == 1">审核中</td>
                    <td ng-if="i.frozen == 2 && i.status == 2">正常</td>
                    <td ng-if="i.frozen == 2 && i.status == 3">未通过</td>
                    <td ng-if="i.frozen == 2 && i.status == 4">已撤销</td>
                    <td>
                        <label for="frozenInput" class="frozenInputLabel" ng-if="i.frozen == 1">
                            <input type="checkbox"  checked ng-click="frozenDiscount(i.id)">冻结
                        </label>
                        <label for="frozenInput" class="frozenInputLabel" ng-if="i.frozen == 2">
                            <input type="checkbox"  ng-click="frozenDiscount(i.id)">冻结
                        </label>
                        <button class="btn btn-success btn-padding" ng-disabled="i.frozen == 1 || i.status == 3 || i.status == 4" ng-click="updatePhoneDiscount(i)">修改</button>
                        <button class="btn btn-primary btn-padding" ng-click="detailDiscountBtn(i.id)">详情</button>
                        <button class="btn btn-danger btn-padding"  ng-click="deleteDiscount(i.id)">删除</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <?=$this->render('@app/views/common/pagination.php',['page'=>'discountsPage']);?>
        <?=$this->render('@app/views/common/nodata.php',['name'=>'dataInfo','text'=>'暂无数据','href'=>true]);?>

    </div>
    <!--新增模态框-->
    <?= $this->render('@app/views/phone-discounts/addPhoneDiscountsModal.php'); ?>
    <!-- 修改折扣模态框 -->
    <?= $this->render('@app/views/phone-discounts/updatePhoneDiscountsModal.php'); ?>
    <!-- 折扣详情模态框 -->
    <?= $this->render('@app/views/phone-discounts/discountsDetailModal.php'); ?>
</div>