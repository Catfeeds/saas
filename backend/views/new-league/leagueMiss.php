<?php
use backend\assets\NewLeagueAsset;

NewLeagueAsset::register($this);
$this->title = '团课爽约';
?>
<div class="container-fliud container-fliud1" ng-controller="leagueCtrl" ng-cloak>
    <div class="panel-heading">
                <span style="display: inline-block"><span style="display: inline-block" class="spanSmall"><b>团课爽约</b></span>
</div>
    <div class="col-sm-12" id="titleBox4" style="display: inline-block">
        <div class="row">
            <div class="col-sm-12 iboxContentPadding borderBottomNone">
                <div class="panel panel-default ">
                    <div class="panel-heading col-sm-12">
                        <div class="col-sm-4">
                            <div class="col-sm-12">
                                <select style="width: 150px;" class=" form-control h30px"
                                        ng-change="missRecordStartChange()" ng-model="missRecordStart">
                                    <option value="">请选择状态</option>
                                    <option value="1">正常</option>
                                    <option value="2">异常</option>
                                    <option value="3">冻结</option>
                                    <option value="4">未激活</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control lineHeight"
                                       ng-model="missRecordsKeywords"
                                       ng-keyup="enterMissRecordsSearch($event)"
                                       placeholder=" 请输入会员或手机号进行搜索...">
                                <span class="input-group-btn">
                                                    <button type="button" ng-click="searchMissRecordsButton(keywords)"
                                                            class="btn btn-primary">搜索</button>
                                                </span>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <?php if (\backend\models\AuthRole::canRoleByAuth('newLeagueMiss', 'MISSSETTING')) { ?>
                                <button type="button" class="btn btn-default  pull-right"
                                        ng-click="missSet()"><span
                                            class="glyphicon glyphicon-asterisk colorFont"
                                            aria-hidden="true"></span>设置
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 iboxContentPadding borderTopNone">
                <div class="ibox float-e-margins borderTopNone">
                    <div class="ibox-content iboxContentPadding borderTopNone">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pd0"
                             role="grid">
                            <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('name',sort)" colspan="1"
                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-camera"
                                                              aria-hidden="true"></span>&nbsp;序号
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('cardNumber',sort)" colspan="1"
                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-list-alt"
                                                              aria-hidden="true"></span>&nbsp;会员卡号
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('category',sort)" colspan="1"
                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-user"
                                                              aria-hidden="true"></span>&nbsp;会员
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('sex',sort)" colspan="1"
                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-bishop"
                                                              aria-hidden="true"></span>&nbsp;性别
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('mobile',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                                        <span class="glyphicon glyphicon-font"
                                                              aria-hidden="true"></span>&nbsp;手机号
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('missTimes',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                                        <span class="glyphicon glyphicon-superscript"
                                                              aria-hidden="true"></span>&nbsp;爽约次数
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('cardStatus',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                                        <span class="glyphicon glyphicon-queen"
                                                              aria-hidden="true"></span>&nbsp;状态
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSortMiss('course_difficulty',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                                        <span class="glyphicon glyphicon-tower"
                                                              aria-hidden="true"></span>&nbsp;剩余解冻天数
                                    </th>
                                    <th class="sorting w240" tabindex="0"
                                        aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                        操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="($index,w) in missRecordsDatas">
                                    <td ng-click="missDetails(w.id)">{{8*(homePageNow - 1)+$index+1}}</td>
                                    <td ng-click="missDetails(w.id)">{{w.card_number}}</td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.memberName != null">{{w.memberName}}</span>
                                        <span ng-if="w.memberName == null">暂无数据</span>
                                    </td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.memberSex == 1">男</span>
                                        <span ng-if="w.memberSex == 2">女</span>
                                        <span ng-if="w.memberSex == 3 || w.memberSex == null || w.memberSex == 0">暂无数据</span>
                                    </td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.mobile != 0">{{w.mobile}}</span>
                                        <span ng-if="w.mobile == 0 || w.mobile == ''|| w.mobile == null">暂无数据</span>
                                    </td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.absentTimes != null">{{w.absentTimes}}</span>
                                        <span ng-if="w.absentTimes == null">0</span>
                                    </td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.status == 1">正常</span>
                                        <span ng-if="w.status == 2">异常</span>
                                        <span ng-if="w.status == 3">冻结</span>
                                        <span ng-if="w.status == 4">未激活</span>
                                    </td>
                                    <td ng-click="missDetails(w.id)">
                                        <span ng-if="w.surplusDay != null">{{w.surplusDay}}</span>
                                        <span ng-if="w.surplusDay == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <?php if (\backend\models\AuthRole::canRoleByAuth('newLeagueMiss', 'UNFREEZE')) { ?>
                                            <button ng-if=" w.status == 3" type="button"  data-toggle="modal"ng-disabled="w.recent_freeze_reason != 1"
                                                    data-target="#Thaw" ng-click="Thaw(w.id,w.status,w)" class="btn btn-success">解冻</button>
                                        <?php } ?>
                                        <button ng-if="w.status == 1 || w.status == 2 || w.status == 4" type="button" class="btn " style="background-color: gainsboro;" >解冻</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php',['name' => 'missRecordsDataBool']); ?>
                            <div class="row"
                                 style="margin-left: 0;margin-right: 0; display: flex;align-items: center;"
                                 ng-if="pages != ''&& pages != undefined">
                                <section style=" font-size: 14px;padding-left: 6px;padding-right: 0;"
                                         class="col-sm-2" ng-if="missRecordsDataBool == false || detailPages != '' ">
                                    第<input
                                            style="width: 50px;padding: 4px 4px;height: 24px;border-radius: 3px;border:solid 1px #E5E5E5;"
                                            type="number" class="" checknum placeholder="几" ng-model="pageNums">页
                                    <button class="btn btn-primary btn-sm" ng-click="skipPages(pageNums)">跳转</button>
                                </section>
                                <div class="col-sm-10" style="padding-left: 0;padding-right: 0;">
                                    <?= $this->render('@app/views/common/pagination.php',['page' => 'detailPages']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  //////////////////////////*********爽约设置*******//////////////////////////////////  -->
    <!-- Modal -->
    <div class="modal fade" id="missSet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title textAlignCenter" id="myModalLabel">设置</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal ng-pristine ng-valid">
                        <input id="_csrf" type="hidden" name="_csrf_backend"
                               value="OW5feVg4X2toWAcjHFoID29fMjILXz4sQSMcSWlpOB8BWyZUakwKAg==">
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label">
                                <span class="formGroupColor">*</span>每月爽约次数
                            </label>
                            <div class="col-sm-8">
                                <input type="number" id="monthlyNumberMiss" inputnum onmousewheel="return false;" class="form-control "
                                       ng-model="monthlyNumberMiss" placeholder="请输入爽约次数"/>
                            </div>
                            <div class="col-sm-12 fontSize12"><p class="missNotes">达到次数后将会被冻结</p></div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label">
                                <span class="formGroupColor">*</span>冻结方式
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control pt2 " style="padding: 4px 12px;" id="freezingMode" ng-change="freezingModeChange123(freezingMode)" ng-model="freezingMode">
                                    <option value="">请选择冻结方式</option>
                                    <option value="1">当月冻结</option>
                                    <option value="2">自定义冻结天数</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput" ng-if="freezingModeFlag">
                            <label class="col-sm-4 control-label">
                                <span class="formGroupColor">*</span>冻结天数
                            </label>
                            <div class="col-sm-8">
                                <input type="number" id="freezingDays" inputnum ng-model="freezingDays"
                                       onmousewheel="return false;" class="form-control " placeholder="请输入冻结天数"/>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label">处罚金额</label>
                            <div class="col-sm-8">
                                <input type="number" id="penaltyAmount"
                                       onmousewheel="return false;" class="form-control " placeholder="请输入解冻处罚金额"/>
                            </div>
                            <div class="col-sm-12 fontSize12"><p class="missNotes">缴费处罚金额后则立即解冻</p></div>
                        </div>
                    </form>
                    <br>
                    <div>
                        <span class="pull-left fa fa-info-circle">修改之前的配置,冻结会员卡无影响,未冻结会员卡爽约次数重置</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" ng-click="missSetRemoveButton()" >重置</button>
                    <button type="button" class="btn btn-success" ng-click="missSetButton()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--    爽约单个详情-->
    <div class="modal fade " id="missDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center">爽约记录</h4>
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px;">
                            <div class="col-sm-4" style="padding-left: 0">
                                <div class=" input-daterange input-group cp userTimeRecord" id="container">
                                    <span class="add-on input-group-addon">日期</span>
                                    <input type="text" readonly="" name="reservation" id="peopleNumberReservation" class="form-control text-center" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success btn-sm" ng-click="missDetailsSearch()">确定</button>
                                <button type="button" class="btn btn-info btn-sm" ng-click="clearSearchBtn()"  style="float: right;">清除</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-body h500px p10" >
                    <div class="row" style="margin-top: 10px">
                        <div class="col-sm-12 h500px">
                            <table class="table table-striped table-hover table-bordered   dataTables-example "
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th width="100" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('name',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                        &nbsp;序号
                                    </th>
                                    <th width="450" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('name',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                        &nbsp;场馆
                                    </th>
                                    <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('name',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                        &nbsp;课程名称
                                    </th>
                                    <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('coachName',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                        &nbsp;上课教练
                                    </th>
                                    <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('classDate',sort)" colspan="1"
                                        aria-label="引擎版本：激活排序列升序">
                                        &nbsp;日期
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="($index,w) in missDetailsData">
                                    <td>{{8*(nowPages - 1)+$index+1}}</td>
                                    <td>{{w.venueName |noData:''}}</td>
                                    <td>{{w.name}}</td>
                                    <td>{{w.coachName |noData:''}}</td>
                                    <!-- <td>{{w.class_date | date:'yyyy-MM-dd hh:mm'}}</td>-->
                                    <td>{{(w.start *1000 | date:'yyyy-MM-dd HH:mm')+ '-' + ( w.end * 1000 | date:'HH:mm')}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/pagination.php',['page' => 'memMissRecords']); ?>
                            <?= $this->render('@app/views/common/nodata.php',['name' => 'missRecordsDataBools']); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 30px;">
                    <div class="col-sm-12" style="text-align: right;margin-bottom: 10px">爽约总次数:{{missDeatilsNumber}}次</div>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!--     添加解冻模态框 -->
    <div class="modal fade" id="Thaw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title textAlignCenter" id="myModalLabel">设置</h4>
                </div>
                <div class="modal-body">
                    <div class="ma30Auto">
                        <img ng-src="/plugins/newLeague/images/w.png" class="ma30Auto" style="display: block" alt="">
                    </div>
                    <div style="margin: 0 auto;text-align: center;" >
                        <h3>解冻金额{{punishMoneys}}元</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="margin0Auto displayBlock btn btn-success" ng-click="defrostAndPay()">缴纳并解冻</button>
                </div>
            </div>
        </div>
    </div>
</div>