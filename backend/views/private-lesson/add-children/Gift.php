/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22 0022
 * Time: 下午 2:47
 */
<div class="row removeDiv">
    <div class="col-sm-12">
        <p class="titleP">5.赠品</p>
    </div>
    <div class="col-sm-12 changeBasicAttrAllDiv">
        <div class="col-sm-6 mt20">
            <div class="col-sm-4 pd0"><span class="red">*</span>商品名称：</div>
            <div class="col-sm-8 pd0">
<!--                <select name="" id="" class="w100Percent" ng-model="giftId" ng-change="selectGift(giftId)">-->
                    <select ng-change="selectGift(giftId<?=$num;?>)" ng-model="$parent.giftId<?=$num;?>" name="" id="" class="w100Percent">
                    <option value="">请选择</option>
                    <option ng-repeat="giftData in allGiftData"
                        value="{{giftData.id}}"
                        ng-disabled="giftData.id | attrVenue:donationHttp">{{giftData.goods_name}}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 mt20">
            <div class="col-sm-4 pd0"><span class="red">*</span>商品数量：</div>
            <div class="col-sm-8 pd0">
                <input type="number" inputnum min="0" name="giftNum" class="w100Percent">
            </div>
        </div>
        <div class="col-sm-12 changeAddButtonMT">
<!--            <button class="btn btn-default" ng-click="addDonationHtml()">添加商品</button>-->
            <button class="btn btn-default removeHtml" ng-click="addDonationHtml(venueId<?=$num;?>,'donation')" data-remove="removeDiv">添加商品</button>
        </div>
    </div>
</div>
