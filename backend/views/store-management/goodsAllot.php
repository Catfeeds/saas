<!--商品页面调拨-->
<div class="modal fade" id="allotShopModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">调拨</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>调拨数量</div>
                            <div class="col-sm-7"><input type="number" min="1" inputnum ng-change="allotShopNumInput(allotShopNum123)"  ng-model="allotShopNum123" class="form-control" placeholder="请输入调拨数量"></div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div class="col-sm-4 text-right"><span class="red">*</span>公司名称</div>
                            <div class="col-sm-7"><input type="text" ng-blur="allotCompanyInput(allotCompany123)"  ng-model="allotCompany123" class="form-control" placeholder="请输入公司名称"></div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" ng-if="getCompanyIdFlag">
                            <div class="col-sm-4 text-right"><span class="red">*</span>调拨场馆</div>
                            <div class="col-sm-7">
                                <select class="form-control selectPd" id="beVenueId" style="width: 100%;" ng-change="allotShopVenueSelect123(allotVenue123)"    ng-model="allotVenue123">
                                    <option value="">请选择场馆</option>
                                    <option ng-repeat="venue in AllotVenueLists123" value="{{venue.id}}">{{venue.name}}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" ng-if="getCompanyIdFlag">
                            <div class="col-sm-4 text-right"><span class="red">*</span>被调拨仓库</div>
                            <div class="col-sm-7">
                                <select class=" form-control selectPd" id="Warehouse123" style="width: 100%;" ng-change="allotShopWarehouseIdSelect(Warehouse)"    ng-model="Warehouse">
                                    <option value="">请选择仓库</option>
                                    <option ng-if="warehouseStoreId != Warehouse.id" value="{{Warehouse.id}}" ng-repeat="Warehouse in allWarehouseLists">{{Warehouse.name}}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right">备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5" placeholder="请填写调拨原因"  ng-model="allotShopNote" class="wB100 borderRadius3" style="resize: none;text-indent: 1em;"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone"  style="padding-top: 0px;">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ladda="allotShopCompleteFlag" ng-click="allotShopComplete1()">完成</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->