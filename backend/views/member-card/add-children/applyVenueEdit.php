
<!--/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/10/30
 * Time: 20:01
 */-->
<div class="col-sm-12 pdLR0 applyVenueBox removeDiv">
    <div class="col-sm-4  heightCenter mT20">
        <span class="width100 text-right"><strong class="red"></strong>场馆类型</span>
        <select class="form-control cp selectPd w240 mL10" ng-change="selectApplyVenueType(applyType<?=$num?>)"  ng-model="applyType<?=$num?>"  name='applyVenueType'>
            <option value="">场馆类型</option>
            <option value="1">普通</option>
            <option value="2">尊爵</option>
        </select>
    </div>
    <div class="col-sm-4  heightCenter mT20">
        <span class="width100 text-right" style="margin-right: 10px;"><strong class="red"></strong>选择场馆</span>
        <select    ng-change="selectApply(applyId<?=$num?>)"  multiple="multiple" ng-model="$parent.applyId<?=$num?>"   class=" form-control cp applySelectVenue js-example-basic-multiple w240">
            <option value="{{venue.id}}"
                    ng-if="applyType<?=$num?> == 1"
                    ng-repeat=" venue in applyTypeVenueLists1"
                    ng-disabled="venue.id | attrVenue:generalVenuesNoRepeat"
            >{{venue.name}}</option>
            <option value="{{venue.id}}"
                    ng-if="applyType<?=$num?> == 2"
                    ng-repeat=" venue in applyTypeVenueLists2"
                    ng-disabled="venue.id | attrVenue:extrawellVenuesNoRepeat"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="col-sm-4 heightCenter mT20">
        <span class="">进馆时间&emsp;&emsp;</span>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true">
            <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="起始时间">
        </div>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
            <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="结束时间">
        </div>
    </div>
    <div class="col-sm-4  heightCenter mT20">
        <div class="width100 text-right " style="margin-right: 10px;"><strong class="red"></strong>通店限制</div>
        <div class="clearfix cp h32 inputUnlimited mL10" >
            <input   type="number" inputnum min="0" value="" placeholder="通店次数"  name='times'   class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input style="width: 6px;" type="checkbox" value="" name="limit"> <i></i> 不限</label>
            </div>
        </div>
        <select  class="form-control cp w70  selectPd mL10" name="weeks">
            <option value="w">周</option>
            <option value="m">月</option>
        </select>
    </div>
    <div class="col-sm-4  heightCenter mT20">
        <div class="width100 text-right"><strong class="red"></strong>卡的等级</div>
        <select class="form-control cp w240 selectPd mL10"   name='times1'>
            <option value="1">普通卡</option>
            <option value="2">VIP卡</option>
        </select>
    </div>
    <div class="col-sm-4 heightCenter mT20 about">
        <div class="checkbox i-checks checkbox-inline t4">
            <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
        </div>
    </div>
    <div class="col-sm-4  heightCenter mT20">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'addValid')" data-remove="removeDiv">删除</button>
    </div>
</div>