<!--商品报损、退货、报溢-->
<div class="modal fade bs-example-modal-lg"  style="overflow: auto;" id="shopLossModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >商品{{shopHandleTypeName}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control userHeaders" ng-model="shopLossOrderKeywords" ng-keyup="shopLossOrderSearch($event)" placeholder=" 请输入单号进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" ng-click="shopLossOrderBtnClick()" class="btn btn-primary btn-sm">搜索</button>
                                        </span>
                        </div>
                    </div>
                </div>
                <div class="row mT20">
                    <div class="col-sm-12 pdLR0">
                        <div class="ibox float-e-margins" style="border: none;">
                            <div class="ibox-content" style="padding: 0">
                                <div style="padding:0;" id="DataTables_Table_0_wrapper"
                                     class="dataTables_wrapper form-inline" role="grid">
                                    <table
                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                style="width: 100px;background-color: #FFF;">序号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                style="width: 140px;background-color: #FFF;">名称
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 140px;background-color: #FFF;">
                                                价格（元）
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序"
                                                style="width: 140px;background-color: #FFF;">数量（瓶）
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width:240px;background-color: #FFF;">
                                                单号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 200px;background-color: #FFF;">入库日期
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 200px;background-color: #FFF;">操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="shopCurrentDetail in ShopCurrentInventoryLists">
                                            <td>{{(ShopCurrentInventoryListsNow - 1)  * listsNumbers +$index +1}}</td>
                                            <td>{{shopCurrentDetail.goods_name}}</td>
                                            <td>{{shopCurrentDetail.gcUnitPrice | number:2}}</td>
                                            <td>{{shopCurrentDetail.surplus_amount}}</td>
                                            <td>{{shopCurrentDetail.list_num}}</td>
                                            <td>{{shopCurrentDetail.create_at*1000 | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" ng-click="shopSelect123(shopCurrentDetail.goods_id,shopCurrentDetail)">选择</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'ShopCurrentInventoryListsFlag','text'=>'暂无数据','href'=>true]);?>
                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'ShopCurrentInventoryListsPages']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--商品报损数量模态框-->
<div class="modal fade" id="shopLossNumModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">商品报损</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20" style="padding-left: 0;" >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>报损数量</div>
                            <div class="col-sm-7"><input type="number" min="1" ng-change="inputShopNum123(shopLossNum)" inputnum ng-model="shopLossNum" class="form-control" placeholder="请输入报损数量"></div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right"><span class="red">*</span>备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="shopLossRemarks" placeholder="请填写报损原因" style="resize: none;text-indent: 1em;"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone  contentCenter">
                <button type="button" class="btn btn-success w100 " ladda="shopLossCompleteFlag" ng-click="shopLossComplete()">完成</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--商品退货数量模态框-->
<div class="modal fade" id="shopReturnNumModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">商品退货</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20" style="padding-left: 0;" >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>退货数量</div>
                            <div class="col-sm-7"><input type="number" min="1" ng-change="inputShopNum123(shopReturnNum)" inputnum ng-model="shopReturnNum" class="form-control" placeholder="请输入退货数量"></div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right"><span class="red">*</span>备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="shopReturnRemarks" placeholder="请填写退货原因" style="resize: none;text-indent: 1em;"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone  contentCenter">
                <button type="button" class="btn btn-success w100 " ladda="shopReturnCompleteFlag" ng-click="shopReturnComplete()">完成</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--商品报溢数量模态框-->
<div class="modal fade" id="shopOverflowNumModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">商品报溢</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20" style="padding-left: 0;" >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>报溢数量</div>
                            <div class="col-sm-7"><input type="number" min="1" ng-change="inputShopNum123(shopOverflowNum)" inputnum ng-model="shopOverflowNum" class="form-control" placeholder="请输入报溢数量"></div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right"><span class="red">*</span>备注</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="shopOverflowRemarks" placeholder="请填写报溢原因" style="resize: none;text-indent: 1em;"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone  contentCenter">
                <button type="button" class="btn btn-success w100 " ladda="shopOverflowCompleteFlag" ng-click="shopOverflowComplete()">完成</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->