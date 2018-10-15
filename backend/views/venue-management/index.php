<?php
use backend\assets\VenueManagementCtrlAsset;
VenueManagementCtrlAsset::register($this);
$this->title = '座次管理';
?>
<main ng-controller="venueManagementCtrl" ng-cloak>
    <input id="_csrf" type="hidden"
           name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
<!--    <div class="wrapper wrapper-content animated fadeIn" >-->
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs text-center bBNone">
                        <li class="col-sm-3 text-left pdLr0">
                            <select id="selectVenue" class="selectPd" ng-change="selectVenue(selectVenueId)" ng-model="selectVenueId" style="min-width: 100px;">
                                <option ng-repeat="venue in allVenueLists" value="{{venue.id}}">{{venue.name}}</option>
                            </select>
                        </li>
                        <li class="active col-sm-3 f16">
                            <a data-toggle="tab" href="#seatArrange" aria-expanded="true" ng-click='clickSeatArrange()'>座位排次</a>
                        </li>
                        <li  class="col-sm-3 f16">
                            <a data-toggle="tab" href="#classroomSite" aria-expanded="false" ng-click="clickClassroomSite()">教室场地</a>
                        </li>
                        <li class="col-sm-3 oP0">kong</li>
                    </ul>
                    <div class="tab-content " >
                        <div id="seatArrange" class="tab-pane active ">
                            <div class="panel-body  bGColor " style="padding: 0;" >
                                <ul class="col-sm-12 col-md-12 pdLr0">
                                    <li class="col-sm-6 col-md-3  mT10 pL0" ng-repeat="SeatList in  allSeatDataLists" ng-click="seatDetailClick(SeatList)" >
                                        <div class="col-sm-12 col-md-12 boxCss f16 cp text-center">
                                            <ul>
                                                <li><h2>{{SeatList.name}}</h2></li>
                                                <li class="mT10 color999"><div>教室：{{SeatList.roomName}}  <span ng-if="SeatList.classroom_area !=''&& SeatList.classroom_area !=null">{{SeatList.classroom_area | noData:''}}m²</span> </div></li>
                                                <li class="mT10 color999"><div>人数：{{SeatList.amount}}人</div></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="col-sm-6 col-md-3  mT10 pL0">
                                        <div class="col-sm-12 col-md-12 boxCss f16 cp" ng-click="addNewSeatLists()">
                                            <ul>
                                                <li class="text-center"><img src="/plugins/newCabinet/images/picadd.png"></li>
                                                <li class="mT10 color999">点击添加新的座位排次</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                              </div>
                        </div>
                        <div id="classroomSite" class="tab-pane">
                            <div class="panel-body">
                                <ul class="col-sm-12 col-md-12 pdLr0">
                                    <li class="col-sm-6 col-md-3  mT10 pL0" ng-repeat="venueSite in allVenueSiteLists">
                                        <div class="col-sm-12 col-md-12 boxCss f16">
                                            <span class="glyphicon glyphicon-remove removeCss cp" ng-click="removeVenueSite(venueSite.id)"></span>
                                            <ul ng-click="updateClassroom(venueSite.id,venueSite.name,venueSite.room_id,venueSite.classroom_area)">
                                                <li class="text-center"><h2>{{venueSite.name}}</h2></li>
                                                <li class="mT10 color999 text-center"><div>面积:<span>{{venueSite.classroom_area != null && venueSite.classroom_area !='' ?venueSite.classroom_area:'暂无' }}m²</span></div></li>
                                                <li class="mT10 color999 text-center"><div>房间:<span>{{venueSite.roomName | noData:''}}（{{venueSite.code}}）</span></div></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="col-sm-6 col-md-3  mT10 pL0">
                                        <div class="col-sm-12 col-md-12 boxCss f16 cp" ng-click="addClassroomSite()">
                                            <ul>
                                                <li class="text-center"><img src="/plugins/newCabinet/images/picadd.png"></li>
                                                <li class="mT10 color999">点击添加新的教室场地</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--</div>-->

    <!--修改教室场地开始-->
    <div class="modal fade" id="updateClassroomModel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">修改教室场地</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-10 mTB20">
                            <li class="col-sm-12 heightCenter">
                                <div class="col-sm-4 text-right"><span class="red">*</span>所属房间</div>
                                <div class="col-sm-8">
                                    <select class="form-control selectCss" ng-model="upRoomId">
                                        <option value="">请选择房间</option>
                                        <option ng-repeat="item in allHouse" ng-selected="item.id == upRoomId" value="{{item.id}}">{{item.name}}（{{item.code}}）</option>
                                    </select>
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-4 text-right"><span class="red">*</span>教室名称</div>
                                <div class="col-sm-8"><input type="text" ng-model="upName" class="form-control" placeholder="请输入教室名称"></div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-4  text-right">面积</div>
                                <div class="col-sm-8 "><input type="text" ng-model="upSquare" class="form-control" placeholder="多少㎡"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ladda="upClassroomLoad" ng-click="upClassroomComplete()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--修改教室场地结束-->

    <!--添加教室场地-->
    <div class="modal fade" id="addClassroomSite" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">添加教室场地</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-10 mTB20">
                            <li class="col-sm-12 heightCenter">
                                <div class="col-sm-4 text-right"><span class="red">*</span>所属房间</div>
                                <div class="col-sm-5">
                                    <select class="form-control selectCss" ng-model="DCodeId">
                                        <option value="">请选择房间</option>
                                        <option ng-repeat="item in allHouse" value="{{item.id}}">{{item.name}}（{{item.code}}）</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-info" style="margin-right: 5px;" ng-click="addHouse()">新增</button>
                                <button type="button" class="btn btn-danger" ng-click="delHouse()">删除</button>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-4 text-right"><span class="red">*</span>教室名称</div>
                                <div class="col-sm-8"><input type="text" ng-model="classroomName" class="form-control" placeholder="请输入教室名称"></div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-4  text-right">面积</div>
                                <div  class="col-sm-8 "><input type="text" ng-model="classroomSquare" class="form-control" placeholder="多少㎡"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ladda="CompleteSiteButton" ng-click="addClassroomComplete()">完成</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--新增座位排次-->
    <div class="modal fade bs-example-modal-lg" id="addNewSeatListsModal" style="overflow: auto;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<!--        <div class="modal-dialog modal-lg" role="document" style="width: 1200px;">-->
        <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">新增座位排次</h4>
                </div>
                <div class="modal-body">
                    <section class="row ">
                        <div class="col-sm-12 contentCenter">
                            <div class="col-sm-10">
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>教室名称</div>
                                    <div class="col-sm-8">
                                        <select class="form-control selectCss" ng-change="selectClassroom(classroomId)" ng-model="classroomId">
                                            <option value="">请选择教室</option>
                                            <option ng-repeat="classroom in allVenueSiteLists" value="{{classroom.id}}">{{classroom.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>增加排数</div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" inputnum ng-blur="rowsBlur(addClassRows)" ng-model="addClassRows" checknum placeholder="多少排">
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>增加列数</div>
                                    <div class="col-sm-8">
                                        <input type="number" inputnum class="form-control" ng-blur="columnsBlur(addClassColumns)" ng-model="addClassColumns" checknum placeholder="多少列">
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>座位名称</div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" ng-model="addCourseName"  placeholder="请输入座位名称">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 contentCenter mT20">
                            <div class="col-sm-12 text-center">
                                <ul>
                                    <li>可容纳<span >{{allPeople}}</span>人</li>
                                    <li class="mT6"><span class="glyphicon glyphicon-info-sign color999"></span>单击座位进行编辑</li>
                                    <li class="mT6"><span class="color999"></span>温馨提示:增加座位排次时小心操作，点击黑色边缘不会保存增加座位信息</li>
                                </ul>
                            </div>
                        </div>
                        <div class=" addSeatLists col-sm-12 text-center contentCenter mT20"  id="addSeatLists">
                            <table>
                                <tbody >
<!--                                    <tr class="seatRowLists"  ng-repeat="(row,$key) in addSeatRows">-->
<!--                                        <td  class="seatSize  p4 cp seatColumnLists" ng-click="editSeat($key,$col)" ng-repeat="(col,$col) in addSeatCols">-->
<!--                                            <div class="addSeatNum"></div>-->
<!--                                            <div class="addSeatType" data-value=""></div>-->
<!--                                        </td>-->
<!--                                    </tr>-->
                                        <tr class="seatRowLists addSeatRowLists" ng-repeat="(row,$key) in addSeatRows">
                                            <td ng-click="editSeat($key,$col)" ng-repeat="(col,$col) in addSeatCols">
                                                <section style="display: flex;align-items: center;" class="seatSize m4  p4 cp seatColumnLists tdBox addSeatNum123">
                                                    <div style="text-align: center;width: 100%;">
                                                        <div class="addSeatNum"></div>
                                                        <div class="addSeatType" data-value=""></div>
                                                    </div>
                                                </section>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ng-click="completeAddSeatLists()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--    新增数据-->
    <div class="modal fade " id="siteManagementAdd2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <label class="col-sm-4 control-label commodityModificationStrong"><span style="color: red">*</span>房间名称或编号</label>
                                <div class="col-sm-4" style="padding-right: 0;">
                                    <input type="text" class="form-control w160" placeholder="房间名称或编号"
                                           ng-model="houseName">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="col-sm-4 control-label commodityModificationStrong"><span style="color: red">*</span>所属场馆</label>
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
                                <label class="col-sm-4 control-label commodityModificationStrong"><span style="color: red">*</span>识别码</label>
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
    <!--座位排次详情-->
    <div class="modal fade bs-example-modal-lg" id="seatDetailModal" style="overflow: auto;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<!--        <div class="modal-dialog modal-lg" role="document" style="width: 1200px;">-->
        <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">座位排次详情</h4>
                </div>
                <div class="modal-body">
                    <section class="row ">
                        <div class="col-sm-12 contentCenter">
                            <div class="col-sm-10">
                                <div class="col-sm-12 contentCenter mT20">
                                    <div class="col-sm-12 text-center">
                                        <ul>
                                            <h2 class="f28 f400">{{clickSeatDetails.name}}</h2>
                                            <li class="f16Col999 mT6"><span>教室:{{clickSeatDetails.roomName}}</span>&emsp;<span ng-if="clickSeatDetails.classroom_area != '' && clickSeatDetails.classroom_area != null">{{clickSeatDetails.classroom_area}}m²</span>&emsp;<span>人数:{{clickSeatDetails.amount}}人</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="seatLists col-sm-12 text-center contentCenter mT20">
                            <table>
                                <tbody>
                                     <tr class="seatDetailLists" ng-repeat="(seat,$key) in seatDetailRows">
                                         <td  ng-if="$key == seat.rows"   ng-repeat="seat in  seatAllDetailSeat">
                                             <section class=" seatEditSize p4 cp m4" style="display: flex;align-items: center;"
                                                      ng-class="{borderNone:seat.seat_type == '0' || seat.seat_number == '0' || seat.seat_type == null || seat.seat_number == null}">
                                                 <div style="text-align: center;width: 100%;">
                                                     <div class="addSeatNum"><span ng-if="seat.seat_number != '0'">{{seat.seat_number}}</span></div>
                                                     <div class="addSeatType" data-value="">
                                                         <span ng-if="seat.seat_type == '0'&& seat.seat_number != '0'"></span>
                                                         <span ng-if="seat.seat_type == '1'&& seat.seat_number != '0'">普通</span>
                                                         <span ng-if="seat.seat_type == '2'&& seat.seat_number != '0'">VIP</span>
                                                         <span ng-if="seat.seat_type == '3'&& seat.seat_number != '0'">贵族</span>
                                                         <span ng-if="seat.seat_type == '4'&& seat.seat_number != '0'">金爵</span>
                                                         <span ng-if="seat.seat_type == '5'&& seat.seat_number != '0'">尊爵</span>
                                                     </div>
                                                 </div>
                                             </section>
                                         </td>
                                     </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default w100" ng-disabled="editSeatListsBOOL" ng-click="editSeatListsClick(clickSeatDetails.id)">修改</button>
                </div>
            </div>
        </div>
    </div>
    <!--编辑座位-->
    <div class="modal fade" id="editSeatModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">编辑座位</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-10 mTB20"  >
                            <li class="col-sm-12 heightCenter">
                                <div class="col-sm-4 text-right"><span class="red">*</span>座位号</div>
                                <div class="col-sm-8"><input type="number" inputnum class="form-control" ng-blur="seatNumberBlur(editSeatNum)" placeholder="请输入座位号" ng-model="editSeatNum"></div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-4  text-right"><span class="red">*</span>座位类别</div>
                                <div  class="col-sm-8 ">
                                    <select class="form-control selectCss"  ng-model="editSeatType" id="selectEditSeatType">
                                        <option value="">请选择座位类别</option>
                                        <option ng-repeat="seatType in seatAllType" value="{{seatType.id}}">{{seatType.name}}</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: space-around;">
                    <button type="button" class="btn btn-default w100" ng-click="delSeat1(editSeatNum,editSeatType)">删除座位</button>
                    <button type="button" class="btn btn-success w100" ng-click="editSeatComplete(editSeatNum,editSeatType)">完成</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--修改座位排次-->
    <div class="modal fade bs-example-modal-lg" id="amendSeatModal" style="overflow: auto;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<!--        <div class="modal-dialog modal-lg" role="document" style="width: 1200px;">-->
        <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">修改座位排次</h4>
                </div>
                <div class="modal-body">
                    <section class="row ">
                        <div class="col-sm-12 contentCenter">
                            <div class="col-sm-10">
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>教室名称</div>
                                    <div class="col-sm-8">
                                        <select class="form-control selectCss" ng-change="selectEditClassroom(EditClassroomId)" ng-model="EditClassroomId">
                                            <option value="">请选择教室</option>
                                            <option ng-selected="classroomEditId == classroom.id " ng-repeat="classroom in allVenueSiteLists" value="{{classroom.id}}">{{classroom.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>座位名称</div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control"  placeholder="请输入座位名称" ng-model="classroomEditName">
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>增加排数</div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" disabled="disabled" ng-model="classroomEditRows" checknum placeholder="多少排">
                                    </div>
                                </div>
                                <div class="col-sm-6 heightCenter mT20">
                                    <div class="col-sm-4 text-right"><span class="red">*</span>增加列数</div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" disabled="disabled" ng-model="classroomEditCols" checknum placeholder="多少列">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 contentCenter mT20">
                            <div class="col-sm-12 text-center">
                                <ul>
                                    <li>可容纳<span>{{classroomEditCols*classroomEditRows}}</span>人</li>
                                    <li class="mT6"><span class="glyphicon glyphicon-info-sign color999"></span>单击座位进行编辑</li>
                                    <li class="mT6"><span class="color999"></span>温馨提示:修改座位排次时小心操作，点击黑色边缘不会保存修改的座位信息</li>
                                </ul>
                            </div>
                        </div>
                        <div class=" seatLists col-sm-12 text-center contentCenter mT20" id="editSeatLists123">
                            <table>
                                <tbody>
                                <tr class="seatDetailModalLists" ng-repeat="(seat,$key1) in seatDetailRows">
                                    <td  ng-if="$key1 == seatEdit.rows" ng-click="editModalSeat(seatEdit.rows,seatEdit.columns)"   ng-repeat="seatEdit in  seatAllDetailSeat" >
                                        <section class=" seatEditSize p4 cp m4  seatModalEditBox editSeatNumber132" ng-class="{tdBut:seatEdit.seat_number =='0'}" style="display: flex;align-items: center;">
                                            <div style="text-align: center;width: 100%;">
                                                <div class="addSeatNum"><span ng-if="seatEdit.seat_number != 0">{{seatEdit.seat_number}}</span></div>
                                                <div class="addSeatType" data-value="{{seatEdit.seat_type}}">
                                                    <span ng-if="seatEdit.seat_type == '0' " data-value='0'></span>
                                                    <span ng-if="seatEdit.seat_type == '1' " data-value='1'>普通</span>
                                                    <span ng-if="seatEdit.seat_type == '2' " data-value='2'>VIP</span>
                                                    <span ng-if="seatEdit.seat_type == '3' " data-value='3'>贵族</span>
                                                    <span ng-if="seatEdit.seat_type == '4' " data-value='4'>金爵</span>
                                                    <span ng-if="seatEdit.seat_type == '5'"  data-value='5'>尊爵</span>
                                                </div>
                                                <div ng-if="seatEdit.seat_number == '0'" class="addFlag"><span class="glyphicon glyphicon-plus"></span></div>
                                                <div ng-if="seatEdit.seat_number != '0'" class="addFlag123 disNone"><span class="glyphicon glyphicon-plus"></span></div>
                                            </div>
                                        </section>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: space-around;">
                    <button type="button" class="btn btn-default w100" ng-click="deleteCourseType()">删除</button>
                    <button type="button" class="btn btn-success w100" ng-click="completeEdit()" ladda="CompleteButton">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--修改模态框中的编辑座位-->
    <div class="modal fade" id="editModalSeatModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">编辑座位</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-10 mTB20"  >
                            <li class="col-sm-12 heightCenter">
                                <div class="col-sm-4 text-right"><span class="red">*</span>座位号</div>
                                <div class="col-sm-8"><input type="number" checknum class="form-control" id="seatNum123"  placeholder="请输入座位号" ng-model="editEditSeatNum"></div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-4  text-right"><span class="red">*</span>座位类别</div>
                                <div  class="col-sm-8 ">
                                    <select class="form-control selectCss"  ng-model="editEditSeatType" id="editModalType123">
                                        <option value="">请选择座位类别</option>
                                        <option ng-repeat="seatType in seatAllType" ng-selected=" selectedSeatTypeId == seatType.id" value="{{seatType.id}}">{{seatType.name}}</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: space-around;">
                    <button type="button" class="btn btn-default w100" ng-click="delModalSeatComplete(editEditSeatNum,editEditSeatType)">删除座位</button>
                    <button type="button" class="btn btn-success w100" ng-click="editEditSeatComplete(editEditSeatNum,editEditSeatType)">完成</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</main>
