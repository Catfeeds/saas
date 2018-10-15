<!--修改-->
<div class="modal fade" id="modifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改商品</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-12 mTB20">
                        <li class="col-sm-12 heightCenter mT20" style="margin: 10px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>商品名称</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsInfo.goods_name" class="form-control" placeholder="请输入商品名称">
                                <input ng-model="datas._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                                <input type="hidden" ng-model=goodsInfo.id>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>仓库名称</div>
                            <div class="col-sm-7">
                                <!--<input type="text" ng-model="goodsInfo.store_name" class="form-control" placeholder="请输入仓库名称">-->
                                <select class="form-control selectPd" ng-model="goodsInfo.store_id" >
                                    <option value="">请选择仓库</option>
                                    <option value="{{i.id}}" ng-repeat="i in stores">{{i.name}}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>所属场馆</div>
                            <div class="col-sm-7">
                                <select  class=" form-control selectPd" ng-model="goodsInfo.venue_id">
                                    <option value="">请选择场馆名称</option>
                                    <option ng-selected="goodsInfo.venue_id == venue.id" ng-repeat="venue in venues" value="{{ venue.id }}">{{ venue.name }}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>所属部门</div>
                            <div class="col-sm-7">
                                <select  class=" form-control selectPd" ng-model="goodsInfo.department_id">
                                    <option value="">请选择部门名称</option>
                                    <option ng-repeat="i in departmentListData" value="{{i.id }}">{{i.name }}</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>商品类型</div>
                            <div class="col-sm-7">
                                <select  class=" form-control selectPd" ng-model="goodsInfo.goods_attribute">
                                    <option value="">请选择商品类型</option>
                                    <option value="1">商品</option>
                                    <option value="2">赠品</option>
                                    <option value="3">自用</option>
                                </select>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right"><span class="red">*</span>商品品类</div>
                            <div class="col-sm-4">
                                <select  class=" form-control selectPd" ng-model="goodsInfo.goods_type_id">
                                    <option value="">请选择商品品类</option>
                                    <option value="{{ type.id }}" ng-repeat="type in types" ng-selected="goodsInfo.goods_type_id == type.id">
                                        {{ type.goods_type }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding-left:4px">
                                <span style="display: inline-block">
                                    <button type="button" ng-click="addGoodsType(goodsInfo.venue_id,goodsInfo.company_id)" class="btn btn-sm btn-info">自定义</button>
                                </span>
                                <span style="display: inline-block">
                                     <button type="button" ng-click="delGoodsType(goodsInfo.goods_type_id,goodsInfo.venue_id)" class="btn btn-sm btn-default">删除</button>
                                </span>
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right">商品品牌</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsInfo.goods_brand" class="form-control" placeholder="请输入商品品牌">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" style="margin:5px 0px;">
                            <div class="col-sm-4 text-right">商品型号</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsInfo.goods_model" class="form-control" placeholder="请输入商品型号">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right">生&nbsp;&nbsp;产&nbsp;&nbsp;商</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsInfo.goods_producer" class="form-control" placeholder="请输入生产商">
                            </div>
                        </li>
                        <li class="col-sm-12 heightCenter mT20" style="margin: 5px 0px;">
                            <div class="col-sm-4 text-right">供&nbsp;&nbsp;应&nbsp;&nbsp;商</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsInfo.goods_supplier" class="form-control" placeholder="请输入供应商">
                            </div>
                        </li>
<!--                        <li class="col-sm-12  mT20">-->
<!--                            <div  class="col-sm-4  text-right">备注</div>-->
<!--                            <div  class="col-sm-7 ">-->
<!--                                <textarea name="" id="" rows="5"  class="wB100 borderRadius3" ng-model="enterStorageNote" placeholder="请填写入库备注" style="resize: none;text-indent: 1em;"></textarea>-->
<!--                            </div>-->
<!--                        </li>-->
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100 fr" ng-click="done(goodsInfo.id)">完成</button>
            </div>
        </div>
    </div>
</div>