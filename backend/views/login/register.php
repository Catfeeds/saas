<?php
use backend\assets\LoginCtrlAsset;
LoginCtrlAsset::register($this);
$this->title = '用户注册';
?>

<!--/**-->
<!--* @云运动 - 后台 - 注册-->
<!--* @author Zhu Mengke <zhumengke@itsports.club>-->
<!--* @create 2017/3/29-->
<!--* @inheritdoc-->
<!--*/-->
<div style="width: 100%;overflow-y: scroll;">
    <div style="color:#35c3c1;margin-bottom: 10px;text-align: center;"><span style="font-size: 18px;color:#fff">幸福里智能健身管理平台</span> | <span >注册</span></div>
    <div ng-controller = 'resCtrl' ng-cloak >

        <form class='login-forms center-block' name="resForm"  style="text-indent: 2px;" ng-submit="SignUpForm()">
            <input ng-model="res._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
            <div class="flex-row" style="margin-top: 0;">
                <input id="username"
                       class='lf--input'
                       placeholder='用户名'
                       type='text'
                       name="formUsername"
                       ng-model="res.username"
                       ng-pattern="/^\w{3,18}$/"
                       required/>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;margin-top: 10px;" ng-show="resForm.formUsername.$dirty && resForm.formUsername.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="resForm.formUsername.$error.required">用户名不能为空！</span>
                <span ng-show="!resForm.formUsername.$error.required">请输入3到18位的数字字母下划线！</span>
            </b>
            <div class="flex-row">
                <input id="mobile"
                       class='lf--input'
                       placeholder='手机号'
                       type='text'
                       name="formMobile"
                       ng-model="res.mobile"
                       ng-pattern="/^1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}$/"
                       required/>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;" ng-show="resForm.formMobile.$dirty && resForm.formMobile.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="resForm.formMobile.$error.required">手机号不能为空！</span>
                <span ng-show="!resForm.formMobile.$error.required">请输入正确的手机号！</span>
            </b>
            <div class="flex-row" style="margin-bottom: 10px;">
                <input id="number"
                       class='lf--input c-input rightTopB-radius'
                       placeholder='输入验证码'
                       type='text'
                       name="formCode"
                       ng-model="res.code"
                       required/>
                <button class="lf--input c-input leftTopB-radius" type="button" ng-click="newCode()" ng-bind="paracont" ng-disabled="disabled" ladda="isRigisterCodeButtonClick">获取验证码</button>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;" ng-show="resForm.formCode.$dirty && resForm.formCode.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="!resForm.formCode.$error.required">请输入接收到的验证码！</span>
                <span ng-show="resForm.formCode.$error.required">验证码不能为空！</span>
            </b>
            <div class="flex-row" style="margin-top: 35px;">
                <input id="name"
                       class='lf--input'
                       placeholder='真实姓名'
                       type='text'
                       name="formName"
                       ng-model="res.name"
                       ng-pattern="/^(([\u4e00-\u9fa5]{2,4})|([a-zA-Z]{2,12}))$/"
                       required/>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;" ng-show="resForm.formName.$dirty && resForm.formName.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="resForm.formName.$error.required">姓名不能为空！</span>
                <span ng-show="!resForm.formName.$error.required">请输入正确的姓名！</span>
            </b>
            <!--    公司-->
            <div class="flex-row">
                <select class="lf--input" name="formCompany_id_id" ng-model="res.company_id" ng-change="getVenue(res.company_id)">
                    <option value="">请选择公司</option>
                    <option ng-repeat="x in company" value="{{x.id}}">{{x.name}}</option>
                </select>
            </div>
            <!--    场馆-->
            <div class="flex-row">
                <select class="lf--input" name="formVenue_id" ng-model="res.venue_id" ng-change="getDepartment(res.venue_id)">
                    <option value="">请选择场馆</option>
                    <option ng-repeat="x in venues" value="{{x.id}}">{{x.name}}</option>
                </select>
            </div>
            <div class="flex-row">
                <select class="lf--input" name="formOrganization_id" ng-model="res.organization_id">
                    <option value="">请选择部门</option>
                    <option ng-repeat="x in records" value="{{x.id}}">{{x.name}}</option>
                </select>
            </div>
            <div class="flex-row">
                <input id="password"
                       class='lf--input'
                       placeholder='新密码'
                       type='password'
                       name="formPassword"
                       ng-model="res.password"
                       ng-pattern="/^[0-9a-zA-Z]{6,18}$/"
                       required/>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;" ng-show="resForm.formPassword.$dirty && resForm.formPassword.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="resForm.formPassword.$error.required">密码不能为空！</span>
                <span ng-show="!resForm.formPassword.$error.required">请输入6到18位的数字或字母！</span>
            </b>
            <div class="flex-row">
                <input id="rePassword"
                       class='lf--input'
                       placeholder='确认密码'
                       type='password'
                       name="formRePassword"
                       ng-model="res.rePassword"
                       ng-pattern="/^[0-9a-zA-Z]{6,18}$/"
                       required/>
            </div>
            <b style="color:#CDCDCD;font-size: 15px;" ng-show="resForm.formRePassword.$dirty && resForm.formRePassword.$invalid">
                <i class="fa fa-info-circle"></i><span ng-show="formRePassword!=formPassword">两次密码输入不一致</span>
                <span ng-show="resForm.formRePassword.$error.required">确认密码不能为空！</span>
                <span ng-show="!resForm.formRePassword.$error.required">请输入6到18位的数字或字母！</span>
            </b>
            <button style="margin-top: 20px;cursor: pointer;user-select: none;" class='lf--submit ladda-button ' ladda="register" type='submit' ng-click="add()">立即注册</button>
            <a class='lf--forgot ' href='/login/index' style="margin-left: 90px;user-select: none;">去登录<i class="glyphicon glyphicon-arrow-right"></i></a>
        </form>
    </div>
</div>
<div class="col-sm-12" style="text-align: center;background: #fff;padding: 10px;font-size: 12px;border-radius: 0;opacity: .6;position: absolute;bottom: 0;">
    &copy;2017-2020 郑州幸福里智能科技有限公司 豫ICP备17024155号-1
</div>


