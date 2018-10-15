
<?php
use backend\assets\AuthCtrlAsset;

AuthCtrlAsset::register($this);
$this->title = '权限管理';
?>

<header>
    <div class="wrapper wrapper-content  animated fadeIn" ng-controller = 'authorityCtrl' ng-cloak>
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b>系统管理</b></span>  >  <span style="display: inline-block"><b>权限管理</b></span>
                    </div>
                    <div class="panel-body">

                        <div class="col-sm-6" style="margin-left: 200px">
                            <div class="input-group">
                                <input type="text" class="form-control" ng-keydown="enterSearch()" placeholder="  请输入公司名称，店面，部门或姓名进行搜索..."
                                       style="height: 34px;line-height: 7px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                                        </span>
                            </div>
                        </div>

                        <div class="col-sm-2 text-right">
                            <li class="nav_add">
                                <ul>
                                    <li class="new_add" id="tmk">
                                        <a href="" class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal" style="font-size: 14px;color: green;top:12px">添加角色</a>
                                    </li>
                                </ul>
                            </li>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限管理列表</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content" style="padding: 0;">

                        <div id="DataTables_Table_0_wrapper"  class="dataTables_wrapper form-inline" role="grid" style="padding: 0px">
                            <div class="row">
                                <div class="col-sm-6" style="display: none;"><div id="DataTables_Table_0_filter"  class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-th" aria-hidden="true"></span>&nbsp;ID
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="平台：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;说明
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;创建时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;创建人
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 282px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="item in items">
                                    <td><span class="center-block" style="display: block;width: 54px;text-align: left;">{{item.ID}}</span></td>
                                    <td><span class="center-block" style="display: block;width: 54px;text-align: left;">{{item.name}}</span></td>
                                    <td><span class="center-block" style="display: block;width: 100px;text-align: left;">{{item.authority}}&nbsp;<small class="label label-primary">{{item.type}}</small></span></td>
                                    <td><span class="center-block" style="display: block;width: 60px;text-align: left;">{{item.create_at}}</span></td>
                                    <td><span class="center-block" style="display: block;width: 54px;text-align: left;">{{item.user}}</span></td>
                                    <td class="tdBtn">
                                        <a href="/authority/set?&c=40"><span class="btn btn-warning btn-sm" type="submit">权限分配</span></a>&nbsp;&nbsp;
                                        <span class="btn btn-success btn-sm" type="submit">
                                             <a href="" data-toggle="modal" data-target="#myModals" style="color: #fff">
                                                修改</a>
                                        </span>&nbsp;&nbsp;
                                        <button class="btn btn-info btn-sm" type="submit">
                                            <a href="/authority/assigning-users?&c=40" style="color: #fff">分配用户</a></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" style="padding-left: 30px;" id="DataTables_Table_0_info" role="alert"
                                         aria-live="polite" aria-relevant="all">显示 1 到 10 项，共 57 项
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
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
            </li>
            </ul>
        </div>
</header>

<!--新增页面-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                    添加角色
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group" style="color: rgb(153,153,153)"><span style="color: red">*</span>姓名</div>
                <div class="form-group text-center">
                    <input type="text" class="form-control actions" id="" placeholder="请输入姓名">
                </div>

                <div class="form-group" style="color: rgb(153,153,153)"><span style="color: red">*</span>说明</div>
                <div class="form-group">
                <textarea class="form-control actions" style="color: rgb(153,153,153);margin-left: 0px;resize:none;">如：普通员工  一般权限
                </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-success  btn-lg" style="width: 50%;">完成</button></center>
            </div>
        </div>
    </div>
</div>

<!--修改页面-->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                    修改角色
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group" style="color: rgb(153,153,153)">姓名</div>
                <div class="form-group text-center">
                    <input type="text" class="form-control actions" id="" placeholder="小花妹妹">
                </div>

                <div class="form-group" style="color: rgb(153,153,153)">说明</div>
                <div class="form-group">
                <textarea class="form-control actions" style="color: rgb(153,153,153);margin-left: 0px;resize: none;">私人教练 一般权限
                </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-success  btn-lg" style="width: 50%;">完成</button></center>
            </div>
        </div>
    </div>
</div>