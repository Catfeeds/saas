<div class="inputBox3 removeDiv">
    <div class="form-group" style="margin-top: 10px;">
        <label for="exampleInputName2" style="font-size: 13px;font-weight: normal;color: #333;">课程名称</label>
        <select multiple="multiple" name="leagueCourseList" ng-change="selectClass(classKey<?=$num?>)" ng-model="classKey<?=$num?>" class="form-control twoStepClass leagueCourseList" style="margin-left: 20px;padding-top: 4px; width: 180px;">
<!--            <option value="">请选择课程</option>-->
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionClass"
                ng-disabled="venue.id | attrVenue:classHttp"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="form-group inputUnlimited" style="margin-top: 10px;margin-left: 60px;position: relative;border: none;">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block">每日节数</label>
        <input type="number" inputnum min="0" name="leagueTimes" class="form-control" id="exampleInputName3" style="margin-left: 20px;padding-top: 4px; width: 180px;display: inline-block;padding-right: 70px;border: solid 1px #ccc !important;" placeholder="0节">
        <div class="checkbox i-checks checkbox-inline"  style="position: absolute; top: 4px;left: 200px;">
            <label><input type="checkbox" value="-1">不限</label>
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'class')"  class="btn btn-white removeHtml"  data-remove="removeDiv" style="position: absolute;top: -6px;right: 175px;">删除</button>
        </div>
    </div>
</div>