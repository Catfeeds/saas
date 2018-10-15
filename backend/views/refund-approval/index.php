<?php
/**
 * Created by PhpStorm.
 * User: 杨大侠
 * Date: 2017/8/26
 * Time: 10:54
 */
use backend\assets\RefundApprovalAsset;

RefundApprovalAsset::register($this);
$this->title = '退款审批';
?>
<main ng-controller="refundApprovalCtrl" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <header>
        <div class="wrapper wrapper-content  animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                             <span
                                style="display: inline-block"><b class="spanSmall">退款审批</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="input-group">
                                    <input type="text" ng-model="keywords" ng-keydown="enterSearch()"
                                           class="form-control headerSearch h34px" placeholder="  请输入订单编号进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" ng-click="searchAbout()"
                                                    class="btn btn-primary">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" ng-click="cleanSearchButton()"
                                        class="btn btn-info" style="margin-left: 10px;">清空</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
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
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
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
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;申请人
                                        </th>
                                        <th ng-click="changeSort('order_time',sort)" class="sorting listTable3"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;日期
                                        </th>
                                        <th ng-click="changeSort('status',sort)" class="sorting listTable1" tabindex="0"
                                            aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;状态
                                        </th>
                                        <th ng-click="changeSort('payee_name',sort)" class="sorting listTable2"
                                            tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;理由
                                        </th>
                                        <th class="sorting listTable2" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="($index,w) in listDateItem">
                                        <td>{{w.venue_name}}</td>
                                        <td>{{w.order_number}}</td>
                                        <td>{{w.member_name}}</td>
                                        <td>{{w.note}}</td>
                                        <td>{{w.total_price | noData:''}}</td>
                                        <td>
                                            {{w.payee_name | noData:''}}
                                        </td>
                                        <td>{{w.apply_time *1000| date:'yyyy-MM-dd'}}</td>
                                        <td>
                                            <small class="label label-primary" ng-if="w.status == 4 ">申请退款</small>
                                            <small class="label label-success" ng-if="w.status == 5">已同意</small>
                                            <small class="label label-danger" ng-if="w.status == 6">已拒绝</small>
                                        </td>
                                        <td ng-mouseleave="reasonsForReFundLeave($index)" ng-mouseenter="reasonsForRefund($index)">
                                            <span  class="tooltipBtn" data-toggle="tooltip" data-placement="bottom" title="{{w.refund_note}}">退款理由</span>
                                        </td>
                                        <td class="tdBtn" ng-if="w.status == 4">
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('refund','AUDIT')){ ?>
                                            <button type="button" data-toggle="modal" data-target="#applyForRefund"
                                                    ng-click="refunded(w.id)" class="btn  btn-sm btn-danger">不同意
                                            </button>
                                            <button type="button" class="btn  btn-sm btn-success"
                                                    ng-click="agree(w.id, w.venue_id)">同意
                                            </button>
                                            <?php } ?>
                                        </td>
                                        <td class="tdBtn" ng-if="w.status == 5 || w.status == 6">
                                            <span data-toggle="modal" data-target="#agreeRefuse"
                                                  ng-click="agreeRefuse(w.id,w.status,w.payee_name)">查看详情<span class="glyphicon glyphicon-menu-right"></span></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <div class="row">
                                    <div class="col-sm-12 text-cneter">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                             id="DataTables_Table_0_paginate">
                                            <?= $this->render('@app/views/common/pagination.php'); ?>
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
    <!--详情模态框-->
    <div class="modal fade" id="agreeRefuse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content w700px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">退款审批详情</h4>
                </div>
                <div class="modal-footer pd35px">
                    <div class="col-sm-12 col-xs-12 pd0">
                        <div class="col-sm-12 col-xs-12 h200px pd0">
                            <div class="col-sm-6 col-xs-6 h200px borderRigth borderBottom ">
                                <div class="col-sm-12 col-xs-12 pt50px textAlignLeft">
                                    <span>申请人:</span>&nbsp;&nbsp;
                                    <strong>
                                         {{applicant |noData:''}}
                                        <!-- <span ng-if="refundedsItem.member_name == null">
                                             {{refundedsItem.member.username}}
                                         </span>
                                        <span ng-if="refundedsItem.member_name != null">
                                            {{refundedsItem.member_name}}
                                        </span>-->
                                    </strong>
                                </div>
                                <div class="col-sm-12 col-xs-12 textAlignLeft pt30px">
                                    <span>日&emsp;期:&nbsp;&nbsp;{{refundedsItem.apply_time *1000 | date:'yyyy-MM-dd'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 h200px borderBottom">
                                <div class="col-sm-12 pt50px textAlignLeft">
                                    <span>申请理由:</span>
                                </div>
                                <div class="col-sm-12 col-xs-12 pt30px">
                                    <textarea rows="3" cols="40" ng-model="refundedsItem.refund_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 h200px pd0">
                            <div class="col-sm-6 col-xs-6 h200px borderRigth">
                                <div class="col-sm-12 col-xs-12 pt50px textAlignLeft">
                                    <span>审批人:</span>&nbsp;&nbsp;
                                    <strong ng-if="refundedsItem.approvalName == null || refundedsItem.approvalName == ''">{{refundedsItem.payee_name}}</strong>
                                    <strong ng-if="refundedsItem.approvalName != null && refundedsItem.approvalName != ''">{{refundedsItem.approvalName}}</strong>
                                </div>
                                <div class="col-sm-12 col-xs-12 textAlignLeft pt30px">
                                    <span>日&emsp;期: &nbsp;&nbsp;{{refundedsItem.review_time *1000 | date:'yyyy-MM-dd'}}</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6  h200px">
                                <div class="col-sm-12 col-xs-12 pt50px textAlignLeft">
                                    <span>订单状态:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong ng-if="refundedsStart == 6">
                                        <span>取消订单失败</span>
                                    </strong>
                                    <strong ng-if="refundedsStart == 5">
                                        <span>取消订单完成</span>
                                    </strong>
                                </div>
                                <div class="col-sm-12 col-xs-12 pt30px" ng-if="refundedsStart == 6">
                                    <textarea rows="3" cols="40" ng-model="refundedsItem.refuse_note" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  拒绝审批  -->
    <div class="modal fade" id="applyForRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel">拒绝原因</h4>
                </div>
                <div class="modal-body">
                    <div class="">
                        <b>拒绝原因:</b>
                    </div>
                    <div class="row mT10">
                        <div class="col-sm-12">
                            <textarea rows="10" ng-model="refund" style="resize: none;width: 100%;">

                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button class="btn btn-success" ng-click="refundedOk(refund)">提交</button>
                </div>
            </div>
        </div>
    </div>
</main>
