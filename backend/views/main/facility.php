<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '设备管理';
?>

<header>
    <div class="wrapper wrapper-content  animated fadeIn" ng-controller = 'mainCtrl' ng-cloak>
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <h2 style="display: inline-block"><b>组织架构管理</b></h2>
                    </div>
                    <div class="panel-body">

                        <div class="col-sm-6" style="margin-left: 200px">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="  请输入名称进行搜索..."
                                       style="height: 34px;line-height: 7px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary">搜索</button>
                                        </span>
                            </div>
                        </div>

                        <div class="col-sm-offset-1 col-sm-2 text-left">
                            <li class="nav_add">
                                <div class="dropdown " style="border: none;left: 0;cursor:pointer " >
                                    <div style="border: none;background-color: transparent !important;padding-bottom: 5px:  " class=" dropdown-toggle f14 " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-plus" style="color: green;">选择添加项目</span>
                                    </div>
                                    <ul  class="dropdown-menu f16 " aria-labelledby="dropdownMenu1" style="border: none !important;box-shadow: 0 0 2px #5e5e5e;font-size: 13px;">
                                        <li><a href="/main/add-brand" >公司品称添加</a></li>
                                        <li><a href="/main/add-venue" >场馆添加</a></li>
                                        <li><a href="/main/add-site" >场地添加</a></li>
<!--                                        <li><a href="/main/add-facility?mid=21&c=20" >设备添加</a></li>-->
                                        <li><a href="/main/add-department" >部门添加</a></li>
                                    </ul>
                                </div>
                            </li>
                        </div>
                        <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                            <!-- 日历范围时间插件-->
                            <div style="float: left;position: relative;margin-left: 20px;" class="input-daterange input-group fl cp" id="container">
                                <div style="float: left;position: relative;margin-left: 1px;margin-top: 1px" class="input-daterange input-group cp" id="container">
                             <span class="add-on input-group-addon">
                            选择时间 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                 </span>
                                    <input type="text" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" / placeholder="请输入搜索时间"  >
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm" tape="submit" style="margin-left: 20px;">确定</button>
                            <button class="btn btn-info btn-sm"  tape="submit" style="margin-left: 20px;">清除</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12" >
                <div class="tabBox clearfix" style="border: solid 1px #e5e5e5;">
                    <div class="list_tab fl " style="">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/index"><span class="yG" >场馆</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/site"><span >场地</span></a>
                    </div>
<!--                    <div class="list_tab fl" style="margin-left: -50px;z-index: 10;">-->
<!--                        <img src="/plugins/main/imgs/u113.png" alt="" /><a href="/main/facility"><span >设备</span></a>-->
<!--                    </div>-->
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/company"><span >公司</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/department"><span >部门</span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>设备信息列表</h5>
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
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbsp;公司名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;使用场馆
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="平台：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;设备型号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;设备名称
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;设备金额
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;设备数量/规格
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="item in items">
                                    <td data-toggle="modal" data-target="#myModals">我爱运动</td>
                                    <td data-toggle="modal" data-target="#myModals">大卫城店</td>
                                    <td data-toggle="modal" data-target="#myModals">0123</td>
                                    <td data-toggle="modal" data-target="#myModals">跑步机</td>
                                    <td data-toggle="modal" data-target="#myModals">5000元</td>
                                    <td data-toggle="modal" data-target="#myModals">30台</td>
                                    <td class="tdBtn">
                                        <span class="btn btn-success btn-sm" type="submit">
                                                <a href="" data-toggle="modal" data-target="#myModal" style="margin-top: 5px;color:#fff">
                                                修改</a>
                                        </span>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="submit">删除</button></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" id="DataTables_Table_0_info" role="alert"
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
<!--新增组织架构-->

<div class="modal fade" id="myModals" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                    设备管理详情
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">资产编号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="请输入资产编号">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">设备型号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="请输入设备型号">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">设备名称</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="跑步机">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">规格</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="台/套">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">数量</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="30台/套">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">制造厂</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="河南郑州建业有限公司">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">出厂日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-6">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">到厂日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-6">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">重量</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="10吨">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">所属锻炼项目</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="健身">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">购置日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-1">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">原值</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="5000元">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">状态</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="正常">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">设备描述</div>
                <div class="form-group text-center">
                    <center><input type="text" class="form-control actions" id="" placeholder="设备描述"></center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">设备照片</div>
                <div class="input-file" style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left: 30px">
                    <p style="width: 100%;height: 100%;line-height: 94px;font-size: 50px;" class="text-center">+</p>
                    <input type="file" style="width: 100%;height: 100%;opacity: 0;position: absolute;top: 0;left: 0;">
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">安装使用公司</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 30px">
                        <option>请选择所属公司</option>
                        <option selected>我爱运动</option>
                        <option>黄金时代</option>
                        <option>千群</option>
                    </select>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">安装使用场馆</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 30px">
                        <option>请选择所属场馆</option>
                        <option selected>大上海</option>
                        <option>大卫城</option>
                        <option>大学路</option>
                    </select>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 30px;">安装使用场地</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 30px">
                        <option>请选择所属场地</option>
                        <option selected>A瑜伽室</option>
                        <option>B瑜伽室</option>
                        <option>C瑜伽室</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-success  btn-lg " data-toggle="modal" data-target="#myModals"  style="width: 50%;">关闭</button></center>
            </div>
        </div>
    </div>
</div>

<!--修改-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                    修改设备管理详情
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">资产编号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="请输入资产编号">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">设备型号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="请输入设备型号">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">设备名称</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="跑步机">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">规格</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="台/套">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">数量</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="30台/套">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">制造厂</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="河南郑州建业有限公司">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">出厂日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-6">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">到厂日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-6">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">重量</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="10吨">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">所属锻炼项目</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="健身">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">购置日期</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="2017-4-1">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">原值</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="5000元">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">状态</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="" placeholder="正常">
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">设备描述</div>
                <div class="form-group text-center">
                    <center><input type="text" class="form-control actions" id="" placeholder="设备描述"></center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">设备照片</div>
                <div class="input-file" style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left: 120px">
                    <p style="width: 100%;height: 100%;line-height: 94px;font-size: 50px;" class="text-center">+</p>
                    <input type="file" style="width: 100%;height: 100%;opacity: 0;position: absolute;top: 0;left: 0;">
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">安装使用公司</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 120px">
                        <option>请选择所属公司</option>
                        <option selected>我爱运动</option>
                        <option>黄金时代</option>
                        <option>千群</option>
                    </select>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">安装使用场馆</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 120px">
                        <option>请选择所属场馆</option>
                        <option selected>大上海</option>
                        <option>大卫城</option>
                        <option>大学路</option>
                    </select>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">安装使用场地</div>
                <div class="form-group text-center">
                    <select class="form-control actions" style="color: rgb(153,153,153);margin-left: 120px">
                        <option>请选择所属场地</option>
                        <option selected>A瑜伽室</option>
                        <option>B瑜伽室</option>
                        <option>C瑜伽室</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-success  btn-lg "   style="width: 50%;">提交</button></center>
            </div>
        </div>
    </div>
</div>
