<?php
use backend\assets\WleaveRecordAsset;

WleaveRecordAsset::register($this);
$this->title = '请假记录';
?>
<div ng-controller="wLeaveRecordCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li class="orderMenu"><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li>场地管理</li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" ng-click="enterCard()" data-toggle="tab">请假记录</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0">
            <div class="panel-body detialS">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <!--列表-->
                        <div class=" col-sm-12 pd0" style="display: flex;flex-wrap: wrap;margin-bottom: 20px;">
                            <div class="w160 mR10 mT10 input-daterange input-group  float" >
                                <span class="add-on input-group-addon smallFont">选择日期</span>
                                <input type="text"
                                       readonly
                                       name="reservation"
                                       id="leaveStatisticsDate"
                                       ng-model="input1"
                                       class="form-control text-center userSelectTime reservationExpire" value="" style="width: 195px;"/>
                            </div>
                            <div class="mR10 mT10">
                                <select class="form-control " ng-model="venueCheck" ng-change="getVenueInfo(venueId)" style="padding: 0 12px;width: 145px;">
                                    <option value="">场馆选择</option>
                                    <option ng-repeat="v in venueList" value="{{v.id}}">{{v.name}}</option>
                                </select>
                            </div>
                            <div class="w160 mR10 mT10">
                                <select class="form-control selectCss "  ng-change="leaveStatusSelect(leaveStatus)" ng-model="leaveStatus">
                                    <option value="">全部请假</option>
                                    <option value="1">特殊请假</option>
                                    <option value="2">正常请假</option>
                                    <option value="3">学生请假</option>
                                </select>
                            </div>
                            <div class="w160 mR10 mT10">
                                <select class="form-control selectCss"  ng-change="approvalStatusSelect(approvalStatus)" ng-model="approvalStatus">
                                    <option value="">全部状态</option>
                                    <option value="1">待处理</option>
                                    <option value="2">已同意</option>
                                    <option value="3">已拒绝</option>
                                </select>
                            </div>
                            <div class="w160 mR10 mT10">
                                <select class="form-control selectCss" ng-change="cardSelectChange(cardListsSelect)"  ng-model="cardListsSelect">
                                    <option value="">请选择卡种</option>
                                    <option value="{{card.id}}" ng-repeat="card in cardLists">{{card.card_name}}</option>
                                </select>
                            </div>
                            <div class="mR10 mT10">
                                <input type="text" class="form-control h34" ng-model="memberNameKeywords" ng-keyup="memberNameSearchBtn($event)" placeholder="请输入姓名进行搜索...">
                            </div>
                            <div class="w160 mR10 mT10">
                                <button class="btn btn-sm btn-success" style="font-size: 12px;" ng-click="cleanSearchButton()">清空</button>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content pd0">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr role="row">
                                                <th style="width: 120px;background: #fff;" ng-if="approvalStatus == 1">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="chooseOnePage" style="vertical-align: text-bottom;">
                                                            <span>选择本页</span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>&nbsp;姓名</th>
                                                <th>&nbsp;性别</th>
                                                <th>&nbsp;手机号</th>
                                                <th>&nbsp;操作人</th>
                                                <th>&nbsp;请假途径</th>
                                                <th>&nbsp;请假天数</th>
                                                <th>&nbsp;请假日期</th>
                                                <th>&nbsp;卡种</th>
                                                <th>&nbsp;理由</th>
                                                <th>&nbsp;会员状态</th>
                                                <th>&nbsp;操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="leaveMember in specialLeaveLists">
                                                <td class="memberChooseTransfer" ng-if="approvalStatus == 1">
                                                    <input type="checkbox" data-choose="{{leaveMember.id}}"">
                                                </td>
                                                <td>{{leaveMember.DetailsName}}</td>
                                                <td>{{leaveMember.sex == '1'?'男': leaveMember.sex == '2'?'女':'暂无'}}</td>
                                                <td>{{leaveMember.mobile | noData:''}}</td>
                                                <td>
                                                    <span ng-show="leaveMember.source == 0 || leaveMember.source == 1">{{ leaveMember.name == null ? '暂无数据' : leaveMember.name }}</span>
                                                    <span ng-show="leaveMember.source == 2 || leaveMember.source == 3 || leaveMember.source == 4 ">{{ leaveMember.DetailsName }}</span>
                                                </td>
                                                <td>
                                                    <span ng-if="leaveMember.source == 1 || leaveMember.source == 0">电脑</span>
                                                    <span ng-if="leaveMember.source == 2">小程序</span>
                                                    <span ng-if="leaveMember.source == 3">公众号</span>
                                                    <span ng-if="leaveMember.source == 4">APP</span>
                                                </td>
                                                <td>{{leaveMember.leaveDay}}</td>
                                                <td>{{leaveMember.leave_start_time *1000 | date:'yyyy/MM/dd'}} - {{leaveMember.leave_end_time *1000 | date:'yyyy/MM/dd'}}</td>
                                                <td>{{ leaveMember.card_name | noData:'' }}</td>
                                                <td title="{{ leaveMember.note }}">{{leaveMember.note | cut:true:4:'...' | noData:''}}</td>
                                                <td>
                                                    <small class="label label-default" ng-if="leaveMember.type =='1'">待处理</small>
                                                    <small style='background-color: #00cc00;' class="label label-success" ng-if="leaveMember.type =='2'">已同意</small>
                                                    <small class="label label-danger" ng-if="leaveMember.type =='3'">已拒绝</small>
                                                </td>
                                                <td class="bind">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('specialLeave', 'AGREEORNOT')) { ?>
                                                        <span ng-if="leaveMember.type =='1'"  style="color: #00b0e8" ng-click="agree(leaveMember.id)">同意</span>
                                                        <span ng-if="leaveMember.type =='1'"  style="color: #00b0e8">|</span>
                                                        <span ng-if="leaveMember.type =='1'"  style="color: #00b0e8" ng-click="noAgree(leaveMember.id)" >不同意</span>
                                                        <span ng-if="leaveMember.type =='1'"  style="color: #00b0e8">|</span>
                                                    <?php } ?>
                                                        <span ng-if="leaveMember.type =='1'"  style="color: #00b0e8" ng-click="revocation(leaveMember.id)">撤销</span>
<!--                                                    <button type="button" class="btn btn-default btn-sm" ng-click="checkNoAgreeDetail(leaveMember.id)">查看详情></button>-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?=$this->render('@app/views/common/nodata.php',['name'=>'specialLeaveFlag','text'=>'暂无数据','href'=>true]);?>
                                        <?=$this->render('@app/views/common/pagination.php',['page'=>'specialLeavePages']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    不同意请假模态框 -->
    <div class="modal fade" id="noAgreeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">拒绝请假</h4>
                </div>
                <div class="modal-body">
                    <section class="row" style="margin-top: 20px;">
                        <div class="col-sm-3 text-right"><span class="red">*</span>原因</div>
                        <div class="col-sm-8">
                            <textarea  name="" id="noAgreeContent" ng-model="noAgreeContent"  rows="4" style="width: 100%;resize: none;text-indent: 2em;"></textarea>
                        </div>
                    </section>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success btn-sm w100" ng-click="noAgreeComplete()">完成</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
