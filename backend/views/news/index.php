<?php
use backend\assets\NewsAsset;
NewsAsset::register($this);
$this->title = '会员管理 - 短信管理';
?>
<div class="container-fluid pd0"
     ng-controller="newsCtrl"
     ng-cloak>
    <div class="row">
        <div class="col-sm-12 pdtb10">
            <div class="col-sm-3 pd0">
                <div class="input-daterange input-group"
                     id="container" >
                    <span class="add-on input-group-addon smallFont">选择日期</span>
                    <input type="text" readonly name="dateClick" id="doubleTime" class="form-control text-center userSelectTime">
                </div>
            </div>
            <div class="col-sm-2 selectC">
                <select class="form-control selectPt"
                        style="width: 100%;"
                        ng-model="venueSelect" ng-change="venueChange(venueSelect)">
                    <option value="">请选择场馆</option>
                    <option  ng-repeat="venue in venueList"
                             value="{{venue.id}}"
                             title="{{venue.name}}">{{venue.name}}</option>
                </select>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" class="form-control h34" ng-model="search" ng-keyup="searchName($event)" placeholder="输入会员名称搜索">
                     <span class="input-group-btn">
                         <button type="button" class="btn btn-primary btn-sm" ng-click="getSearchData()">搜索</button>
                     </span>
                </div>
<!--                <form class="form-inline pd0">-->
<!--                    <div class="form-group col-sm-10 pd0">-->
<!--                        <input type="text"-->
<!--                               class="form-control w100"-->
<!--                               ng-model="search" placeholder="输入会员名称搜索"-->
<!--                               ng-keyup="searchName($event)"/>-->
<!--                    </div>-->
<!--                </form>-->
<!--                <div class="col-sm-2 pd0">-->
<!--                    <button class="btn btn-primary"-->
<!--                            ng-click="getSearchData()">搜索</button>-->
<!--                </div>-->
            </div>
            <div class="col-sm-1">
                <button type="button"
                        class="btn btn-info btn-sm"
                        ng-click="clearBtn()">清空</button>
            </div>
            <div class="col-sm-2 text-right">
                <button type="button"
                        class="btn btn-white searchBtn"
                        ng-click="delItem()">清空列表</button>
            </div>
        </div>
<!--列表-->
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div id="DataTables_Table_0_wrapper"
                     class="dataTables_wrapper form-inline pdb0"
                     role="grid">
                    <table class="table table-striped
                    table-bordered table-hover
                    dataTables-example dataTable"
                           id="DataTables_Table_0"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="boxWhite trWidth1"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1">序号
                            </th>
                            <th class="boxWhite trWidth2"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1">场馆
                            </th>
                            <th class="boxWhite trWidth1"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1">姓名
                            </th>
                            <th class="sorting trWidth3"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                ng-click="changeSort('mobile',sort)">手机号
                            </th>
                            <th class="boxWhite trWidth1"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1">状态
                            </th>
                            <th class="sorting trWidth3"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1"
                                ng-click="changeSort('created_at',sort)">发送时间
                            </th>
                            <th class="boxWhite trWidth4"
                                tabindex="0"
                                aria-controls="DataTables_Table_0"
                                rowspan="1"
                                colspan="1">短信内容
                            </th>
                            <th class="boxWhite trWidth2"
                                tabindex="0"
                                aria-controls="DataTbles_Table_0"
                                rowspan="1"
                                colspan="1">操作
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hoverTr"
                            ng-repeat="item in newsItem">
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">{{8*(nowPage-1)+$index+1}}</td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">{{item.name|noData:''}}</td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">
                                <span>{{item.memberName|noData:''}}</span>
                            </td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">
                                <span>{{item.mobile|noData:''}}</span>
                            </td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">
                                <span ng-if="item.status == '1'">发送成功</span>
                                <span ng-if="item.status == '2'">发送失败</span>
                            </td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">
                                <span ng-if="item.created_at != null">{{item.created_at*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                <span ng-if="item.created_at == null">暂无数据</span>
                            </td>
                            <td data-toggle="modal"
                                data-target="#newsModal"
                                ng-click="lookDetails(item.memberName,item.created_at,item.content)">
                                <span ng-if="item.content != null">{{item.content|cut:true:8:'...'}}</span>
                                <span ng-if="item.content == null">暂无数据</span>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm hoverBtn"
                                        ng-if="item.status == '2'" ng-click="sendNow(item.id)">重新发送</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php'); ?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'noNewsListData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
        </div>
<!--短信详情模态框-->
        <div class="modal fade"
             tabindex="-1"
             role="dialog"
             id="newsModal">
            <div class="modal-dialog"
                 role="document">
                <div class="modal-content clearfix">
                    <div class="modal-header text-center">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">短信内容详情</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 pd0">
                                <div class="col-sm-8 col-sm-offset-2 pd0">
                                    <ul class="list-unstyled">
                                        <li class="mrt20 col-sm-12">
                                            <span class="glyphicon glyphicon-user"></span>
                                            <label>
                                                会员名称:
                                            </label>
                                            {{contentName}}
                                        </li>
                                        <li class="mrt20 col-sm-12">
                                            <span class="glyphicon glyphicon-time"></span>
                                            <label>
                                                发送时间:
                                            </label>
                                            {{contentTime*1000|date:'yyyy-MM-dd HH:mm:ss'}}
                                        </li>
                                        <li class="mrt20 col-sm-12">
                                            <span class="glyphicon glyphicon-envelope"></span>
                                            <label>
                                                发送内容:
                                            </label>
                                            {{contentText}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
