<!--修改-->
<div class="modal fade" id="addGoodsType" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 464px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close goodsClose"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">自定义商品品类</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-12 mTB20"  >
                        <li class="col-sm-12 heightCenter mT20" style="margin: 10px 0px;">
                            <div class="col-sm-4 text-right">商品品类</div>
                            <div class="col-sm-7">
                                <input type="text" ng-model="goodsType" class="form-control" placeholder="请输入商品品类">
                                <input ng-model="datas._csrf" id="_csrf" type="hidden"
                                       name="<?= \Yii::$app->request->csrfParam; ?>"
                                       value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <button type="button" class="btn btn-success w100 fr" ng-click="addType(goodsInfo.venue_id,goodsInfo.company_id)">完成</button>
            </div>
        </div>
    </div>
</div>