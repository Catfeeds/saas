<?php
use backend\assets\ShopAsset;

ShopAsset::register($this);
$this->title = '商品管理';
?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button{
        -webkit-appearance: none !important;
        margin: 0;
    }
</style>
<div ng-controller="indexCtrl" ng-cloak>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span class="displayInlineBlock"><b class="spanSmall">商品管理</b></span>
                        <div class="panel-body">
                            <div class="col-sm-6 ml200" >
                                    <div class="input-group">
                                        <input type="text" class="form-control search" ng-model="keywords" placeholder=" 请输入商品名称进行搜索..." ng-keyup="enterSearch($event)">
                                        <span class="input-group-btn">
                                            <button type="submit" ng-click="searchButton()" class="btn btn-primary">搜索</button>
                                        </span>
                                    </div>
                                </div>
                            <div class="col-sm-3 text-right">
                                    <li class="nav_add">
                                        <ul>
<!--                                            --><?php //if(\backend\models\AuthRole::canRoleByAuth('commodity','ADD')){ ?>
                                            <li class="new_add" id="tmk">
                                                <span class="btn btn-success btn" data-toggle="modal" data-target="#commodityIncrease" >新增商品</span>
<!--                                                <a href="" class="glyphicon glyphicon-plus" data-toggle="modal"-->
<!--                                                   data-target="#commodityIncrease"  style="margin-top: 10px;font-size: 14px;color: rgb(39,194,76)">新增商品</a>-->
                                            </li>
<!--                                            --><?php //} ?>
                                        </ul>
                                    </li>
                                </div>
                        </div>
                    </div>
                    <div class="panelBody"  class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content panelBodyContent">
                                <div  id="DataTables_Table_0_wrapper"
                                     class="dataTables_wrapper form-inline" role="grid">
                                    <table
                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" ng-click="changeSort('goodsName',sort)">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;名称
                                            </th>
<!--                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"-->
<!--                                                rowspan="1"-->
<!--                                                colspan="1" style="width: 120px;"-->
<!--                                                ng-click="changeSort('goodsAttribute',sort)"><span class="fa fa-venus"-->
<!--                                                                                              aria-hidden="true"></span>&nbsp;类型-->
<!--                                            </th>-->
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" ng-click="changeSort('goodsType',sort)">
                                                <span class="fa fa-venus" aria-hidden="true"></span>&nbsp;类别
                                            </th>
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" ng-click="changeSort('goodsBrand',sort)">
                                                <span class="fa fa-tree" aria-hidden="true"></span>&nbsp;品牌
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" ng-click="changeSort('unitPrice',sort)">
                                                <span class="glyphicon glyphicon-jpy" aria-hidden="true"></span>&nbsp;单价
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  ng-click="changeSort('intoNum',sort)" >
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;入库数量
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" ng-click="changeSort('storeNum',sort)">
                                                <span class="glyphicon glyphicon-sunglasses" aria-hidden="true" ></span>&nbsp;结余库存
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" ng-click="changeSort('storeNum',sort)" >
                                                <span class="glyphicon glyphicon-sunglasses" aria-hidden="true" ></span>&nbsp;编辑
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="w in listOfGoodsDatas">
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                {{w.goodsName}}
                                            </td>
<!--                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">-->
<!--                                                <span  ng-if="w.goods_attribute =='1'">商品</span>-->
<!--                                                <span  ng-if="w.goods_attribute =='2'">赠品</span>-->
<!--                                                <span  ng-if="w.goods_attribute == null">暂无</span>-->
<!--                                            </td>-->
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                <span ng-if="w.goods_type == '' || w.goods_type == null">暂无数据</span>
                                                <span  ng-if="w.goods_type != '' || w.goods_type == null">{{w.goods_type}}</span>
                                            </td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                <span ng-if="w.goodsBrand == '' || w.goods_type == null">暂无数据</span>
                                                <span  ng-if="w.goodsBrand != '' || w.goods_type == null">{{w.goodsBrand}}</span>
                                            </td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                <span ng-if="w.unitPrice == '' || w.unitPrice == null">暂无数据</span>
                                                <span  ng-if="w.unitPrice != '' || w.unitPrice == null">{{w.unitPrice}}</span>
                                            </td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                <span ng-if="w.intoNum == '' || w.intoNum == null">暂无数据</span>
                                                <span  ng-if="w.intoNum != '' || w.intoNum == null">{{w.intoNum}}</span>
                                            </td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="commodityDetails(w.id,w.unit,w.goods_type_id,w.intoNum)">
                                                <span ng-if="w.storage_num == '' || w.storage_num == null">暂无数据</span>
                                                <span  ng-if="w.storage_num != '' || w.storage_num == null">{{w.storage_num}}</span>
                                            </td>
                                            <td class="tdButtonContent">
                                                <button class="btn btn-success tdBtn" data-toggle="modal" data-target="#goodsWarehousingModel"  ng-click="goodsWarehousing(w.id,w.unit)">
                                                    <span>入库</span>
                                                </button>
                                                <button class="btn btn-warning tdBtn" data-toggle="modal" data-target="#goodsOutOfStock" ng-click="goodsOutOfStock(w.id,w.unit)">
                                                    <span>出库</span>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/nodata.php',['name'=>'shopShow']); ?>
                                    <?= $this->render('@app/views/common/nodata.php'); ?>
                                    <?= $this->render('@app/views/common/pagination.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 显示详情 -->
    <div class="modal fade" id="myModals2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog myModals2Dialog" role="document">
            <div  class="modal-content clearfix myModals2Content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">商品详情</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-5" >
                        <div class="modal-header" >
                            <li role="presentation" class="dropdown">
                                <a id="drop5" class="fs15" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    请选择类型
                                    <span class="caret"></span>
                                </a>
                                <ul id="menu2" class="dropdown-menu"  aria-labelledby="drop5">
                                    <li role="separator"  class="divider"></li>
                                    <li>
                                        <div data-toggle="modal" data-target="#commodityModification" ng-click="commodityModification()" class="text-center fs14" >
                                            修改
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <div data-toggle="modal" data-target="#commodityLoss" ng-click="commodityLoss()" class="text-center fs14" >
                                            商品报损
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <div data-toggle="modal" data-target="#merchandiseReturns" ng-click="merchandiseReturns()" class="text-center fs14" >
                                            商品退货
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <div data-toggle="modal" data-target="#commodityOverflow" ng-click="commodityOverflow()" class="text-center fs14" >
                                            商品报溢
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </div>
                        <div class="modal-body myModals2ModalBody">
                            <strong>{{commodityDetailsDatessssss.goodsName}} </strong><br>
                            <strong>{{commodityDetailsDatessssss.goods_type}}/{{commodityDetailsDatessssss.unitPrice}}元 /{{commodityDetailsDatessssss.storage_num}} {{commodityDetailsDatessssss.unit}}</strong>
                            <ul id="modal_body2_ul" class="pd0 mt15">
                                <li>商品品牌:
                                    <span ng-if="commodityDetailsDatessssss.goodsBrand == '' || commodityDetailsDatessssss.goodsBrand == null">暂无数据</span>
                                    <span  ng-if="commodityDetailsDatessssss.goodsBrand != '' ||commodityDetailsDatessssss.goodsBrand == null">{{commodityDetailsDatessssss.goodsBrand}}</span>
                                </li>
                                <li>商品型号: {{commodityDetailsDatessssss.goodsModel | noData:''}}</li>
                                <li>生产商: {{commodityDetailsDatessssss.goodsProducer | noData:''}}</li>
                                <li>供应商: {{commodityDetailsDatessssss.goodsSupplier | noData:''}}</li>
                            </ul>
                        </div>
                        <div class="modal-footer myModals2ModalFooter">
                            <button  class="btn btn-success" data-toggle="modal" data-target="#goodsWarehousingModel1" ng-click="goodsWarehousing1()">
                                <span>入库</span>
                            </button>
                            <button  data-toggle="modal" data-target="#goodsOutOfStock1" class="btn btn-warning" ng-click="goodsOutOfStock1()">
                                <span>出库</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-7 myModals2ModalRigthDiv">
                        <table class="table" >
                            <thead>
                            <tr>
                                <th>状态</th>
                                <th>数量</th>
                                <th>日期</th>
                                <th>单号</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="w in commodityDetailsDataList">
                                <td ng-if="w.status == '1'">入库</td>
                                <td ng-if="w.status == '2'">出库</td>
                                <td ng-if="w.status == '3'">报损</td>
                                <td ng-if="w.status == '4'">退库 </td>
                                <td ng-if="w.status == '5'">报溢 </td>
                                <td>{{w.operation_num}}{{w.unit}}</td>
                                <td>{{w.create_at *1000 | date:'yyyy-MM-dd HH:mm'}} </td>
                                <td>{{w.list_num | noData:''}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'shopDetailShow']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    商品修改-->
    <div class="modal fade" id="commodityModification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix commodityModificationModalContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改商品</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group commodityModificationInput" >
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品单价</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="请输入商品单价" ng-model="commodityModificationUpdata.unit_price" onmousewheel="return false;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="completeModificationAdd()">完成修改</button>
                </div>
            </div>
        </div>
    </div>
<!--商品入库-->
    <div class="modal fade" id="goodsWarehousingModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog w35h605" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">商品入库</h4>
                </div>
                <div class="modal-body boxModal-body">
                    <div class="row">
                        <form class="form-horizontal">
                            <input  id="_csrf" type="hidden"
                                    name="<?= \Yii::$app->request->csrfParam; ?>"
                                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group col-sm-12" >
                                <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>入库数量</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control w160" placeholder="请输入入库数量" ng-model="warehousingQuantity" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" oncontextmenu = "value=value.replace(/[^0-9]/g,'')" onmousewheel="return false;">
                                </div>
                                <div class="col-sm-3"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>单号</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control w160" placeholder="请输入单号" ng-model="warehouseReceiptNo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="quxiao()">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="goodsWarehousingAdd(warehousingQuantity,warehouseReceiptNo)">添加</button>
                </div>
            </div>
        </div>
    </div>
    <!--商品详情 商品入库-->
    <div class="modal fade" id="goodsWarehousingModel1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog w35h605" role="document" >
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">商品入库</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal">
                            <input  id="_csrf" type="hidden"
                                    name="<?= \Yii::$app->request->csrfParam; ?>"
                                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group col-sm-12 goodsWarehousingModelInput" >
                                <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>入库数量</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" placeholder="请输入入库数量" ng-model="warehousingQuantity1" onmousewheel="return false;" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" oncontextmenu = "value=value.replace(/[^0-9]/g,'')">
                                </div>
                                <div class="col-sm-3"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                            </div>
                            <div class="form-group goodsWarehousingModelInput col-sm-12" >
                                <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>单号</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="请输入单号" ng-model="warehouseReceiptNo1">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="rkqx()">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="goodsWarehousing1Add(warehousingQuantity1,warehouseReceiptNo1)">添加</button>
                </div>
            </div>
        </div>
    </div>
    <!--商品报损-->
    <div class="modal fade" id="commodityLoss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">商品报损</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal h150">
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12 goodsWarehousingModelInput" >
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品报损</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" placeholder="多少" ng-model="commodityLossNumber" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))">
                            </div>
                            <div class="col-sm-2"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                        </div>
                        <div class="form-group col-sm-12 goodsWarehousingModelInput mt15">
                            <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>商品描述</label>
                            <div class="col-sm-6">
                                <textarea class="commodityLossTextTextarea ml0" ng-model="commodityLossText" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="commodityLossAdd(commodityLossNumber,commodityLossText)">完成</button>
                </div>
            </div>
        </div>
    </div>
<!--商品退货-->
    <div class="modal fade" id="merchandiseReturns" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog w35h605" role="document" >
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">商品退货</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal h150">
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12 goodsWarehousingModelInput">
                            <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>商品退货</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" placeholder="多少" ng-model="merchandiseReturnsNumber" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))">
                            </div>
                            <div class="col-sm-2"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                        </div>
                        <div class="form-group commodityModificationInput col-sm-12 mt15" >
                            <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>商品描述</label>
                            <div class="col-sm-6">
                                <textarea ng-model="merchandiseReturnsText" class="w183 form-control" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="merchandiseReturnsAdd(merchandiseReturnsNumber,merchandiseReturnsText)">完成</button>
                </div>
            </div>
        </div>
    </div>
<!--商品报溢-->
    <div class="modal fade" id="commodityOverflow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog w35h605" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">商品报溢</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal h150">
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12 goodsWarehousingModelInput" >
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品报溢</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" placeholder="多少" ng-model="commodityOverflowNumber" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))">
                            </div>
                            <div class="col-sm-2"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                        </div>
                        <div class="form-group col-sm-12 goodsWarehousingModelInput mt15" >
                            <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>商品描述</label>
                            <div class="col-sm-6">
                                <textarea ng-model="commodityOverflowText" class="commodityLossTextTextarea ml0" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="commodityOverflowAdd(commodityOverflowNumber,commodityOverflowText)">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--    商品出库-->
    <div class="modal fade" id="goodsOutOfStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">商品出库</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal">
                            <input  id="_csrf" type="hidden"
                                    name="<?= \Yii::$app->request->csrfParam; ?>"
                                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group col-sm-12 goodsWarehousingModelInput" >
                                <label class="col-sm-4 control-label commodityModificationStrong" ><span class="commodityModificationSpan">*</span>商品出库</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control w160" placeholder="多少" ng-model="goodsOutOfStockNumber" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" oncontextmenu = "value=value.replace(/[^0-9]/g,'')" onmousewheel="return false;">
                                </div>
                                <div class="col-sm-2"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                            </div>
                            <div class="form-group col-sm-12 goodsWarehousingModelInput mt15" >
                                <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品单号</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control w160 " placeholder="商品单号" ng-model="goodsOutOfStockListNum" onmousewheel="return false;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="ckqx()">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="goodsOutOfStockAdd(goodsOutOfStockNumber,goodsOutOfStockListNum)">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--  详情商品  商品出库-->
    <div class="modal fade" id="goodsOutOfStock1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">商品出库</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="form-horizontal">
                            <input  id="_csrf" type="hidden"
                                    name="<?= \Yii::$app->request->csrfParam; ?>"
                                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group col-sm-12 goodsWarehousingModelInput">
                                <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品出库</label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" placeholder="多少" ng-model="goodsOutOfStockNumber1" onmousewheel="return false;" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" oncontextmenu = "value=value.replace(/[^0-9]/g,'')">
                                </div>
                                <div class="col-sm-2"><span class="spanSize">{{commodityDetailsUnit}}</span></div>
                            </div>
                            <div class="form-group col-sm-12 goodsWarehousingModelInput mt15">
                                <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品单号</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control"  placeholder="商品单号" ng-model="goodsOutOfStockListNums">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="detailck()">取消</button>
                    <button type="button" class="btn btn-primary" ng-click="goodsOutOfStock1Add(goodsOutOfStockNumber1,goodsOutOfStockListNums)">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--    商品增加-->
    <div class="modal fade" id="commodityIncrease" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"  id="myModalLabel">新增商品</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="commodityIncreaseForm">
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
<!--                        <div class="form-group commodityModificationInput">-->
<!--                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品类型</label>-->
<!--                            <div class="col-sm-8">-->
<!--                                <select  class="form-control" id="shopType"  style="padding-top: 2px;">-->
<!--                                    <option value="">请选择商品类型</option>-->
<!--                                    <option value="1">商品</option>-->
<!--                                    <option value="2">赠品</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="form-group commodityModificationInput pr20 pl10" >
                            <div class="col-sm-12">
                                <label class="col-sm-2 pd0 control-label commodityModificationStrong" style="margin-left: 59px"><span class="commodityModificationSpan">*</span>商品类别</label>
                                <div class="col-sm-5" >
                                    <select  class="form-control pt2 w150" ng-change="categoryAddData(increaseAddData.id)" ng-model="increaseAddData.id" >
                                        <option value="">请选择</option>
                                        <option ng-selected="increaseAddData.id == w.id" value="{{w.id}}" ng-repeat="w in commodityData">{{w.goods_type}}</option>
                                    </select>
                                </div>
                                <div  class="col-sm-1"></div>
                                <div class="col-sm-4 pd0 w110">
                                    <button type="button" class="btn btn-info btn-sm " data-toggle="modal" data-target="#exampleModal"  ng-click="customAdd()" >自定义</button>
                                    <button type="button" class="btn btn-warning btn-sm" ng-click="deleteCategory(increaseAddData.id)">删除</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput" >
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品单位</label>
                            <div class="col-sm-8">
                                <select  class="form-control pt2 w208 " ng-model="increaseAddData.unit">
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
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control w208" ng-model="increaseAddData.commodityName" placeholder="请输入商品名称">
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品品牌</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control w208" ng-model="increaseAddData.commodityBrand" placeholder="请输入商品品牌">
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品型号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control w208" ng-model="increaseAddData.commodityModel" placeholder="请输入商品型号">
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="commodityModificationSpan">*</span>商品单价</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control w208"  ng-model="increaseAddData.itemPricing" placeholder="0.00 / 元" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" oncontextmenu = "value=value.replace(/[^0-9]/g,'')" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong">生产商</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control w208" ng-model="increaseAddData.manufacturer" placeholder="请输入生产商">
                            </div>
                        </div>
                        <div class="form-group commodityModificationInput">
                            <label class="col-sm-4 control-label commodityModificationStrong">供应商</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control w208" ng-model="increaseAddData.supplier" placeholder="请输入供应商">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="commodityIncreaseAdd()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--  添加自定义商品 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">请输入自定义商品</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">请输入:</label>
                            <input type="text" class="form-control" id="recipient-name" ng-model="customSalesChannels">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" ng-click="confirmAdd(customSalesChannels)">确定添加</button>
                </div>
            </div>
        </div>
    </div>
</div>
