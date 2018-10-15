<div class=" inputBox2 removeDiv">
    <div class="form-group divs1" style="margin-top: 20px;">
        <label style="font-weight: normal;margin-right: 20px;"><span class="red">*</span>选择场馆</label>
        <select ng-change="selectApply(applyId<?=$num;?>)" ng-model="applyId<?=$num;?>" class="form-control">
            <option value="">请选择场馆</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionApply"
                ng-disabled="venue.id | attrVenue:applyHttp"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="form-group divs2 oneStepXianZhi" style="margin-left: 111px;">
        <div class="input-group clockpicker fl cp w90" style="margin-top: 5px;"><span>进馆时间</span></div>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true">
            <input name="applyStart" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="起始时间">
        </div>
        <div class="input-group clockpicker fl cp w90" data-autoclose="true" style="margin-left: 15px;">
            <input name="applyEnd" type="text" class="input-sm form-control text-center borderRadius3 wB100" placeholder="结束时间">
        </div>
    </div>
    <div class="form-group inputUnlimited currencyTime month" style="margin-top: 20px;margin-left: 60px;position: relative;border: none;">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;"><span class="red">*</span>通店限制</label>
        <input type="number" inputnum min="0" class="form-control" name="currencyTimes" id="exampleInputName3" style="padding-top: 4px; width: 166px;display: inline-block;padding-right: 70px;border: 1px solid #ccc!important;" placeholder="通店次数">
        <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 0px;left: 200px;">
            <label style="margin-left: -30px;"><input style="width: 2px;" type="checkbox" value="-1">不限</label>
            <select  class="form-control cp w70 mL16 " name="weeks">
                <option value="w">周</option>
                <option value="m">月</option>
            </select>
        </div>
    </div>
<!--    <div class="form-group inputUnlimited currencyTimes" style="margin-top: 20px;margin-left: 60px;position: relative;border: none;">-->
<!--        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;">每周通店限制</label>-->
<!--        <input type="number" inputnum min="0" class="form-control" name="currencyTimesr" id="exampleInputName3" style="padding-top: 4px; width: 166px;display: inline-block;padding-right: 70px;border: 1px solid #ccc!important;" placeholder="通店次数">-->
<!--        <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">-->
<!--            <label><input type="checkbox" value="-1">不限</label>-->
<!--        </div>-->
<!--    </div>-->
    <div class="form-group divs2 inputUnlimited" style="margin-left:111px;margin-top: 20px;position: relative;border: none;">
        <label for="exampleInputName3" style="margin-left: 0; font-size: 13px;font-weight: normal;color: #333;"><span class="red">*</span>卡的等级</label>
        <select class="form-control cp"   name='times1' style="margin-left: 20px;">
            <option value="1">请选择等级</option>
            <option value="1">普通卡</option>
            <option value="2">VIP卡</option>
        </select>
        <button type="button" ng-click="removeVenueId(applyId<?=$num;?>,'apply')"  class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: -66px;">删除</button>
    </div>
    <div class="form-group divs2 oneStepXianZhi" style="margin-left: 75px;">
        <div class="checkbox i-checks checkbox-inline t4">
            <label><input style="width: 6px;" type="checkbox" name="aboutLimit">预约团课时，不受团课预约设置限制</label>
        </div>
    </div>
</div>