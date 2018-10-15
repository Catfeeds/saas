<?php
use backend\assets\PrivateTeachCtrlAsset;
PrivateTeachCtrlAsset::register($this);
$this->title = '私教课程管理';
?>
<main class="animated fadeIn" ng-controller="indexController" ng-cloak>
    <header>
        <div class="wrapper wrapper-content  animated fadeIn">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-default ">
                        <div class="panel-heading"> <h2><b>课程管理</b></h2></div>
                        <div class="panel-body">

                            <div class="col-sm-6" style="margin-left: 200px">
                                <div class="input-group">
                                    <input type="text" class="form-control"  ng-model="keywords" placeholder="请输入产品名称进行搜索..."
                                           style="height: 34px;line-height: 7px;" ng-keyup="enterSearch($event)">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" ladda="searchCarding" ng-click="searchCard()">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-3 text-right">
                                <li class="nav_add">
                                    <ul >
                                        <li class="new_add" id="tmk" >
                                            <a href="/private-teach/add?&c=2" class="glyphicon glyphicon-plus"  style="font-size: 14px;margin-top: 5px;color: rgb(39,194,76);">添加私教服务</a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
<!--                                            <a href="/private-teach/appointment?mid=4&c=2" class="glyphicon glyphicon-cog"  style="font-size: 14px;margin-top: 5px;color: grey;">预约设置</a>-->
                                            <a href="/private-teach/add-serve?&c=2" class="glyphicon glyphicon-plus"  style="font-size: 14px;margin-top: 5px;color: rgb(35,183,229);">添加私教课程</a>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <div class="col-sm-12" style="margin: 15px 0 0;"><h4>条件筛选</h4></div>
                            <div class="col-sm-12">
                                <div id="search" style="padding-left: 0;">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li role="presentation" class="dropdown">
                                            <select ng-if="VenueStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.venueId">-->
                                              <option id=""  value=""  selected>所有场馆</option>
                                              <option ng-repeat ="venue in venues" value="{{venue.id}}">{{venue.name}}</option>
                                            </select>
                                            <select ng-if="VenueStauts == false" class="form-control " style="padding: 4px 12px;" >
                                              <option id=""  value=""  selected>所有场馆</option>
                                              <option value="" disabled style="color:red">{{venues}}</option>
                                            </select>
                                        </li>
                                        <li style="margin-left: 0;">
                                            <div style="float: left;position: relative;margin-left: 182px;margin-top: -39px" class="input-daterange input-group cp" id="container">
                                            <span class="add-on input-group-addon">
                                                选择时间:<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </span>
                                                <input type="text" ng-model="dateTime" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control text-center" value="" placeholder="选择时间"/>
                                            </div>
                                        </li>
                                        <li style="margin-left: 20px;position: relative;top: -10px;">
                                            <button class="btn btn-success btn-sm" style="margin-top: -68px;height: 30px;margin-left: 465px" ladda="searchCarding" ng-click="searchCard()">确定</button>
                                            <button class="btn btn-info btn-sm" style="margin-top: -68px;height: 30px;margin-left: 35px" ladda="searchCarding" ng-click="searchClear()">清空</button>
                                        </li>
                                    </ul>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="padding: 0px">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height: 41px">
                            <h5>私教课程管理</h5>
                        </div>
                        <div class="ibox-content" style="padding: 0;">

                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row" style="display: none;;">
                                    <div class="col-sm-6"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 150px;" ng-click="changeSort('name',sort)"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;产品名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 150px;" ng-click="changeSort('valid_time',sort)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;产品有效期
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="平台：激活排序列升序" style="width: 150px;" ng-click="changeSort('total_amount',sort)"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;总售价
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 150px;" ng-click="changeSort('total_sale_num',sort)"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>&nbsp;售卖总数量
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 160px;" ng-click="changeSort('sale_start_time',sort)"><i class="fa fa-calendar-check-o"></i></span>&nbsp;售卖日期
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 150px;" ng-click="changeSort('status',sort)"><i class="fa fa-calendar-check-o"></i></span>&nbsp;状态
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  style="width: 200px;">编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    <tr class="gradeA odd" ng-repeat = '(index,data) in datas' ng-mouseenter="elementTd()">
                                        <td>{{data.name | noData:''}}</td>
                                        <td>{{data.valid_time | noData:''}}天</td>
                                        <td ng-if="data.total_amount != NULL">￥{{data.total_amount}}.00</td>
                                        <td ng-if="data.total_amount == NULL">暂无数据</td>
                                        <td ng-if="data.total_sale_num != -1">{{data.total_sale_num | noData:''}}</td>
                                        <td ng-if="data.total_sale_num == -1">不限</td>
                                        <td>{{data.sale_start_time *1000 | noData:''| date:'yyyy-MM-dd'}} - {{data.sale_end_time *1000 | noData:''| date:'yyyy-MM-dd'}}</td>
                                        <td>
                                            <span class="label label-danger" ng-if="data.status == 2">冻结</span>
                                            <span class="label label-warning" ng-if="data.status == 3">过期</span>
                                            <span class="label label-success" ng-if="data.status == 1">正常</span>
                                        </td>
                                        <td>
                                            <div class="displayBlock ">
                                                <div class="checkbox i-checks">
                                                    <input type="checkbox" value="" style="width: 15px;height: 15px;position: relative;top: 3px;" ng-checked="data.status == 3" ng-click="editStatus(data.id,index,'time')">
                                                    <span style="font-size: 13px;">过期</span>
                                                </div>
                                                <div class="checkbox i-checks">
                                                    <input type="checkbox" value="" style="width: 15px;height: 15px;position: relative;top: 3px;" ng-checked="data.status == 2" ng-click="editStatus(data.id,index,'ban')" >
                                                    <span style="font-size: 13px;">冻结</span>
                                                </div>
<!--                                                <button class="btn btn-success btn-sm" type="submit"><a style="color: #fff" href="#">修改</a></button>-->
                                                <button class="btn btn-danger btn-sm ladda-button"  type="submit" ng-click="delClass(data.id)">删除</button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php');?>
                                <?=$this->render('@app/views/common/pagination.php');?>
                            </div>
                        </div>
                    </div>
                </div>
                </li>
                </ul>
            </div>
    </header>
</main>
