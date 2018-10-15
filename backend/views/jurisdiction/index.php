<?php
/* @var $this yii\web\View */
use backend\assets\JurisdictionCtrlAsset;
JurisdictionCtrlAsset::register($this);

$this->title = '系统管理 - 权限管理';
?>
<div  ng-controller="jurisdictionCtrl" ng-cloak>
    <main>
        <?=$this->render('@app/views/common/csrf.php')?>
        <div class="wrapper wrapper-content animated fadeIn" >
            <div class="panel panel-default ">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12 pd0 panel panel-default "">
                        <div class="panel-heading">
                                <span style="display: inline-block"><b class="spanBig">系统管理</b></span>  >  <span style="display: inline-block"><b class="spanSmall">权限管理</b></span>
                        </div>
                        <div class="panel-body">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title h56">
                                <label for="id_label_single" >
                                    <select  class="js-example-basic-single js-states form-control w150" ng-change="getRoleList()" ng-model="companyId" id="id_label_single">
                                        <option value="">请选择公司名称</option>
                                        <option value="{{company.id}}" ng-repeat="company in companyData">{{company.name}}</option>
                                    </select>
                                </label>
                                <label for="id_label_single" >
                                    <select  class="js-example-basic-single1 js-states form-control w150" ng-change="getRoleList()" ng-model="status" id="id_label_single">
                                        <option value="">请选择权限状态</option>
                                        <option value="0">不限</option>
                                        <option value="1">已分配</option>
                                        <option value="2">未分配</option>
                                    </select>
                                </label>
                            </div>
                            <div class="ibox-content pd0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pdb0" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable mt38" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>角色
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1"><span class="glyphicon glyphicon-home" aria-hidden="true" ></span>所属公司
                                            </th>
                                            <th class="sorting w222" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1"><span class="fa fa-users" aria-hidden="true"></span>人数
                                            </th>
                                            <th class="sorting w260" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in authItems">
                                            <td>
                                                <span>{{item.name}}</span>
                                                <small class="label label-primary" ng-if="item.auth != null">已分配</small>
                                                <small class="label label-default" ng-if="item.auth == null">未分配</small>
                                            </td>
                                            <td>{{item.organization.name}}</td>
                                            <td ><span>{{item.admin.length}}</span></td>
                                            <td class="tdBtn">
                                                <button class=" btn btn-success btn-sm" ladda="updateAuthLoading" ng-click="allocationBtn(item.id)" >修改权限</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/pagination.php')?>
                                    <?=$this->render('@app/views/common/nodata.php')?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!--查看详情模态框end-->

    </main>
    <!--分配权限模态框-->
    <div class="modal fade bs-example-modal-lg" id="allocationModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-toggle="modal" data-target="#allocationModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title  text-center">分配权限</h4>
                </div>
                <div class="modal-body mrt-10" style="margin-top: -10px;">
                    <!-- 前台管理-->
                    <div class="row bigModuleBox" ng-repeat="module in moduleData">
                        <div class="col-sm-12 moduleTop">
                            <div class="col-sm-4 ft14">{{module.name}}</div>
                            <div class="col-sm-4  col-sm-offset-4 text-right mGTop" >
                                <div>
                                    <switch id="enabled" name="enabled" ng-model="attr" switchauth data-value="{{module.id}}" value="{{module.id}}" class="green"></switch>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0">
                            <ul class="col-sm-12 pdLr0 subModule" ng-repeat="menu in module.module" data-module="{{menu.id}}">
                                <li class="col-sm-4" >{{menu.name}}</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline" ng-repeat="func in menu.moduleFunctional">
                                        <label class="ft13"><input type="checkbox" ng-checked="func.id | inArr:functionIdArr:menu.id" class="checkBoxFunc" value="{{func.id}}"><i>✓</i>{{func.name}}</label><br>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" ladda="assignLoading" ng-click="assignAuth()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--end-->

    <!--    查看详情模态框-->
    <div class="modal fade bs-example-modal-lg" id="checkDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-toggle="modal" data-target="#checkDetailModal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title  text-center">权限查看</h4>
                </div>
                <div class="modal-body mt-10">
                    <!-- 前台管理 -->
                    <div class="row ">
                        <div class="col-sm-12 borderd9">
                            <div class="col-sm-4 ">前台管理</div>
                            <div class="col-sm-4  col-sm-offset-4 text-right mGTop" >
                                <div>
                                    <span  class="glyphicon glyphicon-ok colorGreen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 borderd9d9">
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4" >验卡管理</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <label for="">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">编辑</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4">潜在会员</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">编辑</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--中心管理-->
                    <div class="row pdt10">
                        <div class="col-sm-12 borderd9">
                            <div class="col-sm-4 ">中心管理</div>
                            <div class="col-sm-4  col-sm-offset-4 text-right mGTop" >
                                <div>
                                    <span  class="glyphicon glyphicon-ok colorGreen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 borderd9d9d9">
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4" >中心管理</li>
                                <li class="col-sm-8 text-right pdr10">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <label for="centreBoxSee">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxAdd">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxAlter">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxEdit">编辑</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4">中心管理</li>
                                <li class="col-sm-8 text-right mrr0">
                                    <div class="checkbox checkbox-inline">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxSee1">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxAdd1">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxAlter1">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="centreBoxEdit1">编辑</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--会员管理-->
                    <div class="row pdt10">
                        <div class="col-sm-12 borderd9">
                            <div class="col-sm-4 ">会员管理</div>
                            <div class="col-sm-4  col-sm-offset-4 text-right mGTop" >
                                <div>
                                    <span  class="glyphicon glyphicon-ok colorGreen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 borderd9d9">
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4" >会员管理</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <label for="memberBoxSee">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="memberBoxAdd">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="memberBoxAlter">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="memberBoxEdit">编辑</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4">约课管理</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="aboutBoxSee1">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="aboutBoxAdd1">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="aboutBoxAlter1">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="aboutBoxEdit1">编辑</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--系统管理-->
                    <div class="row pdt10">
                        <div class="col-sm-12 borderd9">
                            <div class="col-sm-4 ">系统管理</div>
                            <div class="col-sm-4  col-sm-offset-4 text-right mGTop" >
                                <div>
                                    <span  class="glyphicon glyphicon-ok colorGreen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 borderd9d9">
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4" >系统管理</li>
                                <li class="col-sm-8 text-right pdr0">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <label for="">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">编辑</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="col-sm-12 pdLr0 mttb10">
                                <li class="col-sm-4">系统管理</li>
                                <li class="col-sm-8 text-right pdr10">
                                    <div class="checkbox checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">查看</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">新增</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">修改</label>
                                    </div>
                                    <div class="checkbox  checkbox-inline mrr0">
                                        <span class="glyphicon glyphicon-ok colorGreenF14"></span>
                                        <label for="">编辑</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary">完成</button>
                </div>
            </div>
        </div>
    </div>
</div>
