<?php
/**
 * Created by PhpStorm.
 * User: 杨大侠
 * Date: 2017/8/29
 * Time: 10:27
 */
use backend\assets\LeagueChartAsset;

LeagueChartAsset::register($this);
$this->title = '统计管理 - 团课统计';
?>
<div ng-controller="LeagueChartCtrl" ng-cloak>
    <div class="col-sm-12 animated fadeInLeft pd0 bgBox" style="overflow: hidden">
        <h2 class="text-center">课程人数统计</h2>
        <div class="col-sm-8 pdr20box">
            <div class="col-sm-12 pdb40 bgw">
                <div class="pt2">
                    <div class="col-sm-12 mrt20 text-center">
                        <div class="w70 pull-left">
                            <select class="form-control pb0 selectPd2"
                                    ng-change="classChange(classValue)"
                                    ng-model="classValue">
                                <option value="d">日</option>
                                <option value="m">月</option>
                                <option value="Y">年</option>
                            </select>
                        </div>
                            <span class="pull-right coachDetails"
                                  data-toggle="modal"
                                  data-target="#noSignModal"
                                  ng-click="coachDetails()">查看详情>
                            </span>
                    </div>
                </div>
                <div>
                    <div id="classMian" class="col-sm-12 pd0" style="height:400px;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 pd0 h550">
            <div class="col-sm-12 pd20 bgw">
                <div>
                    <div class="textCentent f20 pt20 ">
                        <span>总人数统计</span>
                    </div>
                    <div class="text-center col-sm-12">
                        <strong class="col-sm-12 fontSize30">
                            <span ng-if="member != ''" class="greenWords">{{member.memberTotal}}</span>
                            <span ng-if="member == ''" class="greenWords">0</span>
                        </strong>
                        <span class="col-sm-12 ">上课累计人数</span>
                    </div>
                    <div class="text-center col-sm-12 mt30px">
                        <div class=" col-sm-12 borLeft">
                            <div class="col-sm-6 fontSize20 borRigth pd">
                                <span ng-if="member != ''" class="orangeWords">{{member.memberMen}}&nbsp;男</span>
                                <span ng-if="member == ''" class="orangeWords"> 0&nbsp;男</span>
                            </div>
                            <div class="col-sm-6  fontSize20 pd">
                                <span ng-if="member != ''" class="blueWords">{{member.memberWoMen}}&nbsp;女</span>
                            <span ng-if="member == ''" class="blueWords">0&nbsp;女</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 pd0 nodataFeng text-center" style="margin-top: 40px;">
                    <img ng-src="/plugins/img/feng22.png" width="160">
                </div>
                <div id="sellMain1" class="col-sm-12 pd0 pdb20" style="height:280px;">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="noSignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document" style="width: 80%;height: 665px;">
            <div class="modal-content clearfix" style="width: 100%;height: 665px;">
                <div style="width: 100%;height: 665px;">
                    <div class="modal-header" style="width: 100%;height: 600px;">
                        <div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <div class="row textCentent">
                                <h4 class="modal-title modalTitle" id="myModalLabel">
                                    统计详情
                                </h4>
                            </div>
                            <div class="row h55 mb10px">
                                <div class="col-sm-5">
                                    <div class="col-sm-8">
                                        <div class="input-daterange input-group cp userTimeRecord" id="container">
                                            <span class="add-on input-group-addon"">
                                            选择日期
                                            </span>
                                            <input type="text"  readonly name="reservation" id="noSignReservation"
                                                   class="form-control text-center userSelectTime "
                                                   style="width: 195px;"/>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-success" ng-click="applyBtn()">
                                            搜索
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div id="DataTables_Table_0_wrapper" class="pdB0 dataTables_wrapper form-inline"
                                     role="grid">
                                    <table
                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 140px;background-color: #FFF;"
                                                ng-click="changeNotSort('member_name',sort)">序号
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" style="width: 140px;"
                                                ng-click="changeNotSort('member_name',sort)">课程名称
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" style="width: 140px;"
                                                ng-click="changeNotSort('member_sex',sort)">人数
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" style="width: 140px;"
                                                ng-click="changeNotSort('member_mobile',sort)">上下课时间
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="hoverTr" ng-repeat="($index,no) in coachDetailsDataItem.data">
                                            <td>{{$index+1}}</td>
                                            <td>
                                                <span>{{no.name}}</span>
                                            </td>
                                            <td>
                                                <span>{{no.classNum}}</span>
                                            </td>
                                            <td>
                                                <span>
                                                    {{no.start*1000 | date:'yyyy-MM-dd HH:mm'}}到{{no.end*1000| date:'yyyy-MM-dd HH:mm'}}
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'classListShow']); ?>
                                    <?= $this->render('@app/views/common/pagination.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="col-sm-12 textAlignRigth pt10">
                                <div class="col-sm-3">

                                </div>
                                <div class="col-sm-1">

                                </div>
                                <div class="col-sm-2" style="display: flex">
                                    <div class="disp">

                                    </div>
                                    <div class=" displayInlineBlock" style="text-align: right;"><span
                                            class="lineHeight30px">教练:{{coachName.name}}</span></div>
                                </div>
                                <div class="col-sm-5 pt4px">
                                    <span class="fontSize20 color">每节平均人数: &nbsp;{{coachDetailsDataItem.sum.average | number : 2}}人 &nbsp;</span>
                                    <span class="fontSize20 color"> 总计:&nbsp;{{coachDetailsDataItem.sum.totalNum}}节 &nbsp; 共&nbsp; {{coachDetailsDataItem.sum.totalClass}}&nbsp;人</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>