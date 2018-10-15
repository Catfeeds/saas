<!--    新增数据-->
<div class="modal fade " id="siteManagementAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="cancelClose(1)"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">新增场地</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>所属房间</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <label for="id_label_single">
                                    <select class="form-control" id="ee" ng-model="DCodeId" style="width: 165px;padding: 0 5px;font-weight: normal;">
                                        <option value="">请选择房间</option>
                                        <option value="{{w.id}}" ng-repeat="w in allHouse">
                                            {{w.name}}（{{w.code}}）
                                        </option>
                                    </select>
                                </label>
                            </div>
<!--                            <div class="col-sm-4">-->
<!--                                <button class="btn btn-sm btn-success" ng-click="addHouse()">新增</button>-->
<!--                                <button class="btn btn-sm btn-danger" ng-click="delHouse()">删除</button>-->
<!--                            </div>-->
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>场地名称</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="text" class="form-control w160" ng-model="siteName"
                                       placeholder="请输入场地名称">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>人数限制</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="number" min="0" class="form-control w160" placeholder="请输入人数"
                                       ng-model="numberBox" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>开放时间</label>
                            <div class="col-sm-4 displayFlex" style="padding-right: 0">
                                <div class="justifyContentCenter col-sm-6 input-group borderRadius clockpicker w80"
                                     data-autoclose="true">
                                    <input name="dayStart" type="text" class="borderRadius zIndex20000 input-sm form-control  text-center borderRadius"
                                           placeholder="起始时间" >
                                </div>
                                <div class="justifyContentCenter col-sm-6 input-group borderRadius clockpicker w80"
                                     data-autoclose="true">
                                    <input name="dayEnd" type="text" class="borderRadius zIndex20000 input-sm form-control text-center borderRadius"
                                           placeholder="结束时间" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>每次时长</label>
                            <div class="col-sm-4" style="padding-right: 0">
                                <input type="number" min="0" class="form-control w160" placeholder="请输入每次时长"
                                       ng-model="timeLength" onmousewheel="return false;">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong">会员卡限制</label>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="w160px">
                                    <select class="js-example-basic-single js-states form-control id_label_single "
                                            multiple="multiple" id="userHeader1">
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
                <button type="button" class="btn btn-warning" ng-click="cancelClose(1)">取消</button>
                <button type="button" class="btn btn-primary"
                        ng-click="addFieldOk()">添加
                </button>
            </div>
        </div>
    </div>
</div>
<!--    新增数据-->
<div class="modal fade " id="siteManagementAdd2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="close()"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">新增房间</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>房间名称或编号</label>
                            <div class="col-sm-4" style="padding-right: 0;">
                                <input type="text" class="form-control w160" placeholder="房间名称或编号"
                                       ng-model="houseName">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>所属场馆</label>
                            <div class="col-sm-4">
                                <label for="id_label_single" class="w160px">
                                    <select class="form-control" ng-model="venueID" id="userHeader1" style="padding: 0 5px;font-weight: normal;color: grey">
                                        <option value="">请选择场馆</option>
                                        <option value="{{w.id}}" ng-repeat="w in allVenue">
                                            {{w.name}}
                                        </option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label commodityModificationStrong"><span class="spanRed">*</span>识别码</label>
                            <div class="col-sm-4" style="padding-right: 0;">
                                <input type="text" class="form-control w160" placeholder="请输入识别码"
                                       ng-model="houseCode" onmousewheel="return false;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" ng-click="cancelAdd()">取消</button>
                <button type="button" class="btn btn-primary"
                        ng-click="addSuccess()">添加
                </button>
            </div>
        </div>
    </div>
</div>