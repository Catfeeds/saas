<div class="row removeDiv">
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;商品名称&emsp;</span>
        <select ng-change="selectDonation(donationKey<?=$num;?>)" ng-model="$parent.donationKey<?=$num;?>" class="form-control cp fl" style="padding: 4px 12px;" >
            <option value="">请选择商品</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionDonation"
                ng-disabled="venue.id | attrVenue:donationHttp">{{venue.goods_name}}</option>
        </select>
<!--        <select ng-if="donationStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">-->
<!--            <option value="">请选择赠品</option>-->
<!--            <option value="" disabled style="color:red;">{{optionDonation}}</option>-->
<!--        </select>-->
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;商品数量</span>
        <input type="number" inputnum min="0" name="giftNum" placeholder="0" class="form-control cp fl">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'donation')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
    </div>
</div>