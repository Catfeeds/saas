<?php
/* @var $this yii\web\View */
use backend\assets\SuperJurisdictionSetCtrlAsset;
SuperJurisdictionSetCtrlAsset::register($this);
$this->title = '权限管理';
?>
<main ng-controller = 'jurisdictionSetCtrl' ng-cloak style="background-color: #FFF;">
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
<!--    <div class="wrapper wrapper-content  animated fadeIn" >-->
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 " style="display: flex;justify-content: space-between;margin-top: 10px;">
                    <span ng-click="backPages()"  class=" cp"><span  style="padding: 2px 20px;font-size: 20px;" class="glyphicon glyphicon-menu-left cp"></span></span>
                    <h4 class=" text-center f20" >{{roleName}}权限设置</h4>
                    <span style="opacity: 0;"> 0</span>
                </div>
                <div class="col-sm-12 pLB5 pRB5 mT20" style="margin-bottom: 60px;" >
                    <div class="row borerB mB10">
                        <h4 class="mB10">同步权限设置</h4>
                        <div class="col-sm-12 mB10 mT20" style="padding-left: 0;padding-right: 0;">
                            <span >角色权限模板</span>
                            <div class="mT10">
                                <select class="form-control w300 selectCss" ng-change="selectRoleTemplate(selectCompanyRoleId)" ng-model="selectCompanyRoleId" id="chooseSelectStyle">
                                    <option value="">选择其它角色权限模板</option>
                                    <option value={{companyRole.role_id}} ng-repeat="companyRole in allCompanyRoleLists" ng-if="companyRole.name!=null">{{companyRole.name}}({{companyRole.orgName}})</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row  " style="display: flex;align-items: center;" >
                        <div >
                            <div>
                                <switch id="isSynchronization" name="isSynchronization" ng-click="isSynchronization()"    class="green "></switch>
                            </div>
                        </div>
                        <div class="mL10">权限同步到其它店面</div>
                    </div>
                    <div class="row borerB">
                        <div class="col-sm-12 pd0 mB10">
                            <div class="col-sm-2 cp removeFlag123"  ng-repeat="synchronizationVenue  in getSynchronizationVenue" ng-model="getSynchronizationVenue" style="display: flex;align-items: center; text-overflow :ellipsis;height: 30px;">
                                <div class="checkbox isSynchronizationVenue " style="display: flex;align-items: center;">
                                    <label title="{{synchronizationVenue.name}}">
                                        <input type="checkbox"  class="checkBoxW" data-company="{{synchronizationVenue.pid}}" value="{{synchronizationVenue.id}}">{{synchronizationVenue.name | cut:true:6:'...'}}
                                    </label>
                                </div>
                                <span  class="glyphicon glyphicon-remove removeFlag color999 mTF4" ng-click="removeVenue($index)"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mT10">
                        <button class="btn btn-default btn-sm" type="button" ng-click="otherBrandClick()" >关联其它品牌</button>
                    </div>

                    <div class="row mT50 authLists" ng-repeat="jurisdiction  in jurisdictionSetData" data-value="{{jurisdiction.id}}">
                        <h4>{{jurisdiction.name}}</h4>
                        <section class="col-sm-12" ng-repeat="($moduleIndex,module) in  jurisdiction.module">
                            <div class="row mT10">
                                <div class="moduleTop" style="display: flex;align-items: center;" >
                                    <div  class="funcLists" data-module ="{{module.id}}" ng-click="switchToggle(module.id)">
                                        <switch  name="enabled" ng-model="attr" switchSuperAuth   data-value="{{module.id}}"  value="{{module.id}}" class="green"></switch>
                                    </div>
                                    <div class="mL10 h24">{{module.name}}</div>
                                </div>
                                <div  class="col-sm-12  borerB  subModule"style="min-height: 20px;padding-left: 20px;">
                                    <div ng-if="module.moduleFunctional != null" class="col-sm-2 pdLr0" ng-repeat="moduleFunction in  module.moduleFunctional">
                                        <div class="checkbox" >
                                            <label title="{{moduleFunction.name}}">
                                                <input type="checkbox"  class="checkBoxW " ng-click="inputToggle($event)" value="{{moduleFunction.id}}" >{{moduleFunction.name  | cut:true:6:'...'}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
<!--    </div>-->

    <div class="footer divFooterBox">
        <ul class="clearfix">
            <li class="fr marginRight30">
                <button type="button" class="btn text-right  btn-success w100" ladda="completeSetFlag" ng-click="completeSet()">完成</button>
            </li>
            <li class="fr marginRight15">
                <button type="button" class="btn text-right   btn-default w100" ng-click="backPages()">取消</button>
            </li>
        </ul>
    </div>

    <!--关联其它品牌模态框-->
    <div class="modal fade" id="otherBrand" tabindex="-1" role="dialog">
        <div class="modal-dialog w720" role="document">
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">关联其它品牌</h4>
                </div>
                <div class="modal-body pd0">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="col-sm-4 pdLr0 text-center borderR relevanceList cp" >
                                <li class="companyLists" ng-click="getAllVenue(company.id,$index)" ng-repeat="company in  relevanceCompanyLists">
                                    <span >{{company.name}}</span>
                                </li>
                            </ul>
                            <ul class="col-sm-8 pdLr0 relevanceList">
                                <li  class="venueLists" ng-repeat="venueItem in relevanceVenueLists">
                                    <div class="col-sm-8">{{venueItem.name}}</div>
                                    <div class="col-sm-4  text-right cp relevanceInputs"  >
                                        <div class="checkbox mT0 mB0" >
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    ng-checked="isChecked(venueItem.id)"
                                                    class="relevanceInput"
                                                    data-venue="{{venueItem.name}}"
                                                    ng-click="addCompanyVenue($event,venueItem)"
                                                    data-company="{{venueItem.pid}}"
                                                    data-storeId="{{venueItem.id}}"
                                                    value="{{venueItem}}"
                                                >关联
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'venueInfo','text'=>'暂无数据','href'=>true]);?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer textCenter">
                    <button type="button" class="btn btn-success w100" ng-click="selectRelevance()">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</main>
