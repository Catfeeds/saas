<?php
use backend\assets\ForeignFieldCtrlAsset;

ForeignFieldCtrlAsset::register($this);
$this->title = '场地预约';
?>
<div ng-controller="FieldCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li ><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li class="orderMenu"><a href="/foreign-field-management/index">场地管理</a></li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active" ><a href="#about" aria-controls="profile" role="tab" data-toggle="tab">预约场地</a></li>
                    <li role="presentation" ><a href="#site" aria-controls="profile" role="tab" data-toggle="tab">场地管理</a></li>
                    <li role="presentation"><a href="#room" aria-controls="profile" role="tab" data-toggle="tab">房间管理</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0" style="height: 100%;">
            <div class="panel-body">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about">
                        <div class="col-sm-12 col-xs-12 ">
                            <div class="col-sm-12 col-xs-12 " style="color: #676a6cd6">
                                <div class="col-sm-8 col-xs-8 pdL0 w200Flag" style="margin-bottom: 10px">
                                    <div >
                                        <select class="venueChoose selectBox venueSelect2"
                                                ng-change="aboutSiteVenueSelect(aboutSiteVenueId)" ng-model="aboutSiteVenueId"
                                                id="aboutSiteVenueId">
                                            <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12  col-xs-12 pd0" style="border: 1px solid #dddddd;">
                                <div class="col-sm-2  col-xs-2 pd0 switchCabinetArea" >
                                    <input type="text" class="form-control" id="venueDateStartInput"
                                           data-date-format="yyyy-mm-dd" placeholder="请选择日期" style="padding: 24px;">
                                    <ul class="checkUl" id="contain" style="overflow-y: auto;border-right: 1px solid #dddddd;border-bottom: 1px solid #dddddd"">
                                    <li class="SiteManagement cp" style="padding-left: 15px;border-bottom: solid 1px #E5E5E5;" ng-repeat="(index, item) in listDataItems" ng-click="selectSiteManagement(item.id,index,item)">
                                        <div style="margin: 10px 0">
                                            <h3 ng-class="{blue: (item.choose),disAbled: time.status}">{{item.yard_name}}</h3>
                                            <p style="color: #867f7f; margin: 10px 0;"><span>开放时间:{{item.business_time}}</span></p>
                                            <p style="color: #867f7f;"><span>人数上限:{{item.people_limit}}</span> </p>
                                        </div>
                                    </li>
                                    </ul>
                                </div>
                                <div class="col-sm-3  col-xs-3 pd0 switchCabinetAreaCabinetNum" >
                                    <div class="ibox float-e-margins boxShowNone " style="overflow-y: auto;overflow-x: hidden;margin: 0">
                                        <div class=" borderNone">
                                            <input  id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                            <div class="col-sm-12  col-xs-12 borderBottom" style="padding: 14.5px 0;">
                                                <div class="col-sm-6  col-xs-6 textAlignCenter"><strong>时间段</strong></div>
                                                <div class="col-sm-6  col-xs-6 textAlignCenter "><strong>预约人数</strong></div>
                                            </div>
                                            <div class="col-sm-12  col-xs-12 qq">
                                                <div class="row">
                                                    <div class="col-sm-12  col-xs-12 borderBottom ths cursorPointer" style="padding: 10px 0;" ng-class="{selTime:value.isClick}" ng-repeat="(key,value) in siteDetailsLeft.orderNumList" ng-click="siteManagementDetails(key,value,index)">
                                                        <div class="col-sm-6 col-xs-6 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{key}}</div>
                                                        <div class="col-sm-6 col-xs-6 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                                        <div class="col-sm-6 col-xs-6 textAlignCenter lineHeight30" ng-if="value.timeStatus == 2">{{key}}</div>
                                                        <div class="col-sm-6 col-xs-6 textAlignCenter lineHeight30" ng-if="value.timeStatus == 2">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7  col-xs-7 pd0 switchCabinetAreaCabinetNum" >
                                    <div class="ibox float-e-margins boxShowNone borderNone">
                                        <div class=" borderNone cc">
                                            <table class="table table-bordered">
                                                <tr class="h35px">
                                                    <td>会员姓名</td>
                                                    <td>手机号</td>
                                                    <td>预约时间</td>
                                                    <td>操作</td>
                                                </tr>
                                                <tbody>
                                                <tr ng-repeat="($index,w) in selectionTimeList" class="cursorPointer">
                                                    <td>{{w.username}}</td>
                                                    <td>{{w.mobile}}</td>
                                                    <td>{{w.create_at *1000 |date:'yyyy-MM-dd HH:mm' }}</td>
                                                    <td>
                                                        <button ng-if="isCancel" ng-click="cancelReservation(w,2,w.about_interval_section)" type="button" class="btn-sm btn btn-default">
                                                            取消预约
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'noDetail']); ?>
                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'detailPages']); ?>
                                        </div>
                                    </div>
                                    <div class="text-center mT40">
<!--                                        <button type="button" ng-disabled="!disBtn || !yesSel" class="btn btn-sm btn-success" ng-click="siteReservation(aboutIntervalSection,1)" style="padding: 5px 35px;" ng-disabled="aboutTimeStatus == 1">预约</button>-->
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="col-sm-4  col-xs-4 text-right" style="height:34px;line-height: 34px;">会员预约</div>
                                                <div class="col-sm-8  col-xs-8  scheduleCourseDetailDivButton" style="margin-top: 0;">
                                                    <div class="input-group">
                                                        <input type="number"
                                                               class="form-control lineHeight7 h34"
                                                               ng-model="keywords" onmousewheel="return false;" placeholder="请输入手机号进行搜索...">
                                                        <span class="input-group-btn">
                                    <button type="button"ng-disabled="!disBtn || !yesSel" ng-disabled="aboutTimeStatus == 1"
                                            ng-click="reservationMemberSearch(keywords,'home')"
                                            class="btn btn-success">搜索</button>
                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="site">
                        <div class="row">
                            <div class="col-sm-12  col-xs-12" style="color: #676a6cd6">
                                <div class="col-sm-8 col-xs-8 pdL0 w200Flag" style="margin-bottom: 10px">
                                    <div >
                                        <select class="venueChoose selectBox venueSelect2"
                                                ng-change="siteVenueSelect(venueId)" ng-model="venueId"
                                                id="id_label_single1">
                                            <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4 text-right">
                                    <div class="row">
                                        <button ng-click="addField()" class="btn btn-sm btn-success" style="color: #fff;">新增场地</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12  col-xs-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content pd0">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pd0" role="grid">
<!--                                            <div class="row disNone">-->
<!--                                                <div class="col-sm-6">-->
<!--                                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 10%;background-color: #FFF;"
                                                        ng-click="changeSort('pic',sort)" colspan="1" aria-label="浏览器：激活排序列升序">
                                                        &nbsp;序号
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 10%;background-color: #FFF;" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">&nbsp;房间
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 15%;background-color: #FFF;"
                                                        ng-click="changeSort('name',sort)" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">&nbsp;场馆
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 15%;background-color: #FFF;"
                                                        ng-click="changeSort('yard_name',sort)" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">
                                                        &nbsp;场地名称
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 10%;background-color: #FFF;"
                                                        ng-click="changeSort('people_limit',sort)" colspan="1"
                                                        aria-label="平台：激活排序列升序">
                                                        &nbsp;人数限制
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 10%;background-color: #FFF;"
                                                        ng-click="changeSort('business_time',sort)" colspan="1"
                                                        aria-label="引擎版本：激活排序列升序">&nbsp;开放时间
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 10%;background-color: #FFF;"
                                                        ng-click="changeSort('active_duration',sort)" colspan="1"
                                                        aria-label="引擎版本：激活排序列升序">
                                                        &nbsp;每次时长
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                        aria-label="引擎版本：激活排序列升序">
                                                        &nbsp;操作
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="gradeA odd" ng-repeat="($index,w) in listDataItem">
                                                    <td ng-click="siteManagementDetailsClick(w.id)" ><span>{{(8*nowPageSite) + $index+1}}</span></td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.roomName | noData:''}}
                                                    </td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.name | noData:''}}
                                                    </td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.yard_name | noData:''}}
                                                    </td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.people_limit | noData:''}}
                                                    </td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.business_time | noData:''}}
                                                    </td>
                                                    <td ng-click="siteManagementDetailsClick(w.id)" >{{w.active_duration | noData:''}}
                                                    </td>
                                                    <td class="tdBtn">
                                                        <button type="button" class="btn btn-warning btn-sm"
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
                                                <div class="col-sm-10 paddingLeft0 paddingRight">
                                                    <?= $this->render('@app/views/common/pagination.php'); ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane " id="room">
                        <div class="row">
                            <div class="col-sm-12 " style="color: #676a6cd6">
                                <div class="col-sm-8 col-xs-8 pdL0 w200Flag" style="margin-bottom: 10px">
                                    <div >
                                        <select class="venueChoose selectBox venueSelect2"
                                                ng-change="roomVenueSelect(roomVenueId)" ng-model="roomVenueId"
                                                 >
                                            <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4 text-right">
                                    <div class="row">
                                        <button ng-click="addHouse()" class="btn btn-sm btn-success" style="color: #fff;">新增房间</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content pd0">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pd0" role="grid">
                                            <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="bgWhite" tabindex="0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">&nbsp;序号
                                                    </th>
                                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">&nbsp;房间号
                                                    </th>
                                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                         colspan="1"
                                                        aria-label="浏览器：激活排序列升序">&nbsp;所属场馆
                                                    </th>
                                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                         colspan="1"
                                                        aria-label="浏览器：激活排序列升序">&nbsp;识别码
                                                    </th>
                                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" style="width: 20%;background-color: #FFF;"
                                                        aria-label="引擎版本：激活排序列升序">&nbsp;操作
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="gradeA odd" ng-repeat = "($index,roomList) in allRoomLists">
                                                    <td ng-click="" ><span>{{(8* nowPageRoom) + $index+1}}</span></td>
                                                    <td ng-click="" >{{roomList.name}}</td>
                                                    <td ng-click="" >{{roomVenueName}}</td>
                                                    <td ng-click="" >{{roomList.code}}</td>
                                                    <td class="tdBtn">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                ng-click="roomListDelete(roomList.id)">
                                                            删除
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'roomPages']); ?>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'allRoomListsFlag', 'text' => '无房间信息', 'href' => true]); ?>
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
    <!--新增场地数据-->
    <?= $this->render('@app/views/foreign-field-management/addNewSiteManagementData.php'); ?>
    <!--修改场地数据-->
    <?= $this->render('@app/views/foreign-field-management/changeSiteManagementData.php'); ?>
    <!--场地数据详情-->
    <?= $this->render('@app/views/foreign-field-management/siteManagementDetailData.php'); ?>
    <!--预约会员-->
    <?= $this->render('@app/views/foreign-field-management/orderMember.php'); ?>
    <!--会员详情-->
    <?= $this->render('@app/views/foreign-field-management/memberDetailData.php'); ?>
</div>
