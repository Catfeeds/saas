<?php
use backend\assets\LeagueCtrlAsset;
LeagueCtrlAsset::register($this);
$this->title = '修改课程';
?>
<div  ng-controller = 'updateCourseCtrl' ng-cloak>
<section class="w60Auto animated fadeIn"  >
    <div class="ha_title">
        <h4>修改课程</h4></div>
    <!--ha_xz 选择-->
    <div class="ha_xz ">
        <div class="w40Auto">
            <form class="bgForm black" action="" method="post">
                <input  id="_csrf" type="hidden"
                       name="<?= \Yii::$app->request->csrfParam; ?>"
                       value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                <p style="text-align:left;width: 100%; ">课程名称</p>
                <input  type="hidden"  value="{{myItem.id}}"  id="groupClassId">
                <input type="hidden" value="{{myItem.class_date}}" id="classDate">
                <select class="form-control " name="" style="color: #000;" ng-model="myItem.course_id">
                    <option value="" disabled>--请选择--</option>
                    <option value="{{myCourse.id}}"    ng-repeat="myCourse in groupCourse">{{myCourse.name}}</option>
                </select>
                <p style="text-align:left;width: 100%; ">教练</p>
                <select class="form-control " name="" style="color: #000;"  ng-model="myItem.coach_id">
                    <option value="" disabled>--请选择--</option>
                    <option value="{{item.id}}"  ng-repeat="item in  coach" >{{item.name}}</option>
                </select>
                <p>
                <p ><a data-toggle="modal"  ng-click="bombBox()"   data-target=".addModal"><span class="glyphicon glyphicon-plus-sign" ></span>添加新的教练</a></p>
                </p>
                <div class="clearfix">
                    <p style="text-align:left;width: 50%; ">场馆</p>
                    <select style="color: #000;" class="form-control" name="请选择课种" ng-change="search()"   ng-model="myItem.venue_id" id="venue">
                        <option value="" disabled>--请选择--</option>
                        <option value="{{venue.id}}" ng-repeat="venue  in venues" >{{venue.name}}</option>
                    </select>
                    <p style="margin-left: 90px;position: relative;top: -18px;left:-142px ">教室</p>
                    <select style="color: #000;margin-top: -18px" class="form-control myClassroomId" id="myClassroomId" ng-model="myItem.classroom_id" ng-change="seat(myItem.classroom_id)">
                        <option value="" disabled>--请选择--</option>
                        <option value="{{classRoom.id}}"  ng-repeat="classRoom in myItem.classroom"  >{{classRoom.name}}</option>
                    </select>
                </div>
                <div style="position: relative" class="">
                    <p style="text-align:left;width: 50%; ">课程难度</p>
                    <select ng-model="myItem.difficulty" class="form-control " name="" style="width: 100%;color: #000;cursor: pointer;margin-bottom: 20px;">
                        <option value="" disabled>--请选择--</option>
                        <option value="3">高级</option>
                        <option value="2">中级</option>
                        <option value="1">初级</option>
                    </select>
                </div>
                <p style="text-align:left;width: 100%; ">课程介绍</p>
                <textarea class="form-control" name="" rows="" cols="20" style="resize: none;"   ng-model="myItem.desc" ></textarea>
                <p>添加课程图片</p>
                <div class="form-group">
                    <img ng-src="{{myItem.pic}}" width="100px" height="100px" ng-if="pic==null" style="margin-left: -360px">
                </div>
                <div class="form-group">
                    <img ng-src="{{pic}}" width="100px" height="100px" ng-if="pic!=null" style="margin-left: -360px">
                </div>
                <div class="input-file ladda-button btn ng-empty uploader"
                     style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left: -75px;margin-top:-136px"
                     ngf-drop="uploadCover($file,'update')"
                     ladda="uploading"
                     ngf-select="uploadCover($file,'update')"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                >
                    <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;" class="text-center">+</p>
                </div>
                <div id="addTime">
<!--                    <p style="text-align:left;width: 100%; ">课程排期</p>-->
<!--                    <div style="position: relative;margin: 10px 0 20px 0;" class="input-daterange input-group cp stratEnd  " >-->
<!--                        <input type="text"  class="input-sm form-control datetimeStart text-center" name="start" value="2017-04-10"  style="width: 42%;font-size: 13px;">-->
<!--                        <span>至</span>-->
<!--                        <input type="text"  class="input-sm form-control datetimeEnd text-center" name="end" value="2017-04-28" style="width: 42%;;font-size: 13px;">-->
<!--                    </div>-->
                    <p style="text-align:left;width: 100%; ">上课时间段</p>
                    <div class="stratEnd" style="margin: 10px 0 20px 0;">
                        <div class="input-group clockpicker fl" data-autoclose="true" style="width: 42%; ">
                            <input type="text"   ng-model="myItem.start"    class="input-sm form-control text-center"   style="width: 100%;border-radius: 3px;">
                        </div>
                        <span>至</span>
                        <div class="input-group clockpicker fl" data-autoclose="true" style="width: 42%; ">
                            <input type="text"   ng-model="myItem.end"   class="input-sm form-control text-center"   style="width: 100%;border-radius: 3px;">
                        </div>
                    </div>
                </div>
<!--                <p>-->
<!--                    <span id="addClassTimeQuantum" class="glyphicon glyphicon-plus-sign grey cp">&nbsp;新增上课时间段</span>-->
<!--                </p>-->
<!--                <div class="clearfix" >-->
<!--                    <div id="addSchedule" class="btn btn-default btn-lg fl">新增课程排期</div>-->
<!--                </div>-->

                <div class="preBack">
                    <span>课程开始前</span><input inputtext  ng-model="myItem.class_limit_time" class="form-control text-center" type="text" value="{{myItem.class_limit_time}}"/><span>不可预约课程</span>
                </div>

                <div class="preBack">
                    <span>课程开始前</span><input inputtext  ng-model="myItem.cancel_limit_time"  class="form-control text-center" type="text" value="{{myItem.cancel_limit_time}}" /><span>不可取消预约</span>
                </div>

                <div class="preBack">
                    <span>最少开课人数</span><input inputtext  ng-model="myItem.least_people"   type="text"  class="form-control text-center"  value="" /><span>最多人数{{myItem.total_seat}}人</span>
                </div>
                <div class="clearfix">
                    <div class="btn btn-primary backBut fl" style="width: 100px;">返回</div>
                    <div class="btn btn-success nextStep fr"  ng-click="update()" id="completeEdit"   style="width: 100px">完成</div>
                </div>
            </form>
        </div>
    </div>
</section>
<?=$this->render('addCoach');?>
</div>
