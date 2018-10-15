<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: 程-->
<!-- * Date: 2017/12/29-->
<!-- * Time: 10:45-->
<!-- */-->
<div class="col-sm-12 col-xs-12 changeBasicAttrAllDiv giftShopBox123 removeDiv">
    <div class="col-sm-5 col-xs-5 mT20">
        <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品名称:</div>
        <div class="col-sm-8 col-xs-7 pd0">
            <select name="giftShopEdit" ng-click="shopGiftSelectClick()" class="form-control selectPadding"  >
                <option value="">请选择</option>
                <option ng-repeat="giftData in allGiftData"
                        ng-disabled=" giftData.id | attrVenue:giftId"
                        value="{{giftData.id}}" >{{giftData.goods_name}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-5 col-xs-5 mT20">
        <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>商品数量:</div>
        <div class="col-sm-8 col-xs-7 pd0">
            <input type="number" inputnum min="0" placeholder="0" name="giftNum" class="form-control">
        </div>
    </div>
    <div  class="col-sm-2 col-xs-2 mT20">
        <button class="btn btn-default btn-sm removeHtml" data-remove="removeDiv">删除</button>
    </div>
</div>