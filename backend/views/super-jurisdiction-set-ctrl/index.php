<?php
/* @var $this yii\web\View */
use backend\assets\SuperJurisdictionSetCtrlAsset;
SuperJurisdictionSetCtrlAsset::register($this);
$this->title = '权限管理';
?>
<main ng-controller = 'superJurisdictionCtrl' ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
<!--    <div class="wrapper wrapper-content  animated fadeIn" >-->
<!--        <div class="row">-->
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b>权限管理</b></span>
                    </div>
                    <div class="panel-body">
                        <div class=" col-sm-offset-3 col-sm-6" >
                            <div class="input-group">
                                <input type="text" class="form-control h34" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder="请输入公司品牌名称进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" ng-click="searchBrand()">搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限信息管理</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content" style="padding: 0;">
                        <div style="margin-bottom: -32px;display: none;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <div class="row"></div>
                        </div>
                        <table style="margin-bottom: 0;" class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-user" aria-hidden="true"></span>品牌名称
                                </th>
                                <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;"><span class="fa fa-server" aria-hidden="true"></span>状态
                                </th>
                                <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 140px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;设置
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr  class="cp" ng-repeat="brand in brandLists">
                                <td>{{brand.name}}</td>
                                <td>
                                    <small class="label label-primary" ng-if="brand.status != 2" >正常</small>
                                    <small class="label label-danger"  ng-if="brand.status == 2" >停用</small>
                                </td>
                                <td class="tdBtn">
                                    <div class="lineBisection">
                                        <div class="checkbox mT0 mB0">
                                            <label>
                                                <input type="checkbox" class="checkBoxInput" ng-checked="brand.status == 2" ng-click="blockUpBrand(brand.id)">停用
                                            </label>
                                        </div>
                                        <button class="btn btn-success btn-sm mL10"  ng-click="getAllRole(brand.id,brand.status)">权限设置</button>
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php'); ?>
                        <?= $this->render('@app/views/common/pagination.php'); ?>
                    </div>
                </div>
            </div>
<!--        </div>-->
<!--    </div>-->

<!--选择角色模态框-->
    <div class="modal fade bs-example-modal-lg" id="selectRole" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header borderNone">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">选择角色</h4>
                </div>
                <div class="modal-body pT0 borderNone">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
                                <div class="input-group">
                                    <input type="text" class="form-control search h34" ng-model="roleKeywords" placeholder=" 请输入角色名进行搜索..." ng-keyup="enterRoleSearch($event)">
                                        <span class="input-group-btn">
                                            <button type="submit" ng-click="searchRoleButton()" ladda="searchRoleButtonFlag"  class="btn btn-primary">搜索</button>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox float-e-margins selectRoleList mT20" >
                        <div class="ibox-content pd0" >
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-bordered table-hover dataTables-example dataTable">
                                <thead>
                                    <tr role="row">
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">角色</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">状态</th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr ng-repeat="role in roleLists">
                                        <td>{{role.name}}</td>
                                        <td>
                                            <small class="label label-primary" ng-if="role.status != 2" >正常</small>
                                            <small class="label label-danger"  ng-if="role.status == 2" >停用</small>
                                        </td>
                                        <td class="tdBtn">
                                            <div class="lineBisection">
                                                <div class="checkbox mT0 mB0 w120 " >
                                                    <label style="position: relative;">
                                                        <input type="checkbox" class="checkBoxInput roleInputBox" ng-checked ="role.status == 2" ng-click="blockUpRole(role.id)"><span class="labelSpan">停用</span>
                                                    </label>
                                                </div>
                                                <button class="btn btn-success btn-sm mL10" ng-disabled="role.status == 2 ? 'disabled':''" ng-click="setRole(role.id,role.name)">权限设置</button>
<!--                                                <button class="btn btn-success btn-sm mL10" ng-disabled="role.status == 2 ? 'disabled':''" ng-click="selectRole2()">关联后设置2</button>-->
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'roleInfo','text'=>'暂无数据','href'=>true]);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--权限设置是否同步-->
    <div class="modal fade " id="setRelevance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content clearfix"  >
                <div class="modal-header borderNone">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">权限设置</h4>
                </div>
                <div class="modal-body pT0 borderNone text-center ">
                    <div class="mT20">
                        <div>
                            <img ng-src="/plugins/img/exclamation.png" alt="">
                        </div>
                        <div class="mT10">
                            已于我爱运动大上海店会务权限同步中，是否不同步？
                        </div>
                        <div class="mT20">
                            <button type="button" class="btn btn-success w100 cp" ng-click="isOutSync()">是的</button>
                            <button type="button" class="btn btn-default w100 mL10 cp" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
