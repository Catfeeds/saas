<?php
use backend\assets\LeagueAddCourseCtrlAsset;
LeagueAddCourseCtrlAsset::register($this);
$this->title = '新增课程';
?>
<div ng-controller="groupClassCtrl" ng-cloak>
<div class="wrapper wrapper-content animated fadeIn" >
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>新增课程向导</h5>
                </div>
                <div class="ibox-content" style="min-height: 630px" >
                    <div id="example-async"  >
                        <h3 class="btn btn-success">第一步</h3>
                        <section class="w60Auto "  >
                            <div class="ha_title">
                                <h4 style="margin-top:-13px">新增课程</h4>
                            </div>
                            <!--ha_xz 选择-->
                            <div class="ha_xz con1" >
                                <div class="w40Auto" id="oneFormGuide">
                                    <form action="" method="post">
                                        <input id="_csrf"  type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                        <div style="position: relative">
                                            <strong class="strongRed">*</strong>
                                            <select ng-if="classStauts == true" ng-model="$parent.className"  class="form-control cp" style="width: 100%;">
                                                <option value="" >请选择课程</option>
                                                <option
                                                    value="{{venue.id}}"
                                                    ng-repeat="venue in optionClass"
                                                >{{venue.name}}</option>
                                            </select>
                                            <select ng-if="classStauts == false" class="form-control cp" style="width: 100%;">
                                                <option value="" >请选择课程</option>
                                                <option value="" disabled style="color:red;">{{optionClass}}</option>
                                            </select>
                                        </div>
                                        <div style="position: relative">
                                            <strong  class="strongRed">*</strong>
                                            <select  ng-if="coachStauts == true" ng-model="$parent.coachId" class="form-control darkGrey" name="" style="width: 100%;cursor: pointer">
                                                <option value="" >请选择教练</option>
                                                <option value="{{item.id}}"  ng-repeat="item in  classCoach" >{{item.name}}</option>
                                            </select>
                                            <select ng-if="coachStauts == false" class="form-control darkGrey" name="" style="width: 100%;cursor: pointer">
                                                <option value="" >请选择教练</option>
                                                <option value="" disabled style="color:red;">{{classCoach}}</option>
                                            </select>
                                        </div>
                                        <p ><a data-toggle="modal" data-target=".addModal"><span class="glyphicon glyphicon-plus-sign" ></span>添加新的教练</a></p>
                                        <div class="clearfix" style="position: relative;margin-bottom: 30px; " >
                                            <strong  style="position: absolute; top: 10px;left: -10px;font-size: 16px;color: red;">*</strong>
                                            <select ng-if="VenueStauts == true" ng-model="$parent.venueId" class="form-control cp" ng-change="search(venueId)">
                                                <option value="">请选择场馆</option>
                                                <option
                                                    value="{{venue.id}}"
                                                    ng-repeat="venue in optionVenue"
                                                >{{venue.name}}</option>
                                            </select>
                                            <select ng-if="VenueStauts == false" class="form-control cp">
                                                <option value="">请选择场馆</option>
                                                <option value="" disabled style="color:red;">{{optionVenue}}</option>
                                            </select>
                                            <select ng-if="classRoomStauts == true" ng-model="$parent.classroom" ng-change="setTotalSeat(classroom)" class="form-control darkGrey" name="" style="cursor: pointer">
                                                <option value="">请选择教室</option>
                                                <option value="{{room}}"
                                                        ng-repeat="room in classRoom"
                                                        ng-init="totalSeat"
                                                >{{room.name}}</option>
                                            </select>
                                            <select  ng-if="classRoomStauts == false"  class="form-control darkGrey" name="" style="cursor: pointer">
                                                <option value="">请选择教室</option>
                                                <option value="" disabled style="color:red;">{{classRoom}}</option>
                                            </select>
                                        </div>
                                        <div style="position: relative">
                                            <strong  class="strongRedNone">*</strong>
                                            <select ng-model="difficulty" class="form-control darkGrey" name="" style="width: 100%;cursor: pointer;position: absolute;top:-10px;">
                                                <option value="" ng-selected>课程难度</option>
                                                <option value="1">初级</option>
                                                <option value="2">中级</option>
                                                <option value="3">高级</option>
                                            </select>
                                        </div>
                                        <div style="position: relative">
                                            <textarea ng-model="desc" class="form-control" name="" style="resize: none;" rows="" cols="2" placeholder="请输入课程介绍" style="position: relative;top: 20px;left: -1px"></textarea>
                                        </div>
                                            <p>添加课程图片</p>
                                        <div class="form-group" style="text-align: center;">
                                            <img ng-src="{{pic}}" width="70px" height="70px">
                                        </div>
                                        <div class="input-file"
                                             style="margin: 20px 0px 20px 0;width: 100px;height: 100px;position: relative; cursor: pointer"
                                             ngf-drop="setCover($file)"
                                             ladda="uploading"
                                             ngf-select="setCover($file)"
                                             ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                             ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                        >
                                            <p style="width: 100%;height: 100%;line-height: 72px;font-size: 50px;" class="text-center">+</p>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </section>
                        <h3 >第二步</h3>
                        <section class="w60Auto">
                            <div class="ha_title">
                                <h4>新增时间段</h4></div>
                            <!--ha_xz 选择-->
                            <div class="ha_xz con1" >
                                <div class="w40Auto">
                                    <form class="bgForm" action="" method="post" id="timeForm">
                                        <div id="addTime">
                                            <div class="groupAddDate">
                                                <div>
                                                    <p style="text-align:left;width: 100%; ">课程排期</p>
                                                    <div style="position: relative;margin: 10px 0 20px 0;" class="input-daterange input-group cp stratEnd " >
                                                        <input  type="text"  class="input-sm form-control datetimeStart text-center" name="start" placeholder="起始日期"  style="width: 42%;font-size: 13px;">
                                                        <span>至</span>
                                                        <input type="text"  class="input-sm form-control datetimeEnd text-center" name="end" placeholder="结束日期" style="width: 42%;;font-size: 13px;">
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <p style="text-align:left;width: 100%; ">上课时间段</p>
                                                    <div class="stratEnd groupTime" style="margin: 10px 0 20px 0;">
                                                        <div class="input-group clockpicker fl" data-autoclose="true" style="width: 42%; ">
                                                            <input  type="text" class="input-sm form-control text-center start"  placeholder="请选择时间" style="width: 100%;border-radius: 3px;">
                                                        </div>
                                                        <span>至</span>
                                                        <div class="input-group clockpicker fl" data-autoclose="true" style="width: 42%; ">
                                                            <input  type="text" class="input-sm form-control text-center end"  placeholder="请选择时间" style="width: 100%;border-radius: 3px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p>
                                            <span id="addClassTimeQuantum" class="glyphicon glyphicon-plus-sign grey cp">&nbsp;新增上课时间段</span>
                                        </p>
                                        <div class="clearfix" >
                                            <div id="addSchedule" class="btn btn-default btn-lg fl">新增课程排期</div>
                                        </div>
                                        <div class="preBack">
                                            <span>课程开始前</span><input ng-model="classLimitTime" inputnum class="form-control text-center" type="number" min="0" placeholder="分钟" /><span>不可预约课程</span>
                                        </div>

                                        <div class="preBack">
                                            <span>课程开始前</span><input ng-model="cancelLimitTime" inputnum class="form-control text-center" type="number" min="0" placeholder="分钟" /><span>不可取消预约</span>
                                        </div>

                                        <div class="preBack">
                                            <span>最少开课人数</span><input ng-model="leastPeople" inputnum class="form-control  text-center" type="number" min="0" placeholder="位" /><span>最多人数{{totalSeat}}人</span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--添加新教练-->
<div   class="modal fade  bs-example-modal-sm addModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div  class="modal-dialog modal-sm" role="document" id="mutaikuang" >
        <div class="modal-content clearfix"  >
            <p  class="clearfix"><span class="glyphicon glyphicon-remove cp fr" data-toggle="modal" data-target=".addModal" style="padding: 5px;font-size: 20px;"></span></p>
            <section class="w60Auto animated fadeIn" style="width: 100%;">
                <div class="ha_title">
                    <h4>添加新教练</h4></div>
                <!--ha_xz 选择-->
                <div class="ha_xz " >
                    <div class="w40Auto " id="addClassForm" style="width: 100%;\text-align: left;">
                        <form action="" method="post" name="myForm">
                            <div class="pictureUpload" ><span class="glyphicon glyphicon-user"></span></div>
                            <input ng-model="coachName" autocomplete="off" name="name" required ng-minlength="2" ng-maxlength="10" ng-pattern="/^([\u3400-\u9FFF]+)+|([a-zA-Z]+)+$/"  class="form-control" type="text" placeholder="请输入教练名称" />
                             <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.required">
                                  <i class="fa fa-info-circle"></i>
                                    请输入姓名（2-10个全中文字符或者全英文字符）
                             </span>
                            <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.minlength || myForm.name.$error.maxlength || myForm.name.$error.pattern">
                                 <i class="fa fa-info-circle"></i>
                                 姓名由2-10个全中文字符或者全英文字符
                            </span>
                            <select ng-if="VenueStauts == true" ng-model="$parent.venueIds" name="venueId" required class="form-control cp" ng-change="getDepartment(venueIds)">
                                <option value="">请选择场馆</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionVenue"
                                >{{venue.name}}</option>
                            </select>
                            <select ng-if="VenueStauts == false"class="form-control cp" name="venueId" >
                                <option value="">请选择场馆</option>
                                <option value="" disabled style="color:red;">{{optionVenue}}</option>
                            </select>
                            <span ng-if="!venueIds" class="text-danger help-block m-b-none" >
                                <i class="fa fa-info-circle"></i>
                                请选择场馆
                              </span>
                            <select ng-if="departmentStauts == true" ng-model="$parent.depId" name="depId" required class="form-control cp" >
                                <option value="">请选择部门</option>
                                <option
                                    value="{{dep.id}}"
                                    ng-repeat="dep in Department"
                                >{{dep.name}}</option>
                            </select>
                            <select ng-if="departmentStauts == false" class="form-control cp" name="depId">
                                <option value="">请选择部门</option>
                                <option value="" disabled style="color:red;">{{Department}}</option>
                            </select>
                            <span ng-if="!depId" class="text-danger help-block m-b-none">
                                <i class="fa fa-info-circle"></i>
                                请选择部门
                            </span>
                            <input ng-model="position" name="position"
                                   ng-minlength="2" ng-maxlength="10" ng-pattern="/^[\u3400-\u9FFF]+$/"
                                   class="form-control" type="text" placeholder="请输入职位" />
                            <span class="text-danger help-block m-b-none" ng-show="myForm.position.$error.minlength || myForm.position.$error.maxlength || myForm.position.$error.pattern ">
                                 <i class="fa fa-info-circle"></i>
                                 请输入2-10个中文字符组成
                            </span>
                            <input ng-model="mobile" name="mobile" ng-change="getMobile(mobile)" autocomplete="off" ng-pattern="/^1((3[0-9]|4[57]|5[0-35-9]|7[0678]|8[0-9])\d{8}$)/" class="form-control" inputnum type="number" placeholder="请输入手机号" />
<!--                            <span class="text-danger help-block m-b-none"  ng-show="myForm.mobile.$error.required">-->
<!--                                <i class="fa fa-info-circle"></i>-->
<!--                                请输入手机号(11位数字)-->
<!--                            </span>-->
                            <span class="text-danger help-block m-b-none" ng-show="myForm.mobile.$error.pattern ">
                                <i class="fa fa-info-circle"></i>
                                手机号 格式不正确
                            </span>
                            <span class="text-danger help-block m-b-none" ng-show=" myForm.mobile.$valid && (mobileInfo == true)">
                                <i class="fa fa-info-circle"></i>
                                手机号 已经存在
                            </span>
                            <input ng-model="email" name="email" autocomplete="off" class="form-control" type="email" placeholder="请输入邮箱" ng-pattern="/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/" />
                             <span class="text-danger help-block m-b-none" ng-show="myForm.email.$error.email || myForm.email.$error.pattern">
                                <i class="fa fa-info-circle"></i>
                                邮箱 格式不正确
                            </span>
                            <input ng-model="salary" name="salary" ng-pattern="/^[1-9]{1}\d{0,4}$/" class="form-control" type="number" inputnum placeholder="请输入薪资" />
                            <span class="text-danger help-block m-b-none" ng-show="myForm.salary.$error.pattern">
                                <i class="fa fa-info-circle"></i>
                                 薪资范围（1-99999）
                            </span>
                            <textarea ng-model="intro" class="form-control" name="desc" style="resize: none;" rows="10" ng-pattern="/^.{1,199}$/" cols="1" placeholder="个人详情介绍..."></textarea>
                             <span class="text-danger help-block m-b-none" ng-show="myForm.desc.$error.pattern">
                                <i class="fa fa-info-circle"></i>
                                 内容过多
                            </span>
                            <div class="clearfix">
                                <a class="fr" href="">
                                    <div class="btn btn-success nextStep"
                                         ng-disabled="
                                                myForm.name.$dirty && myForm.name.$invalid ||
                                                myForm.venueId.$dirty && myForm.venueId.$invalid || VenueStauts == false ||
                                                myForm.depId.$dirty && myForm.depId.$invalid || departmentStauts == false ||
                                                myForm.position.$dirty && myForm.position.$invalid ||
                                                myForm.mobile.$dirty && myForm.mobile.$invalid ||
                                                myForm.email.$dirty && myForm.email.$invalid ||
                                                myForm.salary.$dirty && myForm.salary.$invalid ||
                                                myForm.desc.$dirty && myForm.desc.$invalid ||
                                                myForm.name.$invalid || myForm.venueId.$invalid ||
                                                myForm.depId.$invalid || myForm.mobile.$invalid ||mobileInfo == true
                                             "
                                         ng-click="  myForm.name.$dirty && myForm.name.$invalid ||
                                                myForm.venueId.$dirty && myForm.venueId.$invalid || VenueStauts == false ||
                                                myForm.depId.$dirty && myForm.depId.$invalid || departmentStauts == false ||
                                                myForm.position.$dirty && myForm.position.$invalid ||
                                                myForm.mobile.$dirty && myForm.mobile.$invalid || mobileInfo == true ||
                                                myForm.email.$dirty && myForm.email.$invalid ||
                                                myForm.salary.$dirty && myForm.salary.$invalid ||
                                                myForm.desc.$dirty && myForm.desc.$invalid ||
                                                myForm.name.$invalid || myForm.venueId.$invalid ||
                                                myForm.depId.$invalid || myForm.mobile.$invalid|| setCoachData()" style="width: 100px">添加</div></a>
                            </div>
                        </form>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>



