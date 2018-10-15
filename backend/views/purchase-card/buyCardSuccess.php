<?php
/* @var $this yii\web\View */
use backend\assets\BuyCardCtrlAsset;
BuyCardCtrlAsset::register($this);
$this->title = '会员登记';
?>
<main  style="background-color: #FFF;height: 100%;" ng-controller="buyCardSuccessCtrl" ng-cloak>
    <div  class="header">
        <div class="" onclick="WeixinJSBridge.call('closeWindow')">
            <span class="glyphicon glyphicon-menu-left f24 "  style="font-size: 24px;color: #e5e5e5;"></span>
        </div>
        <div>会员登记</div>
        <div></div>
    </div>
    <div class="weui_msg">
        <div class="weui_icon_area"><i  class="weui_icon_success weui_icon_msg colorAqua"></i></div>
        <div class="weui_text_area">
            <p class="weui_msg_desc fw " style="color: #2FBF79;font-size: 16px;">会员卡购买成功</p>
        </div>
        <div class="weui_opr_area backBtn" >
            <p class="weui_btn_area">
                <a href="javascript:;"  class="weui_btn weui_btn_primary colorAquaBg" onclick="WeixinJSBridge.call('closeWindow')">关闭</a>
            </p>
        </div>
    </div>
</main>