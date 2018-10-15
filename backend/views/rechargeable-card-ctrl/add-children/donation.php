<div class="clearfix removeDiv" >
    <div class="fl  w32" style="position: relative;">
        <span class="">赠品名称&emsp;&emsp;</span>
        <select ng-change="selectDonation(donationKey<?=$num?>)" ng-model="donationKey<?=$num?>" class="form-control cp">
            <option value="" >请选择赠品</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionDonation"
                ng-disabled="venue.id | attrVenue:DonationHttp"
            >{{venue.goods_name}}</option>
        </select>
    </div>
    <div class="fl  w32">
        <span class="">赠品数量&emsp;&emsp;</span>
        <div class="clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;margin-left: 15px;">
            <input  style="width: 100px;height: 100%;border: none;margin-left: 0;" type="number" inputnum min="0" placeholder="0个" name="times" class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline" style="top: 4px;position: relative;">
                <label>
                    <input type="checkbox" value="-1"> <i></i> 不限</label>
                <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'donation')"  data-remove="removeDiv" class="btn btn-white removeHtml" style="position: absolute;top: -6px;right: -70px;">删除</button>
            </div>
        </div>
    </div>
</div>