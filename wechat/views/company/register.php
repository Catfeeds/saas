<?php
use wechat\assets\CompanyRegisterCtrlAsset;
CompanyRegisterCtrlAsset::register($this);
$this->title = '注册';
?>
<div id="register"  ng-controller ="companyRegisterCtrl" ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell ">
            <div class="weui-cell__hd"><label class="weui-label">公司名称</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" ng-model="companyName" type="text"  placeholder="请输入公司名称">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">负责人姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" ng-model="userName"  type="text"  placeholder="请输入负责人姓名">
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" value="{{mobile}}" ng-model="mobile" type="tel" placeholder="请输入手机号">
            </div>
            <div class="weui-cell__ft">
                <button ng-click="getCode()" ng-bind="paracont" ng-disabled="disabled"  class="weui-vcode-btn">{{time}}</button>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" ng-model="newCode" type="number" pattern="[0-9]*" placeholder="请输入验证码">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">店面数量</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input"  ng-blur="storeNumberChange(storefrontNum)" ng-model="storefrontNum"  type="number"   placeholder="请输入店面数量">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="name" class="weui-label">店面类型</label></div>
            <div class="weui-cell__bd">
                <input placeholder="请选择店面类型"   class="weui-input" type="text" id='storeType' readonly/>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="name" class="weui-label">所在地区</label></div>
            <div class="weui-cell__bd">
                <input placeholder="请选择所在地区" class="weui-input" ng-model="regionName"  id="cityPicker111" type="text" value="" readonly="">
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">详情地址</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input"  ng-model="address" type="text"  placeholder="请输入详情地址">
            </div>
        </div>
        <div id="submitBtn" ng-click="confirmRes()"  class="weui-footer ">
            <p class="weui-footer__links">
                <button  class="weui-btn weui-btn_plain-primary">提交审核</button>
            </p>
        </div>
    </div>
</div>

