<div class="inputBox6 removeDiv" style="margin-top: 10px;">
    <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">赠品名称</label>
    <select ng-change="selectDonation(donationKey<?=$num?>)" ng-model="donationKey<?=$num?>" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;">
        <option value="">请选择赠品</option>
        <option
            value="{{venue.id}}"
            ng-repeat="venue in optionDonation"
            ng-disabled="venue.id | attrVenue:DonationHttp"
        >{{venue.goods_name}}</option>
    </select>
    <div class="form-group inputUnlimited" style="margin-left: 60px;position: relative;display: inline-block;border: none;">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">赠品数量</label>
        <input type="number" inputnum min="0" name="giftNum" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;border: solid 1px #ccc !important;display: inline-block;" placeholder="0个">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'donation')"  data-remove="removeDiv" class="btn btn-white removeHtml" style="position: absolute;top: -2px;right: -70px;">删除</button>
    </div>
</div>