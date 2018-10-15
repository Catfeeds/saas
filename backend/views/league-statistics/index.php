<?php
/**
 * Created by PhpStorm.
 * User: 李广杨
 * Date: 2017/8/29
 * Time: 9:29
 */
use backend\assets\LeagueStatisticsAsset;

LeagueStatisticsAsset::register($this);
$this->title = '统计管理 - 团课统计';
?>
<div ng-controller="indexCtrl" ng-cloak>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b class="spanBig">统计管理</b></span>
                        >
                        <span style="display: inline-block"><b class="spanSmall">团课统计</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12 userHeader" style="">
                            <div class="input-group w450">
                                <input type="text" class="form-control userHeaders h35" ng-model="keywords"
                                       ng-keyup="enterSearch($event)" placeholder=" 请输入名称进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" ng-click="searchCard()" class="btn btn-primary">搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class=" col-sm-12 pd0 clearfix  ">
                            <div class="col-sm-3">
                                <div class=" input-daterange input-group fl cp mR10 mT10" id="container"
                                     style="margin-bottom: -2px;">
                                    <div class="input-daterange input-group cp userTimeRecord" id="container">
                                    <span class="add-on input-group-addon">
                                        选择日期
                                    </span>
                                        <input type="text"  ng-model="dateTime" readonly name="reservation"
                                               id="reservation"
                                               class="form-control text-center userSelectTime" value=""
                                               placeholder="选择时间"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="col-sm-3 mt15 " style="width: 150px;">
                                    <select id="Venue" ng-model="Venue"
                                            class="selectCss js-example-basic-single1 js-states form-control memberHeaderVenue"
                                            id="id_label_single">
                                        <option value="">请选择场馆</option>
                                        <option value="{{w.id}}" ng-repeat="w in venueData">{{w.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1 ">
                                <div class="mt15">
                                    <button type="button" ng-click="searchOk()" class="btn btn-sm btn-success">确定</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 userListDetail pd0" style="padding: 0;">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>统计管理&nbsp<span class="a16">团课统计</span></h5>
                        </div>
                        <div class="ibox-content" style="padding: 0">
                            <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                 class="dataTables_wrapper form-inline" role="grid">
                                <!--startprint1-->
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            ng-click="changeSort('member_name',sort)" style="width: 222px;"><span
                                                class="glyphicon glyphicon-italic" aria-hidden="true"></span>&nbsp;序号
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            ng-click="changeSort('organization_name',sort)" style="width: 200px;"><span
                                                class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;场馆
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 120px;" ng-click="changeSort('member_sex',sort)">
                                            <span class="fa fa-venus" aria-hidden="true"></span>&nbsp;教练
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 222px;"
                                            ng-click="changeSort('member_mobile',sort)"><span
                                                class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>&nbsp;总节数
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 222px;">
                                            <span class="glyphicon glyphicon-time" aria-hidden="true"
                                                  ng-click="changeSort('member_active_time',sort)"></span>&nbsp;每节平均人数
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 180px;"><span
                                                class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;总上课人数
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="($index,w) in listDataItem"  ng-click="leagueStatistics(w.id)">
                                        <td>
                                            {{$index+1}}
                                        </td>
                                        <td>
                                            {{w.orName}}
                                        </td>
                                        <td>
                                            <span>{{w.name}}</span>
                                        </td>
                                        <td>
                                            <span>
                                               {{w.classTotal}}
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{w.average  | number : fractionSize}}</span>
                                        </td>
                                        <td>
                                            <span>{{w.classNum}}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--endprint1-->
                                <?= $this->render('@app/views/common/nodata.php',['name' => 'dataInfo']); ?>
                                <?= $this->render('@app/views/common/pagination.php'); ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-sm-10 textRigth">
                                            <span> <span >{{listDataSum.params.start}}</span>到 <span >{{listDataSum.params.end}}</span> 团课上课统计</span>&nbsp;&nbsp;&nbsp; <span class="fontSize20">总计 {{listDataSum.totalMember}}节 {{listDataSum.totalClass}}人 </span>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" ng-click="preview(1)" class="btn btn-sm btn-success">打印统计报表</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>




