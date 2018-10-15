<!--自定义商品品类-->
<div class="modal fade" id="customShopCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">自定义商品品类</h4>
            </div>
            <div class="modal-body">
                <div class="row contentCenter">
                    <ul class="col-sm-10 mTB20"  >
                        <li class="col-sm-12 heightCenter">
                            <div class="col-sm-4 text-right"><span class="red">*</span>商品品类</div>
                            <div class="col-sm-7"><input type="text"   ng-model="customShopCategoryName" class="form-control" placeholder="请输入商品品类"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bTNone clearfix ">
                <button type="button" class="btn btn-success w100 fr" ladda="customShopCategoryCompleteFlag" ng-click="customShopCategoryComplete()">完成</button>
            </div>
        </div>
    </div>
</div>