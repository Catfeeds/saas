<?php
use backend\assets\ApprovalManagementAsset;
ApprovalManagementAsset::register($this);
$this->title = '设置审批流程';
?>
<main class="bgWhite" ng-controller="setApprovalCtrl" ng-cloak>
    <?=$this->render('@app/views/common/csrf.php')?>
    <section style="padding: 20px; ">
        <header class="setHeader mT10">
            <div >
                <span ng-click="setBackPre()"  class="glyphicon glyphicon-menu-left backCss color999 f20 cp"></span>
            </div>
        </header>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-8 col-sm-offset-2" style="min-width: 720px;">
                    <div class="col-sm-12 mT20">
                        <h3>1.设置类型</h3>
                        <div class="col-sm-12  mT20">
                            <div class="col-sm-12 heightCenter">
                                <div class="col-sm-2 pdLr0" style="min-width: 100px;">
                                    <span class="red">*</span>
                                    审批类型
                                </div>
                                <div class="col-sm-6 pdLr0">
                                    <select class="form-control selectPd" style="width: 200px;" ng-model="appType" ng-change="selectAppType(appType)">
                                        <option value="">请选择审批类型</option>
                                        <option value="新增会员卡">新增会员卡</option>
                                        <option value="移动端会员卡折扣价">移动端会员卡折扣价</option>
<!--                                        <option value="{{item.id}}" ng-repeat="item in itemTypes">{{item.type | cut:true:6:'...'}}</option>-->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mT20">
                        <h3>2.审批流程</h3>
                        <div class="col-sm-12 mT20 " >
                            <div class="col-sm-12 " style="border-bottom: solid 1px #E5E5E5; padding-bottom: 10px;">
                                <div class="col-sm-2 heightCenter" style="min-width: 100px;height: 60px;"><span class="red">*</span>审批人</div>
                                <div class="col-sm-10 pdLr0">
                                    <ul class="col-sm-12 pdLr0">
                                        <li class="col-sm-4 pdLr0 mrt20 text-center cp approvalaBox"
                                            ng-repeat="(key,arr) in addApprovalNameArr">
                                            <div class="col-sm-10 pdLr0 heightCenter contentCenter roleBox" style="background-color: #F5f5f5;border-radius: 6px;height: 60px;">
                                                <section class="">
                                                    <div  class=""><h4 title="{{arr.roleName}}" class="">角色:{{arr.roleName |cut:true:5:'...'}}</h4></div>
                                                    <div  class="">姓名:{{arr.name}}</div>
                                                    <span class="removeCss glyphicon glyphicon-remove removeBtn"
                                                          ng-click="removeApprovalOrCC(arr.id)"></span>
                                                </section>
                                            </div>
                                            <div class="col-sm-2 pdLr0 text-center" style="height: 60px; line-height: 60px;">
                                                <span class="glyphicon glyphicon-menu-right f20"></span>
                                            </div>
                                        </li>
                                        <li class="col-sm-4 pdLr0 mrt20 text-center cp addApprovalaBox" >
                                            <div ng-click="addApprovalPeopleBtn()" class="col-sm-10 pdLr0  heightCenter contentCenter" style="background-color: #F5f5f5;border-radius: 6px;height: 60px;">
                                                点击添加角色
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12 mT10">
                                <div class="col-sm-2 heightCenter" style="min-width: 100px;height: 60px;">抄送人</div>
                                <div class="col-sm-10 pdLr0">
                                    <ul class="col-sm-12 pdLr0">
                                        <li class="col-sm-4 pdLr0 mrt20 text-center cp copyBox" ng-repeat="(key,copy) in addCopyNameArr">
                                            <div class="col-sm-10 pdLr0  roleBox heightCenter contentCenter" style="background-color: #F5f5f5;border-radius: 6px;height: 60px;">
                                                <section>
                                                    <div  class=""><h4 class="">角色:{{copy.roleName}}</h4></div>
                                                    <div  class="">姓名:{{copy.name}}</div>
                                                    <span class="removeCss glyphicon glyphicon-remove removeBtn"
                                                          ng-click="removeApprovalOrCC(copy.id)"></span>
                                                </section>
                                            </div>
                                            <div class="col-sm-2 pdLr0 text-center" style="height: 60px; line-height: 60px;">
                                                <span class="glyphicon glyphicon-menu-right f20"></span>
                                            </div>
                                        </li>
                                        <li class="col-sm-4 mrt20 pdLr0 text-center cp addCopyBox" >
                                            <div  ng-click="addCCPeopleBtn()" class="col-sm-10 pdLr0  heightCenter contentCenter" style="background-color: #F5f5f5;border-radius: 6px;height: 60px;">
                                                点击添加角色
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="col-sm-8 col-sm-offset-2" style="min-width: 720px;padding-top: 60px;">
                    <div class="text-right">
                        <button type="button" ng-click="setBackPre()" class="btn btn-success w100">返回</button>
<!--                        <button type="button"-->
<!--                                class="btn btn-sm w100 btn-success"-->
<!--                                ladda="completeSetButtonFlag"-->
<!--                                ng-click="completeSetButton()">确定</button>-->
                    </div>
                </footer>
            </div>
        </div>
    </section>
    <!--添加审批人模态框-->
    <div id="addApprovalPeopleModal" class="modal fade"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">添加{{addApprovalName}}角色</h4>
                </div>
                <div class="modal-body">
                    <section class="row">
                        <div class="col-sm-10 col-sm-offset-1 heightCenter">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>选择公司
                            </div>
                            <div class="col-sm-6">
                                <select  id="addCompanySelect"
                                         class="selectPd form-control"
                                         ng-change="companyChange(companyValue)"
                                         ng-model="companyValue">
                                    <option value="">请选择公司</option>
                                    <option ng-repeat="company in companyItem"
                                            title="{{company.name}}"
                                            value="{{company.id}}">{{company.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-10 mT20 col-sm-offset-1 heightCenter">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>选择场馆
                            </div>
                            <div class="col-sm-6">
                                <select id="addVenueSelect"
                                        class="selectPd form-control"
                                        ng-change="venueChange(venueValue)"
                                        ng-model="venueValue">
                                    <option value="">请选择场馆</option>
                                    <option ng-repeat="venue in venueItem"
                                            title="{{venue.name}}"
                                            value="{{venue.id}}">{{venue.name }}</option>
                                </select>
                            </div>
                        </div>
<!--                        <div class="col-sm-10 mT20 col-sm-offset-1 heightCenter">-->
<!--                            <div class="col-sm-4 text-right">-->
<!--                                <span class="red">*</span>选择部门-->
<!--                            </div>-->
<!--                            <div class="col-sm-6">-->
<!--                                <select id="addDepartmentSelect"-->
<!--                                        class="selectPd form-control"-->
<!--                                        ng-change="deparmentChange(deparmentValue)"-->
<!--                                        ng-model="deparmentValue">-->
<!--                                    <option value="">请选择部门</option>-->
<!--                                    <option ng-repeat="dep in deparmentItem"-->
<!--                                            title="{{dep.name}}"-->
<!--                                            value="{{dep.id}}">{{dep.name }}</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-sm-10 mT20 col-sm-offset-1 heightCenter">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>选择角色
                            </div>
                            <div class="col-sm-6">
                                <select id="addRoleSelect"
                                        class="selectPd form-control"
                                        ng-change="roleChange(roleValue)"
                                        ng-model="roleValue">
                                    <option value="">请选择角色</option>
                                    <option ng-repeat="role in roleItem"
                                            title="{{role.name}}"
                                            value="{{role}}">{{role.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-10 mT20 col-sm-offset-1 heightCenter">
                            <div class="col-sm-4 text-right">
                                <span class="red">*</span>选择人员
                            </div>
                            <div class="col-sm-6">
                                <select id="addStaffSelect" class="selectPd form-control"
                                        ng-change="staffChange(staffValue)"
                                        ng-model="staffValue">
                                    <option value="">请选择人员</option>
                                    <option ng-repeat="staff in employeeList" value="{{staff}}">{{staff.name}}</option>
                                </select>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer contentCenter">
                    <button ng-if="addApprovalFlag"
                            ladda="completeAddApprovalFlag"
                            ng-click="completeAddApproval()"
                            type="button"
                            class="btn  btn-success w100">确定</button>
                    <button ng-if="addCCPeopleFlag"
                            ladda="completeAddCCPeopleFlag"
                            ng-click="completeAddCCPeople()"
                            type="button"
                            class="btn  btn-success w100">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</main>