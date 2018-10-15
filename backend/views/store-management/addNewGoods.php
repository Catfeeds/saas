<!--新增商品-->
<div class="modal fade" id="addStoreShopModal" style="overflow: auto;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">新增商品</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-11 col-sm-offset-1  col-xs-12 mTB20"  >
                        <li class="col-sm-12 col-xs-12 heightCenter">
                            <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>仓库名称</div>
                            <div class="col-sm-5 col-xs-5">
                                <select id="addShopStoreName" class="form-control selectPd" ng-model="addShopStoreSelect" >
                                    <option value="">请选择仓库</option>
                                    <option value="{{Warehouse.id}}" ng-repeat="Warehouse in getAllShopWarehouseLists">{{Warehouse.name}}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>商品类型</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <select  class="form-control selectPd"  ng-model="addShopTypeSelect">
                                    <option value="">请选择类型</option>
                                    <option value="1">商品</option>
                                    <option value="2">赠品</option>
                                    <option value="3">自用</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>商品品类</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <select id="addShopCategory"  class="form-control selectPd" ng-model="addShopCategorySelect" >
                                    <option value="">请选择品类</option>
                                    <option ng-selected="shopCategory.id == addShopCategorySelect123" value="{{shopCategory.id}}" ng-repeat="shopCategory in shopCategoryLists">{{shopCategory.goods_type}}</option>
                                </select>
                            </div>
                            <div  class="col-sm-4  col-xs-4  text-center">
                                <button class="btn btn-warning btn-sm mR10 w70" ng-click="addCustomShopCategory()">自定义</button>
                                <button class="btn btn-default btn-sm w70" ng-click="delCustomShopCategory(addShopCategorySelect)">删除</button>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>选择部门</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <select id="addDepartment"  class="form-control selectPd" ng-model="departmentId">
                                    <option value="">请选择部门</option>
                                    <option value="{{i.id}}" ng-repeat="i in departmentList">{{i.name}}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>商品单位</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <select id="addShopCompany"  class="form-control selectPd"  ng-model="addShopCompanySelect">
                                    <!--                                        瓶、双、套、只、付、个、尊、件、把、罐、包、盒、辆、升、方、块、斤、吨-->
                                    <option value="">请选择单位</option>
                                    <option value="瓶">瓶</option>
                                    <option value="个" >个</option>
                                    <option value="件" >件</option>
                                    <option value="盘" >盘</option>
                                    <option value="箱" >箱</option>
                                    <option value="条" >条</option>
                                    <option value="双">双</option>
                                    <option value="只">只</option>
                                    <option value="付">付</option>
                                    <option value="把">把</option>
                                    <option value="罐">罐</option>
                                    <option value="包">包</option>
                                    <option value="盒">盒</option>
                                    <option value="辆">辆</option>
                                    <option value="斤">斤</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>商品名称</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <input type="text" class="form-control" ng-model="addShopGoodName"  placeholder="请输入商品名称">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right">商品品牌</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <input type="text" class="form-control" ng-model="addShopGoodBrandName"  placeholder="请输入商品品牌">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right">商品型号</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <input type="text" class="form-control" ng-model="addShopGoodModel"  placeholder="请输入型号">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right">生产商</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <input type="text" class="form-control" ng-model="addShopGoodManufacturer"  placeholder="请输入生产商">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-3  col-xs-3  text-right">供应商</div>
                            <div  class="col-sm-5 col-xs-5 ">
                                <input type="text" class="form-control" ng-model="addShopGoodSupplier"  placeholder="请输入供应商">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone ">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100 " ladda="CompleteAddShopButtonFlag" ng-click="addShopComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--商品详情-->
<div class="modal fade bs-example-modal-lg" style="overflow: auto;" id="shopDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg wB80" role="document" style="min-width: 1200px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">商品详情</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0;">
                <div class="row">
                    <section class="col-sm-4 col-lg-3">
                        <div class="col-sm-12 clearfix" >
                            <div class="dropdown fr">
                                <div style="height: 30px;font-size: 16px;" class="text-right w100 cp dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    更多...
                                </div>
                                <ul class="dropdown-menu pdL10 pdR10 cp btnDownBox dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                    <li ng-click="shopHandleTypeClick(3)"><div class="bB1">商品报损</div></li>
                                    <li ng-click="shopHandleTypeClick(4)"><div class="bB1">商品退货</div></li>
                                    <li ng-click="shopHandleTypeClick(5)"><div class="bB1" style="border: none;">商品报溢</div></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <ul class="wB100 color999 f14" >
                                <li><h3 class="f20" >{{shopDetail123.goodsName | noData:''}}</h3></li>
                                <li class="mT10">品类&emsp;&emsp;: {{shopDetail123.goods_type | noData:''}}</li>
                                <li class="mT10">商品品牌: {{shopDetail123.goodsBrand | noData:''}}</li>
                                <li class="mT10">商品型号: {{shopDetail123.goodsModel | noData:''}}</li>
                                <li class="mT10">生产商&emsp;: {{shopDetail123.goodsProducer | noData:''}}</li>
                                <li class="mT10">供应商&emsp;: {{shopDetail123.goodsSupplier | noData:''}}</li>
                            </ul>
                            <div class="wB100 mT10">
                                <button  type="button" class="btn btn-success w70 btn-sm mR6" ng-click="enterStorageBtn(shopDetail123.id)">入库</button>
                                <button  ng-if ="shopDetail123.storage_num != null && shopDetail123.storage_num != '' && shopDetail123.storage_num != undefined && shopDetail123.storage_num > 0"  type="button" class="btn btn-warning w70 btn-sm mR6" ng-click="outerStorageBtn(shopDetail123.id,shopDetail123)">出库</button>
                                <button  ng-if ="shopDetail123.storage_num != null && shopDetail123.storage_num != '' && shopDetail123.storage_num != undefined && shopDetail123.storage_num >= 0"  type="button" class="btn btn-info w70 btn-sm mR6" ng-click="allotShopBtn(shopDetail123.id,shopDetialObject)">调拨</button>
                                <button  class="btn btn-primary w70 btn-sm" ng-disabled="shopDetail123.mobilise != 0" ng-click="changeGoodsInfo(shopDetail123.id,shopDetail123.venue_id)">修改</button>
                            </div>
                        </div>
                    </section>
                    <section class="col-sm-8 col-lg-9">
                        <div class="wB100" style="display: flex;flex-wrap: wrap;">
                            <div class="mR10">
                                <select style="width: 140px;" class="form-control selectPd cp" ng-model="shopStockType123" ng-change="shopStockTypeSelect(shopStockType123)">
                                    <option value="">状态</option>
                                    <option value="1">入库</option>
                                    <option value="2">出库</option>
                                    <option value="3">报损</option>
                                    <option value="4">退货</option>
                                    <option value="5">报溢</option>
                                    <option value="6">入库（调拨）</option>
                                    <option value="7">出库（调拨）</option>
                                </select>
                            </div>
                            <div style="width: 300px;margin-right: 20px;">
                                <div class="input-group">
                                    <input type="text" class="form-control userHeaders" ng-model="shopOrderKeywords" ng-keyup="shopOrderSearch($event)" placeholder=" 请输入单号进行搜索...">
                                    <span class="input-group-btn">
                                        <button type="button" ng-click="shopOrderBtnClick()" class="btn btn-primary btn-sm">搜索</button>
                                    </span>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" ng-click="clearBtn()" class="btn btn-info btn-sm">清空</button>
                            </div>
                        </div>
                        <div class="wB100 mT20">
                            <div class="col-sm-12 pdLR0">
                                <div class="ibox float-e-margins" style="margin-bottom: 0px;">
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
                                                        style="width: 140px;background-color: #FFF;">状态
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 120px;background-color: #FFF;">单价(元)
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" style="width: 140px;background-color: #FFF;">
                                                        数量
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 140px;background-color: #FFF;">金额(元)
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" style="width: 200px;background-color: #FFF;">日期
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width:240px;background-color: #FFF;">
                                                        单号
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" style="width: 240px;background-color: #FFF;">备注
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="shopDetail in ShopDetailModalLists">
                                                    <td>
                                                        <span ng-if="shopDetail.status == '1'">入库</span>
                                                        <span ng-if="shopDetail.status == '2'">出库</span>
                                                        <span ng-if="shopDetail.status == '3'">报损</span>
                                                        <span ng-if="shopDetail.status == '4'">退货</span>
                                                        <span ng-if="shopDetail.status == '5'">报溢</span>
                                                        <span ng-if="shopDetail.status == '6'">入库（调拨）</span>
                                                        <span ng-if="shopDetail.status == '7'">出库（调拨）</span>
                                                    </td>
                                                    <td>{{shopDetail.gcUnitPrice | number:2  | noData:''}}</td>
                                                    <td>{{shopDetail.operation_num | noData:''}}</td>
                                                    <td>{{shopDetail.gcUnitPrice *shopDetail.operation_num |number:2| noData:''}}</td>
                                                    <td>{{shopDetail.create_at *1000 | date:'yyyy-MM-dd HH:mm:ss' | noData:''}}</td>
                                                    <td>{{shopDetail.list_num}}</td>
                                                    <td>{{shopDetail.describe | noData:''}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'ShopDetailModalListsFlag','text'=>'暂无数据','href'=>true]);?>
                                            <?=$this->render('@app/views/common/pagination.php',['page'=>'ShopDetailModalListsPages']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 0px;">
                <div class="row" style="padding-left: 15px;padding-right:15px">
                    <span ng-if="ShopDetailModalLists.length != 0 && shopStockType123 != '' && shopStockType123 != undefined ">{{shopTypeName}}数量: <span class="colorOrange f20">{{ShopDetailModalListsSum.totalSum}}{{WarehouseStockUnit}}</span>&emsp; {{shopTypeName}}总金额: <span class="colorOrange f20">{{ShopDetailModalListsSum.totalMoney | number:2}}元</span>&emsp;</span>
                    库存数量: <span class="colorOrange f20">{{WarehouseStockTotalSum}}{{WarehouseStockUnit}}</span>&emsp;总金额:<span class="colorOrange f20">{{WarehouseStockTotalMoney | number:2}} 元</span>&emsp;
                </div>
                <div class="row" style="padding-left: 15px;padding-right:15px;margin-top: 10px;">
                    <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>