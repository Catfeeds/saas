
<!--
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/30
 * Time: 15:48
 content:页面新增和修改功能
 */-->
<!--新增页面-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center personalInster" id="myModalLabel">
                    添加员工
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group text-center personalRelative">
                    <center>
                        <strong class="personalSure">*</strong>
                        <input type="text" class="form-control actions" id="" ng-model="name"
                               ng-blur="addStaffBlur(name)" placeholder="请输入员工名称" ng-minlength="1"
                               ng-maxlength="10">
                    </center>
                </div>
                <div class="form-group text-center personalRelative">
                    <strong class='personalSure'>*</strong>
                    <select class="form-control actions personalColor MLR120" ng-model="venueId" name="venueId"
                            ng-change="getVenue(venueId)">
                        <option value="">请选择所属公司</option>
                        <option value="{{venue.id}}" ng-repeat="venue in optionVenue">{{venue.name}}</option>
                    </select>
                </div>
                <div class="form-group text-center personalRelative">
                    <strong class="personalSure">*</strong>
                    <select class="form-control actions personalColor MLR120" ng-model="depId" name="depId"
                            ng-change="getDepartment(depId)">
                        <option value="">请选择场馆</option>
                        <option value="{{dep.id}}" ng-repeat="dep in Department">{{dep.name}}</option>
                    </select>
                </div>
                <div class="form-group text-center personalRelative">
                    <strong class='personalSure'>*</strong>
                    <select class="form-control actions personalColor MLR120" ng-change="departmentChange(department)"  ng-model="department" name="department">
                        <option value="">请选择部门</option>
                        <option value="{{department.id}}" ng-repeat="department in departments">
                            {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group text-center personalRelative">
                    <center >
                        <strong style="" class="personalSure">*</strong>
                        <select id="selectedCustomAddId" class="form-control actions displayInline-block personalColor w150px" ng-model="position" name="status">
                            <option value="">请选择员工职位</option>
                            <option ng-selected="customAddId == w.id" data-ids="{{w.id}}" value="{{w.name}}" ng-repeat="w in getEmployeePositionData">{{w.name}}</option>
                        </select>
                        <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'ADDPOSITION')) { ?>
                            <button ng-disabled="customAddBool"  data-toggle="modal" data-target="#sellSource1" class="btn btn-primary btn-sm displayInline-block" ng-click="customAdd()">自定义</button>
                        <?php } ?>
                        <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'DELPOSITION')) { ?>
                            <button class="btn btn-danger btn-sm displayInline-block" ng-click="removeCustom()" style="margin-left: 10px;">删除</button>
                        <?php } ?>
                    </center>
                </div>
                <div class="form-group text-center personalRelative">
                    <strong class="personalSure">*</strong>
                    <select class="form-control actions personalColor MLR120" ng-model="status" name="status">
                        <option value="">请选择员工状态</option>
                        <option value="{{status.id}}" ng-repeat="status in statusArr">{{status.status}}</option>
                    </select>
                </div>
                <div class="form-group text-center personalRelative MLR120">
                    <input type="text" class="form-control actions"  placeholder="请输入别名" ng-model="alias">
                </div>
                <!-- jbq -->
                  <div class="form-group text-center personalRelative MLR120">
                    <input type="text" class="form-control actions"  placeholder="请输入作品地址" ng-model="work_url">
                </div>
                <!-- jbq -->
                <div class="form-group text-center personalRelative MLR120">
                    <input type="text" class="form-control actions"  inputnum placeholder="请输入薪资"
                           ng-model="salary" name="salary" ng-pattern="/^[1-9]{1}\d{0,4}$/">
                </div>
                   <span id="salary" class="text-danger help-block m-b-none" ng-show="myForm.salary.$error.pattern">
                       <i class="fa fa-info-circle"></i>薪资范围（1-99999）
                   </span>
                <div class="form-group text-center personalRelative MLR120">
                    <select class="form-control actions personalColor" ng-model="sex" name="sex">
                        <option value="">请选择性别</option>
                        <option value="{{sex.id}}" ng-repeat="sex in sexArr">{{sex.name}}</option>
                    </select>
                </div>
                <div class="form-group text-center personalRelative MLR120">
                    <input type="text" class="form-control actions" inputnum placeholder="请输入手机号"
                           ng-change="getMobile(mobile)" ng-model="mobile" name="mobile">
                </div>
                <div class="form-group text-center personalRelative MLR120">
                    <input type="text" class="form-control actions" placeholder="请输入身份证号"
                           ng-change="identityCardChange()" ng-model="identityCard">
                </div>
                <div class="form-group text-center date dateBox personalRelative MLR120 birthDate" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control actions" placeholder="请输入出生日期" ng-model="birthDate">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <div class="form-group text-center MLR120">
                    <input type="text" class="form-control actions"  inputnum placeholder="请输入课时/考核"
                           ng-model="classHour" name="classHour" ng-pattern="/^[1-9]{1}\d{0,4}$/">
                </div>
                   <span class="text-danger help-block m-b-none" ng-show="myForm.classHour.$error.pattern">
                       <i class="fa fa-info-circle"></i>课时范围（1-99999）
                   </span>
                <div class="form-group text-center MLR120">
                    <input type="text" class="form-control actions"  inputnum placeholder="请输入基础课量"
                           ng-model="classTime" name="classTime" ng-pattern="/^[1-9]{1}\d{0,4}$/">
                </div>
                   <span class="text-danger help-block m-b-none" ng-show="myForm.classTime.$error.pattern">
                       <i class="fa fa-info-circle"></i>基础课量范围（1-99999）
                   </span>
                <div class="form-group text-center MLR120">
                    <input type="text" class="form-control actions"  inputnum placeholder="请输入免费课量"
                           ng-model="classAmount" name="classAmount" ng-pattern="/^[1-9]{1}\d{0,4}$/">
                </div>
                    <span class="text-danger help-block m-b-none" ng-show="myForm.classAmount.$error.pattern">
                                <i class="fa fa-info-circle"></i>从业时间
                    </span>
                <div class="form-group text-center date dateBox MLR120" id="dateIndexAdd" data-date-format="yyyy-mm-dd" style="position: relative;">
                    <input type="text" class="form-control actions" placeholder="请输入从业时间" ng-model="work_time">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                    <span class="text-danger help-block m-b-none" ng-show="myForm.classAmount.$error.pattern">
                         <i class="fa fa-info-circle"></i>免费课量（1-99999）
                    </span>
                <div class="form-group text-center MLR120" style="position: relative;">
                    <textarea config="summernoteConfigs" style="resize: none;" summernote class="summernote" required ng-model="intro" id="textarea">
                              </textarea>
                    <!--                    <textarea style="border: solid 1px #cfdadd;resize: none;" ng-model="intro" class="form-control actions"  placeholder="请输入简介"   cols="40" rows="10"></textarea>-->
                </div>
                <!--                    <div style="position: relative;padding-top: 20px;">-->
                <!--                        <div class="form-group">-->
                <!--                            <img id="imgBoolTrue" ng-src="/plugins/personal/img/u2063.png" class='photo mL120W100H100 imgBoolTrue' style="width: 80px;height: 80px">-->
                <!--                            <img id="imgBoolFalse"  class='photo mL120W100H100  imgBoolFalse' style="width: 100px;height: 100px">-->
                <!--                        </div>-->
                <!--                        <div class="input-file"-->
                <!--                             style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px">-->
                <!--                            <p style="margin-left: 0px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;"-->
                <!--                               class="text-center">+</p>-->
                <!--                        </div>-->
                <!--                        <div id="fpRegisterDiv" data-toggle="modal" data-target="#myModalsVerification"  style="display: inline; height: 80px;width:80px;position: absolute;top: 20px;left: 295px;">-->
                <!--                            <a id="fpRegister"-->
                <!--                               onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'-->
                <!--                               title="请安装指纹驱动或启动该服务" class="showGray"-->
                <!--                               onmouseover="this.className='showGray'">注册</a>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <p class="personalPhoto ml117mb10">添加员工照片</p>
                <div class="form-group">
                    <img ng-if="pic == ''" ng-src="" class='photo mL120W100H100' style="width: 100px;height: 100px">
                    <img ng-if="pic != ''" ng-src="{{pic}}" class='photo mL120W100H100' style="width: 100px;height: 100px">
                </div>
                <div  data-toggle="modal"  id="btn1"
                      style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px">
                    <p style="margin-top: 5px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;"
                       class="text-center">+</p>
                </div>
            </div>
            <div class="modal-footer MLR120">
                <button style="width: 100px;" type="button" class="btn btn-success MLR120"
                        ng-disabled=" myForm.name.$dirty && myForm.name.$invalid ||  myForm.salary.$dirty && myForm.salary.$invalid ||myForm.name.$invalid "
                        ng-click="add()">
                    完成
                </button>
            </div>
        </div>
    </div>
</div>

<!--修改页面-->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <input type="hidden" value="{{EmployeeData.id}}" id="EmployeeId">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorRgb" id="myModalLabel">
                    修改员工信息
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group MLR120 rgbMl125">姓名</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions" ng-model="EmployeeData.name">
                </div>
                <div class="form-group MLR120 rgbMl125">公司</div>
                <div class="form-group MLR120 text-center">
                    <select class="form-control actions rgb153" ng-model="EmployeeData.companyId" name="venueId"
                            ng-change="getVenue(EmployeeData.companyId)">
                        <option value="{{venue.id}}" ng-repeat="venue in optionVenue">{{venue.name}}</option>
                    </select>
                </div>
                <div class="form-group MLR120 rgbMl125">场馆</div>
                <div class="form-group MLR120 text-center">
                    <select class="form-control actions rgb153" ng-model="EmployeeData.venueId" name="depId"
                            ng-change="getDepartment(EmployeeData.venueId)">
                        <option value="{{dep.id}}" ng-repeat="dep in Department">{{dep.name}}</option>
                    </select>
                </div>
                <div class="form-group MLR120 rgbMl125">部门</div>
                <div class="form-group MLR120 text-center">
                    <select class="form-control actions rgb153" ng-change="EmployeeDataOrganization(EmployeeData.organization_id)" ng-model="EmployeeData.organization_id"
                            name="department">
                        <option value="{{department.id}}" ng-repeat="department in departments">
                            {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group MLR120 rgbMl125">职位</div>
                <div class="form-group MLR120 text-center">
                    <select class="form-control actions rgb153" ng-model="EmployeeData.position"
                            name="department">
                        <option value="">请选择职位</option>
                        <option value="{{department.name}}" ng-repeat="department in getEmployeePositionData">
                            {{department.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group MLR120 rgbMl125">状态</div>
                <div class="form-group MLR120 text-center" style="position: relative;">
                    <select class="form-control actions rgb153" ng-model="EmployeeData.status" name="status">
                        <option value="">请选择员工状态</option>
                        <option value="{{status.id}}" ng-repeat="status in statusArr">{{status.status}}</option>
                    </select>
                </div>
                <div class="form-group MLR120 rgbMl125">别名</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions"  ng-model="EmployeeData.alias"
                           ng-minlength="2" ng-maxlength="10">
                </div>
                <!-- jbq -->
                <div class="form-group MLR120 rgbMl125">作品地址</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions"  ng-model="EmployeeData.work_url"
                          >
                </div>
                <!-- jbq -->
                <div class="form-group MLR120 rgbMl125">薪资</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions"  inputnum
                           ng-model="EmployeeData.salary">
                </div>
                <div class="form-group MLR120 rgbMl125">性别</div>
                <div class="form-group MLR120 text-center" style="position: relative;">
                    <select class="form-control actions rgb153" ng-model="EmployeeData.sex" name="sex">
                        <option value="">请选择性别</option>
                        <option value="{{sex.id}}" ng-repeat="sex in sexArr">{{sex.name}}</option>
                    </select>
                </div>
<!--                <div class="form-group MLR120 rgbMl125">年龄</div>-->
<!--                <div class="form-group MLR120 text-center">-->
<!--                    <input type="text" class="form-control actions" inputnum placeholder="请输入年龄"-->
<!--                            ng-model="EmployeeData.age">-->
<!--                </div>-->
                <div class="form-group MLR120 rgbMl125">身份证号</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions" placeholder="请输入身份证号"
                           ng-change="employeeIdentityCardChange()" ng-model="EmployeeData.identityCard">
                </div>
                <div class="form-group MLR120 rgbMl125">出生日期</div>
                <div class="form-group MLR120 text-center date dateBox birthDate" data-date-format="yyyy-mm-dd">
                    <input id="update_birth" type="text" class="form-control actions" placeholder="请输入出生日期" ng-model="EmployeeData.birth_time">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <div class="form-group MLR120 rgbMl125">手机号</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions" maxlength="11" placeholder="请输入手机号"
                               ng-change="getMobiles(EmployeeData.mobile)" ng-model="EmployeeData.mobile">
                </div>
                <div class="form-group MLR120 rgbMl125">课时/考核</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions"  inputnum
                           ng-model="EmployeeData.class_hour" ng-pattern="/^[1-9]{1}\d{0,4}$/">
                </div>
                    <span class="text-danger help-block m-b-none" ng-show="myForm.classHour.$error.pattern">
                        <i class="fa fa-info-circle"></i>
                        课时范围（1-99999）
                    </span>
                <div class="form-group MLR120 rgbMl125">基础课量</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions" id="classTime" inputnum ng-model="updateClassTime">
                </div>
                <div class="form-group MLR120 rgbMl125">免费课量</div>
                <div class="form-group MLR120 text-center">
                    <input type="text" class="form-control actions" id="classAmount" inputnum ng-model="updateClassAmount">
                </div>
                <div class="form-group MLR120 rgbMl125">请输入从业时间</div>
                <div class="form-group MLR120 text-center date dateBox" id="dateIndex" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control actions" ng-model="EmployeeData.work_date">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <div class="form-group MLR120 rgbMl125">简介</div>
                <div class="form-group MLR120 text-center">
                    <textarea config="summernoteConfigs" style="resize: none;" summernote class="summernote" required ng-model="EmployeeData.intro" id="textarea">
                              </textarea>
<!--                    <textarea style="border: solid 1px #cfdadd;resize: none;" ng-model="EmployeeData.intro" class="form-control actions" cols="40" rows="10"></textarea>-->
                </div>
                <!--        //指纹 不能删除-->
                <!--                    <div style="position: relative;padding-top: 20px;">-->
                <!--                        <div class="form-group">-->
                <!--                            <img id="imgBoolTrue" ng-src="/plugins/personal/img/u2063.png" class='photo mL120W100H100 imgBoolTrue' style="width: 80px;height: 80px">-->
                <!--                            <img id="imgBoolFalse"  class='photo mL120W100H100  imgBoolFalse' style="width: 100px;height: 100px">-->
                <!--                        </div>-->
                <!--                        <div class="input-file"-->
                <!--                             style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px">-->
                <!--                            <p style="margin-left: 0px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;"-->
                <!--                               class="text-center">+</p>-->
                <!--                        </div>-->
                <!--                        <div id="fpRegisterDiv2" data-toggle="modal" data-target="#myModalsVerification"  style="display: inline; height: 80px;width:80px;position: absolute;top: 20px;left: 295px;">-->
                <!--                            <a id="fpRegister2"-->
                <!--                               onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'-->
                <!--                               title="请安装指纹驱动或启动该服务" class="showGray"-->
                <!--                               onmouseover="this.className='showGray'">111</a>-->
                <!--                        </div>-->
                <!--                    </div>-->

                <div style="height: 50px;"></div>
                <div class="form-group textAlignCenter">
                    <img ng-if="EmployeeData.pic != ''" ng-src="{{EmployeeData.pic}}" width="100px" height="100px" style="margin-left: -198px">
                    <img ng-if="EmployeeData.pic == ''" ng-src="" width="100px" height="100px" style="margin-left: -198px">
                </div>
                <div data-toggle="modal"  id="btn2"
                     style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;top: -116px;left:63px;border: 1px solid #ccc">
                    <p style="margin-top: 5px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;" class="text-center">+</p>
                </div>
            </div>
            <div class="modal-footer MLR120">
                <button style="width: 100px;" type="button" class="btn btn-success MLR120"
                        ng-click="update()"
                        ng-disabled="myForm.name.$dirty && myForm.name.$invalid ||
                                     myForm.position.$dirty && myForm.position.$invalid ||
                                     myForm.name.$invalid">完成
                </button>
            </div>
        </div>
    </div>
</div>
<!--修改图片剪裁模态框-->
<div class="modal fade" id="cutPic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <input type="hidden" value="{{EmployeeData.id}}" id="EmployeeId">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorRgb" id="myModalLabel">
                    修改员工头像
                </h3>
            </div>
            <div class="modal-body">
                <div class="m-warp" id="warp">
                    <div class="item">
                        <input type="file"  id="fileInput" style="display: none">
                        <label  id="selectPic" for="fileInput">选择图片</label>
                    </div>
                    <div class="item clearfix">
                        <div class="col col-1">

                            <img-crop area-type="square" image="myImage" result-image="myCroppedImage"></img-crop>
                        </div>
                        <div class="thum col-2 col">
                            <p>预览</p>
                            <img class="showPic" ng-src="{{myCroppedImage}}" width="100px" height="100px" style="margin-left: -40px">
                            <p class="f-text-l f-marTop-20">
                                <button ng-click="uploadPic()" style="margin-left: -30px">确定头像</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--新增图片模态框-->
<div class="modal fade" id="addCutPic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <input type="hidden" value="{{EmployeeData.id}}" id="EmployeeId">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorRgb" id="myModalLabel">
                    添加员工头像
                </h3>
            </div>
            <div class="modal-body">
                <div class="m-warp" id="warp">
                    <div class="item">
                        <input type="file"  id="fileInput" style="display: none">
                        <label  id="selectPic" for="fileInput">选择图片</label>
                    </div>
                    <div class="item clearfix">
                        <div class="col col-1">

                            <img-crop area-type="square" image="myImage" result-image="myCroppedImage"></img-crop>
                        </div>
                        <div class="thum col-2 col">
                            <p>预览</p>
                            <img class="showPic" ng-src="{{myCroppedImage}}" width="100px" height="100px" style="margin-left: -40px">
                            <p class="f-text-l f-marTop-20">
                                <button ng-click="addPic()" style="margin-left: -30px">确定头像</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
