<?php
use backend\assets\LoginCtrlAsset;
LoginCtrlAsset::register($this);
$this->title = '找回密码';
?>
<!--/**-->
<!--* @云运动 - 后台 - 重置密码-->
<!--* @author Zhu Mengke <zhumengke@itsports.club>-->
<!--* @create 2017/4/5-->
<!--* @inheritdoc-->
<!--*/-->

<div style="color:#35c3c1;margin-bottom: 10px"><span style="font-size: 18px;color:#fff">幸福里智能健身管理平台</span> | <span >找回密码</span></div>
<div ng-controller = 'pasCtrl' ng-cloak>
<form class='login-forms' name="pasForm" ng-submit="RePasswordForm()">
    <input ng-model="res._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
    <div class="flex-row">
        <input id="username"
               class='lf--input'
               placeholder='手机号'
               type='text'
               name="mobile"
               ng-model="pas.mobile"
               ng-pattern="/^[1][3587][0-9]{9}$/"
               required/>
    </div>
    <div class="flex-row">
        <input id="number"
               class='lf--input c-input rightTopB-radius'
               placeholder='输入验证码'
               type='text'
               name="code"
               ng-model="pas.code"
               required/>
        <button type="button"
                class="lf--input c-input leftTopB-radius"
                data-target="#exampleModal"
                ng-click="newCode()"
                ng-bind="paracont"
                ng-disabled="disabled" ladda="isCodeButtonClick">
                获取验证码
        </button>
    </div>

    <div class="flex-row" style="margin-top: 35px;">
        <input id="new-password"
               class='lf--input'
               placeholder='新密码'
               type='password'
               name="password"
               ng-model="pas.password"
               ng-pattern="/^[0-9a-zA-Z]{6,18}$/"
               required/>
    </div>
    <div class="flex-row" style="margin-bottom: 20px;">
        <input id="password"
               class='lf--input'
               placeholder='确认密码'
               type='password'
               name="rePassword"
               ng-model="pas.rePassword"
               ng-pattern="/^[0-9a-zA-Z]{6,18}$/"
               required/>
    </div>
    <button style="user-select: none;" class='lf--submit ladda-button' ladda="password" type='submit'>重置密码</button>
    <a class='lf--forgot' href='/login/index' style="margin-left: 90px;user-select: none;">去登录<i class="glyphicon glyphicon-arrow-right"></i></a>
</form>
</div>
<div class="col-sm-12" style="text-align: center;background: #fff;padding: 10px;font-size: 12px;border-radius: 0;opacity: .6;position: absolute;bottom: 0;">
    &copy;2017-2020 郑州幸福里智能科技有限公司 豫ICP备17024155号-1
</div>