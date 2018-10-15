<?php
use backend\assets\ServerIndexCtrlAsset;
ServerIndexCtrlAsset::register($this);
$this->title = '中心管理 - 服务管理';
?>

<div class="wrapper wrapper-content  animated fadeIn" ng-controller = 'packageCtrl' ng-cloak>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <span style="display: inline-block"><b class="spanBig">中心管理</b></span>  >  <span style="display: inline-block"><b class="spanSmall">服务管理</b></span>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6 mL200" >
                        <div class="input-group">
                            <input type="text" class="form-control h34" ng-keydown="enterSearch()" placeholder="请输入卡名进行搜索..."
                                   >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" ng-click="search()">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-1 text-right" >
                        <li class="new_add cp pT0" >
                            <span class="glyphicon glyphicon-plus f14 bgColorGreen"  data-toggle="modal" data-target="#addCourseModal">新增课程套餐</span>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" >
            <div class="tabBox clearfix borderE5"  >
                <div class="list_tab fl zIndex" >
                    <img ng-src="/plugins/servePlan/imgs/u4.png" alt="" /><a href="/serve-plan/index?c=9"><span class="yG" >套餐管理</span></a>
                </div>
                <div class="list_tab fl">
                    <img ng-src="/plugins/servePlan/imgs/u2.png" alt="" /><a href="/serve-plan/serve?c=9"><span >服务管理</span></a>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>服务套餐信息管理</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content" style="padding: 0;">
                    <div style="margin-bottom: -32px;display: none;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <div class="row"></div>
                    </div>


                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-user" aria-hidden="true"></span>&nbsp;名称
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="width: 282px;"><span class="fa fa-server" aria-hidden="true"></span>&nbsp;服务项目
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="平台：激活排序列升序" style="width: 140px;"><span class="fa fa-university " aria-hidden="true"></span>&nbsp;次数限制
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;时间限制
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in items" class="cp">
                                <td>{{item.name}}</td>
                                <td>{{item.serveItem}}</td>
                                <td>{{item.count}}</td>
                                <td>{{item.timeImpose}}</td>
                                <td class="tdBtn">
                                    <div id="myEdit" type="button" class="btn btn-success btn-sm"style="color: #FFFFFF;margin-right: 3px;" data-toggle="modal" data-target="#myModals" >
                                        <!-- 修改-->
                                        <a href="#" style="color: #FFFFFF;">修改</a>
                                    </div>
                                    <div   class="btn btn-danger btn-sm delete">删除</div>
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
</div>
<!--模态框-->
<div class="modal fade " id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" >
        <div class="modal-content clearfix">
            <button style="margin: 5px 5px 0 0;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <section class="yy_search">
                <div class="searchBox">
                    <form action="" style="margin:20px 50px;">
                        <div>
                            <h2 class="mB10 pT10" style="text-align: center">添加课程套餐</h2>
                        </div>
                        <p>套餐名称</p>
                        <input class="form-control" type="text" placeholder="套餐名称" />

                        <div class="courseLists">
                            <div class="courseList">
                                <h4 class="f20 ">课程次数限制</h4>
                                <div class=" lRight">
                                    <p class="f14">动感单车次数限制</p>
                                    <div class="checkbox i-checks" style="width: 200px;">
                                        <label>
                                            <input type="checkbox" value=""> <i></i>不限</label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" placeholder="日几次 / 周几次 / 月几次 /寄几次 / 年几次" />
                                <div class=" lRight" style="margin-bottom: 0;">
                                    <p class="f14">动感单车课程总节数</p>
                                    <div class="checkbox i-checks" style="width: 200px;">
                                        <label>
                                            <input type="checkbox" value=""> <i></i>不限</label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" placeholder="共几节课" />
                            </div>
                        </div>
                        <h4 class="f20 mB10">其它课程</h4>
                        <div class="borderTopLine"></div>
                        <div style="margin-top: 20px;height: 120px" >
                            <button id="addBtn" type="button" class="btn btn-success btn-lg">添加课程</button>
                            <div id="addSelect" class="clearfix dis_none" style="margin-top: 10px; ">
                                <select id="addCourse" class="form-control fl " style="width: 60%;margin: 0;">
                                    <option>瑜伽</option>
                                    <option>单车</option>
                                    <option>大操</option>
                                    <option>篮球</option>
                                </select>
                                <button  id="courseConfirm" type="button" class="btn btn-success btn-lg fr ">确定</button>
                                &nbsp;
                                <button style="margin-right: 10px"  id="courseCancel" type="button" class="btn btn-warning btn-lg fr ">取消</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- 返回、完成按钮-->
                <div id="lastBox">
                    <div class="fixedBox ">
                        <div  data-dismiss="modal" aria-label="Close" class="  btn btn-primary cp" style="width: 100px;">返回</div>
                        <a href="/serve-plan/index?mid=8&c=9"> <button type="button" class="btn btn-success" style="width: 100px">完成</button></a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

