<?php
use backend\assets\SiteManagementAsset;
SiteManagementAsset::register($this);
$this->title = '场地管理';
?>
<div ng-controller='siteManagementCtrl' ng-cloak>
    <header>
        <div class="panel panel-default ">
            <div class="panel-heading">
                <span class="displayInlineBlock"><b class="spanSmall">场地管理</b></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-9 text-center" style="padding: 0;">
                            <div class="col-sm-12" style="padding: 0;">
                                <div class="col-sm-4 mT9">
                                    <label for="id_label_single">
                                        <select class="w150px js-example-basic-single js-states form-control"
                                                ng-change="searchClass(venueId)" ng-model="venueId"
                                                id="id_label_single"  style="width: 135px;">
<!--                                            <option value="">请选择场馆</option>-->
                                            <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}
                                            </option>
                                        </select>
                                    </label>
                                </div>
                                <div class="input-group col-sm-8 mT5">
                                    <input type="text" ng-model="className" id="inputSearch"
                                           class="form-control h34 " ng-keydown="enterSearch($event)"
                                           placeholder="请输入场地名称进行搜索...">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary"
                                                ng-click="searchClass()">搜索</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 text-center" style="padding: 0;">
                            <li class="nav_add">
                                <ul>
                                    <li class="new_add" id="tmk">
                                        <span class="btn btn-success btn f14 mT5" data-toggle="modal"
                                              data-target="#siteManagementAdd" ng-click="addField()">新增场地</span>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </div>
                </div>
<!--                <div class="col-sm-8 text-center">-->
<!--                    <div class="col-sm-12">-->
<!--                        <div class="col-sm-4 mT9">-->
<!--                            <label for="id_label_single">-->
<!--                                <select class="w150px js-example-basic-single js-states form-control"-->
<!--                                        ng-change="searchClass()" ng-model="venueId"-->
<!--                                        id="id_label_single">-->
<!--                                    <option value="">请选择场馆</option>-->
<!--                                    <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}-->
<!--                                    </option>-->
<!--                                </select>-->
<!--                            </label>-->
<!--                        </div>-->
<!--                        <div class="input-group col-sm-8 mT5">-->
<!--                            <input type="text" ng-model="className" id="inputSearch"-->
<!--                                   class="form-control h34 " ng-keydown="enterSearch($event)"-->
<!--                                   placeholder="请输入场地名称进行搜索...">-->
<!--                                        <span class="input-group-btn">-->
<!--                                            <button type="button" class="btn btn-primary"-->
<!--                                                    ng-click="searchClass()">搜索</button>-->
<!--                                        </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-sm-4 text-center">-->
<!--                    <li class="nav_add">-->
<!--                        <ul>-->
<!--                            <li class="new_add" id="tmk">-->
<!--                                            <span class="btn btn-success btn f14 mT5" data-toggle="modal"-->
<!--                                                  data-target="#siteManagementAdd" ng-click="addField()">新增场地</span>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </div>-->
            </div>
        </div>
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>场地列表</h5>
                    <div class="ibox-tools"></div>
                </div>
                <div class="ibox-content pd0">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pd0" role="grid">
                        <div class="row disNone">
                            <div class="col-sm-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                            </div>
                        </div>
                        <table
                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 8%;"
                                    ng-click="changeSort('pic',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                    <span class="glyphicon glyphicon-italic" aria-hidden="true"></span>&nbsp;序号
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 10%;" colspan="1"
                                    aria-label="浏览器：激活排序列升序"><span
                                            class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;房间
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 15%;"
                                    ng-click="changeSort('name',sort)" colspan="1"
                                    aria-label="浏览器：激活排序列升序"><span
                                        class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;场馆
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 15%;"
                                    ng-click="changeSort('yard_name',sort)" colspan="1"
                                    aria-label="浏览器：激活排序列升序">
                                    <span class="glyphicon glyphicon-ice-lolly" aria-hidden="true"></span>&nbsp;场地名称
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 10%;"
                                    ng-click="changeSort('people_limit',sort)" colspan="1"
                                    aria-label="平台：激活排序列升序">
                                    <span class="glyphicon glyphicon-bishop" aria-hidden="true"></span>&nbsp;人数限制
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 13%;"
                                    ng-click="changeSort('business_time',sort)" colspan="1"
                                    aria-label="引擎版本：激活排序列升序"><span
                                        class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;开放时间
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 13%;"
                                    ng-click="changeSort('active_duration',sort)" colspan="1"
                                    aria-label="引擎版本：激活排序列升序">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;每次时长
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" style="width: 16%;"
                                    aria-label="引擎版本：激活排序列升序">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>&nbsp;操作
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="gradeA odd" ng-repeat="($index,w) in listDataItem">
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails"><span>{{$index+1}}</span></td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.roomName | noData:''}}
                                </td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.name | noData:''}}
                                </td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.yard_name | noData:''}}
                                </td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.people_limit | noData:''}}
                                </td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.business_time | noData:''}}
                                </td>
                                <td ng-click="siteManagementDetailsClick(w.id)" data-toggle="modal"
                                    data-target="#siteManagementDetails">{{w.active_duration | noData:''}}
                                </td>
                                <td class="tdBtn">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#siteManagementUpdate"
                                            ng-click="upDate(w.id,w.yard_name,w.room_id,w.people_limit,w.business_time,w.active_duration)">
                                        修改
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            ng-click="removeItem(w.id)">
                                        删除
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php'); ?>
                        <div class="row marginLeftRigth displayFlex"
                             ng-if="pages != ''&& pages != undefined ">
                            <section
                                     class="col-sm-2 fontSize14 paddingRight paddingLeft6px">
                                第<input
                                    type="number" class="borderSolidE5E5E5 padding4px w50 height24 borderRadius" checknum placeholder="几" ng-model="pageNum">页
                                <button class="btn btn-primary btn-sm" ng-click="skipPage(pageNum)">跳转</button>
                            </section>
                            <div class="col-sm-10 paddingLeft0 paddingRight">
                                <?= $this->render('@app/views/common/pagination.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--新增场地数据-->
    <?= $this->render('@app/views/site-management/addNewSiteManagementData.php'); ?>
    <!--修改场地数据-->
    <?= $this->render('@app/views/site-management/changeSiteManagementData.php'); ?>
    <!--场地数据详情-->
    <?= $this->render('@app/views/site-management/siteManagementDetailData.php'); ?>
    <!--预约会员-->
    <?= $this->render('@app/views/site-management/orderMember.php'); ?>
    <!--会员详情-->
    <?= $this->render('@app/views/site-management/memberDetailData.php'); ?>
</div>
