<?php
use backend\assets\LeagueCtrlAsset;
LeagueCtrlAsset::register($this);

$this->title = '课程管理';
?>

<div class="wrapper wrapper-content  animated fadeIn" ng-controller = 'leagueCtrl' ng-cloak>
    <div class="row">
        <div class="col-sm-12">
                <div class="panel panel-default ">
                <div class="panel-heading"> <h2><b>团课课程管理</b></h2></div>
                <div class="panel-body">
                    <div class="col-sm-6" style="margin-left: 200px">
                        <div class="input-group">
                            <input type="text" class="form-control"  ng-model="courseName"  ng-keydown="enterSearch()"  placeholder=" 请输入课程、教练进行搜索..."
                                   style="height: 34px;line-height: 7px;">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" ng-click="search()"  >搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 text-right f14">
                        <li class="new_add" id="tmk">
                            <a style="color: darkgrey;" href="/league/reservation?&c=5" ><span class="glyphicon glyphicon-cog"></span>预约</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="/league/add?&c=5" class="glyphicon glyphicon-plus" >新增课程</a>
                        </li>
                    </div>
                    <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                        <div class=" fl" style="display: flex;justify-content: space-between">
                            <span class="" style="position: relative;margin-top: 5px;width: 100px;   ">选择场馆:</span>
                            <select ng-if="VenueStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.venueId">
                                <option id=""  value="" selected>所有场馆</option>
                                <option ng-repeat ="venue in venues" value="{{venue.id}}">{{venue.name}}</option>
                            </select>
                            <select ng-if="VenueStauts == false" class="form-control " style="padding: 4px 12px;" >
                                <option id=""  value="" selected>所有场馆</option>
                                <option value="" disabled style="color:red">{{venues}}</option>
                            </select>
                        </div>
                        <div class="fl" style="display: flex;justify-content: space-between;margin-left: 20px;">
                            <span class="" style="position: relative;margin-top: 5px;width: 100px;">选择教室:</span>
                            <select ng-if="classroomsStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.classroomId">
                                <option value= ""  selected>所有教室</option>
                                <option ng-repeat=" classrooms in  classrooms"  value="{{classrooms.id}}">{{classrooms.name}}</option>
                            </select>
                            <select ng-if="classroomsStauts == false" class="form-control " style="padding: 4px 12px;" >
                                <option id=""  value=""  selected>所有场馆</option>
                                <option value="" disabled style="color:red">{{classrooms}}</option>
                            </select>
                        </div>

                        <!-- 日历范围时间插件-->
                        <div style="float: left;position: relative;margin-left: 23px;margin-top: 0px;width: 200px" class="input-daterange input-group cp" id="container">
                             <span class="add-on input-group-addon">选择时间:
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                 </span>
                            <input type="text"  readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control text-center" value="" placeholder="选择时间"/>
                            </div>
                        <button class="btn btn-success btn-sm" type="button" ng-click="search()" style="margin-left: 49px;float: left;margin-top: -1px">确定</button>
                        <button type="button" ladda="searchCarding" ng-click="searchClear()" class="btn btn-sm btn-info" style="margin-left: 19px;float: left;margin-top: -1px">清空</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>团课管理信息列表</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content" style="padding: 0;">

                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">

                        <div class="row">
                            <div class="col-sm-6" style="display: none;"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('courseName',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-book" aria-hidden="true"></span>&nbsp;课程
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('coachName',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-user" aria-hidden="true"></span>&nbsp;教练
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('classrooms',sort)"     colspan="1" aria-label="平台：激活排序列升序" style="width: 140px;"><span class="fa fa-university " aria-hidden="true"></span>&nbsp;教室
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('courseDate',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;日期
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                ng-click="changeSort('startTime',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="fa fa-clock-o" aria-hidden="true"></span>&nbsp;课程时间
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                </th>
                            </tr>
                            </thead>
                            <tbody class="cp">
<!--                            <a ng-href="/league/league-detail?mid=6&c=3"></a>-->
                            <tr ng-repeat="item in items">
                                <td ng-click="aboutDetail(item.id)">{{item.course.name}}</td>
                                <td ng-click="aboutDetail(item.id)">{{item.coachName}}</td>
                                <td ng-click="aboutDetail(item.id)">{{item.classRoomName}}</td>
                                <td ng-click="aboutDetail(item.id)">{{item.class_date}}</td>
                                <td ng-click="aboutDetail(item.id)">{{item.start*1000 | date:'HH:mm' }}-{{item.end*1000 | date:'HH:mm' }}</td>
                                <td class="tdBtn">
                                    <div id="myEdit" type="button" class="btn btn-success btn-sm" style="color: #FFFFFF;margin-right: 3px;" data-toggle="modal" data-target=".EditModal" >
                                       <a href="/league/edit-course?id={{item.id}}&c=5" style="color: #FFFFFF;">修改</a>
                                    </div>
                                    <div  class="btn btn-danger btn-sm delete" ng-click="delete(item.id)" >删除</div>
                                </td>

                            </tr>

                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php'); ?>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <?= $this->render('@app/views/common/pagination.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--新增课程弹出框-->
<div   class="modal fade  myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div  class="modal-dialog modal-sm" role="document" id="mutaikuang" >
        <div class="modal-content clearfix" id="mtk_but" >
            <p ><span class="glyphicon glyphicon-remove cp" data-toggle="modal" data-target=".myModal"></span></p>
            <div><a href="/league/search-history-add?mid=6&c=3"><span class="btn btn-default">选择历史课程并新增</span></a></div>
            <div><a class="tkxz" href="/league/add?mid=6&c=3"><span class="btn btn-success">新增新的课程</span></a></div>
        </div>
    </div>
</div>




