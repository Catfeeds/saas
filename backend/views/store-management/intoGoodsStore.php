<!--入库-->
<div class="modal fade" id="enterStorageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">入库</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>入库类型</div>
                            <div class="col-sm-7">
                                <select  class=" form-control selectPd"    ng-model="enterStorageType123">
                                    <option value="">请选择入库类型</option>
                                    <option value="1">正常入库</option>
                                    <option value="2">调拨入库</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div class="col-sm-4 text-right"><span class="red">*</span>入库数量</div>
                            <div class="col-sm-7"><input type="number" min="1" inputnum   ng-model="enterStorageNum" class="form-control" placeholder="请输入入库数量"></div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20">
                            <div class="col-sm-4 text-right"><span class="red">*</span>单价</div>
                            <div class="col-sm-7"><input type="number" min="1"  ng-model="enterStorageMoney" class="form-control" placeholder="请输入单价"></div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right">备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="enterStorageNote" placeholder="请填写入库备注" style="resize: none;text-indent: 1em;border:1px solid #cfdadd"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <div class="row" style="padding-left: 15px;padding-right:15px">入库金额: <span style="color: #FF9900;font-size: 16px;">
                            <span ng-if="enterStorageNum != '' && enterStorageMoney !=''">{{enterStorageNum*enterStorageMoney | number:2}}</span>
                            <span ng-if="enterStorageNum == '' || enterStorageMoney ==''">0.00</span>
                            元</span>
                </div>
                <div class="row" style="padding-left: 15px;padding-right:15px;margin-top: 10px;">
                    <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success w100 fr" ladda="enterStorageCompleteFlag" ng-click="enterStorageComplete()">完成</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--出库-->
<div class="modal fade" id="outerStorageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">出库</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>出库数量</div>
                            <div class="col-sm-7"><input type="number" min="1" ng-change="outerStorageNumChange(outerStorageNum)" inputnum  ng-model="outerStorageNum" class="form-control" placeholder="请输入出库数量"></div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right">备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="exitStorageNote" placeholder="请填写出库备注" style="resize: none;text-indent: 1em;border:1px solid #cfdadd"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <div class="row" style="padding-left: 15px;padding-right:15px">出库金额: <span style="color: #FF9900;font-size: 16px;">{{shopNumMoney | number:2}} 元</span></div>
                <div class="row" style="padding-left: 15px;padding-right:15px;margin-top: 10px;">
                    <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success w100 fr" ladda="outerStorageCompleteFlag" ng-click="outerStorageComplete()">完成</button>
                </div>
            </div>
        </div>
    </div>
</div>