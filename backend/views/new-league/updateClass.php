<!--      新增课程修改-->
<div class="modal fade" id="amendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;">
    <div class="modal-dialog width80" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close closeBtnModal1" ng-click="amendModal()" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title textAlignCenter" id="myModalLabel">修改课程</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 pd0">
                    <b>1.课程属性和详情</b>
                </div>
                <div class="col-sm-12 mt20">
                    <div class="col-sm-4">
                        <span class="formGroupColor">*</span>课种分类
                        <select class="form-control actions actions1 actionsV" style="display: inline-block;margin-top: 0;margin-left: 0;width: 200px;"
                                ng-change="classCurriculuminitChange(classChangid)" ng-model="classChangid">
                            <option value="0">顶级分类</option>
                            <option value="{{w.id}}" ng-repeat="w in updateInitSectle.select">{{w.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <span class="formGroupColor">*</span>课程名称
                        <input type="text" class="form-control actions actionsV" style="display: inline-block;width: 200px;"
                               ng-model="updateInitSectle.courseData.name">
                    </div>
                    <div class="col-sm-4">
                        <span class="formGroupColor">*</span>课程时长
                        <span class="glyphicon glyphicon-info-sign" ng-if="inputWarningTips1" style="color:red;">必须输入大于零的分钟数！</span>
                        <input type="text" id="inputCheck" style="display: inline-block;width: 200px;" class="form-control actions actionsV"
                               ng-model="updateInitSectle.courseData.course_duration" placeholder="请输入大于零的分钟数" inputnum>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-top: 20px">
                    <div class="col-sm-4">
                        <span class="formGroupColor">*</span>课程难度
                        <select name="" id="" class="form-control actions actionsV pt4" style="display: inline-block;width: 200px;"
                                ng-model="updateInitSectle.courseData.course_difficulty">
                            <option value="1">初学</option>
                            <option value="2">进阶</option>
                            <option value="3">强化</option>
                        </select>
                    </div>
                    <div class="col-sm-8 w1280select2w">
                        <span class="formGroupColor">*</span>选择教练
                        <select id="userHeader2" class="form-control fl cardStatus userHeader1" style="display: inline-block;"
                                ng-model="cardStatusUpdate" multiple="multiple">
                            <option ng-repeat="w in ChangeCoachsmyModals1" value="{{w.id}}">{{w.name}}
                            </option>
                        </select>
                        <!--                            <div>-->
                        <!--                                <div class="col-sm-1" style="padding: 0;">-->
                        <!--                                </div>-->
                        <!--                                <div class="col-sm-10">-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                    </div>
                </div>
                <div class="col-sm-12 mt20" style="padding-left: 30px;">
                    &nbsp;课程介绍
                    <textarea style="resize: none;width: 57%;margin-top: 20px;margin-left: 0;" rows="4"
                              class="form-control courseIntroduction"
                              ng-model="updateInitSectle.courseData.course_desrc"></textarea>
                    <!--                        <div class="col-sm-6">-->
                    <!---->
                    <!--                        </div>-->
                </div>
                <div class="col-sm-12 addImage" style="padding-left: 25px;margin-top: 10px;">
                    添加照片
                    <div class="form-group">
                        <img class="w100h100 ml80" ng-src="{{updateInitSectle.courseData.pic?updateInitSectle.courseData.pic:'/plugins/class/img/22.png'}}">
                        <div class="input-file ladda-button btn ng-empty uploader w100h100 border1"
                             ngf-drop="uploadCover($file,'update')" ladda="uploading"
                             ngf-select="upload($file,'update')"
                             ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                             ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                             style="margin-left: 8%;">
                            <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;"
                               class="text-center">+</p>
                        </div>
                    </div>
                </div>
                <div class="ibox-content p0tf">
                    <span class="btn btn-success btn text-right mt20" ng-click="reviseTheCourse()">完成</span>
                </div>
            </div>
        </div>
    </div>
</div>