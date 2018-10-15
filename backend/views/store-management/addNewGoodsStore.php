<!--新增仓库-->
<div class="modal fade" id="addWarehouseModal"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">新增仓库</h4>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>仓库名称</div>
                            <div class="col-sm-8"><input type="text" ng-model="addWarehouseName" class="form-control" placeholder="请输入仓库名称"></div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div  class="col-sm-4  text-right">所属场馆</div>
                            <div  class="col-sm-8 ">
                                <select id="storeIsVenue" class=" form-control"   style="width: 100%;padding: 4px 12px;"  ng-model="addWarehouseVenue">
                                    <option value="">请选择场馆</option>
                                    <option value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ladda="CompleteAddClassroomButtonFlag" ng-click="addClassroomComplete()">完成</button>
            </div>
        </div>
    </div>
</div>