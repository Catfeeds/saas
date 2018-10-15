<!-- 添加售卖场馆模版 -->
<div class="row removeDiv" >
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;<strong class="red">*</strong>售卖场馆&emsp;&emsp;</span>
        <select class="form-control cp fl" ng-if="venueStatus == true"  style="padding: 4px 12px;" >
            <option value="">请选择场馆</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionVenue"
            >{{venue.name}}</option>
        </select>
        <select class="form-control cp fl" ng-if="venueStatus == false"   style="padding: 4px 12px;" >
            <option value="">请选择场馆</option>
            <option value="" disabled style="color:red;">{{optionVenue}}</option>
        </select>
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;<strong class="red">*</strong>单馆售卖数量</span>
        <input type="text" inputnum name="venueSaleNum" min="0" placeholder="0套" class="form-control cp fl">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'svenueHtml123')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>

    </div>
</div>