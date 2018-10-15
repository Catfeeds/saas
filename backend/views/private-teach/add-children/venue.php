<div class="row removeDiv">
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;售卖场馆&emsp;&emsp;</span>
        <select ng-if="venueStatus == true" ng-change="selectVenue(venueKey<?=$num;?>)" ng-model="$parent.venueKey<?=$num;?>" class="form-control cp fl" style="padding: 4px 12px;" >
            <option value="">请选择场馆</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionVenue"
                ng-disabled="venue.id | attrVenue:venueHttp">{{venue.name}}</option>
        </select>
        <select ng-if="venueStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
            <option value="">请选择场馆</option>
            <option value="" disabled style="color:red;">{{optionVenue}}</option>
        </select>
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">&nbsp;单馆售卖数量</span>
        <input type="number" inputnum min="0" name="venueSaleNum" placeholder="0套" class="form-control cp fl">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'venue')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
    </div>
<!--    <div class="col-sm-4 clearfix" id="venueSaleNum">-->
<!--        <span class="fl mT5">&nbsp;单馆售卖数量</span>-->
<!--        <div class="fl clearfix cp addUnlimited h32 venueSaleNum" style="border: solid 1px #cfdadd;border-radius: 3px;margin-left: 6px;">-->
<!--            <input name="venueSaleNum" style="width:136px;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;margin-right: 0;" type="number" inputnum min="0" placeholder="0套"  class="fl form-control cp">-->
<!--            <div class="checkbox i-checks checkbox-inline " style="top: 4px;margin-left: 2px;">-->
<!--                <label>-->
<!--                    <input type="checkbox" value="-1" > <i></i> 不限</label>-->
<!--            </div>-->
<!--            <button type="button" ng-click="removeVenueId(venueId--><?//=$num;?><!--,'venue')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>-->
<!--        </div>-->
<!--    </div>-->

</div>