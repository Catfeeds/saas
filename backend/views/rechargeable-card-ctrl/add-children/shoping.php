<div class="clearfix removeDiv" >
    <div class="fl  w32" style="position: relative;">
        <span class="">商品名称&emsp;</span>
        <select ng-change="selectShop(shopKey<?=$num?>)" ng-model="shopKey<?=$num?>" class="form-control cp">
            <option value="" >请选择商品</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionDonation"
                ng-disabled="venue.id | attrVenue:shopHttp"
            >{{venue.goods_name}}</option>
        </select>
    </div>
    <div class="fl  w32">
        <span class="">&emsp;商品数量&emsp;</span>
        <div class="clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;margin-left: 15px;">
            <input  style="width: 135px;height: 100%;border: none;margin-left: 0;" type="number" inputnum min="0" name="times" placeholder="0节" class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline T4" style="top: -6px;">
                <label>
                    <input style="width: 6px;" type="checkbox" value="-1"> <i></i> 不限</label>
            </div>
        </div>
    </div>
<!--    <div class="fl " style="margin: 26px 0 0 -60px;position: relative;"><span class="glyphicon glyphicon-yen"><b style="font-size: 18px;">0</b></span> 总金额-->
        <div class="fl w32">
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'shop')"  class="btn btn-white removeHtml"  data-remove="removeDiv">删除</button></div>
        </div>

</div>