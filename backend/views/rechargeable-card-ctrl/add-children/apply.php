<div class="clearfix removeDiv" >
    <div class="fl  mT30 w32 applyVenueType">
        <span class="">场馆类型&emsp;&emsp;</span>
        <select class="form-control cp"  ng-change="selectApplyVenueType(applyType<?=$num;?>)"  ng-model="applyType<?=$num;?>" name='applyVenueType'>
            <option value="">场馆类型</option>
            <option value="1">普通</option>
            <option value="2">尊爵</option>
        </select>
    </div>
    <div class="fl  mT30 w32 pRelative" style="position: relative;">
        <span class="">选择场馆&emsp;&emsp;</span>
        <select ng-change="selectApply(applyId<?=$num;?>)"  multiple="multiple" ng-model="applyId<?=$num;?>" class="form-control cp applySelectVenue js-example-basic-multiple">
<!--            <option-->
<!--                value="{{venue.id}}"-->
<!--                ng-repeat="venue in applyTypeVenueLists"-->
<!--                ng-disabled="venue.id | attrVenue:applyTypeVenueLists"-->
<!--            >{{venue.name}}</option>-->
            <option value="{{venue.id}}"
                    ng-if="applyType<?=$num;?> == 1"
                    ng-repeat=" venue in applyTypeVenueLists1"
                    ng-disabled="venue.id | attrVenue:generalVenuesNoRepeat"
            >{{venue.name}}</option>
            <option value="{{venue.id}}"
                    ng-if="applyType<?=$num;?> == 2"
                    ng-repeat=" venue in applyTypeVenueLists2"
                    ng-disabled="venue.id | attrVenue:extrawellVenuesNoRepeat"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="fl  mT30 w32 month" style="position: relative;">
        <span class="">通店限制</span>
        <div class="clearfix cp inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;">
            <input  style="width: 130px;height: 100%;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;" type="number" inputnum min="0" placeholder="通店次数" name="times" class="fl form-control">
            <div class="checkbox i-checks checkbox-inline" style="margin: 4px 4px 4px 0;">
                <label style="margin: 0;">
                    <input style="width: 6px;" type="checkbox" value="-1" ng-model="applyTimes"> <i></i> 不限</label>
            </div>
        </div>
        <select  class="form-control cp w70 mL16" name="weeks">
            <option value="w">周</option>
            <option value="m">月</option>
        </select>
    </div>
    <div class="fl w32 mT30 input-daterange cp pRelative" >
        <span class="">进馆时间&emsp;&emsp;</span>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true">
            <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="起始时间">
        </div>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
            <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="结束时间">
        </div>
    </div>
<!--    <div class="fl  w32 month2" style="position: relative;">-->
<!--        <span class="">每周通店限制</span>-->
<!--        <div class="clearfix cp inputUnlimited openShopWeek" style="border: solid 1px #cfdadd;margin-left: 15px;border-radius: 3px;">-->
<!--            <input  style="width: 130px;height: 100%;border: none;margin-left: 0;padding-top: 0;padding-bottom: 0;" type="number" inputnum min="0" placeholder="通店次数" name="weeks" class="fl form-control">-->
<!--            <div class="checkbox i-checks checkbox-inline" style="margin: 4px 4px 4px 0;">-->
<!--                <label style="margin: 0;">-->
<!--                    <input type="checkbox" value="-1" ng-model="applyTimes"> <i></i> 不限</label>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->
    <div class="fl  w32 times1 mT30" style="position: relative;">
        <span class="">卡的等级&emsp;&emsp;</span>
        <select  class="form-control cp" style="margin-left: 0px;">
<!--            <option value="1" >请选择等级</option>-->
            <option value="1">普通卡</option>
            <option value="2">VIP卡</option>
        </select>
        <button type="button" ng-click="removeVenueId(applyId<?=$num;?>,'apply')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: -340px;">删除</button>
    </div>
    <div class="fl mT30 about">
        <div class="checkbox i-checks checkbox-inline t4">
            <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
        </div>
    </div>
</div>