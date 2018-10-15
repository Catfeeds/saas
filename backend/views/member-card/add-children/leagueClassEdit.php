
<!--卡种管理团课课程修改模板-->
<div class="col-sm-12 pdLR0 addLeagueCourseBox removeDiv">
    <div class="col-sm-5  heightCenter mT20">
        <span class="width100 text-right " style="margin-right: 10px;">课程名称</span>
        <select ng-change="selectClass(classKey<?=$num?>)" name="leagueCourseList" multiple="multiple" ng-model="classKey<?=$num?>" class="form-control cp newLeagueCourseList leagueCourseList js-example-basic-multiple"style="max-height: 60px !important;overflow-y: scroll; ">
            <!--            <option value="" >请选择课程</option>-->
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionClass"
                ng-disabled="venue.id | attrVenue:classArr1234"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="col-sm-5  heightCenter mT20">
        <span class="width100 text-right" style="margin-right: 10px;">每日节数</span>
        <div class=" cp h32 inputUnlimited unDivBorder" >
            <input   type="number" inputnum min="0" name="times" placeholder="0节" class=" form-control pT0 unDivBorderInput w200">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input type="checkbox" value="-1"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2  heightCenter mT20">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removeDiv">删除</button>
    </div>
</div>