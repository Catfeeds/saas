
<!--
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/30
 * Time: 16:51
 * content:新增角色和分配员工
 -->

<!--新增角色 -->
<div class="modal fade" id="newEmployees" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">新增角色</h4>
            </div>
            <div class="modal-body newEmployeesBody">
                <div class="form-group text-center">
                    <input  id="_csrf" type="hidden"
                            name="<?= \Yii::$app->request->csrfParam; ?>"
                            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    <div class="form-group col-sm-12 newEmployeesInput">
                        <label class="col-sm-4 text-right control-label newEmployeesStrong" ><span class="newEmployeesSpan">*</span>角色名称</label>
                        <div class="col-sm-6">
                            <input type="text"  class="form-control ng-pristine ng-untouched ng-valid ng-empty" ng-model="newEmployeesData.roleName" placeholder="请输入名字">
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="form-group col-sm-12 newEmployeesInput" style="margin-top: 10px;">
                        <label class="col-sm-4 text-right control-label newEmployeesStrong"><span class="newEmployeesSpan">*</span>公司名称</label>
                        <div class="col-sm-6">
                            <select class="form-control actions actionsAll  selectPd" style="width: 100%;"   name="venueId" ng-model="newEmployeesData.corporateName">
                                <option value="">请选择公司</option>
                                <option  value="{{w.id}}" ng-repeat="w in newSelectCompanyData">{{w.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="width: 100px;" class="btn btn-default" ng-click="newEmployeesAddCancel()">取消</button>
                <button type="button" style="width: 100px;" class="btn btn-success" ng-click="newEmployeesAdd(newEmployeesData.roleName,newEmployeesData.corporateName)">完成</button>
            </div>
        </div>
    </div>
</div>
<!--分配员工-->
<div class="modal fade" id="assignEmployees" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="min-width: 720px;">
        <div class="modal-content clearfix" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">分配员工</h4>
            </div>
            <div class="modal-body assignEmployeesBody" >
                <header>
                    <div class="col-sm-4" style="">
                        <div class="pull-left">
                            <select style="width: 200px;" class="form-control actions actionsAll pd412" name="venueId" ng-change="assignEmployeeSelectionDepartmentData(selectionDepartmentId)" ng-model="selectionDepartmentId">
                                <option value="">不限</option>
                                <option title="{{w.name}}({{w.organization.name}})"  value="{{w.id}}" ng-repeat="w in selectionDepartment">{{w.name}}({{w.organization.name |cut:true:6:'...'}})</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div>
                            <input type="text" class="form-control" placeholder="请输入角色姓名或者电话进行搜索" ng-model="getSearchData" ng-keyup="enterSearchData($event)">
                        </div>
                    </div>
                    <div class="col-sm-3 text-center">
                        <div>
                            <button  class="btn btn-success topBtn" ng-click="allocationSearch()">搜索</button>
                            <button  class="btn btn-info topBtn" ng-click="clearInfo()">清空</button>
                        </div>
                    </div>
                </header>
                <main ng-if="assignEmployeesData != ''">
                    <div class="col-sm-4 mainDiv"  ng-repeat="w in assignEmployeesData">
                        <div>
                            <div style="margin-left: 5px;">
                                <img class="img-rounded picImg"  ng-if="w.pic == '' || w.pic == undefined"  ng-src="/plugins/role/img/22.png">
                                <img class="img-rounded picImg"  ng-if="w.pic != '' && w.pic != undefined"  ng-src="{{w.pic}}">
                            </div>
                            <div style="margin-left: 5px;">
                                <h5 style="margin-bottom: 5px;">{{w.name}}</h5>
                                <span>{{w.mobile}}</span><br>
                                <p>{{w.organizationName}}</p>
                            </div>
                        </div>
                        <label class="checkbox-inline ">
                            <input type="checkbox" id={{w.id}} value="w.admin_user_id" ng-checked="isSelected(w.admin_user_id)"  ng-click="updateSelection($event,w.admin_user_id)">
                        </label>
                    </div>
                </main>
                <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoMoneyDataShow1','text'=>'无记录','href'=>true]);?>
            </div>
            <div class="modal-footer">
                <!--                    <span style="float: left;">共{{peoplesNum}}人</span>-->
                <button type="button" style="width: 100px;" class="btn btn-danger" ng-click="assignEmployeesCancel()">取消</button>
                <button type="button" style="width: 100px;" class="btn btn-success" ng-click="assignEmployeesAdd()">完成</button>
            </div>
        </div>
    </div>
</div>