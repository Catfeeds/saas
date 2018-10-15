<?php
use backend\assets\PersonalCenterAsset;
PersonalCenterAsset::register($this);
$this->title = '个人中心';
?>
<div ng-controller='personalCenterCtrl' ng-cloak xmlns="http://www.w3.org/1999/html">
    <div class="wrapper wrapper-content  animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default ">
                    <div class="panel-heading personalCenterHeading">
                        <div class="col-sm-6"><h3><b>个人资料</b></h3></div>
                        <div class="col-sm-6"><h3><b>修改密码</b></h3></div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6 header2" style="">
                            <div class="col-sm-5">
                                <div class="picBox">
                                    <div class="picBoxDiv1">
                                        <!--如果没有设置头像，就显示默认头像-->
                                        <img class="picImage" ng-src="{{listData.pic?listData.pic:'/plugins/checkCard/img/11.png'}}">
                                    </div>
                                    <p class="pFont">点击更换头像</p>
                                    <input id="_csrf" type="hidden"
                                           name="<?= \Yii::$app->request->csrfParam; ?>"
                                           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                                    <div class="input-file ladda-button btn ng-empty uploader" id="imgFlagClass"
                                         ngf-drop="uploadCover($file,'update')"
                                         ladda="uploading"
                                         ngf-select="uploadCover($file,'update')"
                                         ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                         ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                        <p class="addCss">+</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12" >
                                        <label for="name">姓名&#160:&#160</label><span>{{listData.name}}</span>
                                    </div>
                                </div>
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12  " >
                                        <label for="name">性别&#160:&#160</label><span ng-if="listData.sex != null">{{listData.sex == 1 ? "男":"女"}}</span>
                                    </div>
                                </div>
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12 " >
                                        <label for="name">权限&#160:&#160</label>{{listData.admin.role.name}}<span></span>
                                    </div>
                                </div>
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12 " >
                                        <label for="name">职务&#160:&#160</label><span >{{listData.position}}</span>
                                    </div>
                                </div>
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12 " >
                                        <label for="name">账号&#160:&#160</label><span>{{listData.username}}</span>
                                    </div>
                                </div>
                                <div class="input-group inputGroupMp">
                                    <div class="col-sm-12 " >
                                        <label for="name">手机号&#160:&#160</label><span>{{listData.mobile}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  " >
                            <div>
                                <div class=" col-sm-12 inputGroupMp">
                                    <div class="col-sm-5 labelTextAlign" >
                                        <label for="name"><span class="spanRed">*</span> 修改方式:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select class="form-control" style="width:179px;padding: 4px 12px" ng-model="selectValue">
                                            <option value="">旧密码修改</option>
                                            <option value="1">验证码修改</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12" ng-if="selectValue == ''">
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign" >
                                            <label for="oldPass"><span class="spanRed">*</span>旧密码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="oldPass" type="password" ng-pattern="/^[0-9a-zA-Z]{6,18}$/" required  ng-model="modifyPassword.oldPassword" class="form-control inputw" placeholder="请输入旧密码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign" >
                                            <label for="newPass"><span class="spanRed">*</span>新密码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="newPass" type="password" ng-pattern="/^[0-9a-zA-Z]{6,18}$/" required  ng-model="modifyPassword.newPassword" class="form-control inputw" placeholder="请输入新密码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign">
                                            <label for="againNewPass"><span class="spanRed">*</span>确认新密码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="againNewPass" type="password" ng-pattern="/^[0-9a-zA-Z]{6,18}$/" required  ng-model="modifyPassword.confirmTheNewPassword" class="form-control inputw" placeholder="请确认新密码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-success" ng-click="oldPasswordChanges()">确认修改</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" ng-if="selectValue == 1">
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign" >
                                            <label for="name"><span class="spanRed">*</span>手机号:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="name" type="text" ng-model="modifyPassword.cellPhoneNumber" class="form-control inputw" placeholder="请输入手机号">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-info" ladda="isParacontButtonClick" ng-click="newCode()" ng-model="paracont" ng-disabled="disabled">{{paracont}}</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign">
                                            <label for="name1"><span class="spanRed">*</span>验证码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="name1" type="number" min="0" ng-model="modifyPassword.verificationCode" class="form-control inputw" placeholder="请确认验证码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign" >
                                            <label for="name2"><span class="spanRed">*</span>新密码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="name2" type="password" ng-pattern="/^[0-9a-zA-Z]{6,18}$/" required  ng-model="modifyPassword.newPassword1" class="form-control inputw" placeholder="请输入新密码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5 labelTextAlign">
                                            <label for="name3"><span class="spanRed">*</span>确认新密码:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="name3" type="password" ng-pattern="/^[0-9a-zA-Z]{6,18}$/" required  ng-model="modifyPassword.confirmTheNewPassword1" class="form-control inputw" placeholder="请确认新密码">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inputGroupMp">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-7">
                                            <button type="button" class="btn btn-success" ng-click="validationCodeModification()">确认修改</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

