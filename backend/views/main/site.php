<?php
use backend\assets\SiteCtrlAsset;
SiteCtrlAsset::register($this);
$this->title = '场地管理';
?>
<div  ng-controller = 'siteCtrl' ng-cloak style="min-width: 620px;">
    <header>
<!--        <div class="wrapper wrapper-content  animated fadeIn" >-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                             <span style="display: inline-block"><b>组织架构管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pd0 " >
                                <div class="col-sm-6 col-xs-8 col-sm-offset-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control a5" ng-keydown="enterSearch()" ng-model="topSearch" placeholder="  请输入公司名称，场馆或场地进行搜索..." ng-keydown="enterSearch()">
                                                <span class="input-group-btn">
                                                    <button type="button"   ng-click="search()"  class="btn btn-primary">搜索</button>
                                                </span>
                                    </div>
                                </div>
                                <div class="col-sm-offset-1 col-xs-4 col-sm-2 text-left">
                                    <li class="nav_add" style="padding-top: 0;">
                                        <div class="dropdown a6" >
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','ADD')){ ?>
                                                <div style="border: none;background-color: transparent !important;padding-bottom: 5px:  " class=" dropdown-toggle f14 " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <span class="btn btn-success btn header2" style="">选择添加项目</span>
                                                </div>
                                            <?php } ?>
                                            <ul  class="dropdown-menu f16 headerTop" aria-labelledby="dropdownMenu1">
                                                <li><a href="/main/add-brand" >公司品称添加</a></li>
                                                <li><a href="/main/add-venue" >场馆添加</a></li>
                                                <li><a href="/main/add-site" >场地添加</a></li>
    <!--                                            <li><a href="/main/add-facility?mid=21&c=20" >设备添加</a></li>-->
                                                <li><a href="/main/add-department" >部门添加</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 headerTop1"><h4>条件筛选</h4></div>
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                                <div class="fl headerTop2">
                                    <span class="" style="position: relative;margin-top: 5px;width: 100px;">选择场地:</span>
<!--                                    <select ng-if="classroomsStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.classroomId">-->
<!--                                        <option value= ""  selected>所有场地</option>-->
<!--                                        <option ng-repeat=" classrooms in  classrooms"  value="{{classrooms.id}}">{{classrooms.name}}</option>-->
<!--                                    </select>-->
                                    <label for="id_label_single" >
                                        <select  class="js-example-basic-single1 js-states form-control"  style="width: 150px;padding-bottom: 3px;" ng-model="venueId1" id="id_label_single">
                                            <option value= ""  selected>所有场馆</option>
                                            <option ng-repeat=" venue in venues"  value="{{venue.id}}">{{venue.name}}</option>
                                        </select>
                                    </label>
<!--                                    <select ng-if="classroomsStauts == false" class="form-control " style="padding: 4px 12px;" >-->
<!--                                        <option id=""  value=""  selected>所有场地</option>-->
<!--                                        <option value="" disabled style="color:red">{{classrooms}}</option>-->
<!--                                    </select>-->
                                </div>
                                <!-- 日历范围时间插件-->
    <!--                            <div style="float: left;position: relative;" class="input-daterange input-group cp" id="container">-->
    <!--                                <i style="position: absolute;top: 8px;left: 100px;;z-index: 999;" class="fa fa-calendar leftDate"></i>-->
    <!--                                <i style="position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-calendar rightDate"></i>-->
    <!--                                <b><input type="text" id = 'datetimeStart' class="input-sm form-control" name="start" placeholder="起始日期"  style="width: 120px;text-align:left;font-size: 13px;cursor: pointer;"></b>-->
    <!--                                <b><input type="text" id="datetimeEnd" class="input-sm form-control" name="end" placeholder="结束日期" style="width: 120px;text-align: left;font-size: 13px;cursor: pointer;"></b>-->
    <!--                            </div>-->
<!--                                <div style="float: left;position: relative;margin-left: 20px;" class="input-daterange input-group fl cp" id="container">-->
<!--                                    <div style="float: left;position: relative;margin-left: 1px;margin-top: 1px" class="input-daterange input-group cp" id="container">-->
<!--                                 <span class="add-on input-group-addon">-->
<!--                                选择时间 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>-->
<!--                                     </span>-->
<!--                                        <input type="text" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" / placeholder="请输入搜索时间"  >-->
<!--                                    </div>-->
<!--                                </div>-->
                                <button class="btn btn-success btn-sm" ng-click="search()" tape="submit" style="margin-left: 35px;">确定</button>
                                <button class="btn btn-info btn-sm" ng-click="searchClear()" tape="submit" style="margin-left: 20px;">清除</button>
                            </div>
                        </div>
                        </div>
                <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                    <div class="tabBox clearfix" style="border: solid 1px #e5e5e5;min-width: 620px;">
                        <div class="list_tab fl " style="">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/index?mid=21&c=20"><span class="yG" >场馆</span></a>
                        </div>
                        <div class="list_tab fl" style="margin-left: -50px;z-index: 10;">
                            <img src="/plugins/main/imgs/u113.png" alt="" /><a href="/main/site?mid=21&c=20"><span >场地</span></a>
                        </div>
<!--                        <div class="list_tab fl" style="margin-left: -50px;">-->
<!--                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/facility?mid=21&c=20"><span >设备</span></a>-->
<!--                        </div>-->
                        <div class="list_tab fl" style="margin-left: -50px;">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/company?mid=21&c=20"><span >公司</span></a>
                        </div>
                        <div class="list_tab fl" style="margin-left: -50px;">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/department?mid=21&c=20"><span >部门</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12"style="padding-left: 0;padding-right: 0;">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>场地信息列表</h5>
                            <div class="ibox-tools">

                            </div>
                        </div>
                        <div class="ibox-content">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row">
                                    <div class="col-sm-6"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('companyName',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 180px;"><span class="fa fa-group" aria-hidden="true"></span>&nbsp;公司名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('venueName',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" style="width: 180px;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;场馆
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('classroom',sort)"    colspan="1" aria-label="平台：激活排序列升序" style="width: 180px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;场地
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('area',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 180px;"><span class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;场地面积
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('total_seat',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon  glyphicon-user" aria-hidden="true"></span>&nbsp;容纳人数
                                        </th>
    <!--                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
    <!--                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 142px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;修改时间-->
    <!--                                    </th>-->
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="gradeA odd" ng-repeat="item in items">
                                        <td>{{item.superior}}</td>
                                        <td>{{item.venueName}}</td>
                                        <td >{{item.name}}</td>
                                        <td>{{item.classroom_area}}</td>
                                        <td>{{item.total_seat | noData:''}}</td>
                                        <td class="tdBtn">
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','UPDATE')){ ?>
                                                <a href="" data-toggle="modal" data-target="#editSite" style="margin-top: 5px;color:#fff">
                                                <span  ng-click="update(item.id,item.venue_id,item.superior_id,item.name,item.classroom_area,item.total_seat,item.classroom_describe,item.classroom_pic)"   class="btn btn-success btn-sm" type="submit">修改</span></a>
                                                &nbsp;&nbsp;
                                            <?php } ?>
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','DELETE')){ ?>
                                                <button class="btn btn-danger btn-sm" ng-click="del(item.id,item.name)" type="submit">删除</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                             id="DataTables_Table_0_paginate">
                                            <?= $this->render('@app/views/common/pagination.php'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            </div>-->
<!--        </div>-->
    </header>

    <!--场地修改页面-->
    <div class="modal fade" id="editSite" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                        修改场地管理详情
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;"><strong style="color:red">*</strong>所属公司</div>
                    <select class="form-control darkGrey"  style="width:56%;height:40px;margin-left:120px"  name="" id="company" ng-model="theCompanyId"  ng-change="searchVenue(theCompanyId)">
                        <option value="">请选择所属公司</option>
                        <option value="{{company.id}}"   ng-repeat="company in companyS">{{company.name}}</option>
                    </select>
                    <input  id="_csrf" type="hidden"
                            name="<?= \Yii::$app->request->csrfParam; ?>"
                            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;margin-top:10px;"><strong style="color:red">*</strong>所属场馆</div>
                    <select class="form-control" name="" style="width:56%;height:40px;margin-left:120px" ng-model="venueId"   id="venue">
                        <option value="">请选择所属场馆</option>
                        <option value="{{venue.id}}"  ng-repeat="venue in venueS" >{{venue.name}}</option>
                    </select>
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;margin-top:10px;"><strong style="color:red">*</strong>场地名称</div>
                    <div class="form-group text-center">
                        <center>
                            <input type="text" class="form-control actions" id="" ng-model="classroomName" value="瑜伽">
                        </center>
                    </div>
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">场地面积(m²)</div>
                    <div class="form-group text-center">
                        <center>
                            <input type="text"  placeholder="请输入正整数，例如300""   class="form-control actions" ng-model="classroomArea"   id="" >
                        </center>
                    </div>
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;"><strong style="color:red">*</strong>场地座位(个)</div>
                    <div class="form-group text-center">
                        <center>
                            <input type="text" ng-model="totalSeat"  placeholder="请输入小于100的正整数"  class="form-control actions" id="">
                        </center>
                    </div>
                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">场地描述</div>
                    <div class="form-group text-center"  style="margin: 0 37px">
                        <center>
                            <textarea name="" id="" ng-model="classroomDes"  cols="1" rows="4" class="form-control" style="width: 300px;resize: none;">

                            </textarea>
                        </center>
                    </div>

                    <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">场地照片</div>
                    <div class="form-group">
                        <img ng-src="{{classroomPic}}" width="100px" height="100px" style="margin-left: 120px;">
                    </div>
                    <div class="input-file ladda-button btn ng-empty uploader"
                         style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left:337px;margin-top: -151px"
                         ngf-drop="uploadCover($file,'update')"
                         ladda="uploading"
                         ngf-select="uploadCover($file,'update')"
                         ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                         ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                    >
                        <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;" class="text-center">+</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <center><button type="button" class="btn btn-success   "  ng-click="updateClassroom()"   style="width: 100px;">提交</button></center>
                </div>
            </div>
        </div>
    </div>
</div>

