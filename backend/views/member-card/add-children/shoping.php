<div class="inputBox5 removeDiv">
    <div class="form-group" style="margin-top: 10px;display: inline-block;">
        <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">商品名称</label>
        <select ng-change="selectShop(shopKey<?=$num?>)" ng-model="shopKey<?=$num?>" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
            <option value="">请选择商品</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionShop"
                ng-disabled="venue.id | attrVenue:shopHttp"
            >{{venue.goods_name}}</option>
        </select>
    </div>
    <div class="form-group inputUnlimited" style="margin-top: 10px;margin-left: 60px;position: relative;display: inline-block;border: none;">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">扣次数量</label>
        <input type="number" inputnum min="0" name="goodsNum" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;border: solid 1px #ccc !important;" placeholder="0个">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'shop')"  class="btn btn-white removeHtml" style="position: absolute;top: -2px;right: -70px;" data-remove="removeDiv">删除</button></div>
    </div>
</div>