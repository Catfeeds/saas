<?php
use backend\assets\StoreManagementCtrlAsset;
StoreManagementCtrlAsset::register($this);
$this->title = '仓库管理';
?>
<main ng-controller="storeCtrl" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="" >
        <div class="row pdLR0">
            <div class="col-sm-12 pdLR0">
                <section class="tabs-container">
                    <ul class="nav nav-tabs text-center bBNone">
                        <li class="active col-sm-3 col-sm-offset-3 f16">
                            <a data-toggle="tab" href="#warehouse" aria-expanded="true" ng-click='warehouseClick()'>仓库管理</a>
                        </li>
                        <li  class="col-sm-3 f16">
                            <a data-toggle="tab" href="#allocation" aria-expanded="false" ng-click="allocationClick()">调拨申请</a>
                        </li>
                    </ul>
                    <section class="tab-content bgWhite" >
                        <div id="warehouse" class="tab-pane active">
                            <div class="panel-body "  id="warehouse123">
                                <div class="row">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="col-sm-offset-3 col-sm-5 w1280wml">
                                            <div class="input-group">
                                                <input type="text" class="form-control userHeaders" ng-model="WarehouseKeywords" ng-keyup="WarehouseSearch($event)" placeholder=" 请输入仓库名称或商品名称或品牌或型号进行搜索...">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="WarehouseKeywordsSearch()" class="btn btn-primary btn-sm">搜索</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <div class="col-sm-6 text-right">
                                                <button type="button" class="btn btn-default btn-sm pdR10" ng-click="addStoreButton()">新增仓库</button>
                                            </div>
                                            <div class="col-sm-6 text-left">
                                                <button type="button" class="btn btn-success btn-sm" ng-click="addShopButton()">新增商品</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pdLR0 homePageSearch" style="display: flex;flex-wrap: wrap;padding: 0 15px;">
                                        <div class="pdR10 mT10" style="width: 286px;">
                                            <div class="input-daterange input-group cp userTimeRecord col-sm-4" >
                                            <span class="add-on input-group-addon">
                                            选择日期
                                            </span>
                                                <input type="text" readonly  name="reservation" id="storeDate" class="form-control text-center  " style="width: 195px;"/>
                                            </div>
                                        </div>
                                        <div class="pdR10 mT10" style="width: 200px;">
                                            <select id="allVenues" class=" form-control selectPd"   style="width: 100%;"  ng-model="homePageWarehouseVenue" ng-change="venueChange(homePageWarehouseVenue)">
                                                <option value="">请选择场馆</option>
                                                <option title="{{venue.name}}" value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>
                                            </select>
                                        </div>
                                        <div class="pdR10 mT10" style="width: 120px;">
                                            <select id="departmentTypes" class=" form-control"  ng-init="indexDepartmentId=''" ng-model="indexDepartmentId" style="width: 100%;padding: 4px 12px;" >
                                                <option value="">选择部门</option>
                                                <option value="{{i.id}}" ng-repeat="i in departments">{{i.name}}</option>
                                            </select>
                                        </div>
                                        <div class="pdR10 mT10"style="min-width: 100px;">
                                            <select class=" form-control selectPd" ng-model="WarehouseType">
                                                <option value="">商品类型</option>
                                                <option value="1">商品</option>
                                                <option value="2">赠品</option>
                                                <option value="3">自用</option>
                                            </select>
                                        </div>
                                        <div class="pdR10 mT10" style="width: 120px;">
                                            <select id="shopTypes" class=" form-control"   style="width: 100%;padding: 4px 12px;" ng-init="WarehouseCategory=''" ng-model="WarehouseCategory">
                                                <option value="">商品品类</option>
                                                <option value="{{shopCategory.id}}" ng-repeat="shopCategory in shopCategoryLists">{{shopCategory.goods_type}}</option>
                                             </select>
                                        </div>

<!--                                        <div class="pdR10 mT10" style="width: 120px;">-->
<!--                                            <select id="shopBrands" class=" form-control"   style="width: 100%;padding: 4px 12px;"  ng-model="WarehouseBrands">-->
<!--                                                <option value="">商品品牌</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="pdR10 mT10" style="min-width: 100px;">-->
<!--                                            <select class=" form-control selectPd" ng-model="WarehouseModel">-->
<!--                                                <option value="">商品型号</option>-->
<!--                                            </select>-->
<!--                                        </div>-->

                                        <div class=" mT10 mR10">
                                            <button class="btn btn-success btn-sm " ng-click="WarehouseKeywordsSearch()">确定</button>
                                        </div>
                                        <div class=" mT10 ">
                                            <button class="btn btn-info btn-sm " ng-click="ClearSearchSelect()">清空</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mT20">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-content" style="padding: 0">
                                                <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                 style="width: 100px;background-color: #FFF;">序号
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                 style="width: 200px;background-color: #FFF;">仓库名称
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 180px;background-color: #FFF;" >
                                                                所属场馆
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                style="width: 180px;background-color: #FFF;">名称
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 120px;background-color: #FFF;">类型
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width:180px;background-color: #FFF;">
                                                                品类
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width:180px;background-color: #FFF;">
                                                                部门
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1"  style="width: 140px;background-color: #FFF;">型号
                                                            </th>
                                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                ng-click="changeGoodSort('ht_createTime',sort)" style="width: 200px;background-color: #FFF;">日期
                                                            </th>
                                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" ng-click="changeGoodSort('ht_stockNum',sort)" style="width: 120px;">库存数量
                                                            </th>
<!--                                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" ng-click="changeGoodSort('ht_totalAmount',sort)" style="width: 120px;">总金额-->
<!--                                                            </th>-->
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1"  style="width: 350px;background-color: #FFF;">操作
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="cp" ng-repeat="WarehouseOrder in AllWarehouseOrderLists">
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{(AllWarehouseOrderNowPage-1)  * listsNumbers +$index +1}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.name}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.venueName | noData:''}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.goods_name | noData:''}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">
                                                                <span ng-if="WarehouseOrder.goods_attribute == null || WarehouseOrder.goods_attribute == 'null'" >暂无数据</span>
                                                                <span ng-if="WarehouseOrder.goods_attribute == '1'" >商品</span>
                                                                <span ng-if="WarehouseOrder.goods_attribute == '2'" >赠品</span>
                                                                <span ng-if="WarehouseOrder.goods_attribute == '3'" >自用</span>
                                                            </td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">
                                                                {{WarehouseOrder.goods_type | noData:''}}
                                                            </td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">
                                                                {{WarehouseOrder.department_name | noData:''}}
                                                            </td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.goods_model | noData:''}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.create_time *1000 | date:'yyyy-MM-dd HH:mm:ss' | noData:''}}</td>
                                                            <td ng-click="shopDetailClick(WarehouseOrder)">{{WarehouseOrder.storage_num | noData:''}}</td>
<!--                                                            <td ng-click="shopDetailClick(WarehouseOrder)">-->
<!--                                                                {{WarehouseOrder.allMany | number:2 | noData:''}}-->
<!--                                                            </td>-->
                                                            <td class="tdBtn">
                                                                <button type="button" class="btn btn-success btn-sm mR6" ng-click="enterStorageBtn(WarehouseOrder.id)">入库</button>
                                                                <button ng-if ="WarehouseOrder.storage_num != null && WarehouseOrder.storage_num != '' && WarehouseOrder.storage_num != undefined && WarehouseOrder.storage_num > 0" type="button" class="btn btn-warning btn-sm mR6" ng-click="outerStorageBtn(WarehouseOrder.id,WarehouseOrder)">出库</button>
                                                                <button ng-if ="WarehouseOrder.storage_num != null && WarehouseOrder.storage_num != '' && WarehouseOrder.storage_num != undefined && WarehouseOrder.storage_num >= 0 " type="button" class="btn btn-info btn-sm mR6" ng-click="allotShopBtn(WarehouseOrder.id,WarehouseOrder)">调拨</button>
                                                                <button class="btn btn-primary btn-sm" data-toggle="modal" ng-disabled="WarehouseOrder.mobilise != 0" ng-click="changeGoodsInfo(WarehouseOrder.id,WarehouseOrder.venue_id)">修改</button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'AllWarehouseOrderFlag','text'=>'暂无数据','href'=>true]);?>
                                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'AllWarehouseOrderPages']);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div id="allocation" class="tab-pane">
                            <div class="panel-body " >
                                <div class="row">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="col-sm-offset-3 col-md-offset-3 col-sm-6 col-md-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control userHeaders" ng-model="applyForKeywords" ng-keyup="applyForEnterSearch($event)" placeholder=" 请输入申请方或被申请方进行搜索...">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="applyForSearch()" class="btn btn-primary btn-sm">搜索</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pdLR0" style="display: flex;flex-wrap: wrap;">
                                        <div class="pdR10 mT10 homePageSearch" style="width: 200px;">
                                            <select id="applyForVenues" class=" form-control "   style="width: 100%;padding: 6px 12px;"  ng-model="applyForVenue">
                                                <option value="">请选择场馆</option>
                                                <option value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>
                                            </select>
                                        </div>
                                        <div class="pdR10 mT10" style="width: 286px;">
                                            <div class="input-daterange input-group cp userTimeRecord col-sm-4" >
                                            <span class="add-on input-group-addon">
                                            选择日期
                                            </span>
                                                <input type="text" readonly  name="reservation" id="applyForDate" class="form-control text-center userSelectTime reservationExpire" style="width: 195px;"/>
                                            </div>
                                        </div>
                                        <div class="pdR10 mT10 homePageSearch" style="width: 120px;">
                                            <select id="applyForTypes" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="applyForType">
                                                <option value="">商品类别</option>
                                                <option value="{{shopCategory.id}}" ng-repeat="shopCategory in shopCategoryLists">{{shopCategory.goods_type}}</option>
                                            </select>
                                        </div>
                                        <div class=" mT10 mR10">
                                            <button class="btn btn-success btn-sm " ng-click="applyForSearch()">确定</button>
                                        </div>
                                        <div class=" mT10 ">
                                            <button class="btn btn-info btn-sm " ng-click="applyForClearSearch()">清空</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mT20">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-content" style="padding: 0">
                                                <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                 style="width: 100px;background-color: #FFF;">序号
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                 style="width: 200px;background-color: #FFF;">申请方
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 180px;background-color: #FFF;" >
                                                                被申请方
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                                style="width: 180px;background-color: #FFF;">名称
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 120px;background-color: #FFF;">型号
                                                            </th>
                                                            <th class="sorting" ng-click="changeApplyForSort('ht_num',sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width:180px;">
                                                                数量
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 140px;background-color: #FFF;">状态
                                                            </th>
                                                            <th class="sorting" ng-click="changeApplyForSort('ht_time',sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 180px;">时间动态
                                                            </th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" style="width: 280px;background-color: #FFF;">操作
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat="ShopApplyFor in  ShopApplyForLists">
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{(ShopApplyForListsNow - 1)  * listsNumbers +$index +1}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.name}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.beName}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.goods_name |noData:''}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.goods_model |noData:''}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.num}}</td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">
                                                                <small class="label label-default " ng-if="ShopApplyFor.type == '1'">待通过</small>
                                                                <small class="label label-primary " ng-if="ShopApplyFor.type == '2'">待调拨</small>
                                                                <small style="background-color: #00cc00;" class="label label-success " ng-if="ShopApplyFor.type == '3'">已调拨</small>
                                                                <small class="label label-danger " ng-if="ShopApplyFor.type == '4'">已拒绝</small>
                                                            </td>
                                                            <td ng-click="AllocationDetailClick(ShopApplyFor)">{{ShopApplyFor.created_at *1000 | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                                            <td>
                                                                <button ng-if="ShopApplyFor.type == '1' && CurrentLogonId == ShopApplyFor.be_venue_id " type="button" class="btn btn-success btn-sm w70" ng-click="allocationOrderAdopt(ShopApplyFor.mobiliseTypeId)">确认通过</button>
                                                                <button ng-if="ShopApplyFor.type == '1' && CurrentLogonId == ShopApplyFor.be_venue_id " type="button" class="btn btn-danger btn-sm w70" ng-click="allocationOrderRefuse(ShopApplyFor)">拒绝</button>
                                                                <button ng-if="ShopApplyFor.type == '2' && CurrentLogonId == ShopApplyFor.be_venue_id " type="button" class="btn btn-success btn-sm w70" ng-click="allocationOrderClick(ShopApplyFor)">调拨</button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'ShopApplyForListsFlag','text'=>'暂无数据','href'=>true]);?>
                                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'ShopApplyForListsPages']);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </div>
    <!--调拨申请详情 及 调拨申请中调拨 及拒绝调拨-->
    <?= $this->render('@app/views/store-management/goodsAllotApply.php'); ?>
    <!--新增商品 及 商品详情-->
    <?= $this->render('@app/views/store-management/addNewGoods.php'); ?>
    <!--商品页面调拨-->
    <?= $this->render('@app/views/store-management/goodsAllot.php'); ?>
    <!--入库 与 出库-->
    <?= $this->render('@app/views/store-management/intoGoodsStore.php'); ?>
    <!--新增仓库-->
    <?= $this->render('@app/views/store-management/addNewGoodsStore.php'); ?>
    <!--自定义商品品类-->
    <?= $this->render('@app/views/store-management/customGoodsType.php'); ?>
    <!--商品报损、退货、报溢  及  报损数量、 退货数量、 报溢数量-->
    <?= $this->render('@app/views/store-management/goodsLossReturnOverflow.php'); ?>
    <!--修改-->
    <?= $this->render('@app/views/store-management/wangModify.php'); ?>
    <!--自定义商品品类-->
    <?= $this->render('@app/views/store-management/addGoodsType.php'); ?>
</main>
