<div   class="modal fade  bs-example-modal-sm addModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="bombBox">
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
                            <input ng-model="coachName" name="name" required ng-minlength="2" ng-maxlength="10" ng-pattern="/^[\u3400-\u9FFF]+$/"  class="form-control" type="text" placeholder="请输入教练名称" />
                             <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.required">
                                  <i class="fa fa-info-circle"></i>
                                    请输入姓名（2-10个中文字符）
                             </span>
                            <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.minlength || myForm.name.$error.maxlength || myForm.name.$error.pattern ">
                                 <i class="fa fa-info-circle"></i>
                                 姓名由2-10个中文字符组成
                            </span>
                            <select ng-model="venueId" name="venueId" required class="form-control cp" ng-change="getDepartment(venueId)">
                                <option value="">请选择场馆</option>
                                <option
                                    value="{{venue.id}}"
                                    ng-repeat="venue in optionVenue"
                                >{{venue.name}}</option>
                            </select>
                            <span ng-if="!venueId" class="text-danger help-block m-b-none">
                                <i class="fa fa-info-circle"></i>
                                请选择场馆
                              </span>
                            <select ng-model="depId" name="depId" required class="form-control cp" >
                                <option value="">请选择部门</option>
                                <option
                                    value="{{dep.id}}"
                                    ng-repeat="dep in Department"
                                >{{dep.name}}</option>
                            </select>
                            <span ng-if="!depId" class="text-danger help-block m-b-none">
                                <i class="fa fa-info-circle"></i>
                                请选择部门(选择场馆后完成此操作)
                            </span>
                            <input ng-model="position" name="position"
                                   ng-minlength="2" ng-maxlength="10" ng-pattern="/^[\u3400-\u9FFF]+$/"
                                   class="form-control" type="text" placeholder="请输入职位" />
                            <span class="text-danger help-block m-b-none" ng-show="myForm.position.$error.minlength || myForm.position.$error.maxlength || myForm.position.$error.pattern ">
                                 <i class="fa fa-info-circle"></i>
                                 请输入2-10个中文字符组成
                            </span>
                            <input ng-model="mobile" name="mobile" autocomplete="off" ng-pattern="/^1((3[0-9]|4[57]|5[0-35-9]|7[0678]|8[0-9])\d{8}$)/" class="form-control" inputnum type="number" placeholder="请输入手机号" />
<!--                            <span class="text-danger help-block m-b-none"  ng-show="myForm.mobile.$error.required">-->
<!--                                <i class="fa fa-info-circle"></i>-->
<!--                                请输入手机号(11位数字)-->
<!--                            </span>-->
                            <span class="text-danger help-block m-b-none" ng-show="myForm.mobile.$error.pattern ">
                                <i class="fa fa-info-circle"></i>
                                手机号 格式不正确
                            </span>
                            <input ng-model="email" name="email" autocomplete="off" class="form-control" type="email" placeholder="请输入邮箱" />
                             <span class="text-danger help-block m-b-none" ng-show="myForm.email.$error.email">
                                <i class="fa fa-info-circle"></i>
                                邮箱 格式不正确
                            </span>
                            <input ng-model="salary" name="salary" ng-pattern="/^[1-9]{1}\d{0,4}$/" class="form-control" type="number" inputnum placeholder="请输入薪资" />
                            <span class="text-danger help-block m-b-none" ng-show="myForm.salary.$error.pattern">
                                <i class="fa fa-info-circle"></i>
                                 薪资范围（1-99999）
                            </span>
                            <textarea ng-model="intro" style="resize: none;" class="form-control" name="" rows="10" cols="1" placeholder="个人详情介绍..."></textarea>
                            <div class="clearfix">
                                <a class="fr" href="">
                                    <div class="btn btn-success nextStep"
                                         ng-disabled="
                                                myForm.name.$dirty && myForm.name.$invalid ||
                                                myForm.venueId.$dirty && myForm.venueId.$invalid ||
                                                myForm.depId.$dirty && myForm.depId.$invalid ||
                                                myForm.position.$dirty && myForm.position.$invalid ||
                                                myForm.mobile.$dirty && myForm.mobile.$invalid ||
                                                myForm.email.$dirty && myForm.email.$invalid ||
                                                myForm.salary.$dirty && myForm.salary.$invalid ||
                                                myForm.name.$invalid || myForm.venueId.$invalid ||
                                                myForm.depId.$invalid || myForm.mobile.$invalid
                                             "
                                         ng-click="setCoachData()" style="width: 100px">添加</div></a>
                            </div>
                        </form>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

