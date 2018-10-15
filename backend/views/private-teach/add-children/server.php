<div class="row removeDiv">
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;服务名称&emsp;&emsp;</span>
        <select ng-if="serverStatus == true" ng-change="selectServer(serverKey<?=$num;?>)" ng-model="$parent.serverKey<?=$num;?>" class="form-control cp fl" style="padding: 4px 12px;" >
            <option value="">请选择服务</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionServer"
                ng-disabled="venue.id | attrVenue:serverHttp">{{venue.name}}</option>
        </select>
        <select ng-if="serverStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
            <option value="">请选择服务</option>
            <option value="" disabled style="color:red;">{{optionServer}}</option>
        </select>
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;每日数量</span>
        <input type="number" inputnum min="0" name="serverNum" placeholder="0" class="form-control cp fl">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'server')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
    </div>
</div>