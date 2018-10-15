<?php
use backend\assets\CabinetCtrlAsset;
CabinetCtrlAsset::register($this);
$this->title = '柜子管理';
?>
<style>
    .modal-backdrop{
        position: inherit;
        z-index: 100;
    }
</style>
<!--header-->
<div class="wrapper wrapper-content animated fadeIn" ng-controller ='cabinetCtrl' ng-cloak>
    <div class="row">
        <div class="col-sm-12 pd0">
            <div class="panel panel-default ">
                <div class="panel-heading"> <h2>
                        <b>柜子管理</b>
                        <div class="pull-right" style="margin-top: -8px;">
                            <select class="btn-white" style="padding-bottom: 2px;padding-left:30px;width:130px;height:30px;border-radius: 4px;font-size: 14px;color: #999;font-weight: bold;" ng-model="venueId">
                                <option  value="" >请选择场馆</option>
                                <option  value="{{venue.id}}" ng-repeat="venue in venueS">{{venue.name}}</option>
                            </select>
                        </div></h2></div>
                <div class="panel-body">

                    <div class="col-sm-6" style="margin-left: 200px;">
                        <div class="input-group">
                            <input type="text" class="form-control"  ng-model="topSearch"  ng-keydown="enterSearch()" placeholder="  请输入柜子名或柜子号进行搜索..."
                                   style="height: 34px;line-height: 7px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                                        </span>
                        </div>
                    </div>
                    <div class="col-sm-3  text-right">
                        <li class="nav_add">
                            <ul>
                                <li id="tmk">
                                    <a href="#" class="glyphicon glyphicon-plus addCabinet" ng-click="addCabinet()"     style="font-size: 14px;margin-top: 5px;color: green;" data-toggle="modal" data-target="#myModals3">添加柜子</a>
                                </li>
                            </ul>
                        </li>
                    </div>
                    <div class="col-sm-12">
                        <h4 style="margin-top: 20px;">条件筛选</h4>
                        <div style="margin-top: 10px;" class="dropdown pull-left"  id="status">
                            <select class="form-control fl" ng-model="sex" style="padding: 0 0 0 4px;width: 100px;">
                                <option value="">性别不限</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                            <div class="checkbox i-checks checkbox-inline checkBigBox" style="margin-top: 2px;margin-left: 20px;">
                                <input type="checkbox" id="inlineCheckbox1" value="1">
                                <label for="inlineCheckbox1">未租</label>
                            </div>
                            <div class="checkbox i-checks checkbox-success checkbox-inline checkBigBox" style="margin-top: 2px;">
                                <input type="checkbox" id="inlineCheckbox2" value="2">
                                <label for="inlineCheckbox2">已租</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline checkBigBox" style="margin-top: 2px;">
                                <input type="checkbox" id="inlineCheckbox3" value="3">
                                <label for="inlineCheckbox3">维修中</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline checkBigBox" style="margin-top: 2px;">
                                <input type="checkbox" id="inlineCheckbox4" value="7" id="endRent" style="margin-top: 2px;">
                                <label for="inlineCheckbox4">快到期</label>
                            </div>
                        </div>
                        <div class="dateBox col-sm-6 pd0" style="margin-top: 8px;margin-left: 10px;">
                            <!-- 日历范围时间插件-->
                            <div style="float: left;position: relative;margin-left: 23px;margin-top: 0px;width: 200px" class="input-daterange input-group cp" id="container">
                             <span class="add-on input-group-addon">选择时间:
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                 </span>
                                <input type="text"  readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control text-center" value="" placeholder="选择时间"/>
                            </div>

                                    <button class="btn btn-success btn-sm"   ng-click="search()"  tape="submit" style="margin-left: 20px;">确定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="padding-left: 0;padding-right: 0;" class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>柜子信息列表&nbsp<span style="font-size: 12px;font-weight: normal;color: #999;">点击查看详情和修改柜子信息</span></h5>
                    </div>
                    <div class="ibox-content" style="padding: 0">
                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('cabinetNum',sort)"     colspan="1" style="width: 240px;"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>&nbsp;柜号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('typeName',sort)"    colspan="1" style="width: 230px;"><span class="fa fa-table aria-hidden="true"></span>&nbsp;类别名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('status',sort)"       colspan="1" style="width: 150px;"><span class="glyphicon glyphicon-tree-deciduous" aria-hidden="true"></span>&nbsp;柜子租用状态
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('customerName',sort)"    colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;客户名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('mobile',sort)"    colspan="1" style="width: 160px;"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;电话
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('price',sort)"    colspan="1" style="width: 160px;"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;金额
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('date',sort)"    colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;到期日
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('operator',sort)"    colspan="1" style="width: 200px;"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;经办人
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 200px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;编辑
                                    </th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr ng-repeat = 'item in items' ng-if="item.consumerName!=null"  ng-click="dataLoad(item.cabinet_number,item.type_name,item.consumerName,item.mobile,
                                item.dayRentPrice,item.monthRentPrice,item.yearRentPrice,item.end_rent,item.AdminOperator,item.status,item.memberCabinetId,item.id)">
                                    <td  data-toggle="modal" data-target="#myModals2" ><span class="center-block" style="">{{item.cabinet_number}}</span></td>
                                    <td  data-toggle="modal" data-target="#myModals2"><span class="center-block" style="">{{item.type_name}}</span></td>
                                    <td data-toggle="modal" data-target="#myModals2">
                                    <small class="label label-primary" ng-if="item.status==2">已租用</small>
                                    <small class="label label-warning" ng-if="item.status==1">未租用</small>
                                    <small class="label label-danger"  ng-if="item.status==3">维修中</small>
                                    </td>
                                    <td data-toggle="modal" data-target="#myModals2"><span class="center-block" style="">{{item.consumerName}}</span></td>
                                    <td data-toggle="modal" data-target="#myModals2"><span class="center-block" style="">{{item.mobile}}</span></td>
                                    <td data-toggle="modal" data-target="#myModals2"><span class="center-block" style="">
                                            <span ng-if="item.price!=null">{{item.price}}元</span>
                                    </td>
                                    <td data-toggle="modal" data-target="#myModals2"><span ng-if="item.end_rent!=null" class="center-block" style="">
<!--                                            display: block;width: 100px;text-align: left;-->
                                            {{item.end_rent*1000 | date:'yyyy-MM-dd'}}</span></td>
                                    <td data-toggle="modal" data-target="#myModals2"><span class="center-block" style="">{{item.AdminOperator}}</span></td>
                                    <td>
                                            <button class="tdBtn btn btn-success btn-sm" data-toggle="modal" data-target="#myModals5"  ng-click="change(item.typeId,item.id,
                                            item.memberCabinetId,item.consumerName,item.mobile,item.type_name,item.cabinet_number,item.start_rent,item.end_rent,item.venueId)" >调柜</button>
                                            <button class="tdBtn btn btn-warning btn-sm"  ng-click="quitRent(item.consumerName,item.mobile,item.type_name,item.cabinet_number,item.start_rent,item.end_rent,item.memberCabinetId)"  type="submit" data-toggle="modal" data-target="#myModals6">退租</button>
                                            <button class="tdBtn btn btn-danger btn-sm"   ng-click="del(item.memberCabinetId,item.id)" type="submit">解绑</button>
                                    </td>
                                </tr>
<!--                            已注释    未租用的和维修期的柜子的样子如下-->
                                <tr ng-repeat = 'item in items' ng-if="item.consumerName==null">
                                    <td>{{item.cabinet_number}}</td>
                                    <td>
                                        {{item.type_name}}
                                    </td>
                                    <td>
                                        <small class="label label-primary" ng-if="item.status==2">已租用</small>
                                        <small class="label label-warning" ng-if="item.status==1">未租用</small>
                                        <small class="label label-danger"  ng-if="item.status==3">维修中</small>
                                    </td>
                                    <td>{{item.consumerName}}</td>
                                    <td>{{item.mobile}}</td>
                                    <td><span ng-if="item.price!=null">{{item.price}}元</span></td>
                                    <td><span ng-if="item.end_rent!=null">{{item.end_rent*1000 | date:'yyyy-MM-dd'}}</span></td>
                                    <td>{{item.AdminOperator}}</td>
                                    <td>
                                        <button type="button"  ng-click="bindUser(item.cabinet_number,item.type_name,item.id)"   class="btn btn-info btn-sm tdBtn" data-toggle="modal" data-target="#myModals4">&nbsp&nbsp绑定用户&nbsp&nbsp</button>
                                    </td>
                                </tr>
<!--                                <tr>-->
<!--                                    <td>005&nbsp&nbsp<small class="label label-danger">维修中</small</td>-->
<!--                                    <td>男中柜</td>-->
<!--                                    <td>无</td>-->
<!--                                    <td>无</td>-->
<!--                                    <td>无</td>-->
<!--                                    <td>无</td>-->
<!--                                    <td>无</td>-->
<!--                                    <td>-->
<!--                                        <button type="button" class="btn btn-success btn-sm tdBtn">&nbsp&nbsp修好了&nbsp&nbsp</button>-->
<!--                                    </td>-->
<!--                                </tr>-->
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php'); ?>
                            <div class="row">
                                <div class="col-sm-6">
<!--                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="alert"-->
<!--                                         aria-live="polite" aria-relevant="all" style="padding-left: 20px">显示 1 到 10 项，共 57 项-->
<!--                                    </div>-->
                                </div>
                                <div class="col-sm-6 text-right">
                                    <div class="dataTables_paginate paging_simple_numbers"
                                         id="DataTables_Table_0_paginate" style="padding-right: 20px">
                                        <?= $this->render('@app/views/common/pagination.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>








<!--    模态-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;padding-left: 40px;padding-right: 40px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">柜子信息列表</h5>
                    <p style="text-align: center;">点击项即可修改</p>
                    <div>
                    </div>
                    <form>
                        <div style="margin-top: 20px;" class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName2">{{num}}</label>
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName3">{{theTypeName}}</label>
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName4">客户名称：{{consumerName}}</label>
<!--                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName4" ng-model="consumerName">-->
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName5">电话:&nbsp;&nbsp;{{tel}}</label>
<!--                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName5" ng-model="tel">-->
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName6">日金额：</label>
                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName6" ng-model="dayRentPrice">
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName6">月金额：</label>
                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName6" ng-model="monthRentPrice">
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName6">年金额：</label>
                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName6" ng-model="yearRentPrice">
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName7">到期日：</label>
                            <input ng-if="endRent!=null"   style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName7"  value="{{endRent*1000 | date:'yyyy-MM-dd'}}">
                        </div>
                        <div class="form-group col-sm-12">
                            <label style="font-size: 14px;" for="exampleInputName8">经办人：</label>
                            <input style="font-size: 14px;color: #000;" type="text" class=" inputClick br0" id="exampleInputName8" ng-model="adminOperator">
                        </div>
                        <div class="form-group col-sm-12 spanBig">
                            <label style="font-size: 14px;" for="exampleInputName9">柜子状态：</label>
                            <small class="label label-primary" ng-if="status==2">已租用</small>
                            <small class="label label-warning" ng-if="status==1">未租用</small>
                            <small class="label label-danger"  ng-if="status==3">维修中</small>
<!--                            <span type="submit" class="btn btn-success btn-sm btnSpan">修改</span>-->
<!--                            <div class="spanBox">-->
<!--                                <small class="label label-primary">已租用</small>-->
<!--                                <small class="label label-warning">未租用</small>-->
<!--                                <small class="label label-danger">维修中</small>-->
<!--                            </div>-->
                        </div>
                        <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                        <button style="margin-top: 20px;" type="submit" ng-click="cabinetUpdate()"   class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<!--    模态2-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">添加柜子</h5>
                    <form>
                        <div style="margin-top: 20px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName11">选择场馆</label>
                            <select class="form-control" style="font-size: 14px;color: #888;padding-top: 4px;" ng-model="organizationId"   ng-change="searchCabinetType(organizationId)">
                                <option value="">请选择场馆</option>
                                <option value ="{{venue.id}}"  ng-repeat="venue in myVenueS">{{venue.name}}</option>
                            </select>
                        </div>
                        <div style="margin-top: 20px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName2">柜子类型</label>
                            <select class="form-control" style="font-size: 14px;color: #888;padding-top: 4px;" ng-model="myCabinetType">
                                <option value="" >请选择柜子类型</option>
                                <option value ="{{Type.id}}" ng-repeat="Type in cabinetType">{{Type.type_name}}</option>
                            </select>
                                <span style="margin-top: 10px;" ng-click="initCabinetType()" type="submit" class="btn btn-success btn-sm addCabinet" data-toggle="modal" data-target="#myModals7">添加柜子类型</span>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName3"  >柜子数量</label>
                            <input type="text" ng-model="cabinetNum" class="form-control" id="exampleInputName3" placeholder="请输入柜子数量 如：1">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName4">柜子编号</label>
                            <p style="font-size: 14px;">0001-0002</p>
                            <p style="margin-top: -12px;" class="text-muted help-block m-b-none">
                                         <i class="fa fa-info-circle"></i>
                                        编号自动生成，自动向以有柜子编号后排列
                                    </p>
                        </div>
                        <div style="margin-top: 10px;" class="form-group" >
                            <label style="font-size: 14px;" for="exampleInputName5">日租金</label>
                            <input ng-model="dayRentPrice" type="text" class="form-control" id="exampleInputName5" placeholder="如：1000元">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName6">月租金</label>
                            <input ng-model="monthRentPrice" type="text" class="form-control" id="exampleInputName6" placeholder="如：1000元">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName7">年租金</label>
                            <input ng-model="yearRentPrice" type="text" class="form-control" id="exampleInputName7" placeholder="如：1000元">
                        </div>
                    </form>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="margin-top: 20px;" ng-click="addMyCabinet()"  class="btn btn-success pull-right successBtn" type="submit" >&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                </div>
            </div>
        </div>
    </div>


    <!--    模态3   -->
    <div style="margin-top: 20px;" class="modal fade" id="myModals4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ng-click="closeUser()">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">绑定会员</h5>
                    <form>
                        <div style="margin-top: 20px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName4">衣柜信息</label>
                            <p style="font-size: 14px;">{{typeName}}&nbsp&nbsp&nbsp&nbsp编号：{{cabinetNumber}}</p>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName3">会员姓名</label>
                            <input ng-model="userName"   type="text" class="form-control" id="exampleInputName3" ng-change="searchs()" ng-input="searchsBlur()"  placeholder="">
                        </div>
                        <ul id="searchsBox" style="display: none;padding-left: 0;">
                            <li ng-repeat="x in searchsData" ng-click="sectleClick(x.memberDetails.name)" id="searchLi">{{x.memberDetails.name}}</li>
                        </ul>

                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">联系方式</label>
                            <input ng-model="theMobile" type="text" class="form-control" id="exampleInputName5" placeholder="">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName6">会员卡号</label>
                            <input ng-model="cardNum"  type="text" class="form-control" id="exampleInputName6" placeholder="">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName7">经办人</label>
                            <input ng-model="adminOperator" type="text" class="form-control" id="exampleInputName7" placeholder="">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName7">办理日期</label>
<!--                            <input ng-model="date"  type="text" class="form-control" id="exampleInputName7" placeholder="">-->
                            <div class="input date dateBox" id="dateIndex"  data-date-format="yyyy-mm-dd">
                                <input class="span2 form-control" size="16" type="text" value="" id="dateSpan" ng-model="date"/>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </form>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="margin-top: 20px;" ng-click="TheBindUser()"   type="submit" class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                </div>
            </div>
        </div>
    </div>



<!-- 模态4 -->
    <div style="margin-top: 20px;" class="modal fade" id="myModals5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="padding-left: 150px;" class="modal-dialog">
            <div style="padding-bottom: 20px;width: 300px;" class="modal-content clearfix">
                <div style="padding-left: 50px;padding-right:50px;border: none;width: 300px;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">会员调柜</h5>
                    <form>
                        <input type="hidden" value="{{originalCabinetId}}" id="originalCabinetId">
                        <div style="margin-top: 20px;font-size: 14px;" class="form-group">
                            <img style="width: 100px;" class="center-block img-circle" src="/plugins/user/images/dong.jpg">
                            <p style="margin-top: 20px;">会员姓名：{{memName}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>联系方式：{{tel}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>当前柜子：{{theTypeName}}{{num}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>柜子起止时间：<br/>{{start*1000  | date:'yyyy-MM-dd'}}—{{end*1000  | date:'yyyy-MM-dd'}}</p>
                        </div>
                        <input  id="_csrf" type="hidden"
                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">调柜类型</label>
                            <select class="form-control" style="font-size: 14px;color: #888;padding-top: 4px;" ng-model="cabinetTypeId" ng-change="findCabinet(cabinetTypeId)">
                                <option value ="{{type.id}}"  ng-repeat="type in typeS">{{type.type_name}}</option>
                            </select>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">调柜编号</label>
                            <select class="form-control" style="font-size: 14px;color: #888;padding-top: 4px;"  ng-model="cabinetId">
                                <option value ="" >请选择</option>
                                <option value ="{{number.id}}"  ng-repeat="number in numberS">{{number.cabinet_number}}</option>
                            </select>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <p style="font-size: 14px;font-weight: bold;">需再支付: <strong>40元</strong></p>
                        </div>
                    </form>
                    <button style="" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="" type="submit" class="btn btn-success pull-right successBtn"   ng-click="changeCabinet()">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                </div>
            </div>
        </div>
    </div>


<!-- 模态5-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="padding-left: 150px;" class="modal-dialog">
            <div style="padding-bottom: 20px;width: 300px;" class="modal-content clearfix">
                <div style="padding-left: 50px;padding-right:50px;border: none;width: 300px;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ng-click="closeCabint()">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">会员退租</h5>
                    <form>
                        <div style="margin-top: 20px;font-size: 14px;" class="form-group">
                            <img style="width: 100px;" class="center-block img-circle" src="/plugins/user/images/dong.jpg">
                            <p style="margin-top: 20px;">会员姓名：{{memName}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>联系方式：{{tel}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>当前柜子：{{theTypeName}}{{num}}</p>
                        </div>
                        <div style="font-size: 14px;" class="form-group">
                            <p>柜子起止时间：<br/>{{start*1000  | date:'yyyy-MM-dd'}}—{{end*1000  | date:'yyyy-MM-dd'}}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">退租日期</label>
                            <input type="text" class="form-control" id="exampleInputName" ng-model="quiteDate" placeholder="请输入退租日期如2016-1-1">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
<!--                            不超期退租-->
                            <p style="font-size: 14px;font-weight: bold;">需退金额: <strong>40元</strong></p>
<!--                            逾期退租-->
<!--                            <p style="font-size: 14px;font-weight: bold;">需再支付: <strong>40元</strong></p>-->
                        </div>
                    </form>
                    <button style="" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="" type="submit" ng-click="quiteCabinet()"   class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                </div>
            </div>
        </div>
    </div>

<!--    模态6-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="padding-left: 150px;" class="modal-dialog">
            <div style="padding-bottom: 20px;width: 300px;" class="modal-content clearfix">
                <div style="padding-left: 50px;padding-right:50px;border: none;width: 300px;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">新增衣柜类型</h5>
                    <form>
                        <div class="form-group">
                            <label for="exampleInputName">柜子名称</label>
                            <input type="text" class="form-control" id="exampleInputName" ng-model="cabinetTypeName"   placeholder="">
                            <span class="text-danger help-block m-b-none">
                                         <i class="fa fa-info-circle"></i>
                                        请输入柜子名称 如：男大柜
                            </span>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">选择性别</label>
                            <select class="form-control" style="font-size: 14px;color: #888;padding-top: 4px;" ng-model="theSex">
                                <option value ="请选择">请选择</option>
                                <option value ="1">男</option>
                                <option value ="2">女</option>
                                <option value="3">不限</option>
                            </select>
                        </div>
                    </form>
                    <button style="" type="submit" class="btn btn-primary backBtn">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp</button>
                    <button style="" type="submit" ng-click="submitCabinetType()"   id="addCabinetType"   class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp</button>
                </div>
            </div>
        </div>
    </div>
    </div>

