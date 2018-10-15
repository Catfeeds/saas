<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '组织架构管理';
?>
<div  ng-controller = 'mainCtrl' ng-cloak style="min-width: 620px;">
    <header>
<!--        <div class="wrapper wrapper-content  animated fadeIn" >-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default ">
                        <div class="panel-heading"><span style="display: inline-block"><b>组织架构管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pd0 " >
                                <div class="col-sm-6 col-xs-8 col-sm-offset-2" >
                                    <div class="input-group">
                                        <input type="text" class="form-control header1" ng-model="topSearch" name="keyword" id="keyword"  ng-keydown="enterSearch()" placeholder="  请输入场馆名称，所属公司，或创建人进行搜索...">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                                                </span>
                                    </div>
                                </div>
    
                                <div class="col-sm-offset-1 col-xs-4 col-sm-2 text-left">
                                    <li class="nav_add" style="padding-top: 0;">
                                        <div class="dropdown " style="border: none;left: 0;cursor:pointer " >
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','ADD')){ ?>
                                                <div style="border: none;background-color: transparent !important;padding-bottom: 5px:  " class=" dropdown-toggle f14 " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <span class="btn btn-success btn header2">选择添加项目</span>
                                                </div>
                                            <?php } ?>
                                            <ul  class="dropdown-menu f14 header3" aria-labelledby="dropdownMenu1">
                                                <li><a href="/main/add-brand" >公司名称添加</a></li>
                                                <li><a href="/main/add-venue" >场馆添加</a></li>
                                                <li><a href="/main/add-site" >场地添加</a></li>
    <!--                                            <li><a href="/main/add-facility?mid=21&c=20" >设备添加</a></li>-->
                                                <li><a href="/main/add-department" >部门添加</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pdLR0 clearfix" style="display: flex;flex-wrap: wrap;">
                                <div class="mB10" style="width: 200px;height: 30px;margin-right: 10px;">
<!--                                    <span class="choiceCg">选择场馆:</span>-->
<!--                                    <select ng-if="VenueStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.venueId">-->
<!--                                        <option id=""  value="" selected>所有场馆</option>-->
<!--                                        <option ng-repeat ="venue in venues" value="{{venue.id}}">{{venue.name}}</option>-->
<!--                                    </select>-->
                                    <label for="id_label_single" >
                                        <select ng-model="$parent.venueId" class="js-example-basic-single1 js-states form-control choices" ng-model="venue_id" id="id_label_single">
                                            <option value="">全部</option>
                                            <option ng-repeat ="venue in venues" value="{{venue.id}}">{{venue.name}}</option>
                                        </select>
                                    </label>

<!--                                    <select ng-if="VenueStauts == false" class="form-control " style="padding: 4px 12px;" >-->
<!--                                        <option id=""  value="" selected>所有场馆</option>-->
<!--                                        <option value="" disabled style="color:red">{{venues}}</option>-->
<!--                                    </select>-->
                                </div>
                                <!-- 日历范围时间插件-->
                                <div style="position: relative;margin-right: 10px;" class="input-daterange input-group  cp mB10" id="container">
                                    <div style="position: relative;margin-left: 1px;" class="input-daterange input-group cp" id="container">
                                 <span class="add-on input-group-addon">
                                选择时间 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                     </span>
                                        <input type="text" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" / placeholder="请输入搜索时间"  >
                                    </div>
                                </div>
                                <div class="mB10">
                                    <button class="btn btn-success btn-sm"  ng-click="search()" tape="submit" style="margin-right: 10px;">确定</button>
                                    <button class="btn btn-info btn-sm"  ng-click="searchClear()" tape="submit" >清除</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12" >
                    <div class="tabBox clearfix vengu" style="min-width: 620px;">
                        <div class="list_tab fl " style="z-index: 10">
                            <img src="/plugins/main/imgs/u113.png" alt="" /><a href="/main/index"><span class="yG" >场馆</span></a>
                        </div>
                        <div class="list_tab fl chang">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/site"><span >场地</span></a>
                        </div>
<!--                        <div class="list_tab fl" style="margin-left: -50px;">-->
<!--                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/facility?mid=21&c=20"><span >设备</span></a>-->
<!--                        </div>-->
                        <div class="list_tab fl chang">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/company"><span >公司</span></a>
                        </div>
                        <div class="list_tab fl chang">
                            <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/department"><span >部门</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>场馆信息列表</h5><span style="font-size: 12px;color: #999;font-weight:normal">点击查看场馆详情</span>
                            <div class="ibox-tools">

                            </div>
                        </div>
                        <div class="ibox-content" style="padding: 0;">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row" style="display: none;">
                                    <div class="col-sm-6"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('departmentName',sort)"   colspan="1" aria-label="浏览器：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;场馆名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('BelDepartmentName',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 242px;"><span class="fa fa-group" aria-hidden="true"></span>&nbsp;所属公司
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            ng-click="changeSort('BelDepartmentName',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 242px;"><span class="fa fa-group" aria-hidden="true"></span>&nbsp;场馆类型
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('create_id',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;创建人
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            ng-click="changeSort('created_at',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 242px;"><span class="fa fa-clock-o" aria-hidden="true"></span>&nbsp;成立时间
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('created_at',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 242px;"><span class="fa fa-clock-o" aria-hidden="true"></span>&nbsp;创建时间
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('update_at',sort)"    colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>&nbsp;修改时间
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 242px;"><span class="glyphicon glyphicon-edit " aria-hidden="true"></span>&nbsp;编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="gradeA odd" ng-repeat="item in items" ng-click="getDetail(item.id)">
                                        <td data-toggle="modal" data-target="#myModals2">{{item.name}}
                                            <small class="label label-danger " ng-if="item.is_allowed_join == 2">不显示</small>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">{{item.superior}}</td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span ng-if="item.venue_type==null || item.venue_type==''">暂无数据</span>
                                            <span ng-if="item.venue_type==1">综合馆</span>
                                            <span ng-if="item.venue_type==2">瑜伽馆</span>
                                            <span ng-if="item.venue_type==3">舞蹈馆</span>
                                            <span ng-if="item.venue_type==4">搏击馆</span>
                                            <span ng-if="item.venue_type==5">游泳馆</span>
                                            <span ng-if="item.venue_type==6">健身馆</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">{{item.username}}</td>
                                        <td data-toggle="modal" data-target="#myModals2">{{item.establish_time != null ?(item.establish_time*1000 | date:'yyyy-MM-dd HH:mm'):'暂无'}}</td>
                                        <td data-toggle="modal" data-target="#myModals2">{{item.created_at != null ?(item.created_at*1000 | date:'yyyy-MM-dd HH:mm'):'暂无'}}</td>
                                        <td data-toggle="modal" data-target="#myModals2">{{item.update_at != null ?(item.update_at*1000 | date:'yyyy-MM-dd HH:mm'):'暂无'}}</td>
                                        <td class="tdBtn">
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','UPDATE')){ ?>
                                                <span class="btn btn-success btn-sm" type="submit">
                                                        <a href="" data-toggle="modal"
                                                           ng-click="updateVenue(item.id,item.pid,item.name,item.address,item.area,item.phone,item.pic,item.describe,item)"
                                                           data-target="#myModals" style="margin-top: 5px;color:#fff">
                                                        修改</a>
                                                </span>&nbsp;&nbsp;
                                            <?php } ?>
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','DELETE')){ ?>
                                                <button class="btn btn-danger btn-sm" ng-click="del(item.id,item.name)"   type="submit">删除</button>
                                            <?php } ?>
                                            <button class="btn btn-primary btn-sm mL6" ng-click="isShow(item.id)"   type="submit">{{item.is_allowed_join != 1? '显示':'不显示'}}</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <div class="row">
    <!--                                <div class="col-sm-6">-->
    <!--                                    <div class="dataTables_info" style="padding-left: 30px;" id="DataTables_Table_0_info" role="alert"-->
    <!--                                         aria-live="polite" aria-relevant="all">显示 1 到 10 项，共 57 项-->
    <!--                                    </div>-->
    <!--                                </div>-->
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
<!--            </div>-->
    </header>
    <!--新增组织架构-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center yanse" id="myModalLabel">
                        添加组织架构
                    </h3>
                </div>
                <div class="modal-body">

                    <div class="form-group text-center">
                        <center>
                        <input type="text" class="form-control actions" id="" placeholder="请输入公司名称">
                        </center>
                    </div>
                    <div class="form-group text-center">
                        <center>
                        <select class="form-control actions ys" style="">
                            <option>请选择类型</option>
                            <option>公司</option>
                            <option>场馆</option>
                            <option>部门</option>
                        </select>
                            </center>
                    </div>
                    <div class="form-group text-center">
                        <center><select class="form-control actions ys">
                            <option>请选择类型</option>
                            <option>公司</option>
                            <option>场馆</option>
                            <option>部门</option>
                        </select></center>
                    </div>
                    <div class="form-group text-center">
                        <center><input type="text" class="form-control actions" id="" placeholder="请输入自定义属性"></center>
                    </div>

                </div>
                <div class="modal-footer">
                    <center><button type="button" class="btn btn-success  btn-lg" style="width: 50%;">完成</button></center>
                </div>
            </div>
        </div>
    </div>
    <!--场馆的修改和详情页面-->
    <?= $this->render('@app/views/main/venueEditAndDetail.php'); ?>
</div>