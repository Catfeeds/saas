<?php
use backend\assets\OrderAsset;

OrderAsset::register($this);
$this->title = '订单管理';
?>

<div ng-controller='orderCtrl' ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <header>
        <div class="wrapper wrapper-content  animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading"><span
                                style="display: inline-block"><b class="spanSmall">订单管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="input-group">
                                    <input type="text" ng-model="keywords" ng-keydown="enterSearch()"
                                           class="form-control headerSearch" placeholder="  请输入购买人、订单编号进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" ng-click="searchAbout()"
                                                    class="btn btn-primary">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'DOWNLOAD')) { ?>
                            <div class="col-sm-3 text-right">
                                <a class="ladda-button btn btn-success dim" href="/order/get-order-excel">
                                    导出文件
                                </a>
                            </div>
                            <?php } ?>
                            <div class="col-sm-12">
                                <div class="col-sm-4 pdLr0" style="font-size: 14px;">
                                    <b>条件筛选</b>
                                </div>
                            </div>
                            <section class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="input-daterange input-group cp" id="container">
                                        <span class="add-on input-group-addon"">选择日期</span>
                                        <input type="text" readonly name="reservation" id="sellDate" class="form-control text-center userSelectTime reservationExpire">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-3" style="padding-left: 0" >
                                    <!-- 1未付款，2已付款，3其他，5已退款，4申请退款-->
                                    <select ng-model="orderStatus" class="form-control selectCss ">
                                        <option value="">请选择订单状态</option>
                                        <option value="1">未付款</option>
                                        <option value="2">已付款</option>
                                        <option value="5">已退款</option>
                                        <option value="4">申请退款</option>
                                        <option value="3">其他</option>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-3" style="padding-left: 0">
                                    <select ng-model="businessBehavior" class="form-control selectCss ">
                                        <option value="">请选择业务行为</option>
                                        <option value="1">私教产品</option>
                                        <option value="2">私教小团体课程</option>
                                        <option value="3">卡种购买</option>
                                        <option value="4">卡种续费</option>
                                        <option value="5">卡种升级</option>
                                        <option value="6">租柜</option>
                                        <option value="7">续柜</option>
                                        <option value="8">跨店升级</option>
                                        <!--<option value="8">app购买</option>-->
                                        <option value="11">转课</option>
                                        <option value="10">其它</option>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-3" style="padding-left: 0">
                                    <select ng-model="paymentType" class="form-control selectCss ">
                                        <option value="">请选择支付方式</option>
                                        <option value="1">现金</option>
                                        <option value="2">支付宝</option>
                                        <option value="3">微信</option>
<!--                                        <option value="4">POS机</option>-->
                                        <option value="5" >建设分期</option>
                                        <option value="6" >广发分期</option>
                                        <option value="7" >招行分期</option>
                                        <option value="8" >借记卡</option>
                                        <option value="9" >贷记卡</option>
                                    </select>
                                </div>
                                <div class="col-md-1 pd0 col-sm-3">
                                    <select ng-model="sellVenueId" class="form-control selectCss ">
                                        <option value="">请选择售卖场馆</option>
                                        <option value="{{venue.id}}" ng-repeat="venue in allVenueSellLists">
                                            {{venue.name}}
                                        </option>
                                        <option ng-if="VenueStautsLength" value="" >
                                            暂无数据
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <div style="display: flex;">
                                        <input type="text" inputnum ng-model="floorPrice" placeholder="最低价"
                                               class="form-control  order-header-input" style="width: 50%">
                                        <input type="text" checknum ng-model="ceilingPrice" placeholder="最高价"
                                               class="form-control  order-header-input" style="width: 50%">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <button class="btn btn-sm btn-info" ng-click="searchAppBuy()">手机端购买</button>
                                </div>
                                <div class="col-md-1 col-sm-1 text-right">
                                    <button class="btn btn-sm btn-success" ng-click="searchAbout()">确定</button>
                                   <!-- <button style="float: left;" class="btn btn-sm btn-default" ng-click="searchClear()">清空</button>-->
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <button class="btn btn-sm btn-default" ng-click="searchClear()">清空</button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>订单信息列表</h5>
                            <div class="ibox-tools"></div>
                        </div>
                        <div class="ibox-content orderList">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row orderList1">
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        </div>
                                    </div>
                                </div>
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th ng-click="changeSort('venue',sort)" class="sorting listTable" tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"><span
                                                class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;售卖场馆
                                        </th>
                                        <th ng-click="changeSort('order_number',sort)" class="sorting listTable1"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"><span
                                                class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;订单编号
                                        </th>
                                        <th ng-click="changeSort('member_name',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="平台：激活排序列升序"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;购买人
                                        </th>
                                        <th ng-click="changeSort('card_name',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 208px"><span
                                                class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbsp;业务行为
                                        </th>
                                        <th ng-click="changeSort('total_price',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;价格
                                        </th>
                                        <th ng-click="changeSort('sell_people_name',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;售卖人
                                        </th>
                                        <th ng-click="changeSort('payee_name',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;操作人
                                        </th>
                                        <th ng-click="changeSort('order_time',sort)" class="sorting listTable3"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;日期
                                        </th>
                                        <th ng-click="changeSort('status',sort)" class="sorting listTable1" tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 100px;"><span
                                                class="glyphicon glyphicon-sound-stereo" aria-hidden="true" ></span>&nbsp;状态
                                        </th>
                                        <th class="sorting listTable4" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1" aria-label="CSS等级：激活排序列升序"><span
                                                class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="gradeA odd" ng-repeat='item in items'>
                                        <td>{{item.venue_name}}</td>
                                        <td>{{item.order_number}}</td>
                                        <td style="text-align: left">
                                            <span style="margin-right: 10px;">
                                                <img class="img-rounded" style="width: 40px;height: 40px;" ng-if="item.pic == null || item.pic == ''" ng-src="../plugins/img/222.png">
                                                <img class="img-rounded" style="width: 40px;height: 40px;" ng-if="item.pic != null && item.pic != ''" ng-src="{{item.pic}}">
                                            </span>
                                            <span title="{{item.username}}" ng-if="item.member_name == null">{{item.member.username | cut:true:5:"..." }}</span>
                                            <span title="{{item.member_name}}" ng-if="item.member_name != null">{{item.member_name | cut:true:5:"..."}}</span>
                                        </td>
                                        <td>{{item.note}}</td>
                                        <td>
                                            <span ng-if="item.net_price != null">{{item.net_price | number:2 | noData:''}}</span>
                                            <span ng-if="item.net_price == null">{{item.total_price | number:2 | noData:''}}</span>
                                        </td>
                                        <td>{{item.sellName != null && item.sellName !=''? item.sellName:'手机端购买' }}</td>
<!--                                        <td ng-if="item.consumption_type == 'cabinet'">暂无数据</td>-->
                                        <td>{{item.payee_name | noData:''}}</td>
                                        <td>{{(item.order_time)*1000 | date:'yyyy-MM-dd'}}</td>
                                        <td>
                                            <small class="label label-primary" ng-if="item.status == 1">未付款</small>
                                            <small class="label label-success" ng-if="item.status == 2">已付款</small>
                                            <small class="label  label-warning" ng-if="item.status == 3">已取消</small>
                                            <small class="label label-primary" ng-if="item.status == 4 ">申请退款</small>
                                            <small class="label label-info" ng-if="item.status == 5">已退款</small>
                                            <small class="label label-danger" ng-if="item.status == 6">已拒绝</small>
                                            <small class="label label-danger" ng-if="item.status == null || item.status == ''">暂无数据</small>
                                        </td>
                                        <td class="tdBtn" >
                                            <!--   未付款-->
                                            <span ng-if="item.status == 1">
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'CANCLEORDER')) { ?>
                                                <button class="btn btn-sm btn-warning"
                                                        ng-click="cancelOrder(item.id)">
                                                    取消订单
                                                </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'PAY')) { ?>
                                                <button class="btn btn-success btn-sm"
                                                        type="submit"
                                                        data-toggle="modal"
                                                        data-target="#myModals"
                                                        class="listEdit"
                                                        ng-click="getOrderInfo(item.id)">
                                                    支付
                                                </button>
                                                <?php } ?>
                                            </span>
                                            <!--                                        已付款-->
                                            <span ng-if="item.status == 2">
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'ORDERDETAIL')) { ?>
                                                 <button class="btn btn-success btn-sm"
                                                         type="submit" data-toggle="modal"
                                                         data-target="#my"
                                                         class="listEdit"
                                                         ng-click="getOrderInfo(item.id,item.member_name)">
                                                         查看订单
                                                </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'UPDATESELLPEOPLE')) { ?>
                                                <button class="btn btn-success btn-sm"
                                                        type="submit" data-toggle="modal"
                                                        data-target="#updateSellModals"
                                                        class="listEdit"
                                                        ng-click="updateSellInfo(item.id,item.member_name,item.venue_id,item.note,item.total_price,item.order_time,item.sell_people_id,item.consumption_type)">
                                                         售卖人修改
                                                </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order', 'ORDERDELET')) { ?>
                                                    <button class="btn btn-danger btn-sm"
                                                            type="submit" data-toggle="modal"
                                                            class="listEdit"
                                                            ng-click="deletingOrder(item.id)">
                                                         删除
                                                    </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('order','ORDERUPDATE')) { ?>
                                                <button class="btn btn-success btn-sm"
                                                        type="submit" data-toggle="modal"
                                                        data-target="#updateModals"
                                                        class="listEdit"
                                                        ng-click="updateOrderInfo(item.id,item.member_name,item.venue_id,item.note,item.total_price,item.order_time,item.sell_people_id,item.consumption_type)">
                                                         订单修改
                                                </button>
                                                <?php } ?>
                                            </span>
                                            <span ng-if="item.status == 3">
                                                <!--                                            已取消-->
                                            订单已取消
                                            </span>
                                            <span ng-if="item.status == 4">
                                                <!--                                      申请退款详情-->
                                                <button class="btn btn-sm btn-info"
                                                        data-toggle="modal"
                                                        data-target="#applyForRefundModal"
                                                        ng-click="applyForRefundModal(item.id)">
                                                        查看详情
                                                </button>
                                            </span>
                                            <span ng-if="item.status == 6">
                                                <!--                                      已拒绝-->
                                                <button class="btn btn-sm btn-info"
                                                        data-toggle="modal"
                                                        data-target="#rejected"
                                                        ng-click="rejected(item.id,item.status)">
                                                        查看详情
                                                </button>
                                            </span>
                                            <span ng-if="item.status == 5">
                                                <!--                                      已退款-->
                                                <button class="btn btn-sm btn-info"
                                                        data-toggle="modal"
                                                        data-target="#refunded"
                                                        ng-click="refunded(item.id,item.status)">
                                                        查看详情
                                                </button>
                                            </span>
                                            <span ng-if="item.note == '续费' && item.status == null">
                                                <button class="btn btn-success btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#my"
                                                        class="listEdit"
                                                        ng-click="getOrderInfo(item.id,item.member_name)">
                                                    查看订单
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <div class="row">
                                    <div class="col-sm-12 text-right" ng-if="itemsLength > 0">
                                        <span>总金额: <span style="font-size: 18px;color:orange;">{{itemsAllMoney | number:2}}</span>元&emsp;&emsp;</span>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                            <?=$this->render('@app/views/common/page.php');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--支付页面详情-->
    <div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="updateMoney">
                        <img src="/plugins/img/zhifu.png">
                        <div class="sureMoney"><b>确认支付...</b>
                            <div class="money"><b>需支付{{orderInfo.total_price}}￥</b></div>
                            <div class="okMOney"><b>需支付完成后，点击"确认支付"按钮</b></div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>订单列表详情</h5>
                                </div>
                                <div class="ibox-content">
                                    <div>售卖场馆:<span class="orderDetail">{{orderInfo.venue_name}}</span>
                                        <p style="margin-left: 347px;margin-top: -17px">价格&emsp;&emsp;:<span class="orderDetail">{{orderInfo.total_price | number:2 |noData:''}}元</span>
                                        </p>
                                    </div>
                                    <div>订单编号:<span class="orderDetail">{{orderInfo.order_number}}</span>
                                        <p class="detailPersonal">操作人员:<span class="orderDetail">{{orderInfo.payee_name| noData:''}}</span>
                                        </p>
                                    </div>
                                    <div>购买人&emsp;:<span class="orderDetail">
                                                                                <span
                                                                                    ng-if="orderInfo.member_name == null">
                                            {{orderInfo.member.username}}
                                        </span>
                                        <span ng-if="orderInfo.member_name != null">
                                            {{orderInfo.member_name}}
                                        </span>
                                    </span>
                                        <p class="detailPersonal">售卖人员:<span class="orderDetail">{{orderInfo.sell_people_name | noData:''}}</span>
                                        </p>
                                    </div>
                                    <div>卡名称&emsp;:<span class="orderDetail">{{orderInfo.card_name}}</span></div>
                                </div>
                                <div class="detailCss"></div>
                            </div>

                            <div class="form-group" style=""><span class="payType">*</span>支付方式
                                <select class="form-control actions payType1" ng-model="payMoneyMode" style="padding: 4px 12px;">
                                    <option value="">请选择支付方式</option>
                                    <option value="1">现金</option>
                                    <option value="2">支付宝</option>
                                    <option value="3">微信</option>
<!--                                    <option value="4">pos机刷卡</option>-->
                                    <option value="5" >建设分期</option>
                                    <option value="6" >广发分期</option>
                                    <option value="7" >招行分期</option>
                                    <option value="8" >借记卡</option>
                                    <option value="9" >贷记卡</option>
                                </select>
                            </div>
                        <textarea placeholder="请输入订单详情信息" ng-model="note" class="form-control orderMessage" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a data-dismiss="modal" aria-hidden="true" href="#" ng-click="cancelOrder(orderInfo.id)"
                           class="orderDelete">取消订单</a>
                        <button ng-click="orderPayment(orderInfo.id)" type="button"
                                class="btn btn-success  btn-lg orderSure">确认支付
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--已支付页面详情-->
    <div class="modal fade" id="my" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 45%;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="updateHeader">
                        <img src="/plugins/img/zhifu.png">
                        <div class="payPerfe"><b>已付款</b>
                            <div class="money"><b>已支付￥{{orderInfo.total_price}}</b></div>
                            <div class="okMOney"><b>支付时间：{{(orderInfo.pay_money_time)*1000 | date:'yyyy-MM-dd HH:mm:ss'
                                    }}</b></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>订单列表详情</h5>
                                </div>
                                <div class="ibox-content row rowSpanStyle" style="margin: 0;padding: 20px 0 0 0;">
                                    <div class="col-sm-6">
                                        <p>售卖场馆:<span class="orderDetail">{{orderInfo.venue_name}}</span></p>
                                        <p>订单编号:<span class="orderDetail">{{orderInfo.order_number}}</span></p>
                                        <p>购买的人:
                                            <span class="orderDetail">
                                                     <span ng-if="orderInfo.member_name == null">
                                                        {{orderInfo.member.username}}
                                                    </span>
                                                    <span ng-if="orderInfo.member_name != null">
                                                        {{orderInfo.member_name}}
                                                    </span>
                                            </span>
                                        </p>
                                        <p>售卖人员:<span class="orderDetail">{{orderInfo.sellName}}</span></p>
                                        <p ng-if="orderInfo.consumption_type == 'card'">卡的名称:<span class="orderDetail">{{orderInfo.card_name}}</span> </p>
                                        <p ng-if="orderInfo.consumption_type == 'charge'">私课产品:<span class="orderDetail">{{orderInfo.card_name}}</span> </p>
                                        <p ng-if="orderInfo.consumption_type != 'card' && orderInfo.consumption_type != 'charge'">名称:<span class="orderDetail">{{orderInfo.card_name}}</span> </p>
                                    </div>
                                    <div class="col-sm-6" style="border-left: 1px solid #ccc;">
                                        <p>订单价格:<span class="orderDetail">{{orderInfo.total_price}}元</span></p>
                                        <p>操作人员:<span class="orderDetail">{{orderInfo.payee_name | noData:''}}</span></p>
                                        <p>
                                            付款途径：
                                            <span ng-if="orderInfo.many_pay_mode == null && orderInfo.pay_money_mode != null">
                                                <span ng-if="orderInfo.pay_money_mode == '1'"  class="orderDetail">现金</span>
                                                <span ng-if="orderInfo.pay_money_mode == '2'"  class="orderDetail">支付宝</span>
                                                <span ng-if="orderInfo.pay_money_mode == '3'"  class="orderDetail">微信</span>
                                                <span ng-if="orderInfo.pay_money_mode == '4'"  class="orderDetail">pos刷卡</span>
                                                <span ng-if="orderInfo.pay_money_mode == '5'"  class="orderDetail">建设分期</span>
                                                <span ng-if="orderInfo.pay_money_mode == '6'"  class="orderDetail">广发分期</span>
                                                <span ng-if="orderInfo.pay_money_mode == '7'"  class="orderDetail">招行分期</span>
                                                <span ng-if="orderInfo.pay_money_mode == '8'"  class="orderDetail">借记卡</span>
                                                <span ng-if="orderInfo.pay_money_mode == '9'"  class="orderDetail">贷记卡</span>
                                                <span>{{orderInfo.total_price|noData:''}}元</span>
                                            </span>
                                            <span ng-if="orderInfo.pay_money_mode == null || orderInfo.many_pay_mode != null">
                                                <span ng-repeat="ww in manyPayMode">
                                                    <span ng-if="ww.type == '1'" class="orderDetail">现金</span>
                                                    <span ng-if="ww.type == '2'" class="orderDetail">支付宝</span>
                                                    <span ng-if="ww.type == '3'" class="orderDetail">微信</span>
                                                    <span ng-if="ww.type == '4'" class="orderDetail">pos刷卡</span>
                                                    <span ng-if="ww.type == '5'" class="orderDetail">建设分期</span>
                                                    <span ng-if="ww.type == '6'" class="orderDetail">广发分期</span>
                                                    <span ng-if="ww.type == '7'" class="orderDetail">招行分期</span>
                                                    <span ng-if="ww.type == '8'" class="orderDetail">借记卡</span>
                                                    <span ng-if="ww.type == '9'" class="orderDetail">贷记卡</span>
                                                    <span>{{ww.price}}</span>元 /
                                                </span>
                                            </span>
                                            <span ng-if="orderInfo.pay_money_mode == null && orderInfo.many_pay_mode == null">暂无数据</span>
                                        </p>
                                        <p>业务行为:<span class="orderDetail">{{orderInfo.note}}</span></p>
                                        <p>订单备注:<span class="orderDetail">{{orderInfo.new_note|noData:''|cut:true:8:'...'}}</span></p>
                                    </div>
                                </div>
<!--                                <div class="orderFinish"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <?php if(\backend\models\AuthRole::canRoleByAuth('order','APPLYREFUND')){ ?>
                    <button ng-if="orderInfo.consumption_type != 'cabinet'" type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyForRefund"
                            ng-click="applyForRefund()">申请退款
                    </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--申请退款-->
    <div class="modal fade" id="applyForRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">申请退款</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        退款理由
                    </div>
                    <div class="row mT10">
                        <div class="col-sm-12">
                            <textarea rows="10"  ng-model="refund" style="resize: none;width: 100%;">
                                我是一个文本框。
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button class="btn btn-success" ng-click="submitARefund(refund)">提交</button>
                </div>
            </div>
        </div>
    </div>
    <!--已拒绝-->
    <div class="modal fade" id="rejected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content w700px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">拒绝退款详情</h4>
                </div>
                <div class="modal-footer pd35px">
                    <div class="col-sm-12   pd0">
                        <div class="col-sm-12 h200px pd0">
                            <div class="col-sm-6 h200px borderRigth borderBottom ">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请人:</span>&nbsp;&nbsp;
                                    <strong>
                                        {{rejectedData.payee_name |noData:''}}
                                       <!-- <span ng-if="rejectedData.member_name == null">
                                            {{rejectedData.member.username}}
                                        </span>
                                        <span ng-if="rejectedData.member_name != null">
                                            {{rejectedData.member_name}}
                                        </span>-->
                                    </strong>
                                </div>
                                <div class="col-sm-12 textAlignLeft pt30px">
                                    <span>日期 &nbsp;&nbsp;&nbsp;&nbsp;{{rejectedData.apply_time *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6 h200px borderBottom">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请理由:</span>
                                </div>
                                <div class="col-sm-12 pt30px">
                                        <textarea rows="3" cols="40" ng-model="rejectedData.refund_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 h200px pd0">
                            <div class="col-sm-6 h200px borderRigth">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>审批人:</span>&nbsp;&nbsp;
                                    <strong ng-if="rejectedData.approvalName == null">{{rejectedData.createName}}</strong>
                                    <strong ng-if="rejectedData.approvalName != null">{{rejectedData.approvalName}}</strong>
                                </div>
                                <div class="col-sm-12 textAlignLeft pt30px">
                                    <span>日期 &nbsp;&nbsp;&nbsp;&nbsp;{{rejectedData.review_time *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6  h200px">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>拒绝理由:</span>
                                </div>
                                <div class="col-sm-12 pt30px">
                                    <textarea rows="3" cols="40" ng-model="rejectedData.refuse_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    已退款-->
    <div class="modal fade" id="refunded" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content w700px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">退款审批详情</h4>
                </div>
                <div class="modal-footer pd35px">
                    <div class="col-sm-12   pd0">
                        <div class="col-sm-12 h200px pd0">
                            <div class="col-sm-6 h200px borderRigth borderBottom ">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请人:</span>&nbsp;&nbsp;
                                    <strong>
                                        {{refundedData.createName |noData:''}}
                                       <!-- <span ng-if="refundedData.member_name == null">
                                            {{refundedData.member.username}}
                                        </span>
                                        <span ng-if="refundedData.member_name != null">
                                            {{refundedData.member_name}}
                                        </span>-->
                                    </strong>
                                </div>
                                <div class="col-sm-12 textAlignLeft pt30px">
                                    <span>日期 &nbsp;&nbsp;&nbsp;&nbsp;{{refundedData.apply_time *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6 h200px borderBottom">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请理由:</span>
                                </div>
                                <div class="col-sm-12 pt30px">
                                    <textarea rows="3" cols="40" ng-model="refundedData.refund_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 h200px pd0">
                            <div class="col-sm-6 h200px borderRigth">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>审批人:</span>&nbsp;&nbsp;
                                    <strong ng-if="refundedData.approvalName == null">{{refundedData.createName}}</strong>
                                    <strong ng-if="refundedData.approvalName != null">{{refundedData.approvalName}}</strong>

                                </div>
                                <div class="col-sm-12 textAlignLeft pt30px">
                                    <span>日期 &nbsp;&nbsp;&nbsp;&nbsp;{{refundedData.review_time *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6  h200px">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>订单状态:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong
                                        ng-if="refundedStatus == 5">订单已取消</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    //申请退款详情-->
    <div class="modal fade" id="applyForRefundModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content w700px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">申请退款详情</h4>
                </div>
                <div class="modal-footer pd35px">
                    <div class="col-sm-12   pd0">
                        <div class="col-sm-12 h200px pd0">
                            <div class="col-sm-6 h200px borderRigth  ">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请人:</span>&nbsp;&nbsp;
                                    <strong>
                                        {{applyForRefundModalData.createName |noData:''}}
                                        <!--<span ng-if="applyForRefundModalData.member_name == null">
                                            {{applyForRefundModalData.member.username}}
                                        </span>
                                        <span ng-if="applyForRefundModalData.member_name != null">
                                            {{applyForRefundModalData.member_name}}
                                        </span>-->
                                    </strong>
                                </div>
                                <div class="col-sm-12 textAlignLeft pt30px">
                                    <span>日期 &nbsp;&nbsp;&nbsp;&nbsp;{{applyForRefundModalData.apply_time *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6 h200px ">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请理由:</span>
                                </div>
                                <div class="col-sm-12 pt30px">
                                    <textarea rows="3" cols="40" ng-model="applyForRefundModalData.refund_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--修改页面-->
    <div class="modal fade" id="updateModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >
                        修改订单信息
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>售卖场馆</div>
                    <select class="form-control actions colorGrey mL120" style="padding: 4px 12px;"  ng-model=venueId>
                        <option value=""  >请输入售卖场馆</option>
                        <option ng-repeat='item in allVenueS' value="{{item.id}}" >{{item.name}}</option>
                    </select>
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>售卖人员</div>
                    <select class="form-control actions colorGrey mL120" style="padding: 4px 12px;"  ng-model=employeeId>
                        <option value=""  >请选择售卖人员</option>
                        <option ng-repeat='item in employee' value="{{item.id}}" >{{item.name}}</option>
                        <input ng-model="datas._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    </select>
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>业务行为</div>
                    <div class="form-group text-center mL120" >
                        <input type="text" class="form-control actions" id="" ng-model=businessNote placeholder="请输入业务行为">
                    </div>
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>订单价格</div>
                    <div class="form-group text-center mL120" >
                        <input type="text" class="form-control actions" id="" ng-model=orderPrice placeholder="请输入订单价格">
                    </div>
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>下单日期</div>
                    <div class="form-group text-center mL120" >
<!--                        <input type="text" class="form-control actions" id="orderTime" value="{{(orderTime)*1000 | date:'yyyy-MM-dd'}}" placeholder="请输入下单日期">-->
                        <div style="width: 100%;height: 30px;" class="input-append date dateBox" id="orderTime" data-date="2017-06-09" data-date-format="yyyy-mm-dd">
                            <input style="width: 100%;height: 30px;" class="span2 form-group" size="16" type="text" value="" id="dateSpan" readonly ng-model="dateInput"/>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <center>
                        <button type="button" class="btn btn-success  btn-lg wB50"  ng-click="update()">
                            完成
                        </button>
                    </center>
            </div>
        </div>
    </div>
</div>
    <!--修改售卖人-->
    <!--修改页面-->
    <div class="modal fade" id="updateSellModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >
                        修改订单售卖人
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>售卖人员</div>
                    <select class="form-control actions colorGrey mL120" style="padding: 4px 12px;"  ng-model=employeeId>
                        <option value=""  >请选择售卖人员</option>
                        <option ng-repeat='item in employee' value="{{item.id}}" >{{item.name}}</option>
                        <input ng-model="datas._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    </select>

                    <center>
                        <button style="margin-top:15px;" type="button" class="btn  btn-primary  "  ng-click="updatesell()">
                            完成
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>