<?php
use backend\assets\EvaluateCtrlAsset;
EvaluateCtrlAsset::register($this);
$this->title = '评价管理';
?>
<div class="wrapper wrapper-content  animated fadeIn" style="background-color: #F5F5F5;" ng-controller = 'evaluateCtrl' ng-cloak>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <span style="display: inline-block"><b>中心管理</b></span>  >  <span style="display: inline-block"><b>评价管理</b></span>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12 col-xs-12">
                        <div class="col-sm-3 col-xs-1"></div>
                        <div class="col-sm-6 col-xs-10" >
                            <div class="input-group">
                                <input type="text" class="form-control" ng-keydown="enterSearch()" placeholder="请输入课程或评价人进行搜索..."
                                       style="height: 34px;line-height: 7px;">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                        <div class="btn-group fl" >
                            <div class="" style="display: flex;align-items: center;margin-right: 10px;margin-bottom: 15px;">
                                <span class=""style="position: relative;width: 100px;">选择场馆:</span>
                                <select class="form-control"style="padding: 4px 12px;">
                                    <option >A场馆</option>
                                    <option >B场馆</option>
                                    <option >C场馆</option>
                                </select>
                            </div>
                        </div>
                        <!-- 日历范围时间插件-->
                        <div style="float: left;position: relative;width:300px;margin-bottom: 15px;margin-right: 10px;" class="input-daterange input-group cp" >
                             <span class="add-on input-group-addon">
                            选择时间: <i class="glyphicon glyphicon-calendar fa fa-calendar" style="margin-top: -4px"></i>
                                 </span>
                            <input type="text" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" placeholder="选择时间"/>
                        </div>
                        <div class="form-group fl pd0 cp clearfix" style="font-size: 13px;">
                            <div class="input-group clockpicker fl" data-autoclose="true" style="float: left;width: 120px;position: relative;">
                                <i style="pointer-events: none;position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-clock-o"></i>
                                <b><input type="text" class="input-sm form-control"  placeholder="起始时间" style="font-size: 13px;cursor: pointer;"></b>
                            </div>
                            <div class="input-group clockpicker fl" data-autoclose="true" style="width: 120px;position: relative;margin-right: 10px;">
                                <i style="pointer-events: none;position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-clock-o"></i>
                                <b><input type="text" class="input-sm form-control" placeholder="结束时间" style="font-size: 13px;cursor: pointer;"></b>
                            </div>
                            <button class="btn btn-success btn-sm fl" tape="submit" style="">确定</button>
                        </div>
                    </div>
<!--                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >-->
<!--                        <div class="btn-group fl" >-->
<!--                            <div class=" fl" style="display: flex;justify-content: space-between">-->
<!--                                <span class=""style="position: relative;margin-top: 5px;width: 100px;">选择场馆:</span>-->
<!--                                <select class="form-control"style="padding: 4px 12px;">-->
<!--                                    <option >A场馆</option>-->
<!--                                    <option >B场馆</option>-->
<!--                                    <option >C场馆</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- 日历范围时间插件-->
<!--                        <div style="float: left;position: relative;margin-left: 212px;margin-top: -30px" class="input-daterange input-group cp" id="container">-->
<!--                             <span class="add-on input-group-addon">-->
<!--                            选择时间: <i class="glyphicon glyphicon-calendar fa fa-calendar" style="margin-top: -4px"></i>-->
<!--                                 </span>-->
<!--                            <input type="text" readonly style="width: 200px;margin-top: -1px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" placeholder="选择时间"/>-->
<!--                        </div>-->
<!--                        <div class="form-group pd0 cp" style="float: left;font-size: 13px;margin-left: 474px;margin-top: -31px">-->
<!--                            <div class="input-group clockpicker" data-autoclose="true" style="margin-left: 61px;float: left;width: 120px;position: relative;">-->
<!--                                <i style="pointer-events: none;position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-clock-o"></i>-->
<!--                                <b><input type="text" class="input-sm form-control"  placeholder="起始时间" style="font-size: 13px;cursor: pointer;"></b>-->
<!--                            </div>-->
<!--                            <div class="input-group clockpicker" data-autoclose="true" style="width: 120px;position: relative;">-->
<!--                                <i style="pointer-events: none;position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-clock-o"></i>-->
<!--                                <b><input type="text" class="input-sm form-control" placeholder="结束时间" style="font-size: 13px;cursor: pointer;"></b>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <button class="btn btn-success btn-sm" tape="submit" style="margin-left: 20px;float: left;margin-top: -31px">确定</button>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
<!--        评价管理信息列表-->
        <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>评价管理信息列表</h5><span style="font-size: 12px;color: #999;font-weight:normal">点击列表查看评价详情</span>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content" style="padding: 0;">
                    <div class="row">
                        <div class="col-sm-6" style="display: none;"><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;日期
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-graduation-cap" aria-hidden="true"></span>&nbsp;课程名称
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="平台：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-sunglasses " aria-hidden="true"></span>&nbsp;教练
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 282px;"><span class="fa fa-text-width" aria-hidden="true"></span>&nbsp;评价得分
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="fa fa-user" aria-hidden="true"></span>&nbsp;评价人
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="fa fa-clock-o" aria-hidden="true"></span>&nbsp;评价时间
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="item in items" class="cp">
                            <td>{{item.evaluateTime}}</td>
                            <td>{{item.course}}</td>
                            <td>{{item.coachName}}</td>
                           <td>{{item.grade}}</td>
                            <td>{{item.valuer}}</td>
                            <td>{{item.date}}</td>

                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="dataTables_paginate paging_simple_numbers"
                                 id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button previous disabled"
                                        aria-controls="DataTables_Table_0" tabindex="0"
                                        id="DataTables_Table_0_previous"><a href="#">上一页</a></li>
                                    <li class="paginate_button active" aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">1</a></li>
                                    <li class="paginate_button " aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">2</a></li>
                                    <li class="paginate_button " aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">3</a></li>
                                    <li class="paginate_button " aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">4</a></li>
                                    <li class="paginate_button " aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">5</a></li>
                                    <li class="paginate_button " aria-controls="DataTables_Table_0"
                                        tabindex="0"><a href="#">6</a></li>
                                    <li class="paginate_button next" aria-controls="DataTables_Table_0"
                                        tabindex="0" id="DataTables_Table_0_next"><a href="#">下一页</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

