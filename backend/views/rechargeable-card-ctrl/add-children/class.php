<div class="clearfix removeDiv leagueCourseList123"  style="margin-top: 20px;">
    <div class="fl  w32" style="position: relative;">
        <span class="w80">课程名称&emsp;&emsp;</span>
        <select ng-change="selectClass(classKey<?=$num?>)" name="leagueCourseList" multiple="multiple" ng-model="classKey<?=$num?>" class="form-control cp leagueCourseList js-example-basic-multiple">
<!--            <option value="" >请选择课程</option>-->
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionClass"
                ng-disabled="venue.id | attrVenue:classArr1234"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="fl  w32">
        <span class="">每日节数&emsp;&emsp;</span>
        <div class="clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;margin-left: 15px;">
            <input  style="width: 130px;height: 100%;border: none;margin-left: 0;" type="number" inputnum min="0" name="times" placeholder="0节" class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline tF2" style="top: 4px;position: relative;">
                <label>
                    <input type="checkbox" value="-1"> <i></i> 不限</label>
                <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'class')"  class="btn btn-white removeHtml"  data-remove="removeDiv" style="position: absolute;top: -6px;right: -70px;">删除</button>
            </div>
        </div>
    </div>
</div>