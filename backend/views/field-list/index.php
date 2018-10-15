
<!-- 会员详情-->
<div class="modal fade in" id="membershipDetails" aria-hidden="true" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true" ng-click="cancelClose(3)">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">预约场地</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal w500">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class=" col-sm-12">
                            <div class="imgBlock">
                                <div>
                                    <img
                                        ng-if="memberDetails.memberMessage.pic != null && memberDetails.memberMessage.pic !=undefined"
                                        ng-src="{{memberDetails.memberMessage.pic}}" class="headImg w50h50px">
                                    <img ng-src="/plugins/checkCard/img/11.png" class="w50h50px "
                                         ng-if="memberDetails.memberMessage.pic == null || memberDetails.memberMessage.pic ==undefined"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente pt15px">
                            <div class="col-sm-6 textRigth">
                                <strong>姓名:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.username}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente ">
                            <div class="col-sm-6 textRigth">
                                <strong>会员编号:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.id}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente">
                            <div class="col-sm-6 textRigth">
                                <strong>手机号:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.mobile}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <select ng-if="memberBool == false" class="form-control w160 cardIdYuyue"
                                        ng-model="memberCardId" style="padding: 4px;">
                                    <option value="{{w.memberCardId}}" ng-if="w.status != 3"
                                            ng-repeat="w in memberDetails.memberCard">
                                        {{w.card_name}}
                                    </option>
                                </select>
                                <select ng-if="memberBool == true" class="form-control w160 h31px">
                                    <option value="">暂无卡种</option>
                                </select>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-disabled="memberBool"
                        class="btn btn-success w80 margin0auto displayBlock"
                        ng-click="memberReservationIsSuccessful()">完成
                </button>
            </div>
        </div>
    </div>
</div>

<!--新增场地-->
<div class="modal fade " id="siteManagementAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="cancelClose(1)"
                        aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">新增场地</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>所属房间</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <label for="id_label_single">
                                    <select class="form-control" id="ee" ng-model="DCodeId" style="width: 165px;padding: 0 5px;font-weight: normal;">
                                        <option value="">请选择房间</option>
                                        <option value="{{w.id}}" ng-repeat="w in allHouse">
                                            {{w.name}}（{{w.code}}）
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-sm btn-success" ng-click="addHouse()">新增</button>
                                <button class="btn btn-sm btn-danger" ng-click="delHouse()">删除</button>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>场地名称</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="text" class="form-control w160" ng-model="siteName"
                                       placeholder="请输入场地名称">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>人数限制</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="number" min="0" class="form-control w160" placeholder="请输入人数"
                                       ng-model="numberBox" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>开放时间</label>
                            <div class="col-sm-4 displayFlex" style="padding-right: 0">
                                <div class="justifyContentCenter col-sm-6 input-group borderRadius clockpicker w80"
                                     data-autoclose="true">
                                    <input name="dayStart" type="text" class="borderRadius zIndex20000 input-sm form-control  text-center borderRadius"
                                           placeholder="起始时间" >
                                </div>
                                <div class="justifyContentCenter col-sm-6 input-group borderRadius clockpicker w80"
                                     data-autoclose="true">
                                    <input name="dayEnd" type="text" class="borderRadius zIndex20000 input-sm form-control text-center borderRadius"
                                           placeholder="结束时间" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>每次时长</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="number" min="0" class="form-control w160" placeholder="请输入每次时长"
                                       ng-model="timeLength" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong">会员卡限制</label>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="w160px">
                                    <select class="js-example-basic-single js-states form-control id_label_single "
                                            multiple="multiple" id="userHeader1">
                                        <option value="{{w.id}}" ng-repeat="w in venueCardCategory">
                                            {{w.card_name}}
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" ng-click="cancelClose(1)">取消</button>
                <button type="button" class="btn btn-primary"
                        ng-click="addFieldOk()">添加
                </button>
            </div>
        </div>
    </div>
</div>

<!--新增房间-->
<div class="modal fade " id="siteManagementAdd2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="close()"
                        aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">新增房间</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>房间名称或编号</label>
                            <div class="col-sm-4" style="padding-right: 0;">
                                <input type="text" class="form-control w160" placeholder="房间名称或编号"
                                       ng-model="houseName">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>所属场馆</label>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="w160px">
                                    <select class="form-control" ng-model="venueID" id="userHeader1" style="padding: 0 5px;font-weight: normal;color: grey">
                                        <option value="">请选择场馆</option>
                                        <option value="{{w.id}}" ng-repeat="w in allVenue">
                                            {{w.name}}
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>识别码</label>
                            <div class="col-sm-4" style="padding-right: 0;">
                                <input type="text" class="form-control w160" placeholder="请输入识别码"
                                       ng-model="houseCode" onmousewheel="return false;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" ng-click="cancelAdd()">取消</button>
                <button type="button" class="btn btn-primary"
                        ng-click="addSuccess()">添加
                </button>
            </div>
        </div>
    </div>
</div>

<!--场地列表-->
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




