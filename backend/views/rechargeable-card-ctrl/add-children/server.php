<div class="clearfix removeDiv" >
    <div class="fl  w32" style="position: relative;">
        <span class="">服务名称&emsp;&emsp;</span>
        <select ng-change="selectServer(serverKey<?=$num;?>)" ng-model="serverKey<?=$num?>" class="form-control cp">
            <option value="" >请选择服务</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionServer"
                ng-disabled="venue.id | attrVenue:serverHttp"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="fl  w32">
        <span class="">每日数量&emsp;&emsp;</span>
        <div class="clearfix cp h32" style="border: solid 1px #cfdadd;margin-left: 15px;">
            <input  style="width: 100px;height: 100%;border: none;margin-left: 0;" type="number" inputnum min="0" name="times" placeholder="0" class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline" style="top: 4px;position: relative;">
                <label>
                    <input type="checkbox" value="-1"> <i></i> 不限</label>
                <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'server')"  class="btn btn-white removeHtml" style="position: absolute;top: -6px;right: -70px;" data-remove="removeDiv">删除</button>
            </div>
        </div>
    </div>
</div>