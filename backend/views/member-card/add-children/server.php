<div class="inputBox4 removeDiv">
    <div class="form-group" style="margin-top: 10px;">
        <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">服务名称</label>
        <select ng-change="selectServer(serverKey<?=$num;?>)" ng-model="serverKey<?=$num?>" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
            <option value="">请选择服务</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionServer"
                ng-disabled="venue.id | attrVenue:serverHttp"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="form-group inputUnlimited" style="margin-top: 10px;margin-left: 60px;position: relative;">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">每日数量</label>
        <input type="number" inputnum min="0" name="serviceTimes" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;padding-right: 70px;"placeholder="0">
        <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">
            <label><input type="checkbox" value="-1">不限</label>
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'server')"  class="btn btn-white removeHtml" style="position: absolute;top: -6px;right: 175px;" data-remove="removeDiv">删除</button>
        </div>
    </div>
</div>