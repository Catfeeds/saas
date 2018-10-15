<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/8/8
 * Time: 19:48
 */
use wechat\assets\CompanyRegisterCtrlAsset;
CompanyRegisterCtrlAsset::register($this);
$this->title = '审核';
?>
<div ng-controller="completeCtrl" ng-cloak>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">已提交</h2>
            <p class="weui-msg__desc">审核结果将会在1-3个工作日以短信的方式通知</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <button ng-click="backPrePage()" class="weui-btn weui-btn_default">返回</button>
            </p>
        </div>
    </div>
</div>
