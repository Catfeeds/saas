<!-- 修改数据-->
<div class="modal fade " id="siteManagementUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">修改场地</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal w500">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong"><span class="spanRed">*</span>所属房间</label>
                            <div class="col-sm-5" style="padding-right: 0">
                                <label for="id_label_single">
                                    <select class="form-control" id="ee" ng-model="upDateHouse" style="width: 165px;padding: 0 5px;font-weight: normal;">
                                        <option value="">请选择房间</option>
                                        <option value="{{w.id}}" ng-selected="w.id == upDateHouse" ng-repeat="w in allHouse">
                                            {{w.name}}（{{w.code}}）
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong"><span class="spanRed">*</span>场地名称</label>
                            <div class="col-sm-5 modalTitleCente mT5 ">
                                <span class="mT5">{{upDateYardName}}</span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong"><span class="spanRed">*</span>人数限制</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control w160" placeholder="请输入人数限制"
                                       ng-model="upDatePeopleLimit" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong"><span class="spanRed">*</span>开放时间</label>
                            <div class="col-sm-5 displayFlex borderRadius">
                                <div class="justifyContentCenter col-sm-6 input-group clockpicker w80"
                                     data-autoclose="true">
                                    <input ng-disabled="true" name="dayStart1" type="text"
                                           class="input-sm form-control zIndex20000 borderRadius text-center"
                                           placeholder="起始时间" >
                                </div>
                                <div class="justifyContentCenter col-sm-6 input-group clockpicker w80"
                                     data-autoclose="true">
                                    <input ng-disabled="true" name="dayEnd1" type="text"
                                           class="input-sm form-control zIndex20000 text-center borderRadius"
                                           placeholder="结束时间" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong"><span class="spanRed">*</span>每次时长</label>
                            <div class="col-sm-5">
                                <input ng-disabled="true" type="number" class="form-control w160"
                                       placeholder="请输入每次时长"
                                       ng-model="upDateActiveAuration" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-5 control-label commodityModificationStrong">会员卡限制</label>
                            <div class="col-sm-5">
                                <label for="editSiteCard">
                                    <select ng-model="upDateArray"
                                            class="js-example-basic-single js-states form-control w168px"
                                            multiple="multiple" id="editSiteCard">
                                        <option value="{{w.id}}" ng-repeat="w in venueCardCategory">
                                            {{w.card_name}}
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" ng-click="upDateAdd()">完成</button>
            </div>
        </div>
    </div>
</div>