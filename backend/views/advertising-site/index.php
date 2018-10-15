<?php
use backend\assets\AdvertisingSiteAsset;
AdvertisingSiteAsset::register($this);
$this->title = '广告设置';
/**
 * 手机管理 - 广告设置 - 手机广告投放设置
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="advertisingSiteContent" ng-controller="advertisingSiteCtrl" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>手机广告</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                    <h4 style="float: left;margin-right: 10px;line-height: 32px;">启动页广告</h4>
                    <switch style="float: left" id="isSynchronization" name="isSynchronization" ng-click="isSynchronization()" class="green "></switch>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 h34" style="padding-left: 0;padding-right: 0;">
                    <div class="input-daterange input-group cp">
                        <span class="add-on input-group-addon">选择日期</span>
                        <input type="text" readonly name="reservation" id="advertisingGreatDate" class="form-control text-center h34" style="width: 100%;">
                    </div>
                </div>
                <div class="col-lg-5 col-md-8 col-sm-8 col-xs-8">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <div class="input-group">
                            <input type="text" class="form-control h34" placeholder="请输入广告名称进行搜索" ng-model="searchKeyword" ng-keydown="enterSearch()">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" ng-click="searchBtn()">搜索</button>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <button type="button" class="btn btn-default" ng-click="clearBtn()">清空</button>
                    </div>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center">
                    <button type="button" class="btn btn-info w100" ng-click="addAdvertisingBtn()">新建</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>广告列表</h4></div>
        <div class="panel-body" style="padding: 0">
            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                        style="" ng-click="changeSort('name',sort)">广告名称
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1" aria-label="浏览器：激活排序列升序" style=""
                        ng-click="changeSort('creat_date',sort)">创建时间
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1" aria-label="浏览器：激活排序列升序" style=""
                        ng-click="changeSort('use_time',sort)">有效期
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1" aria-label="平台：激活排序列升序" style=""
                        ng-click="changeSort('status',sort)">状态
                    </th>
                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                        colspan="1" aria-label="引擎版本：激活排序列升序" style="">备注
                    </th>
                    <th class="" tabindex="0" rowspan="1" colspan="1"  style="background-color: transparent;">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="i in advertisingList">
                    <td ng-click="advertisingDetailBtn(i.id)">{{i.name}}</td>
                    <td ng-click="advertisingDetailBtn(i.id)">{{i.create_at *1000| date:'yyyy-MM-dd'}}</td>
                    <td ng-click="advertisingDetailBtn(i.id)">
                        <span ng-if="i.start == 0 || i.end == 0">暂无数据</span>
                        <span ng-if="i.start != 0 && i.end != 0">{{i.start * 1000 | date:'yyyy/MM/dd'}} - {{i.end * 1000 | date:'yyyy/MM/dd'}} </span>
                    </td>
                    <td ng-click="advertisingDetailBtn(i.id)">
                        <small class="label label-warning" ng-if="i.status == 0">待启用</small>
                        <small class="label label-primary" ng-if="i.status == 1">启用中</small>
                    </td>
                    <td ng-click="advertisingDetailBtn(i.id)">{{i.note | noData:''}}</td>
                    <td>
                        <button class="btn btn-info btnStyle"  ng-click="redactAdvertisingBtn(i.id,i)" ng-disabled="useStatusBtn || i.status == 1">编辑</button>
                        <button class="btn btn-success btnStyle"   ng-click="startUse(i.id,i)" ng-if="i.status == 0" ng-disabled="useStatusBtn">启用</button>
                        <button class="btn btn-waring btnStyle"ng-click="stopUse(i.id)"  ng-if="i.status == 1" ng-disabled="useStatusBtn">停用</button>
                        <button  class="btn btn-danger btnStyle"ng-click="deleteOne(i.id)">删除</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <?=$this->render('@app/views/common/nodata.php',['name'=>'advertisingNoData','text'=>'暂无数据','href'=>true]);?>
            <?=$this->render('@app/views/common/pagination.php',['page'=>'advertisingPage']);?>
        </div>
    </div>
    <!--新建广告模态框-->
    <?=$this->render('@app/views/advertising-site/addAdvertisingModal.php');?>
    <!--编辑广告模态框-->
    <?=$this->render('@app/views/advertising-site/redactAdvertisingModal.php');?>
    <!--广告详情模态框-->
    <?=$this->render('@app/views/advertising-site/advertisingDetailModal.php');?>
</div>
