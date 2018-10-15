<?php
use backend\assets\SpecialLeaveCtrlAsset;
SpecialLeaveCtrlAsset::register($this);
$this->title = '请假管理';
?>
<main ng-controller="specialLeaveCtrl" ng-cloak>
    <input id="_csrf" type="hidden"
           name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <section>
        <div class="wrapper wrapper-content  animated fadeIn">
            <div class="row">
                <div class="col-sm-12 pdLr0">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <span class="displayInline-block"><b class="spanBig">请假管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div  class=" col-sm-12 pd0  ">
                                <div class="col-sm-6 col-sm-offset-3 mT10" style="min-width: 300px;padding-left: 0;">
                                    <div class="input-group">
                                        <input type="text" class="form-control h34" ng-model="memberNameKeywords" ng-keyup="memberNameSearchBtn($event)" placeholder="请输入姓名进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary btn-sm" ng-click="memberNameSearchClick()">搜索</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-12 pd0  " style="display: flex;flex-wrap: wrap;">
                                <div class="w160 mR10 mT10 input-daterange input-group  float" >
                                    <span class="add-on input-group-addon smallFont">选择日期</span>
                                    <input type="text"
                                           readonly
                                           name="reservation"
                                           id="leaveStatisticsDate"
                                           ng-model="input1"
                                           class="form-control text-center userSelectTime reservationExpire" value="" style="width: 195px;"/>
                                </div>
                                <div class="form-group mR10 mT10" style="margin-left:120px;">
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
                                    <select class="form-control selectCss "  ng-change="approvalStatusSelect(approvalStatus)" ng-model="approvalStatus">
                                        <option value="">全部状态</option>
                                        <option value="1">待处理</option>
                                        <option value="2">已同意</option>
                                        <option value="3">已拒绝</option>
                                    </select>
                                </div>
                                <div class="w200 mR10 mT10">
                                   <select id="memberCardSelect123" class=" form-control"   style="width: 100%;padding: 6px 12px;" ng-change="cardSelectChange(cardListsSelect)"  ng-model="cardListsSelect">
                                       <option value="">请选择卡种</option>
                                       <option value="{{card.id}}" ng-repeat="card in cardLists">{{card.card_name}}</option>
                                   </select>
                                </div>
                                <div class="w160 mR10 mT10">
                                    <button class="btn btn-success" style="font-size: 12px;" ng-click="cleanSearchButton()">清空</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--批量同意按钮-->
                    <div class="panel panel-default" ng-if="approvalStatus == 1">
                        <div class="panel-body">
                            <?php if (\backend\models\AuthRole::canRoleByAuth('specialLeave', 'BATCHLEAVE')) { ?>
                                <button class="btn btn-info" ng-click="batchReviewBtn()">批量同意</button>
                            <?php } ?>
                        </div>
                    </div>
                    <!--列表-->
                    <div class="col-sm-12 pdLr0">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>请假列表</h5>
                                <div class="ibox-tools">
                                </div>
                            </div>
                            <div class="ibox-content pd0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row" style="display: none;">
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
                                            <th style="width: 120px;background: #fff;" ng-if="approvalStatus == 1">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="chooseOnePage" style="vertical-align: text-bottom;">
                                                        <span>选择本页</span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 140px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('member_name',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;姓名
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 100px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('member_sex',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;性别
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 200px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('member_mobile',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;手机号
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 140px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('member_applicant',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;操作人
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 140px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('source',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;请假途径
                                            </th>
<!--                                            请假天数-->
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 140px;"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('member_applicant',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;请假天数
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 240px;"
                                                rowspan="1" colspan="1" aria-label="平台：激活排序列升序"
                                                ng-click="changeSort('member_leaveTime',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;请假日期
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" style="width: 200px;"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('member_kind_card',sort)">
                                                <span class="" aria-hidden="true"></span>&nbsp;卡种
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 200px;"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('member_note',sort)">
                                                <span class=""
                                                      aria-hidden="true"></span>&nbsp;理由
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" style="width: 100px;"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('member_state',sort)">
                                                <span class=""
                                                      aria-hidden="true"></span>&nbsp;会员状态
                                            </th>
                                            <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0"style="width: 200px;"
                                                rowspan="1" colspan="1" aria-label="CSS等级：激活排序列升序">
                                                <span class="" aria-hidden="true"></span>&nbsp;操作
                                            </th>
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
                                            <td class="tdBtn">
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('specialLeave', 'AGREEORNOT')) { ?>
                                                <button ng-if="leaveMember.type =='1'" type="button" class="btn btn-success btn-sm" ng-click="agree(leaveMember.id)">同意</button>
                                                <button ng-if="leaveMember.type =='1'" type="button" class="btn btn-warning btn-sm" ng-click="noAgree(leaveMember.id)" >不同意</button>
                                                <?php } ?>
                                                <button ng-if="leaveMember.type =='1'" type="button" class="btn btn-danger btn-sm" ng-click="revocation(leaveMember.id)">撤销</button>
                                                <button ng-if="leaveMember.type =='3'" type="button" class="btn btn-default btn-sm" ng-click="checkNoAgreeDetail(leaveMember.id)">查看详情></button>
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
    </section>
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


    <!-- 请假原因查看模态框-->
    <div class="modal fade" id="checkNoAgreeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">拒绝请假原因</h4>
                </div>
                <div class="modal-body">
                    <section class="row" style="margin-top: 20px;">
<!--                        <div class="col-sm-3 text-right">拒绝原因:</div>-->
                        <div class="col-sm-8 col-sm-offset-2">
                            <p style="text-indent: 2em;">{{rejectNoteContent}}</p>
                        </div>
                    </section>
                </div>
                <div class="modal-footer" style="border-top: none;">
                      <button type="button" class="btn btn-default btn-sm w100" data-dismiss="modal">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--批量同意请假模态框-->
    <?= $this->render('@app/views/special-leave/batchReviewModal.php'); ?>
</main>
