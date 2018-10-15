<?php
use backend\assets\CompanyAsset;
CompanyAsset::register($this);
$this->title = '场地管理';
?>
<div ng-controller = 'companyCtrl' ng-cloak style="min-width: 620px;">
    <header>
        <div class="wrapper wrapper-content  animated fadeIn"  ng-cloak>
            <div class="row">
                <div class="col-sm-12 pdLR0">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <span style="display: inline-block"><b>组织架构管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pd0 " >
                                <div class="col-sm-6 col-xs-8 col-sm-offset-2">
                                    <div class="input-group">
                                        <input type="text"  ng-model="topSearch"  class="form-control" placeholder="  请输入公司名称进行搜索..."
                                               style="height: 34px;line-height: 7px;" ng-keydown="enterSearch()">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="search()" class="btn btn-primary">搜索</button>
                                                </span>
                                    </div>
                                </div>
                                <div class="col-sm-offset-1 col-xs-4 col-sm-2 text-left">
                                    <li class="nav_add" style="padding-top: 0;">
                                        <div class="dropdown " style="border: none;left: 0;cursor:pointer " >
                                            <?php if(\backend\models\AuthRole::canRoleByAuth('organization','ADD')){ ?>
                                                <div style="border: none;background-color: transparent !important;padding-bottom: 5px:  " class=" dropdown-toggle f14 " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <span class="btn btn-success btn header2" style="font-size: 15px;color: green;">选择添加项目</span>
                                                </div>
                                            <?php } ?>
                                            <ul  class="dropdown-menu f16 " aria-labelledby="dropdownMenu1" style="margin-top: 10px;border: none !important;box-shadow: 0 0 2px #5e5e5e;font-size: 13px;">
                                                <li><a href="/main/add-brand" >公司品称添加</a></li>
                                                <li><a href="/main/add-venue" >场馆添加</a></li>
                                                <li><a href="/main/add-site" >场地添加</a></li>
                                                <li><a href="/main/add-department" >部门添加</a></li>
    <!--                                            <li><a href="/main/add-facility?mid=21&c=20" >设备添加</a></li>-->
                                            </ul>
                                        </div>
                                    </li>
                                </div>
                            </div>
<!--                            <div class="col-sm-12" style="margin: 15px 0;"><h4>条件筛选</h4></div>-->
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix" >
                                <div class=" fl" style="display: flex;justify-content: space-between">
<!--                                    <span class="" style="position: relative;margin-top: 5px;width: 100px;   ">选择公司:</span>-->
<!--                                    <select ng-if="companyStauts == true" class="form-control " style="padding: 4px 12px;" ng-model="$parent.companyId">-->
<!--                                        <option id=""  value="" selected>所有公司</option>-->
<!--                                        <option ng-repeat ="company in companys" value="{{company.id}}">{{company.name}}</option>-->
<!--                                    </select>-->
<!--                                    <label for="id_label_single" >-->
<!--                                        <select ng-model="$parent.companyId" class="js-example-basic-single1 js-states form-control"  style="width: 110px;padding-bottom: 3px;" ng-model="venue_id" id="id_label_single">-->
<!--                                            <option id=""  value="" selected>所有公司</option>-->
<!--                                            <option ng-repeat ="company in companys" value="{{company.id}}">{{company.name}}</option>-->
<!--                                        </select>-->
<!--                                    </label>-->
<!--                                    <select ng-if="companyStauts == false" class="form-control " style="padding: 4px 12px;" >-->
<!--                                        <option id=""  value="" selected>所有公司</option>-->
<!--                                        <option value="" disabled style="color:red">{{companys}}</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                                <!-- 日历范围时间插件-->
<!--                                <div style="float: left;position: relative;margin-left: 20px;" class="input-daterange input-group fl cp" id="container">-->
<!--                                    <div style="float: left;position: relative;margin-left: 1px;margin-top: 1px" class="input-daterange input-group cp" id="container">-->
<!--                                 <span class="add-on input-group-addon">-->
<!--                                选择时间 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>-->
<!--                                     </span>-->
<!--                                        <input type="text" readonly style="width: 200px;background-color: #fff" name="reservation" id="reservation" class="form-control" value="" / placeholder="请输入搜索时间"  >-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <button ng-click="search()"   class="btn btn-success btn-sm" tape="submit" style="margin-left: 20px;">确定</button>-->
<!--                                <button class="btn btn-info btn-sm"  tape="submit" ng-click="searchClear()"  style="margin-left: 20px;">清除</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                <div class="tabBox clearfix" style="border: solid 1px #e5e5e5;min-width: 620px;">
                    <div class="list_tab fl " style="">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/index"><span class="yG" >场馆</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;z-index: 10;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/site"><span >场地</span></a>
                    </div>
<!--                    <div class="list_tab fl" style="margin-left: -50px;">-->
<!--                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/facility?mid=21&c=20"><span >设备</span></a>-->
<!--                    </div>-->
                    <div class="list_tab fl" style="margin-left: -50px;z-index: 9999;">
                        <img src="/plugins/main/imgs/u113.png" alt=""/><a href="/main/company"><span>公司</span></a>
                    </div>
                    <div class="list_tab fl" style="margin-left: -50px;">
                        <img src="/plugins/main/imgs/u109.png" alt="" /><a href="/main/department"><span >部门</span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>公司信息列表</h5>
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
                                    ng-click="changeSort('companyId',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="fa fa-list-ol" aria-hidden="true"></span>&nbsp;序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    ng-click="changeSort('companyName',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" style="width: 480px;"><span class="fa fa-group" aria-hidden="true"></span>&nbsp;公司名称
                                    </th>

    <!--                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
    <!--                                    colspan="1" aria-label="平台：激活排序列升序" style="width: 180px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;场地-->
    <!--                                </th>-->
    <!--                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
    <!--                                    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 180px;"><span class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;场地名称-->
    <!--                                </th>-->
    <!--                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
    <!--                                    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon  glyphicon-user" aria-hidden="true"></span>&nbsp;容纳人数-->
    <!--                                </th>-->
                                    <!--                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
                                    <!--                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 142px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;修改时间-->
                                    <!--                                    </th>-->
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="CSS等级：激活排序列升序" style="width: 500px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA odd" ng-repeat="(key,item) in items">
                                    <td>{{4*(nowPage-1)+key+1}}</td>
                                    <td>{{item.name}}</td>
                                    <td class="tdBtn">
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('organization','UPDATE')){ ?>
                                            <a href="" data-toggle="modal" data-target="#editSite" style="margin-top: 5px;color:#fff">
                                            <span class="btn btn-success btn-sm" type="submit" ng-click="update(item.id,item.name)">修改</span></a>
                                            &nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('organization','DELETE')){ ?>
                                            <button class="btn btn-danger btn-sm" ng-click="del(item.id,item.name)"   type="submit">删除</button>
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
        </div>
    </header>

    <!--场地修改页面-->
    <div class="modal fade" id="editSite" tabindex="-1" role="dialsog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 520px;">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center" id="myModalLabel" style="color: rgb(35,173,68)">
                        修改公司名称
                    </h3>
                </div>
                <div class="modal-body" style="display: ">
                    <div style="display: flex;justify-content: center;">
                        <div class="form-group " style="color: rgb(153,153,153);width: 300px;"><strong style="color:red">*</strong>公司名称</div>
                    </div>
                    <div class="form-group text-center">
                        <center>
                            <input type="text" class="form-control actions" ng-model="companyName"   id="" >
                            <input type="hidden" id="companyId">
                            <input  id="_csrf" type="hidden"
                                    name="<?= \Yii::$app->request->csrfParam; ?>"
                                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        </center>
                    </div>
                </div>
                <div class="modal-footer" >
                    <center><button   ng-click="companyUpdate()" type="button" class="btn btn-success "   style="width: 100px;">提交</button></center>
                </div>
            </div>
        </div>
    </div>
</div>


