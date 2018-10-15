<!--调拨申请详情-->
<div class="modal fade bs-example-modal-lg" style="overflow: auto;" id="AllocationOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg " role="document" style="width: 920px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">调拨详情</h4>
            </div>
            <div class="modal-body">
                <div class="row heightCenter" >
                    <section class="col-sm-4 col-lg-3">
                        <div class="col-sm-12">
                            <ul class="wB100 color999 f14" >
                                <li><h3 class="f20" >{{ApplyForShopDetailMess.goods_name}}</h3></li>
                                <li class="mT10">型号&emsp;&emsp;: {{ApplyForShopDetailMess.goods_model | noData:''}}</li>
                                <li class="mT10">数量&emsp;&emsp;: {{allocationObject.num}}</li>
                                <li class="mT10">申请方&emsp;: {{ApplyForShopDetailMess.storeName}}</li>
                                <li class="mT10">被申请方: {{ApplyForShopDetailMess.beStoreName}}</li>
                            </ul>
                        </div>
                    </section>
                    <section class="col-sm-8 col-lg-9 pdLr0">
                        <div class="wB100 ">
                            <div class="col-sm-12 pdLR0">
                                <div class="ibox float-e-margins" style="border: none;">
                                    <div class="ibox-content" style="padding: 0">
                                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper form-inline" role="grid">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1"
                                                        style="width: 240px;background-color: #FFF;">状态
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1"
                                                        style="width: 240px;background-color: #FFF;">时间动态
                                                    </th>
                                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" style="width: 240px;background-color: #FFF;">备注
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <small class="label label-default " ng-if="ApplyForStatusListsMess.type == '1'">待通过</small>
                                                        <small class="label label-primary " ng-if="ApplyForStatusListsMess.type == '2'">待调拨</small>
                                                        <small style="background-color: #00cc00;" class="label label-success " ng-if="ApplyForStatusListsMess.type == '3'">已调拨</small>
                                                        <small class="label label-danger " ng-if="ApplyForStatusListsMess.type == '4'">已拒绝</small>
                                                    </td>
                                                    <td>{{ApplyForStatusListsMess.update_at *1000 | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                                    <td>{{ApplyForStatusListsMess.note | noData:''}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?=$this->render('@app/views/common/nodata.php',['name'=>'onePtFlag','text'=>'暂无数据','href'=>true]);?>
                                            <?=$this->render('@app/views/common/pagination.php',['page'=>'onePtPages']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--调拨申请中调拨模态框-->
<div class="modal fade" id="allocationOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">调拨</h4>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-sm-12">
                        <ul class="wB100 ">
                            <li class="wB100 text-center"><img style="width: 100px;" ng-src="/plugins/img/exclamation.png " alt="警告图片标志"></li>
                            <li class="wB100 text-center mT20">是否确定将价值<span class="colorOrange f16">{{AllocationOrderMoney | number:2}}</span>元的<span class="colorOrange f16">{{allocationOrderDetailMess.num}}</span>{{allocationOrderDetailMess.unit}}<span class="colorOrange f16">{{allocationOrderDetailMess.goods_model}}{{allocationOrderDetailMess.goods_name}}</span></li>
                            <li class="wB100 text-center mT20">调拨到<span class="colorOrange f16">{{allocationOrderDetailMess.name}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer bTNone contentCenter">
                <button type="button" class="btn btn-success w100" ladda="CompleteAllocationOrderButtonFlag" ng-click="allocationOrderComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--拒绝调拨-->
<div class="modal fade" id="RefuseAllocationOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">拒绝原因</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-3  text-right"><span class="red">*</span>原因:</div>
                            <div  class="col-sm-7 ">
                                <textarea name="" id="" rows="5" ng-model="RefuseAllocationContent" placeholder="请填写拒绝原因" class="wB100 borderRadius3" style="resize: none;text-indent: 1em;"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone contentCenter ">
                <button type="button" class="btn btn-success w100 " ladda="RefuseAllocationCompleteFlag" ng-click="RefuseAllocationComplete()">完成</button>
            </div>
        </div>
    </div>
</div>