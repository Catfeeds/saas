<!--/***-->
<!-- * Created by PhpStorm.-->
<!-- * User: DELL-->
<!-- * Date: 2017/12/28-->
<!-- * Time: 10:25-->
<!-- **/-->
<div class="col-sm-12 changeBasicAttrAllDiv allCourse ptServerBoxEdit removeDiv">
    <div class="col-sm-4 col-xs-6 mt20">
        <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>选择课种：</div>
        <div class="col-sm-8 col-xs-8 pd0">
            <select  name="courseId" id="" class="form-control selectPadding" ng-click="oldCourseIdArrClick()">
                <option value="">请选择</option>
                <option title="{{course.name}}" ng-repeat="course in allCourseData"
                        ng-disabled="course.id | attrVenue:oldCourseIdArr123"
                        value="{{course.id}}">{{course.name |cut:true:8:'...'}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 mt20">
        <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>课程时长：</div>
        <div class="col-sm-8 col-xs-8 pd0">
            <input  name="courseLength"placeholder="分钟" type="number" class="form-control">
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 mt20">
        <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>课程节数：</div>
        <div class="col-sm-8 col-xs-8 pd0">
            <input  name="courseNum" placeholder="节" type="number" class="form-control">
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 mt20">
        <div class="col-sm-4 col-xs-4 pd0"><span class="red">*</span>单节原价：</div>
        <div class="col-sm-8 col-xs-8 pd0">
            <input  name="originalPrice" placeholder="元" type="number" class="form-control">
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 mt20">
        <div class="col-sm-4 col-xs-4 pd0">移动端单节原价：</div>
        <div class="col-sm-8 col-xs-8 pd0">
            <input  name="appOriginalPrice" placeholder="元" type="number" class="form-control">
        </div>
    </div>
    <div class="col-sm-4 col-xs-6 mt20">
        <button class="btn btn-default btn-sm removeHtml" data-remove="removeDiv">删除</button>
    </div>
</div>