<?php
use backend\assets\LoginCtrlAsset;

LoginCtrlAsset::register($this);
$this->title = '登录';
?>
<div style="color:#35c3c1;margin-bottom: 10px"><span style="font-size: 18px;color:#fff">幸福里智能健身管理平台</span> | <span >登录</span></div>
<form class='login-forms' ng-controller="loginCtrl" ng-cloak ng-submit="login(credentials)"  name="credentials"  novalidate >
    <div class="flex-row">
        <label class="lf--label rightTopB-radius" for="username" >
            <i class="glyphicon glyphicon-user"></i>
        </label>
        <input ng-model="credentials.username"  id="username" class='lf--input leftTopB-radius' placeholder='用户名' type='text'  required />
    </div>
    <div class="flex-row">
        <label class="lf--label rightTopB-radius" for="password">
                <i class="glyphicon glyphicon-lock"></i>
        </label>
        <input ng-model="credentials.password"  id="password" class='lf--input leftTopB-radius' placeholder='密码' type='password'  required>
    </div>
    <div class="flex-row" id="ddd" style="margin-bottom:20px ;">
       <div id="drag" class="text-center"></div>
    </div>
    <button style="user-select: none;" class='lf--submit ladda-button' ladda="logining" type='submit' value=''>登录</button>
    <a style="user-select: none;" class='lf--forgot' href='/login/password'>忘记密码?</a>
    <a class="lf--forgot" href="/login/register" style="margin-left: 110px;user-select: none;">立即注册</a>
</form>
<div class="col-sm-12" style="text-align: center;background: #fff;padding: 10px;font-size: 12px;border-radius: 0;opacity: .6;position: absolute;bottom: 0;">
    &copy;2017-2020 郑州幸福里智能科技有限公司 豫ICP备17024155号-1
</div>



